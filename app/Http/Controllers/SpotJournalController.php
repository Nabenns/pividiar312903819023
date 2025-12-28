<?php

namespace App\Http\Controllers;

use App\Models\SpotTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotJournalController extends Controller
{
    public function index(Request $request)
    {
        $query = SpotTransaction::where('user_id', auth()->id());

        // All Time Transactions (for Available Months & All Time Stats)
        $allTransactions = $query->orderBy('transaction_date', 'desc')->get();

        // Available Months for Dropdown
        $availableMonths = $allTransactions->sortByDesc('transaction_date')
            ->groupBy(function ($val) {
                return \Carbon\Carbon::parse($val->transaction_date)->format('Y-m');
            })
            ->keys();

        // Filter by Month (Default to Current Month)
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        [$year, $month] = explode('-', $selectedMonth);

        // Filtered Transactions for View
        $transactions = $query->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Calculate Holdings & Avg Price (Based on ALL TIME transactions to be accurate)
        // Note: Holdings should reflect CURRENT state, not historical state of that month.
        // However, PnL for the month should be based on Sells in that month.
        
        $holdings = [];
        $grouped = $allTransactions->whereIn('type', ['buy', 'sell'])->groupBy('pair');

        $globalRealizedPnL = 0; // All Time
        $monthlyRealizedPnL = 0; // Selected Month

        foreach ($grouped as $pair => $txs) {
            $totalQty = 0;
            $totalCost = 0;
            
            foreach ($txs->sortBy('transaction_date') as $tx) {
                if ($tx->type === 'buy') {
                    $totalQty += $tx->amount;
                    $totalCost += $tx->value;
                } elseif ($tx->type === 'sell') {
                    // Calculate Realized PnL for this sell
                    $avgPrice = $totalQty > 0 ? $totalCost / $totalQty : 0;
                    $costOfSold = $tx->amount * $avgPrice;
                    $pnl = $tx->value - $costOfSold;
                    
                    $globalRealizedPnL += $pnl;

                    // Check if this sell happened in the selected month
                    if ($tx->transaction_date->format('Y-m') === $selectedMonth) {
                        $monthlyRealizedPnL += $pnl;
                    }
                    
                    $totalQty -= $tx->amount;
                    $totalCost -= $costOfSold; // Reduce cost basis
                }
            }

            if ($totalQty > 0.00000001) { // Floating point tolerance
                $holdings[] = [
                    'pair' => $pair,
                    'quantity' => $totalQty,
                    'avg_price' => $totalQty > 0 ? $totalCost / $totalQty : 0,
                    'total_cost' => $totalCost,
                ];
            }
        }

        $netDeposit = $allTransactions->where('type', 'deposit')->sum('value') - $allTransactions->where('type', 'withdraw')->sum('value');

        $availableCash = $allTransactions->where('type', 'deposit')->sum('value') 
            - $allTransactions->where('type', 'withdraw')->sum('value')
            - $allTransactions->where('type', 'buy')->sum('value')
            + $allTransactions->where('type', 'sell')->sum('value');

        $stats = [
            'net_deposit' => $netDeposit,
            'available_cash' => $availableCash,
            'total_holdings_value' => collect($holdings)->sum('total_cost'),
            'realized_pnl' => $globalRealizedPnL,
            'monthly_realized_pnl' => $monthlyRealizedPnL,
            'account_balance' => $netDeposit + $globalRealizedPnL,
        ];

        $usdIdrRate = $this->getUsdIdrRate();

        return view('journal.spot', compact('transactions', 'holdings', 'stats', 'availableMonths', 'selectedMonth', 'usdIdrRate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:deposit,withdraw,buy,sell',
            'pair' => 'nullable|required_if:type,buy,sell|string',
            'price' => 'nullable|required_if:type,buy,sell|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'value' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'txid' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Sanitize
        if (isset($validated['pair'])) $validated['pair'] = strip_tags($validated['pair']);
        if (isset($validated['notes'])) $validated['notes'] = strip_tags($validated['notes']);
        if (isset($validated['txid'])) $validated['txid'] = strip_tags($validated['txid']);

        auth()->user()->spotTransactions()->create($validated);

        return redirect()->back()->with('success', 'Transaction recorded successfully!');
    }

    public function update(Request $request, SpotTransaction $spot)
    {
        if ($spot->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'type' => 'required|in:deposit,withdraw,buy,sell',
            'pair' => 'nullable|required_if:type,buy,sell|string',
            'price' => 'nullable|required_if:type,buy,sell|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'value' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'txid' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $spot->update($validated);

        return redirect()->back()->with('success', 'Transaction updated successfully!');
    }

    public function destroy(SpotTransaction $spot)
    {
        if ($spot->user_id !== auth()->id()) abort(403);
        $spot->delete();
        return redirect()->back()->with('success', 'Transaction deleted successfully!');
    }

    public function proxyCoinList()
    {
        return Cache::remember('coingecko_coin_list', 3600, function () {
            $response = Http::withoutVerifying()->get('https://api.coingecko.com/api/v3/coins/markets', [
                'vs_currency' => 'usd',
                'order' => 'market_cap_desc',
                'per_page' => 100,
                'page' => 1,
                'sparkline' => 'false'
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });
    }

    public function proxyPrices(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) return response()->json([]);

        $cacheKey = 'coingecko_prices_' . md5($ids);

        return Cache::remember($cacheKey, 60, function () use ($ids) {
            $response = Http::withoutVerifying()->get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $ids,
                'vs_currencies' => 'usd,idr'
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [];
        });
    }

    public function getUsdIdrRate()
    {
        return Cache::remember('usd_idr_rate', 3600, function () {
            try {
                $response = Http::withoutVerifying()->get('http://api.exchangerate.host/live', [
                    'access_key' => 'aa55aaf9d2dbfd7f06398c0fdcdeaa32',
                    'currencies' => 'IDR',
                    'source' => 'USD',
                    'format' => 1
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['quotes']['USDIDR'] ?? 16000;
                }
            } catch (\Exception $e) {
                // Log error if needed
            }

            return 16000; // Fallback rate
        });
    }
}

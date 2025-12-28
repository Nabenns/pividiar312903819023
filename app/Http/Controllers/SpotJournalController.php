<?php

namespace App\Http\Controllers;

use App\Models\SpotTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpotJournalController extends Controller
{
    public function index()
    {
        $transactions = SpotTransaction::where('user_id', auth()->id())
            ->orderBy('transaction_date', 'desc')
            ->get();

        // Calculate Holdings & Avg Price
        $holdings = [];
        $grouped = $transactions->whereIn('type', ['buy', 'sell'])->groupBy('pair');

        $globalRealizedPnL = 0;

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

        $netDeposit = $transactions->where('type', 'deposit')->sum('value') - $transactions->where('type', 'withdraw')->sum('value');

        $availableCash = $transactions->where('type', 'deposit')->sum('value') 
            - $transactions->where('type', 'withdraw')->sum('value')
            - $transactions->where('type', 'buy')->sum('value')
            + $transactions->where('type', 'sell')->sum('value');

        $stats = [
            'net_deposit' => $netDeposit,
            'available_cash' => $availableCash,
            'total_holdings_value' => collect($holdings)->sum('total_cost'),
            'realized_pnl' => $globalRealizedPnL,
            'account_balance' => $netDeposit + $globalRealizedPnL,
        ];

        return view('journal.spot', compact('transactions', 'holdings', 'stats'));
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
}

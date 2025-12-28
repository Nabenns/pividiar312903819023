<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    //
    public function index()
    {
        $journals = \App\Models\Journal::where('user_id', auth()->id())
            ->orderBy('trade_date', 'desc')
            ->get();

        $winTrades = $journals->where('status', 'win')->count();
        $lossTrades = $journals->where('status', 'loss')->count();
        $totalWinLoss = $winTrades + $lossTrades;

        $stats = [
            'total_trades' => $journals->count(),
            'win_rate' => $totalWinLoss > 0 ? ($winTrades / $totalWinLoss) * 100 : 0,
            'total_pnl' => $journals->sum('pnl_value'),
            'avg_roi' => $journals->count() > 0 ? $journals->avg('pnl_percentage') : 0,
        ];

        return view('journal.index', compact('journals', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('journal-images', 'public');
        }

        auth()->user()->journals()->create([
            ...$validated,
            'image_path' => $path,
        ]);

        return redirect()->route('journal.index')->with('success', 'Trade recorded successfully!');
    }

    public function update(Request $request, \App\Models\Journal $journal)
    {
        // Ensure user owns the journal
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $this->validateRequest($request);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($journal->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($journal->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('journal-images', 'public');
        }

        $journal->update($validated);

        return redirect()->route('journal.index')->with('success', 'Trade updated successfully!');
    }

    public function destroy(\App\Models\Journal $journal)
    {
        if ($journal->user_id !== auth()->id()) {
            abort(403);
        }

        if ($journal->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($journal->image_path);
        }

        $journal->delete();

        return redirect()->route('journal.index')->with('success', 'Trade deleted successfully!');
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'pair' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z\/]+$/'],
            'direction' => 'required|in:long,short',
            'leverage' => 'required|integer|min:1',
            'margin' => 'required|numeric|min:0',
            'entry_price' => 'required|numeric',
            'exit_price' => 'required|numeric',
            'pnl_value' => 'required|numeric',
            'pnl_percentage' => 'required|numeric',
            'status' => 'required|in:win,loss,be',
            'trade_date' => 'required|date',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Sanitize inputs
        $validated['pair'] = strip_tags($validated['pair']);
        $validated['notes'] = $validated['notes'] ? strip_tags($validated['notes']) : null;

        return $validated;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminPaymentController extends Controller
{
    public function pricingIndex()
    {
        $pricing = Pricing::where('is_active', true)->get();
        return Inertia::render('Admin/Payment/Pricing', ['pricing' => $pricing]);
    }

    public function setPricing(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:class,video,live_class,quiz',
            'item_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
        ]);

        Pricing::updateOrCreate(
            ['item_type' => $request->item_type, 'item_id' => $request->item_id],
            ['amount' => $request->amount, 'is_active' => true]
        );

        return back()->with('success', 'Price set successfully');
    }

    public function removePricing(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:class,video,live_class,quiz',
            'item_id' => 'required|integer',
        ]);

        Pricing::where('item_type', $request->item_type)
            ->where('item_id', $request->item_id)
            ->update(['is_active' => false]);

        return back()->with('success', 'Price removed');
    }

    public function transactionLog()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Admin/Payment/Transactions', [
            'transactions' => $transactions,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Purchases/Index', [
            'transactions' => $transactions->map(function ($t) {
                return [
                    'id' => $t->id,
                    'reference' => $t->reference,
                    'item_type' => $t->item_type,
                    'item_id' => $t->item_id,
                    'amount' => number_format($t->amount, 2),
                    'currency' => $t->currency,
                    'status' => $t->status,
                    'paid_at' => $t->paid_at ? $t->paid_at->format('Y-m-d H:i') : null,
                    'created_at' => $t->created_at->format('Y-m-d H:i'),
                ];
            }),
        ]);
    }
}

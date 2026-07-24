<?php

namespace App\Http\Middleware;

use App\Models\Transaction;
use Closure;

class HasAccess
{
    public function handle($request, Closure $next, $itemType)
    {
        $itemId = $request->route()->parameter('id')
            ?? $request->route()->parameter($itemType . '_id')
            ?? $request->input('id');

        if (!$itemId) {
            return $next($request);
        }

        $hasAccess = Transaction::where('user_id', auth()->id())
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->where('status', 'completed')
            ->exists();

        if (!$hasAccess) {
            return response()->json(['error' => 'Access denied. Payment required.'], 403);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\LiveClass;
use App\Models\RecordedVideo;
use App\Models\Quiz;
use App\Models\Transaction;
use Closure;

class HasAccess
{
    public function handle($request, Closure $next, $itemType)
    {
        $itemId = $request->route()->parameter('id')
            ?? $request->route()->parameter($itemType . '_id')
            ?? $request->route()->parameter('quiz_id')
            ?? $request->input('id');

        if (!$itemId) {
            return $next($request);
        }

        $item = match ($itemType) {
            'live_class' => LiveClass::find($itemId),
            'video' => RecordedVideo::find($itemId),
            'quiz' => Quiz::find($itemId),
            default => null,
        };

        if ($item && $item->price <= 0) {
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

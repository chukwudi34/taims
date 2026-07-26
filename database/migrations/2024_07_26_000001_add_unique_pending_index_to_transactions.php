<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $duplicates = DB::table('transactions as t')
            ->select(DB::raw('MIN(id) as keep_id'), 'user_id', 'item_type', 'item_id')
            ->where('status', 'pending')
            ->groupBy('user_id', 'item_type', 'item_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $dup) {
            DB::table('transactions')
                ->where('user_id', $dup->user_id)
                ->where('item_type', $dup->item_type)
                ->where('item_id', $dup->item_id)
                ->where('status', 'pending')
                ->where('id', '!=', $dup->keep_id)
                ->delete();
        }

        DB::statement('CREATE UNIQUE INDEX transactions_pending_unique ON transactions(user_id, item_type, item_id) WHERE status = \'pending\'');
    }

    public function down()
    {
        DB::statement('DROP INDEX IF EXISTS transactions_pending_unique ON transactions');
    }
};

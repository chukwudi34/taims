<?php

use Illuminate\Database\Migrations\Migration;
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

        Schema::table('transactions', function ($table) {
            $table->index(['user_id', 'item_type', 'item_id', 'status'], 'idx_transactions_lookup');
        });
    }

    public function down()
    {
        Schema::table('transactions', function ($table) {
            $table->dropIndex('idx_transactions_lookup');
        });
    }
};

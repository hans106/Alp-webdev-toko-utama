<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Set qty_checked = qty_required and status = 'checked' for any existing items
        DB::table('order_checklist_items')
            ->whereColumn('qty_checked', '<', 'qty_required')
            ->update([
                'qty_checked' => DB::raw('qty_required'),
                'status' => 'checked',
                'updated_at' => now()
            ]);

        // For each checklist, if no remaining incomplete items, set checklist.status = 'sudah_fix'
        $checklists = DB::table('order_checklists')->select('id')->get();
        foreach ($checklists as $c) {
            $incomplete = DB::table('order_checklist_items')
                ->where('order_checklist_id', $c->id)
                ->whereColumn('qty_checked', '<', 'qty_required')
                ->exists();

            if (! $incomplete) {
                DB::table('order_checklists')->where('id', $c->id)->update(['status' => 'sudah_fix', 'updated_at' => now()]);
            }
        }
    }

    public function down()
    {
        // Not reversible safely — leave as no-op
    }
};
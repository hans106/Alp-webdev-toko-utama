<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderChecklist;
use App\Models\OrderChecklistItem;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class OrderChecklistController extends Controller
{
    public function index()
    {
        $checklists = OrderChecklist::with(['order', 'admin'])->latest()->paginate(15);
        return view('admin.checklists.index', compact('checklists'));
    }

    public function show($id)
    {
        $checklist = OrderChecklist::with(['order.orderItems.product', 'items.product'])->where('id', $id)->firstOrFail();
        return view('admin.checklists.show', compact('checklist'));
    }

    /**
     * FUNGSI TOGGLE ITEM (Centang / Hapus Centang)
     */
    public function toggleItem($itemId)
    {
        $item = OrderChecklistItem::findOrFail($itemId);

        // Logika Toggle: Reset jika penuh, Penuhkan jika belum
        if ($item->qty_checked >= $item->qty_required) {
            $item->qty_checked = 0;
            $item->status = 'pending';
        } else {
            $item->qty_checked = $item->qty_required;
            $item->status = 'checked';
        }
        $item->save();

        // Cek Status Header Checklist (Otomatis)
        $checklist = $item->checklist;
        $incompleteItems = $checklist->items()
            ->whereColumn('qty_checked', '<', 'qty_required')
            ->count();

        if ($incompleteItems == 0) {
            $checklist->status = 'sudah_fix';
        } else {
            $checklist->status = 'belum_selesai';
        }
        $checklist->save();

        return redirect()->back()->with('success', 'Item diperbarui.');
    }

    // Fungsi updateItem lama (dibiarkan untuk backup)
    public function updateItem(Request $request, $item)
    {
        $it = OrderChecklistItem::findOrFail($item);
        $qty = (int) $request->input('qty_checked', 0);
        if ($qty < 0) $qty = 0;
        if ($qty > $it->qty_required) $qty = $it->qty_required;

        $it->qty_checked = $qty;
        $it->status = ($it->qty_checked >= $it->qty_required) ? 'checked' : 'pending';
        $it->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CHECKLIST ITEM UPDATED',
            'description' => "Update checklist item #{$it->id}: qty={$it->qty_checked}"
        ]);

        $allDone = $it->checklist->items()->whereColumn('qty_checked', '<', 'qty_required')->count() == 0;
        if ($allDone) {
            $it->checklist->status = 'sudah_fix';
            $it->checklist->save();
        }

        return redirect()->back()->with('success', 'Item diperbarui.');
    }

    public function updateStatus(Request $request, $checklist)
    {
        $cl = OrderChecklist::findOrFail($checklist);
        $status = $request->input('status');
        if (!in_array($status, ['sudah_fix', 'belum_selesai'])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $cl->status = $status;
        $cl->save();

        return redirect()->back()->with('success', 'Status Checklist diperbarui.');
    }

    /**
     * FUNGSI PRINT: Langsung Tampil HTML
     */
    public function print($id)
    {
        $cl = OrderChecklist::with(['order.orderItems.product', 'admin'])->where('id', $id)->firstOrFail();
        return view('admin.checklists.print', compact('cl'));
    }

    /**
     * FUNGSI SEND (KIRIM KURIR): Hanya Notifikasi
     */
    public function send(Request $request, $id)
    {
        $cl = OrderChecklist::with(['items', 'order'])->findOrFail($id);

        // Validasi: Pastikan semua item sudah dicek
        $incomplete = $cl->items()->whereColumn('qty_checked', '<', 'qty_required')->exists();
        if ($incomplete) {
            return redirect()->back()->with('error', 'Gagal: Masih ada barang yang belum dicek!');
        }

        // 1. Update status checklist
        $cl->status = 'sudah_fix';
        $cl->save();

        // 2. Update status order jadi 'sent'
        $order = $cl->order;
        $order->update(['status' => 'sent']);

        // 3. Log Aktivitas
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'SEND TO DELIVERY',
            'description' => "Checklist #{$cl->id} (Order #{$order->invoice_code}) sent to delivery."
        ]);

        // 4. Redirect ke Index + Notifikasi (Sesuai Request)
        return redirect()->route('admin.checklists.index')
            ->with('success', 'Pesanan berhasil dikirim ke kurir (Status: SENT).');
    }
}
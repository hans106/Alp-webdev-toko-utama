<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderChecklist;
use App\Models\OrderChecklistItem;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function updateItem(Request $request, $item)
    {
        $it = OrderChecklistItem::findOrFail($item);

        $qty = (int) $request->input('qty_checked', 0);
        if ($qty < 0) $qty = 0;
        if ($qty > $it->qty_required) $qty = $it->qty_required;

        $it->qty_checked = $qty;
        $it->status = ($it->qty_checked >= $it->qty_required) ? 'checked' : 'pending';
        $it->notes = $request->input('notes');
        $it->save();

        // Log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CHECKLIST ITEM UPDATED',
            'description' => "Update checklist item #{$it->id} (order #{$it->checklist->order->id}): qty_checked={$it->qty_checked}"
        ]);

        // If all items checked, we can optionally change checklist status to 'sudah_fix'
        $allDone = $it->checklist->items()->whereColumn('qty_checked', '<', 'qty_required')->count() == 0;
        if ($allDone) {
            $it->checklist->status = 'sudah_fix';
            $it->checklist->save();
        }

        return redirect()->back()->with('success', 'Checklist item diperbarui.');
    }

    public function updateStatus(Request $request, $checklist)
    {
        $cl = OrderChecklist::findOrFail($checklist);
        $status = $request->input('status');
        if (!in_array($status, ['sudah_fix', 'belum_selesai'])) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $old = $cl->status;
        $cl->status = $status;
        $cl->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CHECKLIST STATUS UPDATED',
            'description' => "Checklist #{$cl->id} status changed: {$old} -> {$status}"
        ]);

        return redirect()->back()->with('success', 'Status Checklist diperbarui.');
    }

    public function print($id)
    {
        $cl = OrderChecklist::with(['order.orderItems.product', 'admin'])->where('id', $id)->firstOrFail();

        // If Dompdf is installed, stream a PDF. Otherwise fall back to the HTML print view.
        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView('admin.checklists.print_pdf', compact('cl'));
            return $pdf->stream(sprintf('checklist-%s.pdf', $cl->id));
        }

        return view('admin.checklists.print', compact('cl'));
    }

    // Kirim checklist ke pengirim (finalize dan ubah status order jadi 'sent')
    public function send(Request $request, $id)
    {
        $cl = OrderChecklist::with(['items', 'order'])->findOrFail($id);

        // Pastikan semua item sudah dicek penuh
        $incomplete = $cl->items()->whereColumn('qty_checked', '<', 'qty_required')->exists();
        if ($incomplete) {
            return redirect()->back()->with('error', 'Tidak bisa kirim: masih ada item yang belum dicek penuh.');
        }

        // Update checklist dan order
        $oldChecklist = $cl->status;
        $cl->status = 'sudah_fix';
        $cl->save();

        $order = $cl->order;
        $oldOrderStatus = $order->status;
        $order->update(['status' => 'sent']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'SEND TO DELIVERY',
            'description' => "Checklist #{$cl->id} for Order #{$order->id} sent to delivery. Checklist status: {$oldChecklist} -> sudah_fix. Order status: {$oldOrderStatus} -> sent"
        ]);

        // If Dompdf is installed, return a small confirmation page that opens the PDF in a new tab
        if (class_exists(Pdf::class)) {
            return view('admin.checklists.sent', compact('cl'));
        }

        return redirect()->route('admin.checklists.index')->with('success', 'Checklist berhasil dikirim ke pengirim.');
    }
}

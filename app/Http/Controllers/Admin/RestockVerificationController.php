<?php

namespace App\Http\Controllers\Admin;

use App\Models\Restock;
use App\Models\RestockVerification;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RestockVerificationController extends Controller
{
    // TAMPILKAN DAFTAR RESTOCK YANG PERLU VERIFIKASI
    public function index()
    {
        $verifications = RestockVerification::with(['restock.product', 'restock.supplier', 'verifiedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $pendingCount = RestockVerification::where('status', 'pending')->count();

        return view('admin.restocks.verifications.index', compact('verifications', 'pendingCount'));
    }

    // TAMPILKAN FORM VERIFIKASI RESTOCK TERTENTU
    public function edit($id)
    {
        $verification = RestockVerification::with(['restock.product', 'restock.supplier'])->findOrFail($id);
        $restock = $verification->restock;

        return view('admin.restocks.verifications.edit', compact('verification', 'restock'));
    }

    // SIMPAN VERIFIKASI
    public function update($id, Request $request)
    {
        $verification = RestockVerification::findOrFail($id);

        // Validasi
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,rejected',
            'actual_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $verification->status;
        
        // Update verification
        $verification->update([
            'status' => $validated['status'],
            'actual_total' => $validated['actual_total'],
            'notes' => $validated['notes'],
            'verified_by' => Auth::id(),
            'verified_at' => now()
        ]);

        // Bandingkan expected vs actual jika kedua ada
        if ($verification->expected_total && $verification->actual_total) {
            $verification->matches = abs($verification->expected_total - $verification->actual_total) < 1;
            $verification->save();
        }

        // --- 📹 REKAM CCTV (VERIFIKASI RESTOCK) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'VERIFY RESTOCK',
            'description' => "Verifikasi Restock #{$verification->restock_id}. Status: '{$oldStatus}' → '{$validated['status']}'. " .
                (isset($validated['actual_total']) ? "Nota Total: Rp " . number_format($validated['actual_total'], 0, ',', '.') . ". " : "") .
                (isset($validated['notes']) ? "Catatan: {$validated['notes']}" : "")
        ]);
        // ------------------------------------

        return redirect()->route('admin.restock-verifications.index')
            ->with('success', 'Verifikasi Restock Tersimpan! ✓');
    }

    // AUTO-CREATE VERIFICATION SAAT RESTOCK DIBUAT (dipanggil dari RestockController)
    public static function createForRestock(Restock $restock)
    {
        if (!$restock->verification) {
            RestockVerification::create([
                'restock_id' => $restock->id,
                'status' => 'pending',
                'expected_total' => $restock->getExpectedTotal()
            ]);
        }
    }
}

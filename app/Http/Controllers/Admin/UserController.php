<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ActivityLog; // ✅ WAJIB IMPORT LOG
use Illuminate\Support\Facades\Auth; // ✅ WAJIB IMPORT AUTH

class UserController extends Controller
{
    // 1. FITUR LIHAT DAFTAR USER
    public function index(Request $request)
    {
        $query = User::latest();

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // 2. FITUR HAPUS USER (DENGAN CCTV)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // VALIDASI: Jangan sampai Role Penting terhapus!
        if (in_array($user->role, ['master', 'inventory', 'admin_penjualan'])) {
            return back()->with('error', 'GAGAL: Akun Master, Gudang, atau Kasir dilindungi sistem.');
        }

        // Simpan data dulu buat laporan CCTV
        $deletedName = $user->name;
        $deletedRole = $user->role;

        // Hapus User
        $user->delete();

        // --- 📹 REKAM CCTV (DELETE USER) ---
        ActivityLog::create([
            'user_id' => Auth::id(), // Siapa yang menghapus?
            'action' => 'DELETE USER',
            'description' => "Menghapus User: '$deletedName' (Role: $deletedRole)."
        ]);
        // ---------------------------------

        return back()->with('success', 'User berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    // 2. FITUR HAPUS USER (Sesuai Request Abang)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // VALIDASI: Jangan sampai Role Penting terhapus!
        if (in_array($user->role, ['superadmin', 'inventory', 'cashier'])) {
            return back()->with('error', 'GAGAL: Akun Superadmin, Gudang, atau Kasir dilindungi sistem.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
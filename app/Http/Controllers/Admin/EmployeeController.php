<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Kita pakai File facade untuk hapus manual

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('admin.employees.employee', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    // --- BAGIAN SIMPAN (DIRUBAH TOTAL) ---
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('image_photo')) {
            $file = $request->file('image_photo');
            
            // Bikin nama unik
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 🔥 PERUBAHAN UTAMA: Pindah langsung ke public/employee
            $file->move(public_path('employee'), $filename);
        }

        Employee::create([
            'name' => $request->name,
            'position' => $request->position,
            'phone' => $request->phone,
            'image_photo' => $filename,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'CREATE EMPLOYEE',
            'description' => 'Merekrut pegawai baru: ' . $request->name,
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Pegawai baru berhasil direkrut!');
    }

    // --- BAGIAN UPDATE (DIRUBAH TOTAL) ---
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image_photo')) {
            
            // Hapus foto lama jika ada (Cek di folder public/employee)
            if ($employee->image_photo && File::exists(public_path('employee/' . $employee->image_photo))) {
                File::delete(public_path('employee/' . $employee->image_photo));
            }

            $file = $request->file('image_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // 🔥 Simpan ke public/employee
            $file->move(public_path('employee'), $filename);
            
            $employee->image_photo = $filename;
        }

        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->phone = $request->phone;
        $employee->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'UPDATE EMPLOYEE',
            'description' => 'Mengupdate data pegawai: ' . $employee->name,
            'ip_address' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'Data pegawai berhasil diupdate!');
    }

    // --- BAGIAN DELETE (DIRUBAH TOTAL) ---
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $nama = $employee->name;

        // Hapus foto dari folder public
        if ($employee->image_photo && File::exists(public_path('employee/' . $employee->image_photo))) {
            File::delete(public_path('employee/' . $employee->image_photo));
        }

        $employee->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'DELETE EMPLOYEE',
            'description' => "Menghapus data pegawai: $nama",
            'ip_address' => request()->ip()
        ]);

        return redirect()->back()->with('success', 'Pegawai berhasil dihapus.');
    }
}
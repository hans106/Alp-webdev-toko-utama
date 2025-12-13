<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Employee; // <--- Jangan lupa panggil Model Employee
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Halaman Tentang Kami (Sejarah + Tim)
    public function about()
    {
        // Ambil data karyawan (yang dipecat otomatis gak ikut karena SoftDeletes)
        $employees = Employee::all();

        return view('front.about', compact('employees'));
    }
}
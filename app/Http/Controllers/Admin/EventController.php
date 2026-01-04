<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;        // Model Event
use App\Models\ActivityLog;  // Model CCTV (Log Aktivitas)
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Penting: Untuk kelola file fisik

class EventController extends Controller
{
    /**
     * Menampilkan halaman daftar event.
     */
    public function index()
    {
        // Ambil data event diurutkan dari yang terbaru
        $events = Event::latest()->get();
        return view('admin.events.event', compact('events'));
    }

    /**
     * Menyimpan event baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'event_date'  => 'required|date',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // 2. Logic Upload Gambar (Langsung ke folder public/events)
        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // 1. Bersihkan nama file (hapus spasi & karakter aneh)
            $cleanName = \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . $cleanName . '.' . $extension;

            // 2. Pastikan folder public/events ada (Auto Create)
            $path = public_path('events');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
        }

        // 3. Pindah file
        $file->move($path, $filename);

        // 3. Simpan ke Database
        Event::create([
            'title'       => $request->title,
            'location'    => $request->location,
            'event_date'  => $request->event_date,
            'description' => $request->description,
            'image'       => $filename,
        ]);

        // 4. Catat ke CCTV (Activity Log)
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'CREATE EVENT',
            'description' => 'Membuat event baru: ' . $request->title,
            'ip_address'  => $request->ip()
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'title'       => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'event_date'  => 'required|date',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Logic Update Gambar
        if ($request->hasFile('image')) {

            // A. Hapus gambar lama jika ada
            if ($event->image) {
                $oldPath = public_path('events/' . $event->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // B. Upload gambar baru (DENGAN PEMBERSIH NAMA)
            $file = $request->file('image');
            
            // --- LOGIC PEMBERSIH NAMA (Disamakan dengan STORE) ---
            $cleanName = \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $filename  = time() . '_' . $cleanName . '.' . $extension;
            // -----------------------------------------------------

            // Pindahkan langsung ke public/events
            $file->move(public_path('events'), $filename);

            // Update nama file di database
            $event->image = $filename;
        }

        // 3. Update Data Lainnya
        $event->title       = $request->title;
        $event->location    = $request->location;
        $event->event_date  = $request->event_date;
        $event->description = $request->description;
        $event->save();

        // 4. Catat ke CCTV
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'UPDATE EVENT',
            'description' => 'Update event: ' . $event->title,
            'ip_address'  => $request->ip()
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $title = $event->title;

        // Hapus file fisik di public/events
        if ($event->image) {
            $path = public_path('events/' . $event->image);

            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $event->delete();

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'DELETE EVENT',
            'description' => "Menghapus event: $title",
            'ip_address'  => request()->ip()
        ]);

        return redirect()->back()->with('success', 'Event berhasil dihapus.');
    }
}

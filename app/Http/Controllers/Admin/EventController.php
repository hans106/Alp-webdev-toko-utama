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
            // Nama file unik: waktu_namaasli.jpg
            $filename = time() . '_' . $file->getClientOriginalName();
            // Pindahkan file ke public/events
            $file->storeAs('public/events', $filename);
        }

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

    /**
     * Memperbarui data event (Edit).
     */
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
            // Hapus file lama dari Storage
            if ($event->image && \Illuminate\Support\Facades\Storage::exists('public/events/' . $event->image)) {
                \Illuminate\Support\Facades\Storage::delete('public/events/' . $event->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Simpan file baru ke Storage
            $file->storeAs('public/events', $filename);
            
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

    /**
     * Menghapus event.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $title = $event->title; // Simpan judul buat log sebelum dihapus

        // 1. Hapus File Gambar Fisik — coba beberapa lokasi (storage disk dan public folders)
        if ($event->image) {
            // a) Hapus dari storage disk 'public/events'
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists('events/' . $event->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('events/' . $event->image);
            }

            // b) Hapus juga jika ada di folder public/Event atau public/events (legacy / seeder)
            $publicPaths = [
                public_path('events/' . $event->image),
                public_path('Event/' . $event->image),
                public_path('storage/events/' . $event->image),
                public_path('storage/Event/' . $event->image),
            ];

            foreach ($publicPaths as $p) {
                if (File::exists($p)) {
                    File::delete($p);
                }
            }
        }

        // 2. Hapus Data dari Database
        $event->delete();

        // 3. Catat ke CCTV
        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => 'DELETE EVENT',
            'description' => "Menghapus event: $title",
            'ip_address'  => request()->ip()
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
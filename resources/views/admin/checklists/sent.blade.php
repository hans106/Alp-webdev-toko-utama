@extends('layouts.admin')

@section('page-title')
    Checklist Dikirim
@endsection

@section('content')
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold">Checklist #{{ $cl->id }} Dikirim</h2>
        <p class="text-gray-600 mt-2">PDF nota sedang diproses dan akan dibuka di tab baru secara otomatis.</p>

        <div class="mt-6 flex gap-2">
            <a id="openPdf" href="{{ route('admin.checklists.print', $cl->id) }}" target="_blank" class="bg-primary text-white px-4 py-2 rounded">Buka PDF Manual</a>
            <a href="{{ route('admin.checklists.index') }}" class="bg-gray-200 px-4 py-2 rounded">Kembali ke Daftar Checklist</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open print route in a new tab
            var url = document.getElementById('openPdf').href;
            try {
                window.open(url, '_blank');
            } catch (e) {
                // fallback: change location for browsers that block popups
                window.location.href = url;
            }

            // After a short delay, go back to the checklist index
            setTimeout(function(){
                window.location.href = '{{ route('admin.checklists.index') }}';
            }, 1200);
        });
    </script>
@endsection
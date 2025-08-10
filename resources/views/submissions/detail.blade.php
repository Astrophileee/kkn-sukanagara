@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg border border-gray-200">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('submissions.index') }}"><i class="fa-solid fa-arrow-left"></i> back</a>
        <div>
            <select name="status" id="status-dropdown" data-id="{{ $submission->id }}" onchange="updateStatus(this)"
                class="border border-gray-300 rounded py-1 text-sm">
                <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reject" {{ $submission->status === 'reject' ? 'selected' : '' }}>Reject</option>
                <option value="accept" {{ $submission->status === 'accept' ? 'selected' : '' }}>Accept</option>
            </select>
        </div>
    </div>

    {{-- Judul Pengaduan --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $submission->judul }}</h1>
        <p class="text-sm text-gray-500">
            @if($submission->created_at->diffInDays(now()) >= 1)
                Dibuat {{ $submission->created_at->format('d/m/Y H:i') }}
            @else
                Dibuat {{ $submission->created_at->diffForHumans() }}
            @endif
        </p>
    </div>

    {{-- Identitas Pelapor --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Identitas Pelapor</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <p><span class="font-medium">Nama:</span> {{ $submission->nama }}</p>
            <p><span class="font-medium">NIK:</span> {{ $submission->nik }}</p>
            <p><span class="font-medium">Alamat:</span> {{ $submission->alamat }}</p>
            <p><span class="font-medium">RT / RW:</span> {{ $submission->rt }}</p>
            <p><span class="font-medium">Pekerjaan:</span> {{ $submission->pekerjaan }}</p>
            <p><span class="font-medium">Status di Desa:</span> {{ $submission->status_desa }}</p>
        </div>
    </div>

    {{-- Detail Pengaduan --}}
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Detail Pengaduan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
            <p><span class="font-medium">Jenis Pengaduan:</span> {{ ucfirst($submission->jenis) }}</p>
            <p><span class="font-medium">Lokasi Kejadian:</span> {{ $submission->lokasi }}</p>
            <p><span class="font-medium">Waktu Kejadian:</span> {{ $submission->waktu }}</p>
            <p><span class="font-medium">Pihak Terlibat:</span> {{ $submission->pihak }}</p>
        </div>
        <div class="text-sm mb-4">
            <p class="mb-2"><span class="font-medium">Kronologi Kejadian:</span></p>
            <p class="bg-gray-50 p-3 rounded border">{{ $submission->kronologi }}</p>
        </div>
        <div class="text-sm mb-4">
            <p class="mb-2"><span class="font-medium">Dampak yang Dirasakan:</span></p>
            <p class="bg-gray-50 p-3 rounded border">{{ $submission->dampak }}</p>
        </div>
        <div class="text-sm">
            <p class="mb-2"><span class="font-medium">Harapan / Usulan:</span></p>
            <p class="bg-gray-50 p-3 rounded border">{{ $submission->harapan }}</p>
        </div>
    </div>

    {{-- Bukti Pendukung --}}
    @if($submission->photo)
    <div>
        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Bukti Pendukung</h2>
        <img src="{{ asset('storage/' . $submission->photo) }}"
             alt="Bukti Pengaduan"
             class="w-full md:w-1/2 rounded-lg border shadow-md">
    </div>
    @endif
</div>

@vite('resources/js/submissions.js')
@endsection

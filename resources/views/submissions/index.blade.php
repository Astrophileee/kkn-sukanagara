@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Pengajuan</h1>
    </div>
    <div class="bg-white min-h-[500px] shadow-md rounded-lg overflow-x-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 m-5">
            @foreach ($submissions as $submission)
            @php
                $status = strtolower($submission->status);
                $badge = match($status) {
                    'pending' => ['label' => 'Pending', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                    'reject'  => ['label' => 'Rejected', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                    'accept', 'approved' => ['label' => 'Accepted', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                    default   => ['label' => ucfirst($submission->status), 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                };
            @endphp
                <a href="{{ route('submissions.show', $submission) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-4">
                        <div class="text-sm text-gray-500 mb-1">
                            <span class="font-semibold text-gray-800">{{ $submission->nama_pengaju }}</span> •
                            <span>dibuat {{ $submission->created_at->diffForHumans() }} • </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $badge['bg'] }} {{ $badge['text'] }} inline-block mt-1">
                                {{ $badge['label'] }}
                            </span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            {{ $submission->judul }}
                        </h2>
                        <div class="w-full h-24 text-sm text-gray-600 overflow-hidden">
                                {{ Str::limit(strip_tags($submission->isi), 200) }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
<script>


</script>

@endsection

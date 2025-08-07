<div class="flex items-start mb-4">
    <img src="{{ asset($comment->user ? $comment->user->photo_url : '/images/default-image-square.png') }}"
         alt="User Photo" class="w-8 h-8 rounded-full mr-3">

    <div class="bg-gray-100 px-4 py-2 rounded-lg w-full">
        <div class="text-sm font-semibold text-gray-700">
            {{ $comment->user->name ?? 'Akun telah dihapus' }}
        </div>
        <div class="text-xs text-gray-500 mb-1">
            {{ $comment->created_at->format('d/m/y H:i') }}
        </div>
        <div class="text-sm text-gray-800 whitespace-pre-line">
            {!! nl2br(e($comment->isi)) !!}
        </div>

        @if ($comment->photo)
            <img src="{{ asset('storage/' . $comment->photo) }}"
                 onclick="openImageModal(this.src)"
                 class="mt-2 max-w-[200px] rounded cursor-pointer" alt="Comment Photo">
        @endif
    </div>
</div>

@extends('layouts.navbar')
@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Inbox Anda</h2>

    @forelse ($inboxes as $inbox)
        <div class="border p-4 rounded mb-4 {{ $inbox->status === 'unread' ? 'bg-yellow-100' : 'bg-white' }}">
            <h3 class="font-semibold">{{ $inbox->title }}</h3>
            <p class="text-sm mt-1">{{ $inbox->message }}</p>
            <form action="{{ route('inbox.read', $inbox->id) }}" method="POST" class="mt-2">
                @csrf
                @if ($inbox->status === 'unread')
                    <button class="text-blue-500 hover:underline" type="submit">Tandai sebagai dibaca</button>
                @else
                    <span class="text-green-600">Sudah dibaca</span>
                @endif
            </form>
        </div>
    @empty
        <p class="text-gray-600">Belum ada pesan di inbox Anda.</p>
    @endforelse
</div>
@endsection

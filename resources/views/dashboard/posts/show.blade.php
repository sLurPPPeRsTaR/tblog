@extends('dashboard.layout')

@section('content')
    <div class="max-w-4xl">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <a href="{{ route('posts.index') }}" class="hover:text-gray-700">Posts</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span>{{ Str::limit($post->title, 50) }}</span>
            </div>
        </div>

        <!-- Post Card -->
        <article class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Featured Image -->
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}"
                    alt="{{ $post->title }}"
                    class="w-full h-96 object-cover">
            @endif

            <!-- Content -->
            <div class="p-8">
                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

                <!-- Meta -->
                <div class="flex items-center text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">{{ $post->user?->name }}</span>
                    </div>
                    <span class="mx-3 text-gray-400">•</span>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $post->created_at->format('F d, Y') }}</span>
                    </div>
                    @if($post->published_at)
                        <span class="mx-3 text-gray-400">•</span>
                        <span class="text-green-600 font-medium">Published</span>
                    @endif
                </div>

                <!-- Excerpt -->
                @if($post->excerpt)
                    <div class="text-xl text-gray-600 italic mb-6 pb-6 border-b border-gray-200">
                        {{ $post->excerpt }}
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Actions -->
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center text-gray-700 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Posts
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('posts.edit', $post) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </div>
@endsection

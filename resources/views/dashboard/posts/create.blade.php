@extends('dashboard.layout')

@section('content')
    <div class="max-w-4xl">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('posts.index') }}" class="hover:text-gray-700">Posts</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span>Create</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Post</h1>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="p-6">
                    @include('dashboard.posts._form')
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between rounded-b-lg">
                    <a href="{{ route('posts.index') }}"
                        class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

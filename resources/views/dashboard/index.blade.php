@extends('dashboard.layout')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Posts</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Post::count() }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Your Posts -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Your Posts</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Post::where('user_id', auth()->id())->count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Posts Per Month</h2>
            <div class="h-64">
                <canvas id="postsChart"></canvas>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Recent Posts</h2>
                <a href="{{ route('posts.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all →</a>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse(\App\Models\Post::with('user')->latest()->take(5)->get() as $post)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('posts.show', $post) }}" class="text-lg font-medium text-gray-900 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                                <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <span>{{ $post->user->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="w-20 h-20 object-cover rounded ml-4">
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-500">No posts yet</p>
                        <a href="{{ route('posts.create') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create your first post</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        (async function(){
            const res = await fetch('{{ route('posts.chart') }}');
            const data = await res.json();
            const labels = Object.keys(data);
            const values = Object.values(data);

            const ctx = document.getElementById('postsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.length ? labels : ['No data'],
                    datasets: [{
                        label: 'Posts per month',
                        data: values.length ? values : [0],
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endsection

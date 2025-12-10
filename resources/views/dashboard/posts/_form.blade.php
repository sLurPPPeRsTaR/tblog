<div class="space-y-6">
    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
            Title <span class="text-red-500">*</span>
        </label>
        <input type="text"
            id="title"
            name="title"
            value="{{ old('title', $post->title ?? '') }}"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Excerpt -->
    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
            Excerpt
            <span class="text-xs text-gray-500 ml-2">(Short description)</span>
        </label>
        <textarea
            id="excerpt"
            name="excerpt"
            rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
        >{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        @error('excerpt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
            Content <span class="text-red-500">*</span>
        </label>
        <textarea
            id="content"
            name="content"
            rows="10"
            required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
        >{{ old('content', $post->content ?? '') }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image -->
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
            Featured Image
        </label>
        <div class="flex items-start gap-4">
            <div class="flex-1">
                <input type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
            </div>
            @if(!empty($post->image ?? null))
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $post->image) }}"
                        alt="Current image"
                        class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                </div>
            @endif
        </div>
    </div>

    <!-- Published At -->
    <div>
        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
            Published Date
            <span class="text-xs text-gray-500 ml-2">(Optional)</span>
        </label>
        <input type="datetime-local"
            id="published_at"
            name="published_at"
            value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('published_at') border-red-500 @enderror">
        @error('published_at')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

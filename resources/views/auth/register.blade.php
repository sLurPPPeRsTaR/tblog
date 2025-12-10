<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4">Register</h1>
        @if($errors->any())
            <div class="mb-3 text-red-600">{{ implode('\n', $errors->all()) }}</div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-sm">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded">Register</button>
            </div>
        </form>
        <p class="mt-4 text-sm">Already have an account? <a href="{{ route('login') }}" class="text-blue-600">Login</a></p>
    </div>
</body>
</html>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
        <h1 class="text-xl font-semibold mb-4">Login</h1>
        @if($errors->any())
            <div class="mb-3 text-red-600">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-sm">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="block text-sm">Password</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-3">
                <label class="inline-flex items-center"><input type="checkbox" name="remember" class="mr-2"> Remember</label>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
            </div>
        </form>
        <p class="mt-4 text-sm">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600">Register</a></p>
    </div>
</body>
</html>

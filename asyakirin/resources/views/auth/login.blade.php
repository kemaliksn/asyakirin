<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengurus - ASY-SYAAKIRIIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-md mx-auto py-20 px-6">
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-bold text-green-700 mb-6 text-center">
            Login Pengurus
        </h1>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Email</label>
                <input type="email" name="email" class="w-full border p-3 rounded" required autofocus>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" class="w-full border p-3 rounded" required>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded font-semibold">
                Login
            </button>

            <div class="mt-4 text-center">
                <a href="/" class="text-sm text-gray-600 hover:text-green-600">
                    ← Kembali ke Form Zakat
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
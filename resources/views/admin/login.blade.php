<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Healthy Meals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-green-50 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-green-700 text-center mb-6">Admin Login</h1>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-green-700 font-semibold">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full p-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <label for="password" class="block text-green-700 font-semibold">Password</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Login</button>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Antrian - @yield('title', 'Selamat Datang')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Pusher untuk real-time update (Opsional) -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .blink {
            animation: blink 1s linear infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold flex items-center">
                <i class="fas fa-ticket-alt mr-2"></i>
                Sistem Antrian Modern
            </a>
            <div class="flex space-x-4">
                <a href="{{ route('home') }}" class="hover:bg-blue-700 px-3 py-2 rounded">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <a href="{{ route('queue.display') }}" class="hover:bg-blue-700 px-3 py-2 rounded">
                    <i class="fas fa-desktop mr-1"></i> Display
                </a>
                <a href="{{ route('operator.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded">
                    <i class="fas fa-user-cog mr-1"></i> Operator
                </a>
                <a href="{{ route('admin.dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded">
                    <i class="fas fa-cogs mr-1"></i> Admin
                </a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-4 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2025 Sistem Antrian Modern. All rights reserved.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>

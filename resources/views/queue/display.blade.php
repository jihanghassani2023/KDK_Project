@extends('layouts.app')

@section('title', 'Display Antrian')

@section('styles')
<style>
    /* Styling for display screen */
    .display-box {
        background: linear-gradient(145deg, #0a2463, #3e92cc);
    }
    .now-serving {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 gap-6">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-800 text-white px-6 py-4 text-center">
                <h2 class="text-2xl font-bold">
                    DISPLAY ANTRIAN
                </h2>
                <p class="text-xl">{{ now()->format('l, d F Y') }}</p>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-8">
                <!-- Nomor yang sedang dilayani -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-center text-gray-700">SEDANG DILAYANI</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($currentlyServing as $queue)
                            <div class="display-box rounded-lg p-4 text-white now-serving">
                                <div class="text-center">
                                    <div class="text-sm mb-2">{{ $queue->service->name }}</div>
                                    <div class="text-4xl font-bold mb-2">{{ $queue->queue_number }}</div>
                                    <div class="bg-yellow-500 text-xs rounded-full px-2 py-1 inline-block">
                                        Loket: {{ $queue->counter->name }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 bg-gray-100 p-8 rounded-lg text-center">
                                <i class="fas fa-info-circle text-gray-400 text-5xl mb-4"></i>
                                <p class="text-gray-500 text-xl">Belum ada antrian yang sedang dilayani</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Waktu & Video -->
                <div>
                    <div class="bg-gray-800 rounded-lg p-6 text-white text-center mb-4">
                        <div id="clock" class="text-5xl font-bold mb-2">00:00:00</div>
                        <div id="date" class="text-xl">{{ now()->format('d/m/Y') }}</div>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-4">
                        <div class="aspect-video bg-gray-300 flex items-center justify-center mb-2">
                            <i class="fas fa-video text-gray-500 text-4xl"></i>
                        </div>
                        <p class="text-center text-gray-500 text-sm">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Clock function
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial update

    // For real-time updates with Pusher (uncomment if using Pusher)
    /*
    const pusher = new Pusher('your-pusher-key', {
        cluster: 'ap1'
    });

    const channel = pusher.subscribe('queue-updates');
    channel.bind('queue-called', function(data) {
        // Play sound
        const audio = new Audio('/sounds/ding.mp3');
        audio.play();

        // Refresh page to show new data
        setTimeout(() => location.reload(), 1000);
    });
    */

    // Auto refresh page every 30 seconds
    setTimeout(() => location.reload(), 30000);
</script>
@endsection

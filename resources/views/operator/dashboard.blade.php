@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-desktop mr-2"></i>Dashboard Operator - {{ $counter->name }}
        </h1>
        <a href="{{ route('operator.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition duration-300">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6" x-data="operatorApp">
        <!-- Panel Kiri - Nomor Antrian Saat Ini -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-user-clock mr-2"></i>Sedang Dilayani
                </h2>
            </div>
            <div class="p-6 text-center">
                <template x-if="currentQueue">
                    <div class="mb-4">
                        <span class="text-5xl font-bold text-blue-600 block mb-2" x-text="currentQueue.queue_number"></span>
                        <span class="text-gray-600 block" x-text="currentQueue.service.name"></span>
                        <div class="mt-4 p-3 bg-yellow-100 text-yellow-800 rounded-lg">
                            <i class="fas fa-info-circle mr-2"></i>Sedang melayani
                        </div>
                    </div>
                </template>

                <template x-if="!currentQueue">
                    <div class="py-8">
                        <i class="fas fa-user-clock text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500">Belum ada antrian yang dipanggil</p>
                    </div>
                </template>
            </div>

            <div class="px-6 pb-6">
                <template x-if="currentQueue">
                    <div class="grid grid-cols-2 gap-3">
                        <button @click="completeService" class="bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded transition duration-300">
                            <i class="fas fa-check mr-1"></i>Selesai
                        </button>
                        <button @click="skipQueue" class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded transition duration-300">
                            <i class="fas fa-forward mr-1"></i>Lewati
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Panel Tengah - Panggil Antrian Berikutnya -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-bullhorn mr-2"></i>Panggil Antrian
                </h2>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="service">
                        Pilih Layanan:
                    </label>
                    <select x-model="selectedService" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center">
                    <button
                        @click="callNextQueue"
                        :disabled="!selectedService"
                        :class="{'bg-green-600 hover:bg-green-700': selectedService, 'bg-gray-400 cursor-not-allowed': !selectedService}"
                        class="w-full text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300"
                    >
                        <i class="fas fa-bullhorn mr-2"></i>Panggil Antrian Berikutnya
                    </button>
                </div>

                <div class="mt-6 bg-gray-100 p-4 rounded">
                    <h3 class="font-semibold mb-2">Informasi:</h3>
                    <p class="text-sm text-gray-600">
                        Pilih layanan dan klik tombol "Panggil Antrian Berikutnya" untuk memanggil antrian selanjutnya.
                    </p>
                </div>
            </div>
        </div>

        <!-- Panel Kanan - Statistik Harian -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-purple-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-chart-bar mr-2"></i>Statistik Hari Ini
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-blue-100 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-blue-600">0</div>
                        <div class="text-sm text-gray-600">Total Dilayani</div>
                    </div>
                    <div class="bg-green-100 rounded-lg p-4 text-center">
                        <div class="text-3xl font-bold text-green-600">0</div>
                        <div class="text-sm text-gray-600">Rata-rata (menit)</div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold mb-2">Layanan Terbanyak:</h3>
                    <div class="bg-gray-100 p-3 rounded">
                        <div class="flex justify-between items-center">
                            <span>Belum ada data</span>
                            <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-full text-xs">0</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">Status Antrian:</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between bg-blue-50 p-2 rounded">
                            <span>Menunggu</span>
                            <span class="font-semibold">0</span>
                        </div>
                        <div class="flex justify-between bg-yellow-50 p-2 rounded">
                            <span>Sedang Dilayani</span>
                            <span class="font-semibold">0</span>
                        </div>
                        <div class="flex justify-between bg-green-50 p-2 rounded">
                            <span>Selesai</span>
                            <span class="font-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('operatorApp', () => ({
            counterId: {{ $counter->id }},
            selectedService: '',
            currentQueue: {!! $currentQueue ? json_encode($currentQueue) : 'null' !!},

            callNextQueue() {
                if (!this.selectedService) return;

                axios.post('{{ route('operator.callNext') }}', {
                    counter_id: this.counterId,
                    service_id: this.selectedService
                })
                .then(response => {
                    if (response.data.success) {
                        this.currentQueue = response.data.queue;

                        // Play sound (Uncomment if sound file is available)
                        // const audio = new Audio('/sounds/calling.mp3');
                        // audio.play();

                        // Optional: Show notification
                        alert(`Berhasil memanggil nomor antrian ${response.data.queue.queue_number}`);
                    } else {
                        alert(response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memanggil antrian.');
                });
            },

            completeService() {
                if (!this.currentQueue) return;

                axios.post('{{ route('operator.complete') }}', {
                    queue_id: this.currentQueue.id
                })
                .then(response => {
                    if (response.data.success) {
                        this.currentQueue = null;
                        alert('Layanan selesai!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyelesaikan layanan.');
                });
            },

            skipQueue() {
                if (!this.currentQueue) return;

                axios.post('{{ route('operator.skip') }}', {
                    queue_id: this.currentQueue.id
                })
                .then(response => {
                    if (response.data.success) {
                        this.currentQueue = null;
                        alert('Antrian dilewati!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat melewati antrian.');
                });
            }
        }));
    });
</script>
@endsection
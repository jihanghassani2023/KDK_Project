@extends('layouts.app')

@section('title', 'Ambil Nomor Antrian')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang di Sistem Antrian Modern</h1>
        <p class="text-lg text-gray-600">Silahkan pilih layanan dan ambil nomor antrian Anda</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Ambil Nomor Antrian -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-ticket-alt mr-2"></i>Ambil Nomor Antrian
                </h2>
            </div>
            <div class="p-6" x-data="{ selectedService: '' }">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="service">
                        Pilih Layanan:
                    </label>
                    <select x-model="selectedService" id="service" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center">
                    <button
                        @click="getQueueNumber"
                        :disabled="!selectedService"
                        :class="{'bg-blue-600 hover:bg-blue-700': selectedService, 'bg-gray-400 cursor-not-allowed': !selectedService}"
                        class="w-full text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300"
                    >
                        <i class="fas fa-print mr-2"></i>Cetak Nomor Antrian
                    </button>
                </div>
            </div>
        </div>

        <!-- Informasi Antrian Saat Ini -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-info-circle mr-2"></i>Informasi Antrian Saat Ini
                </h2>
            </div>
            <div class="p-6">
                <h3 class="font-bold text-lg mb-3">Sedang Dilayani:</h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @forelse($currentlyServing as $queue)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded shadow-sm fade-in">
                            <div class="flex justify-between">
                                <span class="font-semibold">{{ $queue->queue_number }}</span>
                                <span class="text-sm bg-green-500 text-white px-2 py-1 rounded blink">Sedang Dilayani</span>
                            </div>
                            <div class="text-sm text-gray-600">Layanan: {{ $queue->service->name }}</div>
                            <div class="text-sm text-gray-600">Loket: {{ $queue->counter->name }}</div>
                        </div>
                    @empty
                        <div class="col-span-2 bg-gray-100 p-4 rounded text-center text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i> Belum ada antrian yang sedang dilayani
                        </div>
                    @endforelse
                </div>

                <h3 class="font-bold text-lg mb-3">Menunggu:</h3>
                <div class="overflow-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($waitingQueues as $queue)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $queue->queue_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $queue->service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            Menunggu
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada antrian yang menunggu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Popup -->
    <div id="ticketModal" class="fixed z-10 inset-0 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-6">
                    <div class="text-center mb-4">
                        <i class="fas fa-ticket-alt text-blue-600 text-5xl mb-3"></i>
                        <h3 class="text-2xl font-bold" id="ticketNumber"></h3>
                        <p class="text-gray-600" id="ticketService"></p>
                        <p class="text-sm text-gray-500" id="ticketDate"></p>
                        <div class="border-t border-b border-dashed border-gray-300 my-4 py-3">
                            <p class="text-gray-700">Silahkan menunggu nomor Anda dipanggil</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="printTicket" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                            <i class="fas fa-print mr-1"></i> Cetak
                        </button>
                        <button id="closeTicket" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <i class="fas fa-times mr-1"></i> Tutup
                        </button>
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
        window.getQueueNumber = function() {
            const selectedService = document.querySelector('#service').value;

            if(!selectedService) return;

            axios.post('{{ route('queue.create') }}', {
                service_id: selectedService
            })
            .then(function (response) {
                if(response.data.success) {
                    // Tampilkan pop-up tiket
                    const ticketInfo = response.data.ticket_info;
                    document.getElementById('ticketNumber').textContent = ticketInfo.queue_number;
                    document.getElementById('ticketService').textContent = 'Layanan: ' + ticketInfo.service_name;
                    document.getElementById('ticketDate').textContent = 'Tanggal: ' + ticketInfo.created_at;

                    document.getElementById('ticketModal').classList.remove('hidden');

                    // Refresh halaman setelah beberapa detik (opsional)
                    // setTimeout(() => location.reload(), 5000);
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengambil nomor antrian.');
            });
        };

        // Handle tombol close pada popup
        document.getElementById('closeTicket').addEventListener('click', function() {
            document.getElementById('ticketModal').classList.add('hidden');
            location.reload(); // Refresh untuk update data
        });

        // Handle tombol print pada popup
        document.getElementById('printTicket').addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endsection
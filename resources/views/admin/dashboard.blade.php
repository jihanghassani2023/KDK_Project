@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
        <p class="text-gray-600">Manajemen dan statistik sistem antrian</p>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-blue-500 rounded-full p-3 mr-4">
                    <i class="fas fa-tag text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Total Layanan</div>
                    <div class="text-2xl font-bold">{{ $totalServicesCount }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-full p-3 mr-4">
                    <i class="fas fa-desktop text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Total Loket</div>
                    <div class="text-2xl font-bold">{{ $totalCountersCount }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-yellow-500 rounded-full p-3 mr-4">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Antrian Hari Ini</div>
                    <div class="text-2xl font-bold">{{ $todayQueuesCount }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-purple-500 rounded-full p-3 mr-4">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Selesai Dilayani</div>
                    <div class="text-2xl font-bold">{{ $servedQueuesCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Navigasi -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('admin.services') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
            <div class="bg-indigo-600 text-white p-4 text-center">
                <i class="fas fa-tags text-3xl mb-2"></i>
                <h2 class="text-xl font-bold">Manajemen Layanan</h2>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Tambah, edit, dan kelola layanan yang tersedia.</p>
                <div class="flex justify-end">
                    <span class="bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm">
                        {{ $totalServicesCount }} Layanan
                    </span>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.counters') }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
            <div class="bg-teal-600 text-white p-4 text-center">
                <i class="fas fa-desktop text-3xl mb-2"></i>
                <h2 class="text-xl font-bold">Manajemen Loket</h2>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Tambah, edit, dan kelola loket pelayanan.</p>
                <div class="flex justify-end">
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">
                        {{ $totalCountersCount }} Loket
                    </span>
                </div>
            </div>
        </a>

        <a href="#" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
            <div class="bg-red-600 text-white p-4 text-center">
                <i class="fas fa-chart-line text-3xl mb-2"></i>
                <h2 class="text-xl font-bold">Laporan & Statistik</h2>
            </div>
            <div class="p-4">
                <p class="text-gray-600 mb-4">Lihat laporan dan statistik antrian.</p>
                <div class="flex justify-end">
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                        Lihat Detail
                    </span>
                </div>
            </div>
        </a>
    </div>

    <!-- Data Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Status Layanan -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-tag mr-2"></i>Status Layanan
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menunggu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($services as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            {{ $service->waiting_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($service->is_active)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Status Loket -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-desktop mr-2"></i>Status Loket
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-auto max-h-60">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dilayani Hari Ini</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($counters as $counter)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $counter->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $counter->description ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                            {{ $counter->served_today }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($counter->is_active)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
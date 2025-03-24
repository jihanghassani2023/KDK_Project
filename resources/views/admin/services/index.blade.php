@extends('layouts.app')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            <i class="fas fa-tags mr-2"></i>Manajemen Layanan
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition duration-300">
            <i class="fas fa-arrow-left mr-1"></i>Kembali ke Dashboard
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Form Tambah Layanan -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-indigo-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Layanan Baru
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.services.create') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Nama Layanan:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Contoh: Customer Service" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                            Kode Layanan:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="code" name="code" type="text" placeholder="Contoh: CS" maxlength="5" required>
                        <p class="text-gray-500 text-xs mt-1">Maksimal 5 karakter (A-Z, 0-9)</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                            Deskripsi:
                        </label>
                        <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" placeholder="Deskripsi layanan..."></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" checked class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300" type="submit">
                            <i class="fas fa-save mr-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Layanan -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden md:col-span-2">
            <div class="bg-indigo-600 text-white px-6 py-4">
                <h2 class="text-xl font-semibold">
                    <i class="fas fa-list mr-2"></i>Daftar Layanan
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($services as $service)
                            @forelse($services as $service)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $service->description ?? '-' }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                        <a href="{{ route('admin.services.edit', $service->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada layanan yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

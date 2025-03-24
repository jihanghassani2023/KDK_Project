@extends('layouts.app')

@section('title', 'Operator - Pilih Loket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Area Operator</h1>
        <p class="text-lg text-gray-600">Silahkan pilih loket yang akan dioperasikan</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($counters as $counter)
            <a href="{{ route('operator.dashboard', $counter->id) }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="bg-indigo-600 text-white p-4 text-center">
                    <i class="fas fa-desktop text-3xl mb-2"></i>
                    <h2 class="text-xl font-bold">{{ $counter->name }}</h2>
                </div>
                <div class="p-4 text-center">
                    <p class="text-gray-600 mb-4">{{ $counter->description ?? 'Loket Pelayanan' }}</p>
                    <button class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full transition duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Mulai Operasikan
                    </button>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
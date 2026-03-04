@extends('install.layout')

@section('content')
@include('install.components.stepper', ['currentStep' => 2])

<div class="bg-white rounded-lg shadow-sm border p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Pengecekan Persyaratan</h2>
        <p class="text-gray-600">Memastikan server Anda memenuhi persyaratan minimum</p>
    </div>

    <div class="space-y-3 mb-8">
        @foreach($requirements as $name => $passed)
        <div class="flex items-center justify-between p-4 border rounded-lg {{ $passed ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
            <span class="font-medium {{ $passed ? 'text-green-900' : 'text-red-900' }}">{{ $name }}</span>
            @if($passed)
                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            @else
                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>
        @endforeach
    </div>

    @if(!$allPassed)
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
        <p class="text-sm text-red-800">
            <strong>Perhatian:</strong> Beberapa persyaratan tidak terpenuhi. Silakan perbaiki masalah di atas sebelum melanjutkan instalasi.
        </p>
    </div>
    @endif

    <div class="flex justify-between">
        <a href="{{ route('install.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-medium">
            ← Kembali
        </a>
        @if($allPassed)
        <a href="{{ route('install.database') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium">
            Lanjutkan →
        </a>
        @else
        <button disabled class="bg-gray-400 text-white px-6 py-2.5 rounded-lg font-medium cursor-not-allowed">
            Lanjutkan →
        </button>
        @endif
    </div>
</div>
@endsection

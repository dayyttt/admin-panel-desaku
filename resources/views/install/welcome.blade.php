@extends('install.layout')

@section('content')
@include('install.components.stepper', ['currentStep' => 1])

<div class="bg-white rounded-lg shadow-sm border p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Selamat Datang</h2>
        <p class="text-gray-600">Mari kita mulai instalasi SGC Desa Lesane</p>
    </div>

    <div class="space-y-6 mb-8">
        <p class="text-gray-700">
            Wizard ini akan membantu Anda mengatur aplikasi dengan mudah. Proses instalasi membutuhkan waktu sekitar 5 menit.
        </p>
        
        <div class="bg-gray-50 rounded-lg p-5 border">
            <p class="font-medium text-gray-900 mb-3">Yang akan kita lakukan:</p>
            
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Cek persyaratan server</span>
                </div>
                
                <div class="flex items-center gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Konfigurasi database</span>
                </div>
                
                <div class="flex items-center gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Atur informasi desa</span>
                </div>
                
                <div class="flex items-center gap-2 text-gray-700">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Buat akun administrator</span>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900 mb-1">Persiapan</p>
                    <p class="text-sm text-blue-800">Pastikan Anda sudah menyiapkan database MySQL dan kredensial aksesnya.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('install.requirements') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium inline-flex items-center gap-2">
            <span>Mulai Instalasi</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</div>
@endsection

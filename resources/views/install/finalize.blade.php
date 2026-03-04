@extends('install.layout')

@section('content')
@include('install.components.stepper', ['currentStep' => 6])

<div class="bg-white rounded-lg shadow-sm border p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Siap untuk Instalasi</h2>
        <p class="text-gray-600">Klik tombol di bawah untuk memulai proses instalasi</p>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
        <h3 class="font-semibold text-green-900 mb-4">Ringkasan Konfigurasi:</h3>
        
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-green-700">Nama Desa:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.nama_desa') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Kode Desa:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.kode_desa') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Kecamatan:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.kecamatan') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Kabupaten:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.kabupaten') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Provinsi:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.provinsi') }}</span>
            </div>
            @if(session('desa_info.kode_pos'))
            <div class="flex justify-between">
                <span class="text-green-700">Kode Pos:</span>
                <span class="font-medium text-green-900">{{ session('desa_info.kode_pos') }}</span>
            </div>
            @endif
            <hr class="border-green-200">
            <div class="flex justify-between">
                <span class="text-green-700">Admin Name:</span>
                <span class="font-medium text-green-900">{{ session('admin_info.name') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Admin Email:</span>
                <span class="font-medium text-green-900">{{ session('admin_info.email') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-green-700">Admin Username:</span>
                <span class="font-medium text-green-900">{{ session('admin_info.username') }}</span>
            </div>
        </div>
    </div>

    <div id="installProgress" class="hidden mb-8">
        <div class="bg-gray-100 rounded-lg p-6">
            <div class="flex items-center mb-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600 mr-4"></div>
                <span class="text-gray-700 font-medium">Sedang menginstal...</span>
            </div>
            <div class="text-sm text-gray-600 space-y-1" id="progressLog">
                <div>Membuat konfigurasi...</div>
            </div>
        </div>
    </div>

    <div id="installSuccess" class="hidden mb-8">
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-green-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-900 font-semibold text-lg">Instalasi Berhasil!</span>
            </div>
            <p class="text-green-800 mb-4">SGC Desa Lesane telah berhasil diinstal dan siap digunakan.</p>
            <a href="/admin" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition">
                Masuk ke Dashboard →
            </a>
        </div>
    </div>

    <div id="installError" class="hidden mb-8">
        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-red-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-900 font-semibold text-lg">Instalasi Gagal</span>
            </div>
            <p class="text-red-800" id="errorMessage"></p>
        </div>
    </div>

    <div class="flex justify-between" id="actionButtons">
        <a href="{{ route('install.admin') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-medium">
            ← Kembali
        </a>
        <button onclick="startInstall()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium">
            Mulai Instalasi
        </button>
    </div>
</div>

<script>
function startInstall() {
    document.getElementById('actionButtons').classList.add('hidden');
    document.getElementById('installProgress').classList.remove('hidden');
    
    const progressLog = document.getElementById('progressLog');
    
    const addLog = (message) => {
        const div = document.createElement('div');
        div.textContent = message;
        progressLog.appendChild(div);
    };
    
    addLog('Membuat konfigurasi aplikasi...');
    
    setTimeout(() => {
        addLog('Menjalankan migrasi database...');
    }, 1000);
    
    setTimeout(() => {
        addLog('Membuat data desa...');
    }, 2000);
    
    setTimeout(() => {
        addLog('Membuat akun administrator...');
    }, 3000);
    
    setTimeout(() => {
        addLog('Mengatur role dan permission...');
    }, 4000);
    
    fetch('{{ route("install.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('installProgress').classList.add('hidden');
        
        if (data.success) {
            document.getElementById('installSuccess').classList.remove('hidden');
        } else {
            document.getElementById('installError').classList.remove('hidden');
            document.getElementById('errorMessage').textContent = data.message;
            document.getElementById('actionButtons').classList.remove('hidden');
        }
    })
    .catch(error => {
        document.getElementById('installProgress').classList.add('hidden');
        document.getElementById('installError').classList.remove('hidden');
        document.getElementById('errorMessage').textContent = 'Error: ' + error.message;
        document.getElementById('actionButtons').classList.remove('hidden');
    });
}
</script>
@endsection

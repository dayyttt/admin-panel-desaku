@extends('install.layout')

@section('content')
@include('install.components.stepper', ['currentStep' => 3])

<div class="bg-white rounded-lg shadow-sm border p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Konfigurasi Database</h2>
        <p class="text-gray-600">Masukkan informasi koneksi database MySQL Anda</p>
    </div>

    <form method="POST" action="{{ route('install.database.save') }}" id="dbForm">
        @csrf
        
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Host Database</label>
                <input type="text" name="db_host" value="127.0.0.1" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Port</label>
                <input type="number" name="db_port" value="3306" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Database</label>
                <input type="text" name="db_name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="sgc_lesane">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" name="db_user" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="root">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="db_pass"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Kosongkan jika tidak ada password">
            </div>
        </div>

        <div id="testResult" class="hidden mb-6"></div>

        <div class="flex justify-between">
            <a href="{{ route('install.requirements') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-medium">
                ← Kembali
            </a>
            <div class="space-x-3">
                <button type="button" onclick="testConnection()" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg font-medium">
                    Test Koneksi
                </button>
                <button type="submit" id="submitBtn" disabled class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Lanjutkan →
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let connectionTested = false;

function testConnection() {
    const form = document.getElementById('dbForm');
    const formData = new FormData(form);
    const resultDiv = document.getElementById('testResult');
    const submitBtn = document.getElementById('submitBtn');
    
    resultDiv.innerHTML = '<div class="text-center py-2">Testing...</div>';
    resultDiv.classList.remove('hidden');
    
    fetch('{{ route("install.database.test") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-800">${data.message}</p>
                </div>
            `;
            connectionTested = true;
            submitBtn.disabled = false;
        } else {
            resultDiv.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">${data.message}</p>
                </div>
            `;
            connectionTested = false;
            submitBtn.disabled = true;
        }
    })
    .catch(error => {
        resultDiv.innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <p class="text-sm text-red-800">Error: ${error.message}</p>
            </div>
        `;
        connectionTested = false;
        submitBtn.disabled = true;
    });
}

document.getElementById('dbForm').addEventListener('submit', function(e) {
    if (!connectionTested) {
        e.preventDefault();
        alert('Silakan test koneksi database terlebih dahulu');
    }
});
</script>
@endsection

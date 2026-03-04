@extends('install.layout')

@section('content')
@include('install.components.stepper', ['currentStep' => 4])

<div class="bg-white rounded-lg shadow-sm border p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Informasi Desa</h2>
        <p class="text-gray-600">Pilih wilayah desa Anda</p>
    </div>

    <form method="POST" action="{{ route('install.desa.save') }}">
        @csrf
        
        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Provinsi <span class="text-red-500">*</span>
                    <span id="loading-provinsi" class="spinner" style="display: none;"></span>
                </label>
                <select name="provinsi" id="provinsi" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">Memuat data...</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kabupaten/Kota <span class="text-red-500">*</span>
                    <span id="loading-kabupaten" class="spinner" style="display: none;"></span>
                </label>
                <select name="kabupaten" id="kabupaten" required disabled
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100">
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kecamatan <span class="text-red-500">*</span>
                    <span id="loading-kecamatan" class="spinner" style="display: none;"></span>
                </label>
                <select name="kecamatan" id="kecamatan" required disabled
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Desa/Kelurahan (Referensi) <span class="text-red-500">*</span>
                    <span id="loading-desa" class="spinner" style="display: none;"></span>
                </label>
                <select id="desa" required disabled
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100">
                    <option value="">Pilih Desa/Kelurahan</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih dari daftar untuk auto-fill kode desa</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Desa <span class="text-red-500">*</span></label>
                <input type="text" name="nama_desa" id="nama_desa" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Contoh: Lesane">
                <p class="text-xs text-gray-500 mt-1">Nama desa Anda (bisa diedit manual)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Desa <span class="text-red-500">*</span></label>
                <input type="text" name="kode_desa" id="kode_desa" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Contoh: 9401012001" maxlength="13">
                <p class="text-xs text-gray-500 mt-1">Kode desa akan terisi otomatis atau bisa input manual</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                <input type="text" name="kode_pos" id="kode_pos"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    placeholder="Contoh: 96181" maxlength="5">
                <p class="text-xs text-gray-500 mt-1">Opsional - Kode pos wilayah desa Anda</p>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('install.database') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2.5 rounded-lg font-medium">
                ← Kembali
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium">
                Lanjutkan →
            </button>
        </div>
    </form>
</div>

<script>
const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

$(document).ready(function() {
    // Initialize Select2
    $('#provinsi, #kabupaten, #kecamatan, #desa').select2({
        placeholder: function() {
            return $(this).data('placeholder');
        },
        allowClear: false,
        width: '100%',
        language: {
            searching: function() {
                return "Mencari...";
            },
            noResults: function() {
                return "Tidak ada hasil";
            }
        }
    });
    
    loadProvinsi();
});

async function loadProvinsi() {
    const select = $('#provinsi');
    const loading = $('#loading-provinsi');
    
    try {
        loading.show();
        select.prop('disabled', true);
        
        const response = await fetch(`${API_BASE}/provinces.json`);
        if (!response.ok) throw new Error('Gagal memuat data provinsi');
        
        const data = await response.json();
        
        select.empty().append('<option value="">Pilih Provinsi</option>');
        
        data.forEach(item => {
            select.append(new Option(item.name, item.name, false, false))
                .find('option:last').attr('data-id', item.id);
        });
        
        select.prop('disabled', false).trigger('change');
    } catch (error) {
        console.error('Error:', error);
        select.empty().append('<option value="">Gagal memuat data - Coba refresh halaman</option>');
        alert('Gagal memuat data provinsi. Pastikan koneksi internet Anda aktif dan coba refresh halaman.');
    } finally {
        loading.hide();
    }
}

$('#provinsi').on('change', async function() {
    const selectedOption = $(this).find('option:selected');
    const provinsiId = selectedOption.attr('data-id');
    const loading = $('#loading-kabupaten');
    
    $('#kabupaten').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop('disabled', true).trigger('change');
    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true).trigger('change');
    $('#desa').empty().append('<option value="">Pilih Desa/Kelurahan</option>').prop('disabled', true).trigger('change');
    $('#kode_desa').val('');
    $('#nama_desa').val('');
    
    if (!provinsiId) return;
    
    try {
        loading.show();
        
        const response = await fetch(`${API_BASE}/regencies/${provinsiId}.json`);
        if (!response.ok) throw new Error('Gagal memuat data kabupaten');
        
        const data = await response.json();
        
        const select = $('#kabupaten');
        select.empty().append('<option value="">Pilih Kabupaten/Kota</option>');
        
        data.forEach(item => {
            select.append(new Option(item.name, item.name, false, false))
                .find('option:last').attr('data-id', item.id);
        });
        
        select.prop('disabled', false).trigger('change');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data kabupaten. Silakan coba lagi.');
    } finally {
        loading.hide();
    }
});

$('#kabupaten').on('change', async function() {
    const selectedOption = $(this).find('option:selected');
    const kabupatenId = selectedOption.attr('data-id');
    const loading = $('#loading-kecamatan');
    
    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true).trigger('change');
    $('#desa').empty().append('<option value="">Pilih Desa/Kelurahan</option>').prop('disabled', true).trigger('change');
    $('#kode_desa').val('');
    $('#nama_desa').val('');
    
    if (!kabupatenId) return;
    
    try {
        loading.show();
        
        const response = await fetch(`${API_BASE}/districts/${kabupatenId}.json`);
        if (!response.ok) throw new Error('Gagal memuat data kecamatan');
        
        const data = await response.json();
        
        const select = $('#kecamatan');
        select.empty().append('<option value="">Pilih Kecamatan</option>');
        
        data.forEach(item => {
            select.append(new Option(item.name, item.name, false, false))
                .find('option:last').attr('data-id', item.id);
        });
        
        select.prop('disabled', false).trigger('change');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data kecamatan. Silakan coba lagi.');
    } finally {
        loading.hide();
    }
});

$('#kecamatan').on('change', async function() {
    const selectedOption = $(this).find('option:selected');
    const kecamatanId = selectedOption.attr('data-id');
    const loading = $('#loading-desa');
    
    $('#desa').empty().append('<option value="">Pilih Desa/Kelurahan</option>').prop('disabled', true).trigger('change');
    $('#kode_desa').val('');
    $('#nama_desa').val('');
    
    if (!kecamatanId) return;
    
    try {
        loading.show();
        
        const response = await fetch(`${API_BASE}/villages/${kecamatanId}.json`);
        if (!response.ok) throw new Error('Gagal memuat data desa');
        
        const data = await response.json();
        
        const select = $('#desa');
        select.empty().append('<option value="">Pilih Desa/Kelurahan</option>');
        
        data.forEach(item => {
            select.append(new Option(item.name, item.name, false, false))
                .find('option:last').attr('data-id', item.id);
        });
        
        select.prop('disabled', false).trigger('change');
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data desa. Silakan coba lagi.');
    } finally {
        loading.hide();
    }
});

$('#desa').on('change', function() {
    const selectedOption = $(this).find('option:selected');
    const desaId = selectedOption.attr('data-id');
    const desaName = selectedOption.val();
    
    if (desaId && desaName) {
        // Auto-fill kode desa
        $('#kode_desa').val(desaId);
        // Auto-fill nama desa (bisa diedit manual)
        $('#nama_desa').val(desaName);
    }
});
</script>
@endsection

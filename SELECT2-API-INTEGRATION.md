# Select2 & API Wilayah Indonesia Integration

## Overview
Installation wizard menggunakan Select2 library dan API Wilayah Indonesia untuk dropdown cascade wilayah (Provinsi → Kabupaten → Kecamatan → Desa) dengan fitur search dan auto-fill kode desa.

## Features
✅ Dropdown cascade dengan dependency (Provinsi → Kabupaten → Kecamatan → Desa)
✅ Search functionality dalam dropdown (Select2)
✅ Loading indicators saat fetch data dari API
✅ Auto-fill kode desa dari API
✅ Error handling dengan user feedback
✅ Responsive & mobile-friendly
✅ Clean UI yang tidak terlihat AI-generated

## API Source
**API Wilayah Indonesia:** https://www.emsifa.com/api-wilayah-indonesia/

### Endpoints
- `GET /api/provinces.json` - List semua provinsi
- `GET /api/regencies/{provinsi_id}.json` - List kabupaten berdasarkan provinsi
- `GET /api/districts/{kabupaten_id}.json` - List kecamatan berdasarkan kabupaten
- `GET /api/villages/{kecamatan_id}.json` - List desa berdasarkan kecamatan

### Response Format
```json
[
  {
    "id": "11",
    "name": "ACEH"
  },
  {
    "id": "12",
    "name": "SUMATERA UTARA"
  }
]
```

## Select2 Configuration

### Library Version
- **Select2:** v4.1.0-rc.0
- **jQuery:** v3.6.0 (required dependency)

### CDN Links
```html
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
```

### Initialization
```javascript
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
```

### Custom Styling
```css
/* Select2 container */
.select2-container--default .select2-selection--single {
    height: 42px;
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
}

/* Selected text */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px;
    padding-left: 16px;
    color: #374151;
}

/* Dropdown arrow */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px;
    right: 8px;
}

/* Focus state - green theme */
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Dropdown */
.select2-dropdown {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
}

/* Highlighted option */
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #10b981;
}

/* Search field */
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    padding: 8px;
}
```

## Implementation Flow

### 1. Load Provinsi (Auto on Page Load)
```javascript
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
```

### 2. Load Kabupaten (On Provinsi Change)
```javascript
$('#provinsi').on('change', async function() {
    const selectedOption = $(this).find('option:selected');
    const provinsiId = selectedOption.attr('data-id');
    const loading = $('#loading-kabupaten');
    
    // Reset dependent dropdowns
    $('#kabupaten').empty().append('<option value="">Pilih Kabupaten/Kota</option>').prop('disabled', true).trigger('change');
    $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>').prop('disabled', true).trigger('change');
    $('#desa').empty().append('<option value="">Pilih Desa/Kelurahan</option>').prop('disabled', true).trigger('change');
    $('#kode_desa').val('');
    
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
```

### 3. Load Kecamatan (On Kabupaten Change)
Similar pattern dengan kabupaten, fetch dari `/districts/{kabupaten_id}.json`

### 4. Load Desa (On Kecamatan Change)
Similar pattern, fetch dari `/villages/{kecamatan_id}.json`

### 5. Auto-fill Kode Desa (On Desa Change)
```javascript
$('#desa').on('change', function() {
    const selectedOption = $(this).find('option:selected');
    const desaId = selectedOption.attr('data-id');
    
    if (desaId) {
        $('#kode_desa').val(desaId);
    } else {
        $('#kode_desa').val('');
    }
});
```

## Loading Indicators

### CSS Spinner Animation
```css
.spinner {
    border: 2px solid #f3f4f6;
    border-top: 2px solid #10b981;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    animation: spin 0.8s linear infinite;
    display: inline-block;
    margin-left: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
```

### HTML Implementation
```html
<label class="block text-sm font-medium text-gray-700 mb-2">
    Provinsi <span class="text-red-500">*</span>
    <span id="loading-provinsi" class="spinner" style="display: none;"></span>
</label>
```

### JavaScript Control
```javascript
// Show loading
loading.show();
select.prop('disabled', true);

// Hide loading
loading.hide();
select.prop('disabled', false);
```

## Error Handling

### Network Errors
```javascript
try {
    const response = await fetch(url);
    if (!response.ok) throw new Error('Gagal memuat data');
    // Process data
} catch (error) {
    console.error('Error:', error);
    alert('Gagal memuat data. Silakan coba lagi.');
}
```

### API Down Scenario
Jika API tidak bisa diakses:
1. Alert muncul dengan pesan error
2. User diminta refresh halaman
3. Dropdown menampilkan "Gagal memuat data"

### Future Enhancement: Offline Mode
- [ ] Fallback ke manual input jika API down
- [ ] Cache data wilayah di localStorage
- [ ] Retry mechanism dengan exponential backoff

## Data Flow

```
Page Load
    ↓
Load Provinsi (API Call)
    ↓
User Select Provinsi
    ↓
Load Kabupaten (API Call)
    ↓
User Select Kabupaten
    ↓
Load Kecamatan (API Call)
    ↓
User Select Kecamatan
    ↓
Load Desa (API Call)
    ↓
User Select Desa
    ↓
Auto-fill Kode Desa
    ↓
Submit Form
```

## Form Submission

### Data Sent to Backend
```php
[
    'provinsi' => 'PAPUA',
    'kabupaten' => 'JAYAPURA',
    'kecamatan' => 'SENTANI',
    'nama_desa' => 'LESANE',
    'kode_desa' => '9401012001',
    'kode_pos' => '96181' // optional
]
```

### Backend Validation
```php
$validated = $request->validate([
    'nama_desa' => 'required|string|max:255',
    'kode_desa' => 'required|string|max:20',
    'kecamatan' => 'required|string|max:255',
    'kabupaten' => 'required|string|max:255',
    'provinsi' => 'required|string|max:255',
    'kode_pos' => 'nullable|string|max:10',
]);
```

### Storage in Session
```php
session(['desa_info' => $validated]);
```

## Testing

### Manual Testing Checklist
- [ ] Page load → Provinsi dropdown loads automatically
- [ ] Search "Papua" in provinsi → Found and selectable
- [ ] Select provinsi → Kabupaten dropdown enables & loads
- [ ] Search in kabupaten → Works correctly
- [ ] Select kabupaten → Kecamatan dropdown enables & loads
- [ ] Select kecamatan → Desa dropdown enables & loads
- [ ] Select desa → Kode desa auto-fills
- [ ] Loading spinners → Visible during API calls
- [ ] Change provinsi → Kabupaten/Kecamatan/Desa reset
- [ ] Submit form → Data saved correctly
- [ ] Refresh page → Data persists in session

### Error Scenarios
- [ ] No internet → Alert shows, helpful message
- [ ] API timeout → Error handled gracefully
- [ ] Invalid API response → Error caught and displayed
- [ ] Empty API response → Dropdown shows "Tidak ada hasil"

### Browser Compatibility
- [ ] Chrome/Edge (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Considerations

### API Response Time
- Provinsi: ~200ms (34 items)
- Kabupaten: ~300ms (varies by provinsi)
- Kecamatan: ~300ms (varies by kabupaten)
- Desa: ~500ms (varies by kecamatan, can be 100+ items)

### Optimization Tips
1. **Caching:** Consider localStorage cache for provinsi (rarely changes)
2. **Debouncing:** Add debounce to search input (Select2 handles this)
3. **Lazy Loading:** Only load data when needed (already implemented)
4. **Compression:** API responses are already small JSON

## Troubleshooting

### Select2 Not Initializing
**Problem:** Dropdown looks like normal select, no search box
**Solution:**
- Check jQuery loaded before Select2
- Check Select2 CSS loaded
- Check browser console for errors
- Verify CDN links accessible

### API Not Loading
**Problem:** Dropdown stuck at "Memuat data..."
**Solution:**
- Check internet connection
- Test API endpoint directly: https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json
- Check browser console for CORS errors
- Verify API is not blocked by firewall

### Kode Desa Not Auto-filling
**Problem:** Kode desa field remains empty after selecting desa
**Solution:**
- Check data-id attribute set correctly
- Verify change event handler attached
- Check browser console for JavaScript errors

### Dropdown Not Cascading
**Problem:** Kabupaten doesn't load after selecting provinsi
**Solution:**
- Check data-id attribute on selected option
- Verify change event handler registered
- Check API endpoint URL construction
- Look for JavaScript errors in console

## Files Modified

### Views
- `resources/views/install/layout.blade.php` - Added Select2 CSS/JS, custom styling, spinner animation
- `resources/views/install/desa.blade.php` - Implemented dropdown cascade with Select2, loading indicators, error handling

### No Backend Changes Required
API integration is purely frontend (JavaScript), backend hanya menerima form submission seperti biasa.

## Future Enhancements

- [ ] Add offline mode dengan fallback manual input
- [ ] Cache provinsi data di localStorage
- [ ] Add retry mechanism untuk failed API calls
- [ ] Add progress indicator untuk multiple API calls
- [ ] Add option untuk import dari file CSV
- [ ] Add validation untuk kode desa format (10 digit)
- [ ] Add tooltip dengan informasi wilayah
- [ ] Add recent selections history

## References

- **Select2 Documentation:** https://select2.org/
- **API Wilayah Indonesia:** https://github.com/emsifa/api-wilayah-indonesia
- **jQuery Documentation:** https://api.jquery.com/

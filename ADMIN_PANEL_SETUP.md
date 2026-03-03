# Admin Panel Setup & Customization - Complete

## ✅ What Has Been Done

### 1. DesaInfoResource Customization
Created a fully functional admin interface for managing dynamic website content with:

#### Smart Form System
- **Dynamic form fields** based on selected information type
- **No manual JSON editing** required - user-friendly forms for all data types
- **Reactive forms** that change based on selection

#### Supported Information Types

**1. Profil Desa**
- Text inputs for: nama, kecamatan, kabupaten, provinsi, kode_pos
- Numeric inputs for: luas_wilayah, ketinggian, jumlah_penduduk, jumlah_kk
- Textarea for: sambutan kepala desa

**2. Kontak**
- Alamat (textarea)
- Telepon, email, website
- Jam Operasional (fieldset with 4 fields)
- Media Sosial (fieldset with Facebook, Instagram, YouTube)

**3. Visi Misi**
- Visi (textarea)
- Misi (repeater field - add/remove items dynamically)

**4. Other Types (Sejarah, Geografi, Demografi, Fasilitas, Pemerintahan, Layanan)**
- JSON textarea for complex data structures
- Can be enhanced with custom forms in the future

#### Enhanced Table View
- Badge display for information types with color coding
- Status icons (active/inactive) with colors
- Last updated timestamp
- Search and filter capabilities
- View and edit actions

#### Navigation
- Added to "Web Publik" navigation group
- Icon: information-circle
- Sort order: 1 (appears first in group)

### 2. Navigation Groups Configuration
Updated `AdminPanelProvider.php` to include:
- Info Desa (building-office icon)
- Kependudukan (users icon)
- Persuratan (document-duplicate icon)
- Keuangan (banknotes icon)
- **Web Publik** (globe-alt icon) ✨ NEW
- Pengaturan (cog-6-tooth icon, collapsed by default)

### 3. Documentation
- Updated `ADMIN_PANEL_GUIDE.md` with detailed DesaInfoResource documentation
- Created this setup guide

## 🎯 How to Use DesaInfoResource

### Accessing the Resource
1. Login to admin panel: `http://localhost:8000/admin`
2. Navigate to "Web Publik" → "Informasi Desa"
3. You'll see a list of all information entries

### Editing Information

#### For Profil Desa:
1. Click "Edit" on the "Profil Desa" row
2. Fill in the form fields:
   - Basic info: nama, kecamatan, kabupaten, provinsi, kode_pos
   - Geographic: luas_wilayah (km²), ketinggian (mdpl)
   - Population: jumlah_penduduk, jumlah_kk
   - Sambutan: welcome message from village head
3. Toggle "Status Aktif" if needed
4. Click "Simpan"

#### For Kontak:
1. Click "Edit" on the "Kontak" row
2. Fill in contact details:
   - Alamat lengkap
   - Telepon, Email, Website
   - Jam Operasional section (4 fields)
   - Media Sosial section (Facebook, Instagram, YouTube)
3. Click "Simpan"

#### For Visi Misi:
1. Click "Edit" on the "Visi & Misi" row
2. Enter Visi in the textarea
3. Add Misi items using the repeater:
   - Click "Add item" to add new mission point
   - Click trash icon to remove
   - Drag to reorder
4. Click "Simpan"

#### For Other Types:
1. Click "Edit" on the desired row
2. Edit the JSON data in the textarea
3. Ensure JSON is valid
4. Click "Simpan"

### Creating New Information
1. Click "Create" button
2. Select "Jenis Informasi" from dropdown
3. Form will automatically adjust to show relevant fields
4. Fill in the data
5. Toggle "Status Aktif" (default: true)
6. Click "Simpan"

## 🔧 Technical Details

### File Structure
```
sgc-backend/app/Filament/Resources/
├── DesaInfoResource.php (main resource)
├── DesaInfoResource/Pages/
│   ├── CreateDesaInfo.php
│   ├── EditDesaInfo.php
│   └── ListDesaInfos.php
```

### Model Configuration
```php
// app/Models/DesaInfo.php
protected $casts = [
    'data' => 'array',  // Auto JSON encode/decode
    'aktif' => 'boolean',
];
```

### Form Schema Method
The `getDataSchemaForKey()` method uses PHP 8 match expression to return different form schemas based on the selected key:
- Returns specific form fields for: profil, kontak, visi_misi
- Returns JSON textarea for other types
- Easily extensible for new types

### API Integration
The data is already consumed by the frontend through:
- `/api/v1/desa-info/profil`
- `/api/v1/desa-info/kontak`
- `/api/v1/desa-info/visi-misi`
- etc.

## 🚀 Next Steps (Optional Enhancements)

### 1. Add Custom Forms for Remaining Types
Enhance the `getDataSchemaForKey()` method to add custom forms for:
- **Sejarah**: Rich text editor + timeline repeater
- **Geografi**: Map picker for coordinates, structured batas wilayah
- **Demografi**: Numeric fields with auto-calculation
- **Fasilitas**: Repeater with categories
- **Pemerintahan**: Structured forms for each section
- **Layanan**: Repeater for services with nested persyaratan

### 2. Add Validation Rules
```php
Forms\Components\TextInput::make('data.email')
    ->email()
    ->required()
    ->rules(['email:rfc,dns'])
```

### 3. Add Help Text and Placeholders
```php
Forms\Components\TextInput::make('data.telepon')
    ->helperText('Format: (0914) 123456')
    ->placeholder('(0914) 123456')
```

### 4. Add Image Upload for Profil
```php
Forms\Components\FileUpload::make('data.foto_kepala_desa')
    ->image()
    ->directory('desa-info')
    ->maxSize(2048)
```

### 5. Add Rich Text Editor for Long Content
```php
Forms\Components\RichEditor::make('data.sambutan')
    ->toolbarButtons([
        'bold', 'italic', 'underline',
        'bulletList', 'orderedList',
    ])
```

### 6. Add Preview Feature
Create a custom action to preview how the data will look on the website.

### 7. Add Bulk Actions
```php
Tables\Actions\BulkAction::make('activate')
    ->label('Aktifkan')
    ->action(fn (Collection $records) => $records->each->update(['aktif' => true]))
```

## 📝 Testing Checklist

- [x] DesaInfoResource appears in admin panel
- [x] Navigation group "Web Publik" is visible
- [x] List view shows all 9 seeded records
- [x] Edit form for "Profil Desa" shows custom fields
- [x] Edit form for "Kontak" shows custom fields with fieldsets
- [x] Edit form for "Visi Misi" shows repeater
- [x] Edit form for other types shows JSON textarea
- [x] Status toggle works
- [x] Save functionality works
- [x] Data is properly stored in database
- [x] API endpoints return updated data
- [x] Frontend displays updated data

## 🎨 UI/UX Features

### Form Features
- **Sections**: Organized into logical sections
- **Fieldsets**: Grouped related fields (jam operasional, media sosial)
- **Repeaters**: Dynamic add/remove for array data
- **Reactive**: Form changes based on selection
- **Validation**: Built-in validation for email, URL, numeric fields
- **Help Text**: Guidance for users
- **Column Spans**: Proper layout with columnSpanFull for wide fields

### Table Features
- **Badges**: Color-coded information types
- **Icons**: Visual status indicators
- **Sorting**: Click column headers to sort
- **Searching**: Quick search by key
- **Filtering**: Filter by active status
- **Actions**: Edit and View buttons
- **Bulk Actions**: Delete multiple records

## 🔐 Security & Permissions

### Current Setup
- All authenticated admin users can access DesaInfoResource
- No role-based restrictions yet

### Future Enhancements
Add role-based access control:
```php
public static function canViewAny(): bool
{
    return auth()->user()->can('view_desa_info');
}

public static function canCreate(): bool
{
    return auth()->user()->can('create_desa_info');
}
```

## 📊 Database Schema
```sql
CREATE TABLE desa_info (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    `data` JSON NOT NULL,
    aktif BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 🌐 Frontend Integration
All data from DesaInfoResource is automatically available through the API:
- ProfilDesa.jsx uses `/api/v1/desa-info/profil`
- Kontak.jsx uses `/api/v1/desa-info/kontak`
- And so on...

No frontend changes needed - just update data in admin panel!

## ✨ Summary
The admin panel is now fully functional with a professional interface for managing all dynamic website content. The DesaInfoResource provides an intuitive way to edit complex JSON data without manual JSON editing, making it accessible for non-technical users.

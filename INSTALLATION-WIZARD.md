# Installation Wizard - SGC Desa Lesane

## Overview
Installation Wizard memudahkan deployment SGC Desa Lesane dengan proses instalasi step-by-step seperti WordPress. Tidak perlu lagi konfigurasi manual via terminal.

## Fitur

### 1. Auto-Redirect ke Installer
- Saat aplikasi belum terinstal, otomatis redirect ke `/install`
- Setelah terinstal, installer tidak bisa diakses lagi

### 2. Step-by-Step Installation

#### Step 1: Welcome
- Penjelasan proses instalasi
- Informasi yang dibutuhkan

#### Step 2: Requirements Check
- PHP >= 8.2
- Extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, GD
- Writable: .env, storage
- Visual indicator (✓ atau ✗) untuk setiap requirement

#### Step 3: Database Configuration
- Input: Host, Port, Database Name, Username, Password
- Tombol "Test Koneksi" untuk validasi sebelum lanjut
- Auto-update .env file

#### Step 4: Desa Information
- Nama Desa
- Kode Desa (10 digit)
- Kecamatan
- Kabupaten
- Provinsi
- Kode Pos (optional)

#### Step 5: Admin Account
- Nama Lengkap
- Email
- Username
- Password (min 8 karakter)
- Password Confirmation

#### Step 6: Finalize & Install
- Ringkasan konfigurasi
- Tombol "Mulai Instalasi"
- Progress log real-time
- Success/Error message
- Auto-redirect ke dashboard setelah sukses

## Proses Instalasi

Saat tombol "Mulai Instalasi" diklik:

1. Generate APP_KEY (jika belum ada)
2. Run migrations (`php artisan migrate --force`)
3. Create desa info di database
4. Run RolePermissionSeeder
5. Create admin user dengan role super_admin
6. Create `.installed` lock file di storage
7. Clear session data

## Lock Mechanism

File `.installed` di `storage/.installed` mencegah:
- Re-instalasi aplikasi
- Akses ke installer setelah instalasi selesai

## Middleware

### CheckInstalled
- Diterapkan ke semua route aplikasi
- Redirect ke `/install` jika belum terinstal

### CheckNotInstalled
- Diterapkan ke route installer
- Redirect ke `/admin` jika sudah terinstal

## Routes

```php
// Installation routes (middleware: check.not.installed)
/install                    - Welcome page
/install/requirements       - Requirements check
/install/database          - Database config
/install/database/test     - Test DB connection (POST)
/install/desa              - Desa info
/install/admin             - Admin account
/install/finalize          - Finalize & install
/install/install           - Process installation (POST)
```

## Deployment Workflow

### Fresh Installation

1. Upload files ke server
2. Buka domain (misal: https://desalesane.go.id)
3. Otomatis redirect ke `/install`
4. Ikuti wizard step-by-step
5. Selesai! Redirect ke dashboard

### Manual Reset (Development Only)

Untuk reset instalasi saat development:

```bash
# 1. Delete lock file
rm storage/.installed

# 2. Reset database
php artisan migrate:fresh

# 3. Akses /install lagi
```

## Security

- CSRF protection di semua form
- Password hashing dengan bcrypt
- Database connection test sebelum save
- Validation di setiap step
- Lock file mencegah re-instalasi

## Error Handling

- Database connection error → tampilkan pesan error detail
- Migration error → tampilkan error message
- Validation error → tampilkan di form
- General error → tampilkan di finalize page

## UI/UX

- Clean, simple design dengan Tailwind CSS
- Progress indicator di setiap step
- Visual feedback (loading, success, error)
- Responsive untuk mobile
- Keyboard-friendly forms

## Testing

### Test Requirements Check
```bash
# Akses /install/requirements
# Pastikan semua requirement ✓
```

### Test Database Connection
```bash
# Di step database:
# 1. Input kredensial salah → error message
# 2. Input kredensial benar → success message
# 3. Tombol "Lanjutkan" disabled sampai test berhasil
```

### Test Complete Installation
```bash
# 1. Ikuti semua step
# 2. Klik "Mulai Instalasi"
# 3. Lihat progress log
# 4. Redirect ke /admin setelah sukses
# 5. Coba akses /install → redirect ke /admin
```

## Troubleshooting

### Installer tidak muncul
- Cek apakah file `storage/.installed` ada
- Hapus file tersebut untuk reset

### Database connection error
- Cek kredensial database
- Pastikan MySQL service running
- Cek firewall/port 3306

### Migration error
- Pastikan database kosong atau fresh
- Cek permission user database
- Cek syntax error di migration files

### Permission error
- Pastikan storage/ writable: `chmod -R 775 storage`
- Pastikan .env writable: `chmod 664 .env`

## Future Enhancements

- [ ] Multi-language support
- [ ] Email configuration step
- [ ] Sample data seeder option
- [ ] Backup/restore during installation
- [ ] Installation log file
- [ ] Pre-flight check untuk server optimization
- [ ] Redis configuration (optional)
- [ ] SMTP test email

## Files Created

```
app/Http/Controllers/InstallController.php
app/Http/Middleware/CheckInstalled.php
app/Http/Middleware/CheckNotInstalled.php
resources/views/install/layout.blade.php
resources/views/install/welcome.blade.php
resources/views/install/requirements.blade.php
resources/views/install/database.blade.php
resources/views/install/desa.blade.php
resources/views/install/admin.blade.php
resources/views/install/finalize.blade.php
```

## Modified Files

```
bootstrap/app.php          - Register middleware aliases
routes/web.php            - Add installation routes
```

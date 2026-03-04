# Installation Wizard - Testing Guide

## Quick Start Testing

### Prerequisites
✅ Fresh database created: `sgc_test_install`
✅ Database credentials ready
✅ Internet connection active (untuk API Wilayah Indonesia)
✅ Browser: Chrome, Firefox, atau Safari (latest version)

### Database Setup
```bash
# Login ke MySQL
mysql -u root -p
# Password: ServBay.dev

# Create database
CREATE DATABASE sgc_test_install;
exit;
```

## Step-by-Step Testing

### 1. Access Installer
```
URL: http://localhost:8000
Expected: Auto-redirect ke /install
```

**Checklist:**
- [ ] Redirect otomatis ke /install
- [ ] Welcome page tampil dengan logo SGC
- [ ] Tombol "Mulai Instalasi" visible
- [ ] Footer menampilkan copyright

### 2. Requirements Check
```
URL: http://localhost:8000/install/requirements
```

**Checklist:**
- [ ] Semua requirements menampilkan status (✓ atau ✗)
- [ ] PHP >= 8.2 ✓
- [ ] All extensions ✓
- [ ] Writable .env ✓
- [ ] Writable storage ✓
- [ ] Tombol "Lanjutkan" enabled jika semua pass
- [ ] Tombol "Kembali" berfungsi

**Expected Output:**
```
✓ PHP >= 8.2
✓ BCMath Extension
✓ Ctype Extension
✓ JSON Extension
✓ Mbstring Extension
✓ OpenSSL Extension
✓ PDO Extension
✓ Tokenizer Extension
✓ XML Extension
✓ GD Extension
✓ Writable .env
✓ Writable storage
```

### 3. Database Configuration
```
URL: http://localhost:8000/install/database
```

**Test Data:**
```
Host: 127.0.0.1
Port: 3306
Database: sgc_test_install
Username: root
Password: ServBay.dev
```

**Checklist:**
- [ ] Form fields tampil dengan default values
- [ ] Tombol "Test Koneksi" berfungsi
- [ ] Test koneksi berhasil → Success message muncul
- [ ] Test koneksi gagal → Error message muncul
- [ ] Tombol "Lanjutkan" berfungsi setelah test berhasil
- [ ] Data tersimpan di .env file

**Test Scenarios:**

#### Scenario A: Valid Credentials
1. Input credentials di atas
2. Klik "Test Koneksi"
3. Expected: Alert "Koneksi database berhasil!"
4. Klik "Lanjutkan"
5. Expected: Redirect ke /install/desa

#### Scenario B: Invalid Credentials
1. Input password salah: "wrongpassword"
2. Klik "Test Koneksi"
3. Expected: Alert "Koneksi gagal: Access denied..."
4. Tombol "Lanjutkan" tetap disabled

### 4. Desa Information (Select2 & API Integration)
```
URL: http://localhost:8000/install/desa
```

**Checklist - Initial Load:**
- [ ] Provinsi dropdown loading (spinner visible)
- [ ] Provinsi dropdown populated setelah load
- [ ] Kabupaten dropdown disabled dengan text "Pilih Kabupaten/Kota"
- [ ] Kecamatan dropdown disabled
- [ ] Desa dropdown disabled
- [ ] Kode desa field readonly & empty

**Test Flow:**

#### Step 1: Select Provinsi
1. Klik dropdown Provinsi
2. Expected: Search box muncul (Select2)
3. Type "Papua"
4. Expected: Filter results, "PAPUA" muncul
5. Select "PAPUA"
6. Expected:
   - Loading spinner muncul di label Kabupaten
   - Kabupaten dropdown enabled setelah load
   - Kabupaten dropdown populated dengan data

**Checklist:**
- [ ] Search functionality works
- [ ] Loading spinner visible
- [ ] Kabupaten dropdown enables
- [ ] Kabupaten dropdown has options

#### Step 2: Select Kabupaten
1. Klik dropdown Kabupaten
2. Type "Jayapura"
3. Select "JAYAPURA"
4. Expected:
   - Loading spinner muncul di label Kecamatan
   - Kecamatan dropdown enabled setelah load
   - Kecamatan dropdown populated

**Checklist:**
- [ ] Search works in Kabupaten
- [ ] Loading spinner visible
- [ ] Kecamatan dropdown enables
- [ ] Kecamatan dropdown has options

#### Step 3: Select Kecamatan
1. Klik dropdown Kecamatan
2. Select "SENTANI"
3. Expected:
   - Loading spinner muncul di label Desa
   - Desa dropdown enabled setelah load
   - Desa dropdown populated

**Checklist:**
- [ ] Loading spinner visible
- [ ] Desa dropdown enables
- [ ] Desa dropdown has options

#### Step 4: Select Desa
1. Klik dropdown Desa
2. Type "Lesane" (if available, or select any desa)
3. Select desa
4. Expected:
   - Kode desa field auto-fills dengan ID desa
   - Kode desa field readonly

**Checklist:**
- [ ] Desa selection works
- [ ] Kode desa auto-fills
- [ ] Kode desa is readonly

#### Step 5: Optional Kode Pos
1. Input kode pos: "96181"
2. Expected: Field accepts input

#### Step 6: Submit
1. Klik "Lanjutkan"
2. Expected: Redirect ke /install/admin

**Checklist:**
- [ ] Form validation passes
- [ ] Redirect successful
- [ ] Data saved in session

**Test Cascade Reset:**
1. Select Provinsi → Kabupaten → Kecamatan → Desa
2. Change Provinsi
3. Expected:
   - Kabupaten reset to "Pilih Kabupaten/Kota"
   - Kecamatan reset & disabled
   - Desa reset & disabled
   - Kode desa cleared

**Checklist:**
- [ ] Cascade reset works correctly
- [ ] All dependent dropdowns reset
- [ ] Kode desa cleared

### 5. Admin Account
```
URL: http://localhost:8000/install/admin
```

**Test Data:**
```
Name: Admin Desa Lesane
Email: admin@desalesane.id
Username: admin
Password: password123
Confirm Password: password123
```

**Checklist:**
- [ ] All fields visible
- [ ] Password field type="password" (hidden)
- [ ] Confirm password field type="password"
- [ ] Form validation works
- [ ] Submit redirects to /install/finalize

**Test Scenarios:**

#### Scenario A: Valid Data
1. Input data di atas
2. Klik "Lanjutkan"
3. Expected: Redirect ke /install/finalize

#### Scenario B: Password Mismatch
1. Password: "password123"
2. Confirm: "password456"
3. Klik "Lanjutkan"
4. Expected: Validation error "Password tidak cocok"

#### Scenario C: Short Password
1. Password: "pass"
2. Klik "Lanjutkan"
3. Expected: Validation error "Password minimal 8 karakter"

### 6. Finalize & Install
```
URL: http://localhost:8000/install/finalize
```

**Checklist:**
- [ ] Review information displayed
- [ ] Tombol "Install Sekarang" visible
- [ ] Tombol "Kembali" berfungsi

**Installation Process:**
1. Klik "Install Sekarang"
2. Expected:
   - Loading indicator muncul
   - Progress messages (optional)
   - Success message setelah selesai
   - Auto-redirect ke /admin/login

**Checklist:**
- [ ] Installation starts
- [ ] No errors in browser console
- [ ] Success message appears
- [ ] Redirect to /admin/login
- [ ] File `storage/.installed` created

**Backend Verification:**
```bash
# Check .installed file
ls -la storage/.installed

# Check database
mysql -u root -p sgc_test_install
SHOW TABLES;
SELECT * FROM users;
SELECT * FROM desa_infos;
SELECT * FROM roles;
exit;
```

**Expected Tables:**
- users (1 admin user)
- desa_infos (1 record)
- roles (4 roles: super_admin, admin, operator, viewer)
- permissions (many records)
- role_has_permissions (many records)
- model_has_roles (1 record: admin user has super_admin role)

### 7. Post-Installation
```
URL: http://localhost:8000/admin/login
```

**Test Login:**
```
Email/Username: admin
Password: password123
```

**Checklist:**
- [ ] Login page accessible
- [ ] Login with email works
- [ ] Login with username works
- [ ] Redirect to dashboard after login
- [ ] Dashboard loads without errors
- [ ] Sidebar menu visible
- [ ] User info displayed

**Test Installer Lock:**
1. Try access: http://localhost:8000/install
2. Expected: Redirect to /admin
3. Try access: http://localhost:8000/install/desa
4. Expected: Redirect to /admin

**Checklist:**
- [ ] Installer routes blocked
- [ ] All installer URLs redirect to /admin
- [ ] Lock mechanism working

## Error Testing

### Test API Failure
1. Disconnect internet
2. Access /install/desa
3. Expected:
   - Provinsi dropdown shows "Gagal memuat data"
   - Alert appears with helpful message
   - User can refresh to retry

### Test Database Failure
1. Stop MySQL service
2. Try test connection in database step
3. Expected: Error message "Connection refused"

### Test Invalid Session
1. Complete step 1-3
2. Clear browser cookies/session
3. Try access step 4
4. Expected: Redirect to step 1 or error handling

## Performance Testing

### API Response Times
- [ ] Provinsi load: < 1 second
- [ ] Kabupaten load: < 1 second
- [ ] Kecamatan load: < 1 second
- [ ] Desa load: < 2 seconds (can be 100+ items)

### Installation Time
- [ ] Complete installation: < 30 seconds
- [ ] Migration execution: < 10 seconds
- [ ] Seeder execution: < 5 seconds

## Browser Compatibility

### Desktop
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)

### Mobile
- [ ] iOS Safari
- [ ] Chrome Mobile
- [ ] Firefox Mobile

## Cleanup & Re-test

### Reset Installation
```bash
# 1. Delete lock file
rm storage/.installed

# 2. Drop database
mysql -u root -p
DROP DATABASE sgc_test_install;
CREATE DATABASE sgc_test_install;
exit;

# 3. Reset .env (optional)
# Restore original DB credentials if changed

# 4. Clear browser cache & cookies

# 5. Access http://localhost:8000
# Should redirect to /install
```

## Common Issues & Solutions

### Issue: Provinsi dropdown tidak load
**Solution:**
- Check internet connection
- Check browser console for errors
- Test API directly: https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json
- Refresh page

### Issue: Select2 tidak muncul (no search box)
**Solution:**
- Check jQuery loaded (view page source)
- Check Select2 CSS/JS loaded
- Clear browser cache
- Check browser console for errors

### Issue: Kode desa tidak auto-fill
**Solution:**
- Check browser console for JavaScript errors
- Verify data-id attribute on selected option
- Check change event handler

### Issue: Installation stuck/timeout
**Solution:**
- Check database connection
- Check migration files for errors
- Check seeder files for errors
- Increase PHP max_execution_time

### Issue: Redirect loop after installation
**Solution:**
- Check .installed file exists
- Check middleware registered correctly
- Clear browser cache
- Check session configuration

## Success Criteria

✅ All 6 steps completed without errors
✅ Select2 dropdowns work with search
✅ API integration loads all wilayah data
✅ Kode desa auto-fills correctly
✅ Database configured and migrations run
✅ Admin user created with super_admin role
✅ Lock file created
✅ Installer routes blocked after installation
✅ Login successful
✅ Dashboard loads without errors

## Reporting Issues

When reporting issues, include:
1. Step number where error occurred
2. Browser & version
3. Error message (screenshot)
4. Browser console errors (F12 → Console)
5. Network tab errors (F12 → Network)
6. PHP error logs (storage/logs/laravel.log)

## Next Steps After Testing

1. Change SESSION_DRIVER back to 'database' in .env
2. Run `php artisan config:cache`
3. Test with production-like data
4. Run seeders for dummy data (optional)
5. Configure email settings
6. Set up backup schedule
7. Deploy to staging/production

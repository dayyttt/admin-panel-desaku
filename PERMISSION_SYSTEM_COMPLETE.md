# Permission System - Implementation Complete

## Overview
Implementasi sistem permission menggunakan Spatie Laravel Permission untuk kontrol akses yang granular dan fleksibel.

## System Architecture

### Dual Permission System
Sistem menggunakan 2 layer permission:

1. **Navigation Level** (via `shouldRegisterNavigation()`)
   - Menyembunyikan menu dari sidebar
   - Berdasarkan field `tipe` di tabel users
   - Quick & simple untuk UX

2. **Action Level** (via Spatie Permission)
   - Kontrol akses CRUD operations
   - Granular permissions per action
   - Dapat dikustomisasi per user

## Roles Created

### 1. SUPERADMIN
- **Total Permissions**: 71 (ALL)
- **Access Level**: Full Access
- **Users**: superadmin

### 2. OPERATOR
- **Total Permissions**: 59
- **Access Level**: Operational Access
- **Users**: operator, kaur_pemerintahan, kaur_kesra, kaur_umum, bendahara, staff_it

### 3. KEPALA_DESA
- **Total Permissions**: 17
- **Access Level**: View & Approve Only
- **Users**: kades

## Permission Matrix

### 📁 KEPENDUDUKAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_penduduk | ✅ | ✅ | ✅ |
| create_penduduk | ✅ | ✅ | ❌ |
| edit_penduduk | ✅ | ✅ | ❌ |
| delete_penduduk | ✅ | ✅ | ❌ |
| export_penduduk | ✅ | ✅ | ❌ |
| view_keluarga | ✅ | ✅ | ✅ |
| create_keluarga | ✅ | ✅ | ❌ |
| edit_keluarga | ✅ | ✅ | ❌ |
| delete_keluarga | ✅ | ✅ | ❌ |
| view_kelahiran | ✅ | ✅ | ✅ |
| create_kelahiran | ✅ | ✅ | ❌ |
| edit_kelahiran | ✅ | ✅ | ❌ |
| delete_kelahiran | ✅ | ✅ | ❌ |
| view_kematian | ✅ | ✅ | ✅ |
| create_kematian | ✅ | ✅ | ❌ |
| edit_kematian | ✅ | ✅ | ❌ |
| delete_kematian | ✅ | ✅ | ❌ |
| view_mutasi | ✅ | ✅ | ❌ |
| create_mutasi | ✅ | ❌ | ❌ |

### 📁 PERSURATAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_surat | ✅ | ✅ | ✅ |
| create_surat | ✅ | ✅ | ❌ |
| edit_surat | ✅ | ✅ | ❌ |
| delete_surat | ✅ | ✅ | ❌ |
| approve_surat | ✅ | ❌ | ✅ |
| print_surat | ✅ | ✅ | ✅ |
| view_surat_kategori | ✅ | ✅ | ❌ |
| manage_surat_kategori | ✅ | ✅ | ❌ |
| view_surat_jenis | ✅ | ✅ | ❌ |
| manage_surat_jenis | ✅ | ✅ | ❌ |
| view_surat_template | ✅ | ✅ | ✅ |
| manage_surat_template | ✅ | ✅ | ❌ |

### 📁 KEUANGAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_keuangan | ✅ | ✅ | ✅ |
| create_keuangan | ✅ | ✅ | ❌ |
| edit_keuangan | ✅ | ✅ | ❌ |
| delete_keuangan | ✅ | ❌ | ❌ |
| verify_keuangan | ✅ | ❌ | ❌ |
| view_apbdes | ✅ | ✅ | ✅ |
| manage_apbdes | ✅ | ❌ | ❌ |
| view_laporan_keuangan | ✅ | ✅ | ✅ |

### 📁 PEMBANGUNAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_pembangunan | ✅ | ✅ | ✅ |
| create_pembangunan | ✅ | ✅ | ❌ |
| edit_pembangunan | ✅ | ✅ | ❌ |
| delete_pembangunan | ✅ | ✅ | ❌ |

### 📁 BANTUAN SOSIAL

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_bantuan | ✅ | ✅ | ✅ |
| create_bantuan | ✅ | ✅ | ❌ |
| edit_bantuan | ✅ | ✅ | ❌ |
| delete_bantuan | ✅ | ✅ | ❌ |

### 📁 ASET & INVENTARIS

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_aset | ✅ | ✅ | ✅ |
| create_aset | ✅ | ✅ | ❌ |
| edit_aset | ✅ | ✅ | ❌ |
| delete_aset | ✅ | ✅ | ❌ |
| view_aset_kategori | ✅ | ✅ | ❌ |
| manage_aset_kategori | ✅ | ✅ | ❌ |

### 📁 SEKRETARIAT

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_sekretariat | ✅ | ✅ | ✅ |
| create_sekretariat | ✅ | ✅ | ❌ |
| edit_sekretariat | ✅ | ✅ | ❌ |
| delete_sekretariat | ✅ | ✅ | ❌ |

### 📁 WEB PUBLIK

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_web | ✅ | ✅ | ❌ |
| create_web | ✅ | ✅ | ❌ |
| edit_web | ✅ | ✅ | ❌ |
| delete_web | ✅ | ✅ | ❌ |
| publish_web | ✅ | ✅ | ❌ |

### 📁 PENGATURAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_users | ✅ | ❌ | ❌ |
| create_users | ✅ | ❌ | ❌ |
| edit_users | ✅ | ❌ | ❌ |
| delete_users | ✅ | ❌ | ❌ |
| view_config | ✅ | ❌ | ❌ |
| edit_config | ✅ | ❌ | ❌ |
| view_logs | ✅ | ❌ | ❌ |

### 📁 LAPORAN

| Permission | Superadmin | Operator | Kepala Desa |
|------------|-----------|----------|-------------|
| view_laporan | ✅ | ✅ | ✅ |
| export_laporan | ✅ | ✅ | ✅ |

## Permission Categories

| Category | Count | Description |
|----------|-------|-------------|
| View | 22 | Read access to resources |
| Create | 13 | Create new records |
| Edit | 13 | Modify existing records |
| Delete | 12 | Remove records |
| Manage | 5 | Full CRUD for categories/settings |
| Export | 2 | Export data to Excel/PDF |
| Approve | 1 | Approve surat (Kepala Desa) |
| Print | 1 | Print documents |
| Verify | 1 | Verify financial transactions |
| Publish | 1 | Publish web content |

## Usage in Code

### Check Permission in Controller
```php
if (auth()->user()->can('create_penduduk')) {
    // User can create penduduk
}
```

### Check Permission in Blade
```blade
@can('edit_surat')
    <button>Edit Surat</button>
@endcan
```

### Check Permission in Resource
```php
public static function canCreate(): bool
{
    return auth()->user()->can('create_penduduk');
}

public static function canEdit(Model $record): bool
{
    return auth()->user()->can('edit_penduduk');
}

public static function canDelete(Model $record): bool
{
    return auth()->user()->can('delete_penduduk');
}
```

### Check Multiple Permissions
```php
// Has ANY of these permissions
if (auth()->user()->hasAnyPermission(['create_surat', 'edit_surat'])) {
    // ...
}

// Has ALL of these permissions
if (auth()->user()->hasAllPermissions(['view_surat', 'approve_surat'])) {
    // ...
}
```

## User Role Assignment

All users automatically assigned roles based on their `tipe` field:

```php
// In RolePermissionSeeder
switch ($user->tipe) {
    case 'superadmin':
        $user->assignRole('superadmin');
        break;
    case 'operator':
        $user->assignRole('operator');
        break;
    case 'kepala_desa':
        $user->assignRole('kepala_desa');
        break;
}
```

## Key Features

### 1. Kepala Desa Special Permissions
- **approve_surat**: Dapat approve permohonan surat
- **print_surat**: Dapat print surat yang sudah disetujui
- **view_***: View-only access untuk monitoring

### 2. Operator Restrictions
- **NO delete_keuangan**: Tidak bisa hapus transaksi keuangan
- **NO verify_keuangan**: Tidak bisa verifikasi transaksi
- **NO manage_apbdes**: Tidak bisa kelola APBDes structure
- **NO create_mutasi**: Mutasi otomatis dari sistem

### 3. Superadmin Full Access
- All 71 permissions
- Can manage users, config, logs
- Can verify & delete financial records

## Commands

### View User Permissions
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->getAllPermissions();
>>> $user->roles;
```

### Assign Permission to User
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->givePermissionTo('create_surat');
```

### Revoke Permission
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->revokePermissionTo('delete_penduduk');
```

### Sync Permissions
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->syncPermissions(['view_surat', 'create_surat']);
```

## Database Tables

Spatie Permission creates these tables:
- `roles` - Role definitions
- `permissions` - Permission definitions
- `model_has_roles` - User-Role assignments
- `model_has_permissions` - Direct user permissions
- `role_has_permissions` - Role-Permission assignments

## Files Created/Modified

1. `sgc-backend/database/seeders/RolePermissionSeeder.php` - Seeder for roles & permissions
2. `sgc-backend/app/Models/User.php` - Already has `HasRoles` trait

## Next Steps (Optional)

1. **Implement in Resources**: Add permission checks to Filament Resources
2. **Policy Classes**: Create Laravel Policies for models
3. **Middleware**: Add permission middleware to routes
4. **Custom Permissions**: Allow superadmin to create custom permissions via UI
5. **Permission Groups**: Group related permissions for easier management

---

**Status**: ✅ Complete
**Date**: 2026-03-02
**Total Permissions**: 71
**Total Roles**: 3
**Users with Roles**: 8/8

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // CREATE PERMISSIONS
        // ========================================
        
        $permissions = [
            // Kependudukan
            'view_penduduk',
            'create_penduduk',
            'edit_penduduk',
            'delete_penduduk',
            'export_penduduk',
            'view_keluarga',
            'create_keluarga',
            'edit_keluarga',
            'delete_keluarga',
            'view_kelahiran',
            'create_kelahiran',
            'edit_kelahiran',
            'delete_kelahiran',
            'view_kematian',
            'create_kematian',
            'edit_kematian',
            'delete_kematian',
            'view_mutasi',
            'create_mutasi',
            
            // Persuratan
            'view_surat',
            'create_surat',
            'edit_surat',
            'delete_surat',
            'approve_surat',
            'print_surat',
            'view_surat_kategori',
            'manage_surat_kategori',
            'view_surat_jenis',
            'manage_surat_jenis',
            'view_surat_template',
            'manage_surat_template',
            
            // Keuangan
            'view_keuangan',
            'create_keuangan',
            'edit_keuangan',
            'delete_keuangan',
            'verify_keuangan',
            'view_apbdes',
            'manage_apbdes',
            'view_laporan_keuangan',
            
            // Pembangunan
            'view_pembangunan',
            'create_pembangunan',
            'edit_pembangunan',
            'delete_pembangunan',
            
            // Bantuan Sosial
            'view_bantuan',
            'create_bantuan',
            'edit_bantuan',
            'delete_bantuan',
            
            // Aset & Inventaris
            'view_aset',
            'create_aset',
            'edit_aset',
            'delete_aset',
            'view_aset_kategori',
            'manage_aset_kategori',
            
            // Sekretariat
            'view_sekretariat',
            'create_sekretariat',
            'edit_sekretariat',
            'delete_sekretariat',
            
            // Web Publik
            'view_web',
            'create_web',
            'edit_web',
            'delete_web',
            'publish_web',
            
            // Pengaturan
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_config',
            'edit_config',
            'view_logs',
            
            // Laporan
            'view_laporan',
            'export_laporan',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ========================================
        // CREATE ROLES & ASSIGN PERMISSIONS
        // ========================================

        // 1. SUPERADMIN - Full Access
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $superadmin->syncPermissions(Permission::all());

        // 2. OPERATOR - Operational Access
        $operator = Role::firstOrCreate(['name' => 'operator']);
        $operator->syncPermissions([
            // Kependudukan - Full
            'view_penduduk', 'create_penduduk', 'edit_penduduk', 'delete_penduduk', 'export_penduduk',
            'view_keluarga', 'create_keluarga', 'edit_keluarga', 'delete_keluarga',
            'view_kelahiran', 'create_kelahiran', 'edit_kelahiran', 'delete_kelahiran',
            'view_kematian', 'create_kematian', 'edit_kematian', 'delete_kematian',
            'view_mutasi',
            
            // Persuratan - Full
            'view_surat', 'create_surat', 'edit_surat', 'delete_surat', 'print_surat',
            'view_surat_kategori', 'manage_surat_kategori',
            'view_surat_jenis', 'manage_surat_jenis',
            'view_surat_template', 'manage_surat_template',
            
            // Keuangan - Create & View
            'view_keuangan', 'create_keuangan', 'edit_keuangan',
            'view_apbdes', 'view_laporan_keuangan',
            
            // Pembangunan - Full
            'view_pembangunan', 'create_pembangunan', 'edit_pembangunan', 'delete_pembangunan',
            
            // Bantuan Sosial - Full
            'view_bantuan', 'create_bantuan', 'edit_bantuan', 'delete_bantuan',
            
            // Aset - Full
            'view_aset', 'create_aset', 'edit_aset', 'delete_aset',
            'view_aset_kategori', 'manage_aset_kategori',
            
            // Sekretariat - Full
            'view_sekretariat', 'create_sekretariat', 'edit_sekretariat', 'delete_sekretariat',
            
            // Web Publik - Full
            'view_web', 'create_web', 'edit_web', 'delete_web', 'publish_web',
            
            // Laporan
            'view_laporan', 'export_laporan',
        ]);

        // 3. KEPALA DESA - View & Approve Only
        $kepalaDesa = Role::firstOrCreate(['name' => 'kepala_desa']);
        $kepalaDesa->syncPermissions([
            // Kependudukan - View Only
            'view_penduduk', 'view_keluarga', 'view_kelahiran', 'view_kematian',
            
            // Persuratan - View & Approve
            'view_surat', 'approve_surat', 'print_surat',
            'view_surat_template',
            
            // Keuangan - View Only
            'view_keuangan', 'view_apbdes', 'view_laporan_keuangan',
            
            // Pembangunan - View Only
            'view_pembangunan',
            
            // Bantuan Sosial - View Only
            'view_bantuan',
            
            // Aset - View Only
            'view_aset',
            
            // Sekretariat - View Only
            'view_sekretariat',
            
            // Laporan
            'view_laporan', 'export_laporan',
        ]);

        // ========================================
        // ASSIGN ROLES TO USERS
        // ========================================

        // Assign berdasarkan field 'tipe'
        $users = User::all();
        foreach ($users as $user) {
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
        }

        $this->command->info('✅ Roles & Permissions created successfully!');
        $this->command->info('📊 Total Permissions: ' . Permission::count());
        $this->command->info('👥 Total Roles: ' . Role::count());
        $this->command->info('🔗 Users assigned to roles: ' . User::role(['superadmin', 'operator', 'kepala_desa'])->count());
    }
}

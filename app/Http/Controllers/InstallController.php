<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\DesaConfig;

class InstallController extends Controller
{
    public function index()
    {
        if ($this->isInstalled()) {
            return redirect('/admin');
        }
        return view('install.welcome');
    }

    public function requirements()
    {
        $requirements = [
            'PHP >= 8.2' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'BCMath Extension' => extension_loaded('bcmath'),
            'Ctype Extension' => extension_loaded('ctype'),
            'JSON Extension' => extension_loaded('json'),
            'Mbstring Extension' => extension_loaded('mbstring'),
            'OpenSSL Extension' => extension_loaded('openssl'),
            'PDO Extension' => extension_loaded('pdo'),
            'Tokenizer Extension' => extension_loaded('tokenizer'),
            'XML Extension' => extension_loaded('xml'),
            'GD Extension' => extension_loaded('gd'),
            'Writable .env' => is_writable(base_path('.env')) || !file_exists(base_path('.env')),
            'Writable storage' => is_writable(storage_path()),
        ];

        $allPassed = !in_array(false, $requirements);

        return view('install.requirements', compact('requirements', 'allPassed'));
    }

    public function database()
    {
        return view('install.database');
    }

    public function testDatabase(Request $request)
    {
        $validated = $request->validate([
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        try {
            $pdo = new \PDO(
                "mysql:host={$validated['db_host']};port={$validated['db_port']};dbname={$validated['db_name']}",
                $validated['db_user'],
                $validated['db_pass']
            );
            
            return response()->json(['success' => true, 'message' => 'Koneksi database berhasil!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Koneksi gagal: ' . $e->getMessage()], 400);
        }
    }

    public function saveDatabase(Request $request)
    {
        $validated = $request->validate([
            'db_host' => 'required',
            'db_port' => 'required|numeric',
            'db_name' => 'required',
            'db_user' => 'required',
            'db_pass' => 'nullable',
        ]);

        $this->updateEnv([
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $validated['db_host'],
            'DB_PORT' => $validated['db_port'],
            'DB_DATABASE' => $validated['db_name'],
            'DB_USERNAME' => $validated['db_user'],
            'DB_PASSWORD' => $validated['db_pass'] ?? '',
        ]);

        return redirect()->route('install.desa');
    }

    public function desa()
    {
        return view('install.desa');
    }

    public function saveDesa(Request $request)
    {
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255',
            'kode_desa' => 'required|string|max:20',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        session(['desa_info' => $validated]);

        return redirect()->route('install.admin');
    }

    public function admin()
    {
        return view('install.admin');
    }

    public function saveAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255|alpha_dash',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',      // harus ada huruf kecil
                'regex:/[A-Z]/',      // harus ada huruf besar
                'regex:/[0-9]/',      // harus ada angka
                'regex:/[@$!%*#?&]/', // harus ada simbol
            ],
        ], [
            'password.min' => 'Password minimal 8 karakter',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol (@$!%*#?&)',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash dan underscore',
        ]);

        session(['admin_info' => $validated]);

        return redirect()->route('install.finalize');
    }

    public function finalize()
    {
        return view('install.finalize');
    }

    public function install()
    {
        try {
            // Generate APP_KEY if not exists
            if (empty(env('APP_KEY'))) {
                Artisan::call('key:generate', ['--force' => true]);
            }

            // Run migrations
            Artisan::call('migrate', ['--force' => true]);

            // Create or update desa config
            $desaInfo = session('desa_info');
            DesaConfig::updateOrCreate(
                ['id' => 1], // Only one config record
                [
                    'nama_desa' => $desaInfo['nama_desa'],
                    'kode_desa' => $desaInfo['kode_desa'],
                    'nama_kecamatan' => $desaInfo['kecamatan'],
                    'nama_kabupaten' => $desaInfo['kabupaten'],
                    'nama_provinsi' => $desaInfo['provinsi'],
                    'kode_pos' => $desaInfo['kode_pos'] ?? null,
                ]
            );

            // Run seeders for roles and permissions first
            Artisan::call('db:seed', ['--class' => 'RolePermissionSeeder', '--force' => true]);

            // Create or update admin user
            $adminInfo = session('admin_info');
            $user = User::updateOrCreate(
                ['email' => $adminInfo['email']],
                [
                    'name' => $adminInfo['name'],
                    'username' => $adminInfo['username'],
                    'password' => Hash::make($adminInfo['password']),
                    'tipe' => 'superadmin',
                    'aktif' => true,
                ]
            );

            // Assign superadmin role (sync to avoid duplicates)
            $user->syncRoles(['superadmin']);

            // Create .installed lock file
            file_put_contents(storage_path('.installed'), date('Y-m-d H:i:s'));

            // Clear sessions
            session()->forget(['desa_info', 'admin_info']);

            return response()->json(['success' => true, 'message' => 'Instalasi berhasil!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Instalasi gagal: ' . $e->getMessage()], 500);
        }
    }

    private function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        
        if (!file_exists($envPath)) {
            copy(base_path('.env.example'), $envPath);
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $value = $this->formatEnvValue($value);
            
            if (preg_match("/^{$key}=/m", $envContent)) {
                $envContent = preg_replace(
                    "/^{$key}=.*/m",
                    "{$key}={$value}",
                    $envContent
                );
            } else {
                $envContent .= "\n{$key}={$value}";
            }
        }

        file_put_contents($envPath, $envContent);
    }

    private function formatEnvValue($value)
    {
        if (empty($value)) {
            return '""';
        }
        
        if (preg_match('/\s/', $value)) {
            return '"' . str_replace('"', '\"', $value) . '"';
        }
        
        return $value;
    }

    private function isInstalled()
    {
        return file_exists(storage_path('.installed'));
    }
}

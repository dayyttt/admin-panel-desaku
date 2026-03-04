# Quick Start - Deployment SGC Desa Lesane

## Persiapan

### 1. Requirement Server
- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js & NPM (untuk build assets)
- Web Server (Apache/Nginx)

### 2. Persiapan Database
```sql
CREATE DATABASE sgc_lesane CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sgc_user'@'localhost' IDENTIFIED BY 'password_aman';
GRANT ALL PRIVILEGES ON sgc_lesane.* TO 'sgc_user'@'localhost';
FLUSH PRIVILEGES;
```

## Deployment Steps

### Method 1: Upload ke Hosting (Recommended)

#### 1. Build di Local
```bash
# Clone repository
git clone https://github.com/yourusername/sgc-backend.git
cd sgc-backend

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Buat zip untuk upload
zip -r sgc-lesane.zip . -x "node_modules/*" ".git/*" "tests/*"
```

#### 2. Upload ke Server
- Upload `sgc-lesane.zip` ke server
- Extract di folder web root (misal: `/var/www/html` atau `public_html`)
- Set permission:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 3. Konfigurasi Web Server

**Apache (.htaccess sudah ada)**
```apache
# Pastikan mod_rewrite enabled
sudo a2enmod rewrite
sudo systemctl restart apache2
```

**Nginx**
```nginx
server {
    listen 80;
    server_name desalesane.go.id;
    root /var/www/html/sgc-backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 4. Akses Domain
- Buka browser: `https://desalesane.go.id`
- Otomatis redirect ke `/install`
- Ikuti wizard instalasi

### Method 2: Deploy via Git (Advanced)

```bash
# Di server
cd /var/www/html
git clone https://github.com/yourusername/sgc-backend.git
cd sgc-backend

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Set permission
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Akses domain untuk mulai instalasi
```

## Installation Wizard

### Step 1: Welcome
Klik "Mulai Instalasi"

### Step 2: Requirements Check
Pastikan semua requirement ✓ (hijau)

Jika ada yang ✗ (merah):
- Install extension yang kurang
- Fix permission storage/

### Step 3: Database Configuration
```
Host: 127.0.0.1
Port: 3306
Database: sgc_lesane
Username: sgc_user
Password: password_aman
```

Klik "Test Koneksi" → harus success
Klik "Lanjutkan"

### Step 4: Desa Information
```
Nama Desa: Desa Lesane
Kode Desa: 7301012001
Kecamatan: Kecamatan Lesane
Kabupaten: Kabupaten Gorontalo
Provinsi: Gorontalo
Kode Pos: 96181
```

### Step 5: Admin Account
```
Nama: Administrator
Email: admin@desalesane.go.id
Username: admin
Password: ********
Konfirmasi: ********
```

### Step 6: Finalize
- Review konfigurasi
- Klik "Mulai Instalasi"
- Tunggu proses selesai (30-60 detik)
- Otomatis redirect ke dashboard

## Post-Installation

### 1. Login Dashboard
```
URL: https://desalesane.go.id/admin
Username: admin
Password: (yang dibuat di wizard)
```

### 2. Konfigurasi Tambahan

#### Setup Email (Optional)
Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@desalesane.go.id
MAIL_FROM_NAME="SGC Desa Lesane"
```

#### Setup Redis (Optional, untuk performance)
```bash
# Install Redis
sudo apt install redis-server

# Edit .env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### Setup Cron Job (untuk scheduled tasks)
```bash
crontab -e

# Add this line:
* * * * * cd /var/www/html/sgc-backend && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Import Data Awal (Optional)

```bash
# Jalankan seeder untuk data sample
php artisan db:seed --class=PendudukSeeder
php artisan db:seed --class=PerangkatDesaSeeder
php artisan db:seed --class=ApbdesSeeder
```

### 4. Backup Database

```bash
# Setup auto backup
php artisan backup:run

# Schedule backup harian (tambah ke cron)
0 2 * * * cd /var/www/html/sgc-backend && php artisan backup:run >> /dev/null 2>&1
```

## SSL Certificate (HTTPS)

### Using Let's Encrypt (Free)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Get certificate
sudo certbot --apache -d desalesane.go.id

# Auto-renewal
sudo certbot renew --dry-run
```

## Troubleshooting

### 500 Internal Server Error
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Permission Denied
```bash
# Fix permission
sudo chown -R www-data:www-data /var/www/html/sgc-backend
sudo chmod -R 775 storage bootstrap/cache
```

### Database Connection Error
- Cek kredensial di `.env`
- Cek MySQL service: `sudo systemctl status mysql`
- Cek firewall: `sudo ufw allow 3306`

### Blank Page
```bash
# Enable error display (development only)
# Edit .env
APP_DEBUG=true

# Check PHP error log
tail -f /var/log/php8.2-fpm.log
```

## Maintenance Mode

```bash
# Enable maintenance
php artisan down --message="Sedang maintenance" --retry=60

# Disable maintenance
php artisan up
```

## Update Application

```bash
# Backup database first!
php artisan backup:run

# Pull latest code
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Run migrations
php artisan migrate --force

# Clear cache
php artisan optimize:clear
php artisan optimize
```

## Security Checklist

- [ ] Change default admin password
- [ ] Setup SSL certificate (HTTPS)
- [ ] Set `APP_DEBUG=false` di production
- [ ] Set strong `APP_KEY`
- [ ] Restrict database user privileges
- [ ] Setup firewall (UFW/iptables)
- [ ] Regular backup database
- [ ] Update PHP & dependencies regularly
- [ ] Monitor error logs
- [ ] Setup fail2ban untuk brute force protection

## Performance Optimization

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Enable OPcache (php.ini)
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
```

## Support

- Documentation: `/docs`
- Issues: GitHub Issues
- Email: support@sgc-lesane.com

## Selamat! 🎉

SGC Desa Lesane sudah siap digunakan. Mulai kelola data desa Anda dengan mudah!

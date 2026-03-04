# Cara Mendapatkan API Key - Panduan Lengkap

## 🎯 Yang Anda Butuhkan: 2 API Key

### 1. **Perplexity API Key** (untuk search data terbaru)
### 2. **OpenAI API Key** (untuk generate konten)

---

## 📝 STEP 1: Perplexity API Key

### A. Daftar Akun Perplexity

1. **Buka browser**, ketik:
   ```
   https://www.perplexity.ai/
   ```

2. **Klik "Sign Up"** di pojok kanan atas

3. **Pilih cara daftar:**
   - Dengan Google (paling mudah) ✅
   - Dengan Email
   - Dengan Apple ID

4. **Jika pakai Google:**
   - Klik "Continue with Google"
   - Pilih akun Google Anda
   - Klik "Allow"

5. **Verifikasi email** (jika diminta)

### B. Dapatkan API Key

1. **Setelah login**, buka:
   ```
   https://www.perplexity.ai/settings/api
   ```
   
   Atau:
   - Klik foto profil di pojok kanan atas
   - Klik "Settings"
   - Klik tab "API"

2. **Klik tombol "Generate API Key"**

3. **Copy API Key** yang muncul
   - Format: `pplx-xxxxxxxxxxxxxxxxxxxxxxxx`
   - Contoh: `pplx-1a2b3c4d5e6f7g8h9i0j`

4. **SIMPAN API KEY INI!** 
   - Paste ke Notepad/Notes
   - Atau langsung ke file .env

### C. Cek Free Tier

- Free tier: **5 requests per hari**
- Cukup untuk testing
- Untuk production, bisa upgrade nanti

---

## 📝 STEP 2: OpenAI API Key

### A. Daftar Akun OpenAI

1. **Buka browser**, ketik:
   ```
   https://platform.openai.com/signup
   ```

2. **Klik "Sign up"**

3. **Pilih cara daftar:**
   - Dengan Google (paling mudah) ✅
   - Dengan Email
   - Dengan Microsoft

4. **Jika pakai Google:**
   - Klik "Continue with Google"
   - Pilih akun Google Anda
   - Klik "Allow"

5. **Verifikasi email** (jika diminta)

6. **Isi informasi:**
   - Nama lengkap
   - Nomor telepon (untuk verifikasi)
   - Kode OTP yang dikirim ke HP

### B. Setup Billing (PENTING!)

⚠️ **OpenAI TIDAK ADA FREE TIER untuk API**
Anda harus isi saldo minimal $5

1. **Setelah login**, buka:
   ```
   https://platform.openai.com/settings/organization/billing/overview
   ```

2. **Klik "Add payment method"**

3. **Pilih metode pembayaran:**
   - Credit Card (Visa/Mastercard) ✅
   - Debit Card
   
4. **Isi data kartu:**
   - Nomor kartu
   - Tanggal expired
   - CVV
   - Nama di kartu
   - Billing address

5. **Klik "Add payment method"**

6. **Top up saldo:**
   - Klik "Add to credit balance"
   - Minimal: $5
   - Recommended: $10-20 (cukup untuk 50-100 desa)
   - Klik "Continue"

### C. Dapatkan API Key

1. **Buka:**
   ```
   https://platform.openai.com/api-keys
   ```

2. **Klik "Create new secret key"**

3. **Beri nama key** (optional):
   - Contoh: "SGC Desa Production"
   - Atau biarkan kosong

4. **Klik "Create secret key"**

5. **Copy API Key** yang muncul
   - Format: `sk-proj-xxxxxxxxxxxxxxxxxxxxxxxx`
   - Contoh: `sk-proj-1a2b3c4d5e6f7g8h9i0j`

6. **⚠️ PENTING: COPY SEKARANG!**
   - Key hanya muncul 1 kali
   - Tidak bisa dilihat lagi setelah ditutup
   - Simpan di tempat aman

### D. Set Usage Limits (Recommended)

1. **Buka:**
   ```
   https://platform.openai.com/settings/organization/limits
   ```

2. **Set "Monthly budget":**
   - Contoh: $20/month
   - Untuk mencegah overspending

3. **Set "Email notification":**
   - Centang "Send email when 75% of budget used"
   - Centang "Send email when 100% of budget used"

4. **Klik "Save"**

---

## 📝 STEP 3: Masukkan ke File .env

### A. Buka File .env

1. **Di terminal/command prompt:**
   ```bash
   cd sgc-backend
   nano .env
   ```
   
   Atau buka dengan text editor:
   - VS Code
   - Sublime Text
   - Notepad++

### B. Cari Baris Ini:

```env
# OpenAI Configuration
OPENAI_API_KEY=your-openai-api-key-here
OPENAI_MODEL=gpt-4o-mini

# AI Content Generator
AI_PROVIDER=openai
AI_SEARCH_PROVIDER=perplexity
PERPLEXITY_API_KEY=pplx-your-key-here
```

### C. Ganti dengan API Key Anda:

```env
# OpenAI Configuration
OPENAI_API_KEY=sk-proj-1a2b3c4d5e6f7g8h9i0j
OPENAI_MODEL=gpt-4o-mini

# AI Content Generator
AI_PROVIDER=openai
AI_SEARCH_PROVIDER=perplexity
PERPLEXITY_API_KEY=pplx-9z8y7x6w5v4u3t2s1r0q
```

⚠️ **PENTING:**
- Jangan pakai tanda kutip (`"` atau `'`)
- Jangan ada spasi sebelum/sesudah `=`
- Paste key langsung setelah `=`

### D. Save File

- **Nano:** Tekan `Ctrl+X`, lalu `Y`, lalu `Enter`
- **VS Code:** Tekan `Ctrl+S` (Windows) atau `Cmd+S` (Mac)

---

## ✅ STEP 4: Test API Keys

### A. Test Perplexity

```bash
cd sgc-backend
php artisan tinker
```

Lalu ketik:
```php
$response = \Illuminate\Support\Facades\Http::withHeaders([
    'Authorization' => 'Bearer ' . config('ai.perplexity_api_key'),
])->post('https://api.perplexity.ai/chat/completions', [
    'model' => 'sonar',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello']
    ],
]);

echo $response->status();
// Jika 200 = SUCCESS ✅
// Jika 401 = API key salah ❌
```

### B. Test OpenAI

```php
$response = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
    'model' => 'gpt-4o-mini',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello']
    ],
]);

echo $response->choices[0]->message->content;
// Jika ada response = SUCCESS ✅
// Jika error = API key salah ❌
```

### C. Test Generate Content

```bash
php artisan desa:generate-content --type=desa-info
```

Jika berhasil, akan muncul:
```
🤖 AI Content Generator

📝 Generating Desa Info...
   🔍 Searching for information...
   🤖 Calling AI...
   💾 Saving to database...
   ✅ sejarah created
   ✅ visi_misi created
   ...
```

---

## 💰 Estimasi Biaya

### Per Generation (1 desa):
- Perplexity: $0.05 - $0.10
- OpenAI: $0.10 - $0.20
- **Total: $0.15 - $0.30**

### 10 Desa:
- Total: $1.50 - $3.00

### 100 Desa:
- Total: $15 - $30

### Monthly (updates):
- 10 desa: $1 - $2
- 100 desa: $5 - $10

---

## 🔒 Keamanan API Key

### ✅ DO:
- Simpan di file .env
- Jangan commit .env ke git
- Set usage limits di dashboard
- Rotate key setiap 3-6 bulan

### ❌ DON'T:
- Jangan share API key ke orang lain
- Jangan commit ke GitHub/GitLab
- Jangan hardcode di code
- Jangan screenshot dan share

---

## 🐛 Troubleshooting

### Error: "Invalid API key"

**Perplexity:**
```bash
# Cek format key
echo $PERPLEXITY_API_KEY
# Harus: pplx-xxxxx

# Cek di .env
cat .env | grep PERPLEXITY
```

**OpenAI:**
```bash
# Cek format key
echo $OPENAI_API_KEY
# Harus: sk-proj-xxxxx

# Cek di .env
cat .env | grep OPENAI_API_KEY
```

### Error: "Insufficient credits"

**OpenAI:**
1. Buka: https://platform.openai.com/settings/organization/billing/overview
2. Cek saldo
3. Top up jika kurang

### Error: "Rate limit exceeded"

**Perplexity Free Tier:**
- Limit: 5 requests/day
- Solusi: Tunggu 24 jam atau upgrade

**OpenAI:**
- Cek usage: https://platform.openai.com/usage
- Tunggu atau upgrade tier

---

## 📞 Support

### Perplexity:
- Email: support@perplexity.ai
- Docs: https://docs.perplexity.ai/

### OpenAI:
- Help: https://help.openai.com/
- Community: https://community.openai.com/

---

## ✅ Checklist

Pastikan sudah:
- [ ] Daftar Perplexity
- [ ] Dapat Perplexity API key (pplx-xxxxx)
- [ ] Daftar OpenAI
- [ ] Setup billing OpenAI (minimal $5)
- [ ] Dapat OpenAI API key (sk-proj-xxxxx)
- [ ] Masukkan kedua key ke .env
- [ ] Test dengan tinker
- [ ] Test generate content
- [ ] Set usage limits
- [ ] Simpan key di tempat aman

---

## 🎉 Selesai!

Sekarang Anda bisa generate konten dengan:
```bash
php artisan desa:generate-content
```

Sistem akan:
1. ✅ Search data real tentang desa dari internet (Perplexity)
2. ✅ Generate konten akurat (OpenAI)
3. ✅ Save ke database
4. ✅ Siap untuk review dan publish!

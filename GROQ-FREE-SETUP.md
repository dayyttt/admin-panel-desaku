# Groq - Setup GRATIS untuk Generate Konten

## 🎉 100% GRATIS - Tidak Perlu Kartu Kredit!

Groq adalah AI inference platform yang menyediakan akses GRATIS ke model Llama 3 (open source). Perfect untuk sekali pakai saat instalasi!

---

## ✅ Keuntungan Groq

- ✅ **100% GRATIS** - Tidak perlu kartu kredit
- ✅ **Unlimited** - Tidak ada biaya per request
- ✅ **Sangat Cepat** - Inference tercepat di dunia
- ✅ **Bagus untuk Bahasa Indonesia** - Llama 3 support Indonesian
- ✅ **Rate Limit Generous** - 30 requests/minute (cukup banget!)
- ✅ **Mudah Setup** - 5 menit selesai

---

## 📝 Cara Daftar (5 Menit)

### Step 1: Buka Website Groq

```
https://console.groq.com/
```

### Step 2: Sign Up

1. Klik "Sign Up" atau "Get Started"
2. **Pilih "Continue with Google"** (paling mudah)
3. Pilih akun Google Anda
4. Klik "Allow"

**TIDAK PERLU:**
- ❌ Kartu kredit
- ❌ Nomor telepon
- ❌ Verifikasi email
- ❌ Billing info

### Step 3: Dapatkan API Key

1. Setelah login, Anda akan masuk ke Dashboard
2. Di sidebar kiri, klik **"API Keys"**
3. Klik tombol **"Create API Key"**
4. (Optional) Beri nama: "SGC Desa"
5. Klik **"Submit"**
6. **Copy API Key** yang muncul
   - Format: `gsk_xxxxxxxxxxxxxxxxxxxxxxxx`
   - Contoh: `gsk_1a2b3c4d5e6f7g8h9i0j`

⚠️ **PENTING:** Copy sekarang! Key hanya muncul 1 kali.

### Step 4: Simpan API Key

Paste ke Notepad/Notes atau langsung ke .env

---

## 🔧 Konfigurasi

### Edit File .env

Buka `sgc-backend/.env`, cari bagian AI Configuration:

```env
# AI Content Generator - GROQ (GRATIS!)
AI_PROVIDER=groq
GROQ_API_KEY=gsk_xxxxxxxxxxxxxxxxxxxxxxxx
GROQ_MODEL=llama3-70b-8192
AI_SEARCH_PROVIDER=none
```

**Ganti `gsk_xxxxxxxxxxxxxxxxxxxxxxxx` dengan API key Anda!**

⚠️ **Jangan pakai tanda kutip, langsung paste key-nya!**

---

## ✅ Test

### Test 1: Cek API Key

```bash
cd sgc-backend
php artisan tinker
```

Lalu ketik:
```php
$response = \Illuminate\Support\Facades\Http::withHeaders([
    'Authorization' => 'Bearer ' . config('ai.groq_api_key'),
])->post('https://api.groq.com/openai/v1/chat/completions', [
    'model' => 'llama3-70b-8192',
    'messages' => [
        ['role' => 'user', 'content' => 'Hello']
    ],
]);

echo $response->status();
// Jika 200 = SUCCESS ✅
// Jika 401 = API key salah ❌
```

Ketik `exit` untuk keluar dari tinker.

### Test 2: Generate Content

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
   ✅ geografi created
   ✅ demografi created
   ✅ fasilitas created
✅ Desa Info generation completed!
```

---

## 💰 Biaya

### GRATIS! 🎉

- ✅ Tidak ada biaya per request
- ✅ Tidak ada biaya bulanan
- ✅ Tidak ada hidden cost
- ✅ Tidak perlu kartu kredit

### Rate Limits (Generous!)

- **30 requests per minute**
- **14,400 tokens per minute**
- **Cukup untuk generate 100+ desa per hari!**

---

## 📊 Perbandingan: Groq vs OpenAI

| Feature | Groq (FREE) | OpenAI (Paid) |
|---------|-------------|---------------|
| **Biaya** | GRATIS ✅ | $0.15-0.60 per 1M tokens |
| **Setup** | Tanpa kartu kredit ✅ | Perlu kartu kredit + $5 |
| **Kualitas** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Kecepatan** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ |
| **Bahasa Indonesia** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **Rate Limit** | 30 req/min | Tergantung tier |

### Kesimpulan:
- **Untuk sekali pakai saat instalasi:** Groq ✅
- **Untuk production dengan data real:** OpenAI + Perplexity

---

## 🎯 Use Case

### Perfect untuk:
- ✅ Testing/development
- ✅ Demo/prototype
- ✅ Instalasi pertama kali
- ✅ Generate konten awal
- ✅ Budget terbatas

### Kurang cocok untuk:
- ❌ Production dengan data real-time
- ❌ Butuh web search integration
- ❌ Butuh akurasi maksimal

---

## 🔄 Upgrade ke OpenAI Nanti

Jika nanti mau upgrade ke OpenAI (untuk data lebih akurat):

1. Daftar OpenAI: https://platform.openai.com/
2. Setup billing (minimal $5)
3. Dapatkan API key
4. Edit .env:
   ```env
   AI_PROVIDER=openai
   OPENAI_API_KEY=sk-proj-xxxxx
   OPENAI_MODEL=gpt-4o-mini
   ```
5. Done!

---

## 🐛 Troubleshooting

### Error: "Invalid API key"

```bash
# Cek format key
cat .env | grep GROQ_API_KEY
# Harus: gsk_xxxxx (tanpa spasi, tanpa quotes)

# Test manual
curl https://api.groq.com/openai/v1/models \
  -H "Authorization: Bearer gsk_xxxxx"
```

### Error: "Rate limit exceeded"

- Groq limit: 30 requests/minute
- Solusi: Tunggu 1 menit, lalu coba lagi
- Atau generate per section (--type=desa-info)

### Hasil kurang akurat

- Groq tidak punya web search
- Solusi: Edit manual hasil generate
- Atau upgrade ke OpenAI + Perplexity

---

## 📚 Resources

### Groq
- Website: https://groq.com/
- Console: https://console.groq.com/
- Docs: https://console.groq.com/docs
- Models: https://console.groq.com/docs/models

### Llama 3
- Model: llama3-70b-8192
- Context: 8,192 tokens
- Speed: ~300 tokens/second (tercepat!)

---

## ✅ Checklist

- [ ] Buka https://console.groq.com/
- [ ] Sign up dengan Google (gratis, tanpa CC)
- [ ] Klik "API Keys" → "Create API Key"
- [ ] Copy API key (gsk_xxxxx)
- [ ] Paste ke .env
- [ ] Set AI_PROVIDER=groq
- [ ] Test dengan tinker
- [ ] Generate content
- [ ] Cek hasil di database

---

## 🎉 Selesai!

Sekarang Anda bisa generate konten **100% GRATIS** dengan:

```bash
php artisan desa:generate-content
```

Sistem akan:
1. ✅ Generate konten menggunakan Groq (GRATIS!)
2. ✅ Save ke database
3. ✅ Siap untuk review dan publish!

**Tidak ada biaya sama sekali!** 🎉

---

## 💡 Tips

### 1. Generate Bertahap
```bash
# Generate desa info dulu
php artisan desa:generate-content --type=desa-info

# Lalu web publik
php artisan desa:generate-content --type=web-publik
```

### 2. Review & Edit
- Hasil Groq bagus tapi tidak sempurna
- Selalu review dan edit manual
- Sesuaikan dengan kondisi real desa

### 3. Simpan API Key
- Simpan API key di tempat aman
- Bisa dipakai berkali-kali
- Tidak ada expiry date

### 4. Monitor Usage
```bash
# Cek berapa kali sudah generate
php artisan tinker
>>> \App\Models\AiContentGeneration::count()
```

---

## 🆘 Butuh Bantuan?

- Groq Discord: https://discord.gg/groq
- Groq Docs: https://console.groq.com/docs
- Email: support@groq.com

---

## 🎊 Bonus: Models Lain

Groq juga support model lain (semua GRATIS!):

```env
# Llama 3 70B (recommended)
GROQ_MODEL=llama3-70b-8192

# Llama 3 8B (lebih cepat, kurang akurat)
GROQ_MODEL=llama3-8b-8192

# Mixtral 8x7B (bagus untuk coding)
GROQ_MODEL=mixtral-8x7b-32768

# Gemma 7B (dari Google)
GROQ_MODEL=gemma-7b-it
```

Coba-coba model mana yang paling cocok untuk Anda!

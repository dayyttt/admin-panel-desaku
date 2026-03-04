# AI API Setup Guide - Mendapatkan Data Terbaru

## Overview
Untuk generate konten yang akurat dengan data terbaru, kita perlu 2 jenis API:
1. **AI API** - Untuk generate konten
2. **Search API** - Untuk mendapatkan data real dari internet

## 🏆 Rekomendasi Terbaik

### **Option 1: Perplexity AI** ⭐ (RECOMMENDED)
**All-in-one solution: AI + Web Search dalam 1 API**

#### Keuntungan:
- ✅ Sudah include web search otomatis
- ✅ Selalu menggunakan data terbaru dari internet
- ✅ Memberikan sumber/referensi (citations)
- ✅ Lebih murah dari OpenAI + Search terpisah
- ✅ Khusus untuk research & fact-finding
- ✅ Bagus untuk Bahasa Indonesia

#### Pricing:
- Model `sonar`: $0.20 per 1M tokens
- Model `sonar-pro`: $1.00 per 1M tokens
- Estimasi: $0.10 - $0.30 per generation
- **Free tier**: 5 requests/day (cukup untuk testing)

#### Setup:
1. **Daftar di Perplexity:**
   - Kunjungi: https://www.perplexity.ai/
   - Sign up dengan email/Google
   - Verifikasi email

2. **Dapatkan API Key:**
   - Login ke: https://www.perplexity.ai/settings/api
   - Klik "Generate API Key"
   - Copy API key (format: `pplx-xxxxx`)

3. **Konfigurasi .env:**
   ```env
   AI_PROVIDER=openai
   AI_SEARCH_PROVIDER=perplexity
   PERPLEXITY_API_KEY=pplx-xxxxxxxxxxxxx
   
   # OpenAI tetap dipakai untuk generate konten
   OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxx
   OPENAI_MODEL=gpt-4o-mini
   ```

4. **Test:**
   ```bash
   php artisan desa:generate-content --type=desa-info
   ```

---

### **Option 2: OpenAI + Tavily** (Alternative)
**Kombinasi AI terbaik + Search API khusus**

#### Keuntungan:
- ✅ OpenAI GPT-4o-mini (AI terbaik untuk Bahasa Indonesia)
- ✅ Tavily (Search API khusus untuk AI)
- ✅ Real-time web data
- ✅ Structured output

#### Pricing:
- OpenAI: $0.15/$0.60 per 1M tokens
- Tavily: $0.005 per search
- Estimasi: $0.15 - $0.40 per generation
- **Free tier Tavily**: 1000 searches/month

#### Setup:
1. **OpenAI API Key:**
   - Kunjungi: https://platform.openai.com/api-keys
   - Klik "Create new secret key"
   - Copy key (format: `sk-proj-xxxxx`)

2. **Tavily API Key:**
   - Kunjungi: https://tavily.com/
   - Sign up
   - Dashboard → API Keys
   - Copy key (format: `tvly-xxxxx`)

3. **Konfigurasi .env:**
   ```env
   AI_PROVIDER=openai
   AI_SEARCH_PROVIDER=tavily
   OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxx
   OPENAI_MODEL=gpt-4o-mini
   TAVILY_API_KEY=tvly-xxxxxxxxxxxxx
   ```

---

### **Option 3: Groq + Serper** (Paling Murah)
**Free AI + Murah Search**

#### Keuntungan:
- ✅ Groq GRATIS (Llama 3)
- ✅ Serper murah ($0.001 per search)
- ✅ Sangat cepat
- ✅ Cocok untuk budget terbatas

#### Pricing:
- Groq: GRATIS (rate limit: 30 req/min)
- Serper: $0.001 per search
- Estimasi: $0.01 - $0.05 per generation
- **Free tier Serper**: 2500 searches

#### Setup:
1. **Groq API Key:**
   - Kunjungi: https://console.groq.com/
   - Sign up
   - Keys → Create API Key
   - Copy key (format: `gsk_xxxxx`)

2. **Serper API Key:**
   - Kunjungi: https://serper.dev/
   - Sign up
   - Dashboard → API Key
   - Copy key

3. **Konfigurasi .env:**
   ```env
   AI_PROVIDER=groq
   AI_SEARCH_PROVIDER=serper
   GROQ_API_KEY=gsk_xxxxxxxxxxxxx
   GROQ_MODEL=llama3-70b-8192
   SERPER_API_KEY=xxxxxxxxxxxxx
   ```

---

## 📊 Perbandingan Lengkap

| Provider | AI Quality | Search Quality | Speed | Cost/Gen | Free Tier | Bahasa ID |
|----------|-----------|----------------|-------|----------|-----------|-----------|
| **Perplexity** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | $0.10-$0.30 | 5 req/day | ⭐⭐⭐⭐⭐ |
| **OpenAI + Tavily** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ | $0.15-$0.40 | 1000 search | ⭐⭐⭐⭐⭐ |
| **Groq + Serper** | ⭐⭐⭐⭐ | ⭐⭐⭐ | ⭐⭐⭐⭐⭐ | $0.01-$0.05 | Unlimited | ⭐⭐⭐⭐ |

---

## 🎯 Rekomendasi Berdasarkan Kebutuhan

### Untuk Production (Desa Real):
**→ Perplexity AI**
- Data paling akurat
- Selalu update
- All-in-one solution
- Worth the cost

### Untuk Development/Testing:
**→ Groq + Serper**
- Gratis/murah
- Cukup bagus
- Cepat
- Hemat budget

### Untuk Kualitas Maksimal:
**→ OpenAI GPT-4o + Tavily**
- AI terbaik
- Search reliable
- Hasil paling bagus
- Agak mahal

---

## 🚀 Quick Start (Perplexity)

### 1. Daftar & Dapatkan API Key
```bash
# 1. Buka browser
https://www.perplexity.ai/settings/api

# 2. Sign up / Login
# 3. Generate API Key
# 4. Copy key (pplx-xxxxx)
```

### 2. Update .env
```env
AI_SEARCH_PROVIDER=perplexity
PERPLEXITY_API_KEY=pplx-xxxxxxxxxxxxx

# Tetap pakai OpenAI untuk generate
OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxx
OPENAI_MODEL=gpt-4o-mini
```

### 3. Test
```bash
php artisan desa:generate-content --type=desa-info
```

### 4. Cek Hasil
```bash
php artisan tinker
>>> \App\Models\DesaInfo::where('key', 'sejarah')->first()->data
```

---

## 💡 Tips & Best Practices

### 1. Gunakan Free Tier Dulu
- Test dengan free tier
- Pastikan hasilnya sesuai
- Baru upgrade ke paid

### 2. Monitor Usage
```bash
# Cek berapa kali sudah generate
php artisan tinker
>>> \App\Models\AiContentGeneration::count()

# Cek total cost (estimasi)
>>> \App\Models\AiContentGeneration::count() * 0.20
```

### 3. Cache Results
- Simpan hasil generation
- Jangan generate ulang terlalu sering
- Update hanya kalau perlu

### 4. Review Before Publish
- Selalu review hasil AI
- Sesuaikan dengan kondisi real
- Edit jika perlu

---

## 🔒 Security

### Jangan Commit API Keys!
```bash
# .env sudah di .gitignore
# Jangan pernah commit .env ke git!

# Untuk production, gunakan:
# - Laravel Forge secrets
# - AWS Secrets Manager
# - Environment variables di server
```

### Rotate Keys Regularly
- Ganti API key setiap 3-6 bulan
- Atau jika ada security breach
- Atau jika key ter-expose

---

## 🐛 Troubleshooting

### Error: "Invalid API key"
```bash
# Cek .env
cat .env | grep PERPLEXITY_API_KEY

# Pastikan format benar: pplx-xxxxx
# Pastikan tidak ada spasi
# Pastikan tidak ada quotes
```

### Error: "Rate limit exceeded"
```bash
# Perplexity free tier: 5 req/day
# Solusi:
# 1. Tunggu 24 jam
# 2. Atau upgrade ke paid plan
# 3. Atau pakai provider lain
```

### Hasil Tidak Akurat
```bash
# Coba provider lain
# Atau edit prompt di AiContentGeneratorService.php
# Atau tambahkan context lebih detail
```

---

## 📚 Resources

### Perplexity AI
- Website: https://www.perplexity.ai/
- API Docs: https://docs.perplexity.ai/
- Pricing: https://www.perplexity.ai/settings/api

### OpenAI
- Website: https://platform.openai.com/
- API Docs: https://platform.openai.com/docs
- Pricing: https://openai.com/pricing

### Tavily
- Website: https://tavily.com/
- API Docs: https://docs.tavily.com/
- Pricing: https://tavily.com/pricing

### Groq
- Website: https://groq.com/
- Console: https://console.groq.com/
- Docs: https://console.groq.com/docs

### Serper
- Website: https://serper.dev/
- API Docs: https://serper.dev/docs
- Pricing: https://serper.dev/pricing

---

## 📞 Support

Jika ada masalah:
1. Cek dokumentasi provider
2. Cek log: `storage/logs/laravel.log`
3. Cek database: `ai_content_generations` table
4. Contact support dengan error message

---

## ✅ Checklist Setup

- [ ] Pilih provider (Perplexity recommended)
- [ ] Daftar dan dapatkan API key
- [ ] Update .env dengan API key
- [ ] Test dengan command
- [ ] Cek hasil di database
- [ ] Review dan edit jika perlu
- [ ] Monitor usage dan cost
- [ ] Setup billing alerts (jika paid)

---

## 🎉 Ready to Go!

Setelah setup, jalankan:
```bash
php artisan desa:generate-content
```

Dan sistem akan:
1. ✅ Search data real tentang desa dari internet
2. ✅ Generate konten akurat berdasarkan data real
3. ✅ Save ke database
4. ✅ Siap untuk review dan publish!

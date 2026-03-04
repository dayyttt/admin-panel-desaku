# API Key - Ringkasan Singkat

## 🎯 PILIHAN TERBAIK UNTUK SEKALI PAKAI

### ⭐ **GROQ - 100% GRATIS!** (RECOMMENDED)

**Link:** https://console.groq.com/

**Keuntungan:**
- ✅ **GRATIS** - Tidak perlu kartu kredit!
- ✅ Daftar dengan Google (5 menit)
- ✅ Unlimited usage
- ✅ Sangat cepat
- ✅ Bagus untuk Bahasa Indonesia

**Setup:**
1. Buka: https://console.groq.com/
2. Sign up dengan Google
3. Klik "API Keys" → "Create API Key"
4. Copy key (format: `gsk_xxxxx`)

**Masukkan ke .env:**
```env
AI_PROVIDER=groq
GROQ_API_KEY=gsk_xxxxx-ganti-dengan-key-anda
GROQ_MODEL=llama3-70b-8192
AI_SEARCH_PROVIDER=none
```

**Test:**
```bash
php artisan desa:generate-content --type=desa-info
```

---

## 💰 Perbandingan

| Provider | Biaya | Kartu Kredit | Kualitas | Setup |
|----------|-------|--------------|----------|-------|
| **Groq** | GRATIS ✅ | Tidak perlu ✅ | ⭐⭐⭐⭐ | 5 menit |
| OpenAI | $0.20/desa | Perlu + $5 | ⭐⭐⭐⭐⭐ | 15 menit |
| Perplexity | $0.10/desa | Tidak perlu | ⭐⭐⭐⭐ | 10 menit |

---

## ✅ Kesimpulan

**Untuk sekali pakai saat instalasi:**
→ **Pakai GROQ** (100% gratis, tanpa kartu kredit!)

**Untuk production dengan data real:**
→ Upgrade ke OpenAI + Perplexity nanti

---

## 📚 Panduan Lengkap

- `GROQ-FREE-SETUP.md` - Panduan lengkap Groq (GRATIS)
- `CARA-DAFTAR-API-KEY.md` - Panduan OpenAI + Perplexity (Bayar)
- `AI-API-SETUP-GUIDE.md` - Perbandingan semua provider

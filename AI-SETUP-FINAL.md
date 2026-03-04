# AI Content Generator - Setup Final

## ✅ Setup Selesai!

Anda sudah setup dengan konfigurasi:
- **AI Provider:** Groq (100% GRATIS)
- **Search Provider:** None (AI pakai general knowledge)

---

## 🎯 Rekomendasi Setup

### **OPTION 1: Groq Saja (GRATIS)** ⭐ CURRENT
**Untuk:** Sekali pakai saat instalasi

```env
AI_PROVIDER=groq
GROQ_API_KEY=gsk_xxxxx
AI_SEARCH_PROVIDER=none
```

**Keuntungan:**
- ✅ 100% GRATIS
- ✅ Unlimited usage
- ✅ Cukup bagus untuk konten awal
- ✅ Bisa edit manual setelah generate

**Kekurangan:**
- ❌ Tidak ada data real dari internet
- ❌ AI pakai general knowledge saja

---

### **OPTION 2: Groq + Serper (Lebih Akurat)** ⭐⭐
**Untuk:** Mau data lebih akurat tapi tetap murah

```env
AI_PROVIDER=groq
GROQ_API_KEY=gsk_xxxxx
AI_SEARCH_PROVIDER=serper
SERPER_API_KEY=xxxxx
```

**Keuntungan:**
- ✅ Groq GRATIS
- ✅ Serper: GRATIS 2,500 searches
- ✅ Data real dari Google Search
- ✅ Lebih akurat

**Biaya:**
- Groq: GRATIS
- Serper: GRATIS (2,500 searches), lalu $0.001/search

**Cara Daftar Serper:**
1. Buka: https://serper.dev/
2. Sign up dengan Google
3. Dashboard → API Key
4. Copy key
5. Paste ke .env

---

## 📊 Tentang Token & Rate Limits

### **Groq (GRATIS):**
- ✅ **30 requests per minute**
- ✅ **14,400 tokens per minute**
- ✅ **Unlimited daily**

### **Estimasi Usage:**
- 1 desa = ~3,000-4,000 tokens
- Bisa generate **3-4 desa per menit**
- Atau **180-240 desa per jam**
- **UNLIMITED per hari!**

### **Kesimpulan:**
**TIDAK PERLU model cadangan!** Groq sangat generous.

---

## 🚀 Cara Pakai

### Generate Semua Konten:
```bash
cd sgc-backend
php artisan desa:generate-content
```

### Generate Desa Info Saja:
```bash
php artisan desa:generate-content --type=desa-info
```

### Generate Web Publik Saja:
```bash
php artisan desa:generate-content --type=web-publik
```

---

## 📝 Hasil Generate

### Desa Info (5 sections):
1. **Sejarah** - 3-4 paragraf + 7 timeline
2. **Visi & Misi** - 1 visi + 6 misi
3. **Geografi** - Koordinat, batas, topografi, iklim
4. **Demografi** - Jumlah penduduk, KK, kepadatan
5. **Fasilitas** - Pendidikan, kesehatan, ibadah, ekonomi, dll

### Web Publik:
1. **Artikel** - 8 artikel/berita
2. **Potensi** - 8 potensi desa
3. **UMKM** - 8 lapak UMKM

---

## 💡 Tips

### 1. Review & Edit
- Hasil AI bagus tapi tidak sempurna
- Selalu review dan edit manual
- Sesuaikan dengan kondisi real desa

### 2. Generate Bertahap
```bash
# Desa info dulu
php artisan desa:generate-content --type=desa-info

# Cek hasilnya, lalu web publik
php artisan desa:generate-content --type=web-publik
```

### 3. Jika Mau Data Lebih Akurat
- Tambahkan Serper API (gratis 2,500 searches)
- Atau upgrade ke OpenAI + Perplexity nanti

---

## 🔄 Upgrade Nanti (Optional)

Jika nanti mau data lebih akurat:

### **OpenAI + Perplexity:**
```env
AI_PROVIDER=openai
OPENAI_API_KEY=sk-proj-xxxxx
AI_SEARCH_PROVIDER=perplexity
PERPLEXITY_API_KEY=pplx-xxxxx
```

**Biaya:** ~$0.20-0.30 per desa

---

## ✅ Checklist

- [x] Groq API key sudah di .env
- [x] AI_PROVIDER=groq
- [x] AI_SEARCH_PROVIDER=none
- [ ] Test generate content
- [ ] Review hasil
- [ ] Edit jika perlu
- [ ] Publish!

---

## 🎉 Siap Digunakan!

Jalankan:
```bash
php artisan desa:generate-content
```

Dan sistem akan generate konten untuk desa Anda! 🚀

# AI API Quick Comparison - Pilih yang Mana?

## 🏆 Rekomendasi: **Perplexity AI**

### Kenapa Perplexity?
✅ **All-in-one**: AI + Web Search dalam 1 API  
✅ **Data Terbaru**: Selalu search web sebelum generate  
✅ **Akurat**: Memberikan sumber/referensi  
✅ **Murah**: $0.10-$0.30 per generation  
✅ **Bahasa Indonesia**: Sangat bagus  
✅ **Free Tier**: 5 requests/day untuk testing  

### Setup Cepat:
```env
AI_SEARCH_PROVIDER=perplexity
PERPLEXITY_API_KEY=pplx-xxxxx
OPENAI_API_KEY=sk-proj-xxxxx
OPENAI_MODEL=gpt-4o-mini
```

### Cara Daftar:
1. Buka: https://www.perplexity.ai/settings/api
2. Sign up / Login
3. Generate API Key
4. Copy key (format: `pplx-xxxxx`)
5. Paste ke .env

---

## 📊 Perbandingan Cepat

| Provider | Cost/Gen | Free Tier | Data Terbaru | Setup | Rekomendasi |
|----------|----------|-----------|--------------|-------|-------------|
| **Perplexity** | $0.10-$0.30 | 5/day | ⭐⭐⭐⭐⭐ | Mudah | ⭐⭐⭐⭐⭐ Production |
| **OpenAI + Tavily** | $0.15-$0.40 | 1000 search | ⭐⭐⭐⭐ | Sedang | ⭐⭐⭐⭐ Kualitas Max |
| **Groq + Serper** | $0.01-$0.05 | Unlimited | ⭐⭐⭐ | Mudah | ⭐⭐⭐⭐ Budget Hemat |

---

## 🎯 Pilih Berdasarkan Kebutuhan

### Untuk Desa Real (Production):
→ **Perplexity AI**  
Data paling akurat, selalu update, worth the cost

### Untuk Testing/Development:
→ **Groq + Serper**  
Gratis/murah, cukup bagus, hemat budget

### Untuk Kualitas Maksimal:
→ **OpenAI GPT-4o + Tavily**  
AI terbaik, hasil paling bagus, agak mahal

---

## 💰 Estimasi Biaya

### Per Desa (Initial Generation):
- Perplexity: $0.20
- OpenAI + Tavily: $0.30
- Groq + Serper: $0.03

### 100 Desa:
- Perplexity: $20
- OpenAI + Tavily: $30
- Groq + Serper: $3

### Monthly (Updates):
- Perplexity: $5-10
- OpenAI + Tavily: $10-15
- Groq + Serper: $1-2

---

## ✅ Kesimpulan

**Gunakan Perplexity AI** karena:
1. Paling mudah setup (1 API saja)
2. Data selalu terbaru dari web
3. Akurat dengan sumber referensi
4. Harga reasonable
5. Free tier cukup untuk testing

**Link Setup:** Lihat `AI-API-SETUP-GUIDE.md` untuk panduan lengkap

# Admin Panel Workflows - Quick Reference

## 🚀 Common Workflows

### 1. Update Website Content (Profil Desa)
**Goal**: Change village profile information displayed on the website

**Steps**:
1. Login to admin: `http://localhost:8000/admin`
2. Navigate: Web Publik → Informasi Desa
3. Find "Profil Desa" row → Click "Edit"
4. Update fields:
   - Jumlah Penduduk (if population changed)
   - Jumlah KK (if family count changed)
   - Sambutan (update welcome message)
5. Click "Simpan"
6. Check website: `http://localhost:5173/profil-desa`

**Result**: Website automatically shows updated information

---

### 2. Update Contact Information
**Goal**: Change phone number, email, or social media links

**Steps**:
1. Navigate: Web Publik → Informasi Desa
2. Find "Kontak" row → Click "Edit"
3. Update any field:
   - Telepon: `(0914) 123456`
   - Email: `desalesane@malukutengahkab.go.id`
   - Facebook: `@DesaLesane`
   - Instagram: `@desalesane`
4. Click "Simpan"
5. Check website: `http://localhost:5173/kontak`

**Result**: Contact page shows new information

---

### 3. Publish New Article/News
**Goal**: Add news article to website

**Steps**:
1. Navigate: Web Publik → Artikel & Berita
2. Click "Create"
3. Fill in form:
   - Judul: Article title
   - Slug: auto-generated from title
   - Konten: Article content (rich text editor)
   - Kategori: Select category (Berita/Pengumuman/Kegiatan)
   - Gambar: Upload featured image
   - Status: Published
   - Tanggal Publikasi: Select date
4. Click "Simpan"
5. Check website: `http://localhost:5173/berita`

**Result**: Article appears on news page

---

### 4. Add New UMKM/Business
**Goal**: Register new village business in the system

**Steps**:
1. Navigate: Web Publik → Lapak UMKM
2. Click "Create"
3. Fill in form:
   - Nama Usaha: Business name
   - Pemilik: Select owner from penduduk
   - Kategori: Select category
   - Deskripsi: Business description
   - Alamat: Business address
   - Telepon: Contact number
   - Foto: Upload business photo
   - Status: Aktif
4. Click "Simpan"
5. Check website: `http://localhost:5173/umkm`

**Result**: Business appears on UMKM page

---

### 5. Process Birth Registration
**Goal**: Register new baby and create population record

**Steps**:
1. Navigate: Kependudukan → Proses Kelahiran
2. Click "Create"
3. Fill in baby data:
   - Nama Bayi: Baby's name
   - Jenis Kelamin: Gender
   - Tanggal Lahir: Birth date
   - Jam Lahir: Birth time
   - Tempat Dilahirkan: Birth place
   - Berat & Panjang: Weight & length
4. Fill in parent data:
   - NIK Ayah: Father's NIK
   - NIK Ibu: Mother's NIK
   - No KK: Family card number
5. Click "Simpan"
6. System automatically creates new penduduk record

**Result**: Baby registered in population database

---

### 6. Generate Population Report
**Goal**: Create monthly population report PDF

**Steps**:
1. Navigate: Kependudukan → Laporan & Statistik
2. Select report type: "Laporan Kependudukan Bulanan"
3. Select month and year
4. Click "Generate PDF"
5. PDF downloads automatically

**Result**: Professional PDF report with:
- Population statistics
- Birth/death data
- Migration data
- Charts and graphs

---

### 7. Process Letter Request
**Goal**: Create official village letter for resident

**Steps**:
1. Navigate: Persuratan → Permohonan Masuk
2. Find pending request → Click "Edit"
3. Review request details
4. Change status: "Diproses" → "Selesai"
5. Upload signed letter (if applicable)
6. Click "Simpan"
7. Resident receives notification

**Result**: Letter is ready for pickup

---

### 8. Manage Village Budget (APBDes)
**Goal**: Input and track village budget

**Steps**:
1. Navigate: Keuangan → APBDes
2. Click "Create" for new fiscal year
3. Fill in:
   - Tahun Anggaran: Fiscal year
   - Total Pendapatan: Total income
   - Total Belanja: Total expenditure
4. Add budget items (Bidang):
   - Click "Add Bidang"
   - Enter: Kode, Nama, Anggaran
   - Repeat for all budget categories
5. Click "Simpan"

**Result**: Budget is tracked and can be monitored

---

### 9. Record Financial Transaction
**Goal**: Record income or expense transaction

**Steps**:
1. Navigate: Keuangan → Transaksi
2. Click "Create"
3. Fill in:
   - Tanggal: Transaction date
   - Jenis: Pemasukan/Pengeluaran
   - Kategori: Select category
   - Jumlah: Amount
   - Keterangan: Description
   - Bukti: Upload receipt/proof
4. Status: Pending (for approval)
5. Click "Simpan"
6. Treasurer approves transaction

**Result**: Transaction recorded in financial system

---

### 10. Update Village Gallery
**Goal**: Add photos to village gallery

**Steps**:
1. Navigate: Web Publik → Galeri
2. Click "Create"
3. Fill in:
   - Judul: Photo title
   - Deskripsi: Description
   - Kategori: Select category
   - Gambar: Upload photo(s)
   - Tanggal: Event date
4. Click "Simpan"
5. Check website: `http://localhost:5173/galeri`

**Result**: Photos appear in gallery page

---

## 🎯 Quick Tips

### For Content Editors
- Always check "Status Aktif" toggle before saving
- Use "Preview" to see how content looks
- Save drafts frequently
- Upload images in JPG/PNG format (max 2MB)

### For Data Entry Staff
- Verify NIK format: 16 digits
- Check No KK format: 16 digits
- Use proper date format: YYYY-MM-DD
- Fill required fields (marked with *)

### For Financial Staff
- Always upload transaction proof
- Double-check amounts before saving
- Use proper categories for reporting
- Approve transactions promptly

### For Village Head
- Review pending requests daily
- Check dashboard statistics weekly
- Generate reports monthly
- Monitor budget vs actual spending

---

## 🔍 Troubleshooting

### "Data tidak tersimpan"
- Check all required fields are filled
- Verify data format (NIK, email, phone)
- Check file size for uploads (max 2MB)
- Ensure unique constraints (NIK, No KK)

### "Foto tidak muncul"
- Check file format (JPG, PNG only)
- Verify file size (max 2MB)
- Clear browser cache
- Re-upload image

### "PDF tidak ter-generate"
- Check date range is valid
- Ensure data exists for selected period
- Try different browser
- Contact admin if persists

### "User tidak bisa login"
- Verify username and password
- Check user status is "Aktif"
- Reset password if needed
- Contact superadmin

---

## 📞 Support

### Technical Issues
- Check `ADMIN_PANEL_GUIDE.md` for detailed documentation
- Check `ADMIN_PANEL_SETUP.md` for setup information
- Contact IT support: `it@desalesane.id`

### Training
- Request training session from village secretary
- Watch tutorial videos (if available)
- Practice in test environment first

### Feature Requests
- Submit through village secretary
- Describe feature clearly
- Explain use case and benefits
- Wait for approval and development

---

## 📊 Best Practices

### Data Entry
1. Enter data immediately after receiving documents
2. Verify data accuracy before saving
3. Keep physical documents organized
4. Update status promptly

### Content Management
1. Plan content calendar monthly
2. Write clear, concise content
3. Use high-quality images
4. Publish regularly (at least weekly)

### Financial Management
1. Record transactions daily
2. Reconcile accounts weekly
3. Generate reports monthly
4. Archive documents properly

### Security
1. Never share login credentials
2. Logout after use
3. Use strong passwords
4. Report suspicious activity

---

## 🎓 Training Checklist

### New Admin User
- [ ] Login and change password
- [ ] Navigate all menu sections
- [ ] Create test article
- [ ] Upload test image
- [ ] Generate test report
- [ ] Understand user roles

### Content Editor
- [ ] Create and publish article
- [ ] Upload gallery photos
- [ ] Update village information
- [ ] Add UMKM listing
- [ ] Manage static pages

### Data Entry Staff
- [ ] Add new penduduk
- [ ] Process birth registration
- [ ] Update family card
- [ ] Record migration data
- [ ] Generate population report

### Financial Staff
- [ ] Record transaction
- [ ] Approve transaction
- [ ] Generate financial report
- [ ] Update budget
- [ ] Reconcile accounts

---

## 📅 Regular Tasks

### Daily
- Check pending letter requests
- Record financial transactions
- Monitor dashboard statistics
- Respond to inquiries

### Weekly
- Publish new article/news
- Update gallery with event photos
- Review and approve transactions
- Backup important data

### Monthly
- Generate population report
- Generate financial report
- Update village statistics
- Review and update content

### Quarterly
- Review budget vs actual
- Update village profile
- Archive old documents
- Plan next quarter activities

### Annually
- Create new fiscal year budget
- Generate annual reports
- Update village vision/mission
- Review and update policies

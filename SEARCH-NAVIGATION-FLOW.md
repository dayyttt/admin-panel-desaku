# Search Navigation Flow

## Alur Navigasi dari Search ke Menu Aktif

### 1. User Mencari Menu
```
User ketik "penduduk" di search box
    ↓
Fuzzy matching menemukan hasil
    ↓
Hasil ditampilkan dengan highlight
```

### 2. User Memilih Menu
```
User klik hasil ATAU tekan Enter
    ↓
Search box langsung tertutup
    ↓
Input field di-clear
    ↓
Navigate ke URL menu
```

### 3. Halaman Baru Load
```
Browser navigate ke URL baru
    ↓
Filament detect URL aktif
    ↓
sidebar-active-fix.blade.php running
    ↓
Menu otomatis ditandai aktif (sgc-active class)
    ↓
Parent group juga aktif (sgc-group-active)
    ↓
Visual: background solid, border hijau, icon hijau
```

## Visual Feedback

### Saat Klik Hasil Search:
1. **Scale down** (transform: scale(0.98)) - feedback visual
2. **Background lebih gelap** - konfirmasi klik
3. **Search tertutup** - UI bersih
4. **Navigate** - pindah halaman

### Setelah Navigate:
1. **Menu aktif** - background solid gray + border hijau
2. **Icon hijau** - visual indicator
3. **Text putih** (dark mode) / hitam (light mode)
4. **Parent group icon hijau** - context visual

## Integrasi dengan Existing System

### sidebar-active-fix.blade.php
Script ini sudah handle:
- Auto-detect URL aktif
- Add class `sgc-active` ke menu
- Add class `sgc-group-active` ke parent group
- Update saat Livewire navigation

### sidebar-custom.css
CSS sudah define:
- `.sgc-active` styling untuk submenu aktif
- `.sgc-group-active` styling untuk parent group
- Smooth transitions
- Dark/light mode support

## Contoh Flow Lengkap

```
1. User di Dashboard
2. Tekan Ctrl+K
3. Ketik "pnddk" (typo)
4. Muncul hasil: "Penduduk" (Kependudukan)
5. Klik hasil atau Enter
6. Search tertutup
7. Navigate ke /admin/penduduks
8. Halaman load
9. Menu "Penduduk" otomatis aktif:
   - Background: solid gray
   - Border left: 4px hijau
   - Icon: hijau
   - Text: putih (dark) / hitam (light)
10. Parent "Kependudukan" juga aktif:
    - Icon group: hijau
    - Background enhanced
```

## Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| `Ctrl+K` | Focus search |
| `↓` | Next result |
| `↑` | Previous result |
| `Enter` | Navigate to selected + close search |
| `Esc` | Clear + close search |
| `Click` | Navigate to clicked + close search |

## Technical Details

### Navigation Method
```javascript
// Clean navigation
window.location.href = href;
```

### Active Detection (sidebar-active-fix.blade.php)
```javascript
// Extract pathname from URL
const currentPath = new URL(window.location.href).pathname;

// Match with menu href
if (menuHref === currentPath) {
    menuButton.classList.add('sgc-active');
}
```

### CSS Active State
```css
.fi-sidebar-item-button.sgc-active {
    background: linear-gradient(...);
    border-left: 4px solid #22c55e;
    /* ... */
}
```

## Benefits

✅ **Instant Feedback** - User tahu klik berhasil
✅ **Clean UI** - Search tertutup otomatis
✅ **Visual Consistency** - Menu aktif sama seperti klik manual
✅ **Smooth Transition** - Tidak ada glitch atau delay
✅ **Keyboard Friendly** - Enter juga close search
✅ **Mobile Friendly** - Touch events handled

## Testing Checklist

- [x] Klik hasil search → navigate + close
- [x] Enter pada selected → navigate + close
- [x] Menu aktif setelah navigate
- [x] Parent group aktif jika submenu
- [x] Visual feedback saat klik (scale down)
- [x] Search input ter-clear
- [x] Tidak ada duplicate navigation
- [x] Works dengan Livewire navigation
- [x] Dark mode styling correct
- [x] Light mode styling correct

---

**Status**: ✅ Fully Integrated
**Flow**: Search → Click/Enter → Close → Navigate → Auto Active
**User Experience**: Seamless and intuitive

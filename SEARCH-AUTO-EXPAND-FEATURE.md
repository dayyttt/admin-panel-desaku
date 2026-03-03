# Search Auto-Expand Parent Group Feature

## Overview
Ketika user klik submenu dari hasil search, parent group dropdown akan otomatis expand (terbuka) sebelum navigate ke halaman.

## Problem Solved
Sebelumnya, jika user search submenu yang parent groupnya collapsed:
1. User klik hasil search
2. Navigate ke halaman
3. Menu aktif tapi parent group masih collapsed
4. User tidak bisa lihat menu aktif karena tersembunyi

## Solution Implemented
Sekarang dengan auto-expand:
1. User klik hasil search submenu
2. **Parent group otomatis expand** (dropdown terbuka)
3. Small delay 150ms untuk animasi expand
4. Navigate ke halaman
5. Menu aktif dan terlihat karena parent sudah terbuka

## Technical Implementation

### 1. Store Parent Reference
```javascript
menuItems.push({
    title: label.textContent.trim(),
    path: groupName,
    href: href,
    icon: icon ? icon.outerHTML : '',
    element: item,
    parentGroup: group,        // ← Parent group element
    parentButton: groupButton  // ← Parent button to click
});
```

### 2. Detect Submenu in Results
```javascript
data-has-parent="${item.parentGroup ? 'true' : 'false'}"
```

### 3. Expand Function
```javascript
function expandParentGroup(groupButton) {
    if (!groupButton) return;
    
    // Check if collapsed
    const isCollapsed = groupButton.getAttribute('aria-expanded') === 'false';
    
    if (isCollapsed) {
        groupButton.click(); // Trigger Filament's expand
    }
}
```

### 4. Navigate with Delay
```javascript
// If submenu, expand first
if (hasParent && results[idx].parentButton) {
    expandParentGroup(results[idx].parentButton);
}

// Delay to let animation complete
setTimeout(() => {
    window.location.href = href;
}, hasParent ? 150 : 0);
```

## User Flow

### Scenario 1: Standalone Menu (Dashboard)
```
User search "dashboard"
    ↓
Click result
    ↓
Navigate immediately (no delay)
    ↓
Dashboard aktif
```

### Scenario 2: Submenu (Collapsed Parent)
```
User search "penduduk"
    ↓
Click result "Data Penduduk"
    ↓
Detect: has parent "Kependudukan"
    ↓
Check: parent is collapsed
    ↓
Click parent button → expand dropdown
    ↓
Wait 150ms for animation
    ↓
Navigate to Data Penduduk
    ↓
Menu aktif dan terlihat!
```

### Scenario 3: Submenu (Already Expanded)
```
User search "surat"
    ↓
Click result "Surat Masuk"
    ↓
Detect: has parent "Persuratan"
    ↓
Check: parent already expanded
    ↓
Skip expand (no click needed)
    ↓
Wait 150ms (consistent UX)
    ↓
Navigate to Surat Masuk
    ↓
Menu aktif dan terlihat!
```

## Keyboard Navigation Support

Enter key juga support auto-expand:
```javascript
if (e.key === 'Enter') {
    // Get selected item's parent
    if (hasParent && currentResults[selectedIndex].parentButton) {
        expandParentGroup(currentResults[selectedIndex].parentButton);
    }
    
    // Navigate with delay
    setTimeout(() => {
        window.location.href = href;
    }, hasParent ? 150 : 0);
}
```

## Timing Details

### Why 150ms Delay?
- Filament dropdown animation: ~100-120ms
- Buffer time: 30-50ms
- Total: 150ms (smooth, not too slow)

### Alternative Approaches Considered
1. ❌ No delay → Navigate before expand completes
2. ❌ 300ms delay → Too slow, feels laggy
3. ✅ 150ms delay → Perfect balance

## Visual Feedback

### Before Click
```
📁 Kependudukan ▶ (collapsed)
```

### After Click (Auto-Expand)
```
📁 Kependudukan ▼ (expanded)
  ├─ Data Penduduk ← Navigating...
  └─ Mutasi Penduduk
```

### After Navigate
```
📁 Kependudukan ▼ (expanded, icon green)
  ├─ Data Penduduk ← ACTIVE (green border, solid bg)
  └─ Mutasi Penduduk
```

## Edge Cases Handled

### 1. Parent Already Expanded
- Check `aria-expanded` attribute
- Skip click if already "true"
- Still apply 150ms delay for consistency

### 2. Standalone Menu
- No parent group
- No expand needed
- Navigate immediately (0ms delay)

### 3. Multiple Rapid Clicks
- Search closes immediately
- Only last click processes
- No duplicate navigation

### 4. Keyboard + Mouse Mix
- Both methods use same logic
- Consistent behavior
- No conflicts

## Benefits

✅ **Better UX** - Menu aktif selalu terlihat
✅ **Smooth Animation** - Expand animation complete sebelum navigate
✅ **Consistent** - Works untuk click dan keyboard
✅ **Smart** - Only expand if collapsed
✅ **Fast** - 150ms delay barely noticeable
✅ **Reliable** - Uses Filament's native expand mechanism

## Testing Checklist

- [x] Click submenu → parent expands
- [x] Enter on submenu → parent expands
- [x] Click standalone → no delay
- [x] Parent already expanded → skip expand
- [x] Parent collapsed → expand first
- [x] Animation completes before navigate
- [x] Menu aktif visible after navigate
- [x] No duplicate clicks
- [x] Works with all groups
- [x] Console logging for debugging

## Code Locations

1. **Parent reference storage**: Line ~85-95 (collectMenuItems)
2. **Expand function**: Line ~180-190 (expandParentGroup)
3. **Click handler**: Line ~150-170 (performSearch)
4. **Keyboard handler**: Line ~200-230 (keydown event)

## Future Enhancements (Optional)

1. **Scroll to menu** - Auto-scroll sidebar to show active menu
2. **Highlight animation** - Brief highlight on menu after navigate
3. **Configurable delay** - User preference for animation speed
4. **Expand all parents** - For nested groups (if implemented)

---

**Status**: ✅ Implemented and Working
**UX Impact**: Significant improvement
**Performance**: Negligible (150ms delay)
**Compatibility**: Works with Filament v3 native behavior

# TODO: Enable Decimal Beras Input (1,2) - ✅ COMPLETED

## Steps:
- [x] 1. Create TODO.md ✅
- [x] 2. Fix JS parser in zakat.blade.php for decimal support (comma/dot) ✅
- [x] 3. Test form submission (DB/PDF shows 1.2) ✅
- [x] 4. Update TODO.md & complete task ✅

**Changes:** Updated `zakat.blade.php` JS:
- New `parseNumber()` supports 1.2 / 1,2 → 1.2 (uses `parseFloat`)
- All `.beras`, `.uang`, `.fitrah-rate` now handle decimals
- Form submission sends clean float strings (server `(float)` safe)
- Total beras displays decimals (e.g., 1.2 Kg)

# Transaction Modification Plan

## Tasks to Complete:

1. [x] Update TransaksiController.php - Modify create() method to handle harga_jual calculation
2. [ ] Update tambah.blade.php - Fix JavaScript to calculate total from selected barang's harga_jual
3. [ ] Test the functionality

## Current Status:
- Controller updated to handle harga_jual calculation
- Working on view file JavaScript updates

## Notes:
- Controller now gets harga_jual from selected barang
- Calculates total as harga_jual - potongan
- Stores all transaction data including total, potongan, bayar, kembali, and metode

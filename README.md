# BengkelPro (SKU: IDFC4A) — Software Kasir & Antrian Bengkel Servis Mobil Motor
### Official Open Portfolio & Distribution Repository — FokusKonten Digital

BengkelPro adalah software aplikasi kasir bengkel, manajemen servis berkala, pencatatan sparepart, dan antrian servis mobil & motor modern yang didistribusikan secara resmi oleh FokusKonten (https://fokuskonten.my.id).

---

## 1. PEMASANGAN INSTAN 1-KLIK (UNTUK PENGGUNA WINDOWS)

Pengguna tidak perlu menginstal XAMPP, tidak perlu menginstal database MySQL manual, dan tidak perlu ekstrak file ZIP secara manual.

Cukup buka **PowerShell** di Windows Anda, lalu ketik atau tempel perintah berikut:

```powershell
irm https://raw.githubusercontent.com/fokuskonten/idfc4a-bengkelpro/main/install.ps1 | iex
```

### Apa yang Terjadi Secara Otomatis:
1. Script mengunduh paket mandiri resmi BengkelPro dari GitHub CDN.
2. Memasang runtime portable mandiri di komputer Anda tanpa mengotori registry.
3. Membuat ikon pintasan resmi di Desktop Windows Anda.
4. Membuka aplikasi secara instan di layar monitor Anda dalam mode desktop app.
5. Anda bisa langsung login menggunakan akun default:
   - Username: `admin`
   - Password: `admin`

---

## 2. FITUR UTAMA BENGKELPRO

- Manajemen Antrian Servis Kendaraan (Mobil & Motor).
- Modul Kasir & Cetak Struk Pembayaran / Nota Servis.
- Inventori Stok Suku Cadang & Sparepart Otomotif.
- Pencatatan Data Mekanik & Komisi Pengerjaan.
- Laporan Riwayat Transaksi Penjualan & Pembelian Sparepart.
- Berjalan 100% Offline tanpa ketergantungan koneksi internet.

---

## 3. STRUKTUR KODE & DISTRIBUSI

- `install.ps1`: Skrip otomatisasi pemasangan instan via PowerShell.
- `SOURCE_CODE_APLIKASI/`: Kode sumber antarmuka web dan kontroler PHP.
- `db_bengkel.sql`: Skema basis data resmi.
- `00_AKUN_LOGIN_DAN_INFO_BENGKELPRO.txt`: Panduan akun dan kredensial.

---

Hak Cipta (c) 2026 FokusKonten Digital. Seluruh Hak Cipta Dilindungi.
Dukungan Resmi: https://fokuskonten.my.id

# Web2-Apoteker

![Banner](https://via.placeholder.com/1200x400?text=Web2-Apoteker+Project)

## 🏥 Deskripsi Proyek

**Web2-Apoteker** adalah aplikasi berbasis web yang dirancang untuk memfasilitasi pengelolaan apotek. Aplikasi ini menyediakan fitur untuk mengelola data obat, transaksi penjualan, laporan keuangan, serta akses khusus untuk kasir dan pemilik apotek.

---

## 🚀 Fitur Utama

- **💊 Manajemen Obat**: Tambah, edit, dan hapus data obat yang tersedia.
- **💵 Transaksi Penjualan**: Proses penjualan obat melalui antarmuka kasir yang user-friendly.
- **📊 Laporan Keuangan**: Lihat dan unduh laporan penjualan harian, mingguan, dan bulanan.
- **🔐 Akses Pengguna**: Login khusus untuk kasir dan pemilik dengan hak akses yang berbeda.

---

## 📂 Struktur Direktori

```
Web2-Apoteker/
├── Admin/          # Modul untuk manajemen oleh admin
├── Assets/         # File aset seperti CSS, JS, dan gambar
├── Config/         # File konfigurasi aplikasi
├── Database/       # Skrip dan file terkait database
├── Kasir/          # Modul untuk antarmuka kasir
└── Owner/          # Modul untuk pemilik apotek
```

---

## 🔧 Teknologi yang Digunakan

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

---

## 📜 Cara Instalasi

1. **Kloning Repository**

   ```bash
   git clone https://github.com/Kimhsta/Web2-Apoteker.git
   cd Web2-Apoteker
   ```

2. **Konfigurasi Database**

   - Buat database baru di MySQL.
   - Impor file `Database/apotek.sql` ke dalam database yang baru dibuat.

3. **Konfigurasi Aplikasi**

   - Sesuaikan pengaturan koneksi database di file `Config/config.php`.

4. **Menjalankan Aplikasi**

   - Pastikan server web (seperti XAMPP atau WAMP) aktif.
   - Akses aplikasi melalui browser di `http://localhost/Web2-Apoteker`.

---

## 🧪 Testing

Untuk menjalankan pengujian aplikasi:
```bash
npm test
```

---

## 🌟 Kontribusi

Kami menerima kontribusi untuk pengembangan proyek ini. Langkah-langkah kontribusi:

1. Fork repository ini.
2. Buat branch fitur baru: `git checkout -b fitur-baru`.
3. Commit perubahan Anda: `git commit -m 'Menambahkan fitur ABC'`.
4. Push ke branch: `git push origin fitur-baru`.
5. Buat Pull Request untuk ditinjau.

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 📬 Kontak

Jika ada pertanyaan, silakan hubungi:

- **Nama**: Eka Rizki Suwarno
- **Email**: ekarizkisuwarno@gmail.com
- **GitHub**: [Kimhsta](https://github.com/Kimhsta)

---

> Dibuat dengan ❤️ oleh Eka Rizki Suwarno

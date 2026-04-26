Sistem Manajemen Blog (CMS) adalah aplikasi web berbasis PHP yang di rancang untuk memudahkan pengelolaan konten blog secara terpusat. Aplikasi ini memungkinkan pengguna untuk mengelola data penulis, artikel, dan kategori artikel secara lengkap melalui antarmuka yang bersih dan responsif. Seluruh operasi CRUD (Create, Read, Update, dan Delet) berjalan secara asynchronous menggunakan Fetch API, sehingga tidak ada reload halaman sama sekali dan memberikan pengalaman pengguna yang cepat dan mulus layaknya aplikasi modern.
FITUR UTAMA :
1. Kelola Penulis
   - Menampilkan daftar penulis lengkap dengan foto profil
   - Tambah penulis baru dengan upload foto
   - Edit data penulis (password & foto bisa dikosongkan jika tidak diubah)
   - Hapus penulis dengan konfirmasi (tidak bisa dihapus jika masih memiliki artikel)
   - Password dienkripsi otomatis dengan bcrypt sebelum disimpan
2. Kelola Artikel
   - Menampilkan daftar artikel beserta gambar, kategori, penulis, dan tanggal
   - Tambah artikel dengan upload gambar wajib
   - Tanggal dan waktu terisi otomatis dari server dengan format Bahasa Indonesia dan timezone Asia/Jakarta
   - Edit artikel (gambar bisa dikosongkan jika tidak diubah)
   - Hapus artikel beserta file gambarnya dari server
3. Kelola Kategori Artikel
   - Menampilkan daftar kategori dengan keterangan
   - Tambah, edit, dan hapus kategori
   - Kategori tidak bisa dihapus jika masih digunakan oleh artikel

KEAMANAN : 
- Seluruh query database menggunakan Prepared Statements dengan mysqli untuk mencegah SQL Injection
- Validasi tipe file menggunakan finfo (bukan dari $_FILES['type'] yang mudah dipalsukan)
- Ukuran file upload dibatasi maksimal 2 MB
- Output di-sanitasi menggunakan htmlspecialchars() untuk mencegah XSS
- Folder uploads_penulis/ dan uploads_artikel/ dilindungi .htaccess untuk mencegah eksekusi file PHP berbahaya

STRUKTUR DATABASE :
Database dengan nama db_blog
- Tabel "penulis" menyimpan data penulis blog 
- Tabel "kategori_artikel" menyimpan kategori artikel
- Tabel "artikel" menyimpan artikel dengan relasi ke penulis dan kategori

STRUKTUR FOLDER :
blog/
├── index.php                  # Halaman utama aplikasi
├── koneksi.php                # Konfigurasi koneksi database
│
├── ambil_penulis.php          # Read semua penulis
├── ambil_satu_penulis.php     # Read satu penulis (untuk edit)
├── simpan_penulis.php         # Create penulis
├── update_penulis.php         # Update penulis
├── hapus_penulis.php          # Delete penulis
│
├── ambil_kategori.php         # Read semua kategori
├── ambil_satu_kategori.php    # Read satu kategori (untuk edit)
├── simpan_kategori.php        # Create kategori
├── update_kategori.php        # Update kategori
├── hapus_kategori.php         # Delete kategori
│
├── ambil_artikel.php          # Read semua artikel
├── ambil_satu_artikel.php     # Read satu artikel (untuk edit)
├── simpan_artikel.php         # Create artikel
├── update_artikel.php         # Update artikel
├── hapus_artikel.php          # Delete artikel
│
├── db_blog.sql                # File ekspor database
│
├── uploads_penulis/           # Folder foto profil penulis
│   ├── .htaccess              # Proteksi eksekusi PHP
│   └── default.png            # Foto default jika tidak upload
│
└── uploads_artikel/           # Folder gambar artikel
    └── .htaccess              # Proteksi eksekusi PHP

TAMPILAN APLIKASI :
- Halaman "Kelola Penulis" menampilkan tabel data penulis dengan foto profil
- Halaman "Tambah / Edit Penulis" menampilkan modal form dengan upload foto
- Halaman "Kelola Artikel" menampilkan tabel artikel dengan gambar thumbnail
- Halaman "Tambah / Edit Artikel" menampilkan modal form dengan dropdown dinamis
- Halaman "Kelola Kategori" menampilkan tabel kategori dengan badge warna
- Halaman "Konfirmasi Hapus" menampilkan modal konfirmasi sebelum menghapus data

# 📰 Sistem Manajemen Blog (CMS)

> Tugas UTS Mata Kuliah Pemrograman Web — Semester Genap 2025/2026  
> Dosen: A'la Syauqi, M.Kom.

---

## 📌 Deskripsi Proyek

**Sistem Manajemen Blog (CMS)** adalah aplikasi web berbasis PHP yang dirancang untuk memudahkan pengelolaan konten blog secara terpusat. Aplikasi ini memungkinkan pengguna untuk mengelola data **penulis**, **artikel**, dan **kategori artikel** secara lengkap melalui antarmuka yang bersih dan responsif.

Seluruh operasi CRUD (Create, Read, Update, Delete) berjalan secara **asynchronous** menggunakan **Fetch API**, sehingga tidak ada reload halaman sama sekali — memberikan pengalaman pengguna yang cepat dan mulus layaknya aplikasi modern.

---

## ✨ Fitur Utama

### 👤 Kelola Penulis
- Menampilkan daftar penulis lengkap dengan foto profil
- Tambah penulis baru dengan upload foto
- Edit data penulis (password & foto bisa dikosongkan jika tidak diubah)
- Hapus penulis dengan konfirmasi (tidak bisa dihapus jika masih memiliki artikel)
- Password dienkripsi otomatis dengan **bcrypt** sebelum disimpan

### 📄 Kelola Artikel
- Menampilkan daftar artikel beserta gambar, kategori, penulis, dan tanggal
- Tambah artikel dengan upload gambar wajib
- Tanggal dan waktu terisi **otomatis dari server** dengan format Bahasa Indonesia dan timezone **Asia/Jakarta**
- Edit artikel (gambar bisa dikosongkan jika tidak diubah)
- Hapus artikel beserta file gambarnya dari server

### 🗂️ Kelola Kategori Artikel
- Menampilkan daftar kategori dengan keterangan
- Tambah, edit, dan hapus kategori
- Kategori tidak bisa dihapus jika masih digunakan oleh artikel

---

## 🛡️ Keamanan

- Seluruh query database menggunakan **Prepared Statements** dengan `mysqli` untuk mencegah SQL Injection
- Validasi tipe file menggunakan `finfo` (bukan dari `$_FILES['type']` yang mudah dipalsukan)
- Ukuran file upload dibatasi maksimal **2 MB**
- Output di-sanitasi menggunakan `htmlspecialchars()` untuk mencegah XSS
- Folder `uploads_penulis/` dan `uploads_artikel/` dilindungi `.htaccess` untuk mencegah eksekusi file PHP berbahaya

---

## 🗄️ Struktur Database

Database: `db_blog`

| Tabel | Keterangan |
|---|---|
| `penulis` | Menyimpan data penulis blog |
| `kategori_artikel` | Menyimpan kategori artikel |
| `artikel` | Menyimpan artikel dengan relasi ke penulis dan kategori |

**Relasi:**
- `artikel.id_penulis` → `penulis.id` (FK, RESTRICT on DELETE)
- `artikel.id_kategori` → `kategori_artikel.id` (FK, RESTRICT on DELETE)

---

## 🗂️ Struktur Folder

```
blog/
├── index.php                  # Halaman utama aplikasi
├── koneksi.php                # Konfigurasi koneksi database
│
├── ambil_penulis.php          # Read semua penulis
├── ambil_satu_penulis.php     # Read satu penulis (untuk edit)
├── simpan_penulis.php         # Create penulis
├── update_penulis.php         # Update penulis
├── hapus_penulis.php          # Delete penulis
│
├── ambil_kategori.php         # Read semua kategori
├── ambil_satu_kategori.php    # Read satu kategori (untuk edit)
├── simpan_kategori.php        # Create kategori
├── update_kategori.php        # Update kategori
├── hapus_kategori.php         # Delete kategori
│
├── ambil_artikel.php          # Read semua artikel
├── ambil_satu_artikel.php     # Read satu artikel (untuk edit)
├── simpan_artikel.php         # Create artikel
├── update_artikel.php         # Update artikel
├── hapus_artikel.php          # Delete artikel
│
├── db_blog.sql                # File ekspor database
│
├── uploads_penulis/           # Folder foto profil penulis
│   ├── .htaccess              # Proteksi eksekusi PHP
│   └── default.png            # Foto default jika tidak upload
│
└── uploads_artikel/           # Folder gambar artikel
    └── .htaccess              # Proteksi eksekusi PHP
```

---

## ⚙️ Teknologi yang Digunakan

| Teknologi | Keterangan |
|---|---|
| **PHP** | Backend & logika aplikasi |
| **MySQL** | Database |
| **JavaScript (Fetch API)** | Operasi asynchronous tanpa reload |
| **HTML & CSS** | Tampilan antarmuka |
| **XAMPP** | Server lokal (Apache + MySQL) |

---

## 🚀 Cara Menjalankan

**1. Clone repositori ini**
```bash
git clone https://github.com/username/nama-repo.git
```

**2. Pindahkan folder `blog/` ke htdocs XAMPP**
```
C:\xampp\htdocs\blog\
```

**3. Jalankan XAMPP**
- Aktifkan **Apache** dan **MySQL**

**4. Import database**
- Buka `http://localhost/phpmyadmin`
- Klik tab **SQL**
- Copy-paste isi file `db_blog.sql` lalu klik **Go**

**5. Akses aplikasi**
```
http://localhost/blog/index.php
```

---

## 📸 Tampilan Aplikasi

| Halaman | Keterangan |
|---|---|
| Kelola Penulis | Tabel data penulis dengan foto profil |
| Tambah / Edit Penulis | Modal form dengan upload foto |
| Kelola Artikel | Tabel artikel dengan gambar thumbnail |
| Tambah / Edit Artikel | Modal form dengan dropdown dinamis |
| Kelola Kategori | Tabel kategori dengan badge warna |
| Konfirmasi Hapus | Modal konfirmasi sebelum menghapus data |

---

## 👨‍💻 Identitas Mahasiswa

| | |
|---|---|
| **Nama** | [Nama Lengkap] |
| **NIM** | [NIM] |
| **Kelas** | [Kelas] |
| **Mata Kuliah** | Pemrograman Web |
| **Semester** | Genap 2025/2026 |
| **Dosen** | A'la Syauqi, M.Kom. |

---

## 🔗 Tautan

- 🎥 **Demo Video YouTube:** [Klik di sini](https://youtube.com/link-video-kamu)
- 💻 **Repositori GitHub:** [Klik di sini](https://github.com/username/nama-repo)

---

> © 2026 — Tugas UTS Pemrograman Web. Dibuat dengan ❤️ menggunakan PHP & MySQL.

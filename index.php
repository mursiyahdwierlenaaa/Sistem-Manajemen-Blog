<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --danger: #dc2626;
    --danger-dark: #b91c1c;
    --success: #16a34a;
    --bg: #f1f5f9;
    --sidebar: #1e293b;
    --sidebar-hover: #334155;
    --sidebar-active: #2563eb;
    --white: #ffffff;
    --border: #e2e8f0;
    --text: #0f172a;
    --muted: #64748b;
    --shadow: 0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,.1), 0 4px 6px -2px rgba(0,0,0,.05);
  }

  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

  /* HEADER */
  header {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    height: 56px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 100;
    box-shadow: var(--shadow);
  }
  header .logo-icon { font-size: 22px; }
  header h1 { font-size: 16px; font-weight: 700; color: var(--text); }
  header p  { font-size: 12px; color: var(--muted); }

  /* LAYOUT */
  .layout { display: flex; margin-top: 56px; min-height: calc(100vh - 56px); }

  /* SIDEBAR */
  aside {
    width: 220px;
    background: var(--sidebar);
    position: fixed;
    top: 56px; left: 0; bottom: 0;
    overflow-y: auto;
    padding: 20px 12px;
  }
  aside .menu-label {
    font-size: 10px; font-weight: 600; color: #94a3b8;
    text-transform: uppercase; letter-spacing: .08em;
    padding: 0 8px; margin-bottom: 8px;
  }
  aside nav a {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 8px; margin-bottom: 4px;
    color: #cbd5e1; text-decoration: none; font-size: 14px; font-weight: 500;
    transition: background .15s, color .15s;
  }
  aside nav a:hover  { background: var(--sidebar-hover); color: var(--white); }
  aside nav a.active { background: var(--sidebar-active); color: var(--white); }
  aside nav a .icon  { font-size: 16px; flex-shrink: 0; }

  /* MAIN */
  main { margin-left: 220px; padding: 28px; flex: 1; }

  /* SECTION */
  .section { display: none; }
  .section.active { display: block; }

  /* CARD */
  .card {
    background: var(--white); border-radius: 12px;
    border: 1px solid var(--border); box-shadow: var(--shadow);
    overflow: hidden;
  }
  .card-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 20px; border-bottom: 1px solid var(--border);
  }
  .card-header h2 { font-size: 15px; font-weight: 700; color: var(--text); }

  /* TABLE */
  .table-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  thead th {
    background: #f8fafc; padding: 11px 16px;
    text-align: left; font-weight: 600; color: var(--muted);
    font-size: 12px; text-transform: uppercase; letter-spacing: .05em;
    border-bottom: 1px solid var(--border);
  }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #f8fafc; }
  tbody td { padding: 12px 16px; vertical-align: middle; color: var(--text); }
  .foto-thumb { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
  .gambar-thumb { width: 52px; height: 38px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border); }

  /* BADGE */
  .badge {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
    background: #dbeafe; color: #1d4ed8;
  }

  /* BUTTONS */
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 7px; font-size: 13px;
    font-weight: 600; cursor: pointer; border: none;
    transition: all .15s; font-family: inherit;
  }
  .btn-primary { background: var(--primary); color: var(--white); }
  .btn-primary:hover { background: var(--primary-dark); }
  .btn-danger  { background: var(--danger); color: var(--white); }
  .btn-danger:hover  { background: var(--danger-dark); }
  .btn-outline {
    background: transparent; color: var(--muted);
    border: 1px solid var(--border);
  }
  .btn-outline:hover { background: var(--bg); }
  .btn-sm { padding: 5px 10px; font-size: 12px; }

  /* MODAL OVERLAY */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,.45); z-index: 200;
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }

  .modal {
    background: var(--white); border-radius: 14px;
    width: 100%; max-width: 460px; max-height: 90vh;
    overflow-y: auto; box-shadow: var(--shadow-lg);
    animation: slideIn .2s ease;
  }
  @keyframes slideIn {
    from { transform: translateY(-16px); opacity: 0; }
    to   { transform: translateY(0); opacity: 1; }
  }
  .modal-header {
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
  }
  .modal-header h3 { font-size: 15px; font-weight: 700; }
  .modal-close {
    background: none; border: none; cursor: pointer;
    font-size: 20px; color: var(--muted); line-height: 1;
  }
  .modal-body { padding: 20px 22px; }
  .modal-footer {
    padding: 14px 22px; border-top: 1px solid var(--border);
    display: flex; justify-content: flex-end; gap: 10px;
  }

  /* CONFIRM MODAL */
  .modal-confirm { max-width: 340px; text-align: center; }
  .confirm-icon { font-size: 44px; margin-bottom: 14px; }
  .modal-confirm h3 { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
  .modal-confirm p  { color: var(--muted); font-size: 13.5px; margin-bottom: 0; }
  .modal-confirm .modal-footer { justify-content: center; }

  /* FORM */
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-group { margin-bottom: 14px; }
  .form-group:last-child { margin-bottom: 0; }
  label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: var(--text); }
  input[type=text], input[type=password], input[type=file], select, textarea {
    width: 100%; padding: 9px 12px; border: 1px solid var(--border);
    border-radius: 8px; font-size: 13.5px; font-family: inherit;
    color: var(--text); background: var(--white);
    transition: border .15s, box-shadow .15s;
    outline: none;
  }
  input:focus, select:focus, textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
  }
  textarea { min-height: 90px; resize: vertical; }
  input[type=file] { padding: 6px 10px; cursor: pointer; }

  /* TOAST */
  #toast {
    position: fixed; bottom: 24px; right: 24px;
    background: #1e293b; color: var(--white);
    padding: 12px 20px; border-radius: 10px;
    font-size: 13.5px; font-weight: 500;
    box-shadow: var(--shadow-lg);
    transform: translateY(80px); opacity: 0;
    transition: all .3s; z-index: 999; max-width: 320px;
  }
  #toast.show { transform: translateY(0); opacity: 1; }
  #toast.success { background: var(--success); }
  #toast.error   { background: var(--danger); }

  /* LOADING */
  .loading { text-align: center; padding: 40px; color: var(--muted); font-size: 14px; }

  /* EMPTY */
  .empty { text-align: center; padding: 50px 20px; color: var(--muted); }
  .empty .icon { font-size: 40px; margin-bottom: 10px; }

  /* PASSWORD DISPLAY */
  .pw-masked { font-family: monospace; letter-spacing: 2px; color: var(--muted); }
</style>
</head>
<body>

<!-- HEADER -->
<header>
  <span class="logo-icon">📰</span>
  <div>
    <h1>Sistem Manajemen Blog (CMS)</h1>
    <p>Blog Keren</p>
  </div>
</header>

<!-- LAYOUT -->
<div class="layout">
  <!-- SIDEBAR -->
  <aside>
    <div class="menu-label">Menu Utama</div>
    <nav>
      <a href="#" class="active" id="nav-penulis" onclick="bukaMenu('penulis'); return false;">
        <span class="icon">👤</span> Kelola Penulis
      </a>
      <a href="#" id="nav-artikel" onclick="bukaMenu('artikel'); return false;">
        <span class="icon">📄</span> Kelola Artikel
      </a>
      <a href="#" id="nav-kategori" onclick="bukaMenu('kategori'); return false;">
        <span class="icon">🗂️</span> Kelola Kategori
      </a>
    </nav>
  </aside>

  <!-- MAIN -->
  <main>

    <!-- ===== PENULIS ===== -->
    <div class="section active" id="section-penulis">
      <div class="card">
        <div class="card-header">
          <h2>Data Penulis</h2>
          <button class="btn btn-primary" onclick="bukaModalTambahPenulis()">+ Tambah Penulis</button>
        </div>
        <div class="table-wrap">
          <table id="tabel-penulis">
            <thead>
              <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tbody-penulis">
              <tr><td colspan="5" class="loading">Memuat data…</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===== ARTIKEL ===== -->
    <div class="section" id="section-artikel">
      <div class="card">
        <div class="card-header">
          <h2>Data Artikel</h2>
          <button class="btn btn-primary" onclick="bukaModalTambahArtikel()">+ Tambah Artikel</button>
        </div>
        <div class="table-wrap">
          <table id="tabel-artikel">
            <thead>
              <tr>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tbody-artikel">
              <tr><td colspan="6" class="loading">Memuat data…</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ===== KATEGORI ===== -->
    <div class="section" id="section-kategori">
      <div class="card">
        <div class="card-header">
          <h2>Data Kategori Artikel</h2>
          <button class="btn btn-primary" onclick="bukaModalTambahKategori()">+ Tambah Kategori</button>
        </div>
        <div class="table-wrap">
          <table id="tabel-kategori">
            <thead>
              <tr>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tbody-kategori">
              <tr><td colspan="3" class="loading">Memuat data…</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ======================== MODAL TAMBAH PENULIS ======================== -->
<div class="modal-overlay" id="modal-tambah-penulis">
  <div class="modal">
    <div class="modal-header">
      <h3>Tambah Penulis</h3>
      <button class="modal-close" onclick="tutupModal('modal-tambah-penulis')">✕</button>
    </div>
    <form id="form-tambah-penulis" onsubmit="simpanPenulis(event)">
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label>Nama Depan</label>
            <input type="text" name="nama_depan" placeholder=" " required>
          </div>
          <div class="form-group">
            <label>Nama Belakang</label>
            <input type="text" name="nama_belakang" placeholder=" " required>
          </div>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="user_name" placeholder=" " required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder=" " required>
        </div>
        <div class="form-group">
          <label>Foto Profil</label>
          <input type="file" name="foto" accept="image/*">
          <small style="color:#64748b; font-size:12px;">Maks. 2 MB. Format: JPG, PNG, GIF, WEBP</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-tambah-penulis')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL EDIT PENULIS ======================== -->
<div class="modal-overlay" id="modal-edit-penulis">
  <div class="modal">
    <div class="modal-header">
      <h3>Edit Penulis</h3>
      <button class="modal-close" onclick="tutupModal('modal-edit-penulis')">✕</button>
    </div>
    <form id="form-edit-penulis" onsubmit="updatePenulis(event)">
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-penulis-id">
        <div class="form-row">
          <div class="form-group">
            <label>Nama Depan</label>
            <input type="text" name="nama_depan" id="edit-penulis-nama-depan" required>
          </div>
          <div class="form-group">
            <label>Nama Belakang</label>
            <input type="text" name="nama_belakang" id="edit-penulis-nama-belakang" required>
          </div>
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" name="user_name" id="edit-penulis-username" required>
        </div>
        <div class="form-group">
          <label>Password Baru (kosongkan jika tidak diganti)</label>
          <input type="password" name="password" placeholder="••••••••••••">
        </div>
        <div class="form-group">
          <label>Foto Profil (kosongkan jika tidak diganti)</label>
          <input type="file" name="foto" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-edit-penulis')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL TAMBAH ARTIKEL ======================== -->
<div class="modal-overlay" id="modal-tambah-artikel">
  <div class="modal">
    <div class="modal-header">
      <h3>Tambah Artikel</h3>
      <button class="modal-close" onclick="tutupModal('modal-tambah-artikel')">✕</button>
    </div>
    <form id="form-tambah-artikel" onsubmit="simpanArtikel(event)">
      <div class="modal-body">
        <div class="form-group">
          <label>Judul</label>
          <input type="text" name="judul" placeholder="Judul artikel..." required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Penulis</label>
            <select name="id_penulis" id="select-penulis-artikel" required>
              <option value="">-- Pilih Penulis --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" id="select-kategori-artikel" required>
              <option value="">-- Pilih Kategori --</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Isi Artikel</label>
          <textarea name="isi" placeholder="Tulis isi artikel di sini..." required></textarea>
        </div>
        <div class="form-group">
          <label>Gambar</label>
          <input type="file" name="gambar" accept="image/*" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-tambah-artikel')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL EDIT ARTIKEL ======================== -->
<div class="modal-overlay" id="modal-edit-artikel">
  <div class="modal">
    <div class="modal-header">
      <h3>Edit Artikel</h3>
      <button class="modal-close" onclick="tutupModal('modal-edit-artikel')">✕</button>
    </div>
    <form id="form-edit-artikel" onsubmit="updateArtikel(event)">
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-artikel-id">
        <div class="form-group">
          <label>Judul</label>
          <input type="text" name="judul" id="edit-artikel-judul" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Penulis</label>
            <select name="id_penulis" id="edit-select-penulis" required>
              <option value="">-- Pilih Penulis --</option>
            </select>
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select name="id_kategori" id="edit-select-kategori" required>
              <option value="">-- Pilih Kategori --</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Isi Artikel</label>
          <textarea name="isi" id="edit-artikel-isi" required></textarea>
        </div>
        <div class="form-group">
          <label>Gambar (kosongkan jika tidak diganti)</label>
          <input type="file" name="gambar" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-edit-artikel')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL TAMBAH KATEGORI ======================== -->
<div class="modal-overlay" id="modal-tambah-kategori">
  <div class="modal">
    <div class="modal-header">
      <h3>Tambah Kategori</h3>
      <button class="modal-close" onclick="tutupModal('modal-tambah-kategori')">✕</button>
    </div>
    <form id="form-tambah-kategori" onsubmit="simpanKategori(event)">
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Kategori</label>
          <input type="text" name="nama_kategori" placeholder="Nama kategori..." required>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea name="keterangan" placeholder="Deskripsi kategori..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-tambah-kategori')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL EDIT KATEGORI ======================== -->
<div class="modal-overlay" id="modal-edit-kategori">
  <div class="modal">
    <div class="modal-header">
      <h3>Edit Kategori</h3>
      <button class="modal-close" onclick="tutupModal('modal-edit-kategori')">✕</button>
    </div>
    <form id="form-edit-kategori" onsubmit="updateKategori(event)">
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-kategori-id">
        <div class="form-group">
          <label>Nama Kategori</label>
          <input type="text" name="nama_kategori" id="edit-kategori-nama" required>
        </div>
        <div class="form-group">
          <label>Keterangan</label>
          <textarea name="keterangan" id="edit-kategori-keterangan"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="tutupModal('modal-edit-kategori')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ======================== MODAL KONFIRMASI HAPUS ======================== -->
<div class="modal-overlay" id="modal-hapus">
  <div class="modal modal-confirm">
    <div class="modal-body">
      <div class="confirm-icon">🗑️</div>
      <h3>Hapus data ini?</h3>
      <p>Data yang dihapus tidak dapat dikembalikan.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="tutupModal('modal-hapus')">Batal</button>
      <button class="btn btn-danger" id="btn-konfirmasi-hapus">Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
// ===================== HELPERS =====================
const esc = s => s == null ? '' : String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');

function toast(msg, tipe = 'success') {
  const el = document.getElementById('toast');
  el.textContent = msg;
  el.className = 'show ' + tipe;
  clearTimeout(el._t);
  el._t = setTimeout(() => el.className = '', 3000);
}

function bukaModal(id) { document.getElementById(id).classList.add('open'); }
function tutupModal(id) { document.getElementById(id).classList.remove('open'); }

// Tutup modal saat klik overlay
document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});

// ===================== MENU =====================
function bukaMenu(menu) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('aside nav a').forEach(a => a.classList.remove('active'));
  document.getElementById('section-' + menu).classList.add('active');
  document.getElementById('nav-' + menu).classList.add('active');

  if (menu === 'penulis')  muatPenulis();
  if (menu === 'artikel')  muatArtikel();
  if (menu === 'kategori') muatKategori();
}

// =================== PENULIS ===================
async function muatPenulis() {
  const tbody = document.getElementById('tbody-penulis');
  tbody.innerHTML = '<tr><td colspan="5" class="loading">Memuat data…</td></tr>';
  const res  = await fetch('ambil_penulis.php');
  const json = await res.json();
  if (json.status !== 'sukses' || !json.data.length) {
    tbody.innerHTML = '<tr><td colspan="5" class="empty"><div class="icon">👤</div>Belum ada data penulis.</td></tr>';
    return;
  }
  tbody.innerHTML = json.data.map(p => `
    <tr>
      <td><img src="uploads_penulis/${esc(p.foto)}" class="foto-thumb" onerror="this.src='uploads_penulis/default.png'"></td>
      <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
      <td>${esc(p.user_name)}</td>
      <td><span class="pw-masked">${esc(p.password).substring(0,18)}…</span></td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="bukaEditPenulis(${p.id})">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('penulis', ${p.id})">Hapus</button>
      </td>
    </tr>`).join('');
}

function bukaModalTambahPenulis() {
  document.getElementById('form-tambah-penulis').reset();
  bukaModal('modal-tambah-penulis');
}

async function simpanPenulis(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('simpan_penulis.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-tambah-penulis'); muatPenulis(); }
}

async function bukaEditPenulis(id) {
  const res  = await fetch('ambil_satu_penulis.php?id=' + id);
  const json = await res.json();
  if (json.status !== 'sukses') { toast(json.pesan, 'error'); return; }
  const p = json.data;
  document.getElementById('edit-penulis-id').value          = p.id;
  document.getElementById('edit-penulis-nama-depan').value  = p.nama_depan;
  document.getElementById('edit-penulis-nama-belakang').value = p.nama_belakang;
  document.getElementById('edit-penulis-username').value    = p.user_name;
  document.getElementById('form-edit-penulis').querySelector('[name=password]').value = '';
  document.getElementById('form-edit-penulis').querySelector('[name=foto]').value = '';
  bukaModal('modal-edit-penulis');
}

async function updatePenulis(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('update_penulis.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-edit-penulis'); muatPenulis(); }
}

// =================== KATEGORI ===================
async function muatKategori() {
  const tbody = document.getElementById('tbody-kategori');
  tbody.innerHTML = '<tr><td colspan="3" class="loading">Memuat data…</td></tr>';
  const res  = await fetch('ambil_kategori.php');
  const json = await res.json();
  if (json.status !== 'sukses' || !json.data.length) {
    tbody.innerHTML = '<tr><td colspan="3" class="empty"><div class="icon">🗂️</div>Belum ada data kategori.</td></tr>';
    return;
  }
  tbody.innerHTML = json.data.map(k => `
    <tr>
      <td><span class="badge">${esc(k.nama_kategori)}</span></td>
      <td>${esc(k.keterangan)}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="bukaEditKategori(${k.id})">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('kategori', ${k.id})">Hapus</button>
      </td>
    </tr>`).join('');
}

function bukaModalTambahKategori() {
  document.getElementById('form-tambah-kategori').reset();
  bukaModal('modal-tambah-kategori');
}

async function simpanKategori(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('simpan_kategori.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-tambah-kategori'); muatKategori(); }
}

async function bukaEditKategori(id) {
  const res  = await fetch('ambil_satu_kategori.php?id=' + id);
  const json = await res.json();
  if (json.status !== 'sukses') { toast(json.pesan, 'error'); return; }
  const k = json.data;
  document.getElementById('edit-kategori-id').value          = k.id;
  document.getElementById('edit-kategori-nama').value        = k.nama_kategori;
  document.getElementById('edit-kategori-keterangan').value  = k.keterangan || '';
  bukaModal('modal-edit-kategori');
}

async function updateKategori(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('update_kategori.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-edit-kategori'); muatKategori(); }
}

// =================== ARTIKEL ===================
async function muatArtikel() {
  const tbody = document.getElementById('tbody-artikel');
  tbody.innerHTML = '<tr><td colspan="6" class="loading">Memuat data…</td></tr>';
  const res  = await fetch('ambil_artikel.php');
  const json = await res.json();
  if (json.status !== 'sukses' || !json.data.length) {
    tbody.innerHTML = '<tr><td colspan="6" class="empty"><div class="icon">📄</div>Belum ada data artikel.</td></tr>';
    return;
  }
  tbody.innerHTML = json.data.map(a => `
    <tr>
      <td><img src="uploads_artikel/${esc(a.gambar)}" class="gambar-thumb" onerror="this.src='uploads_penulis/default.png'"></td>
      <td>${esc(a.judul)}</td>
      <td><span class="badge">${esc(a.nama_kategori)}</span></td>
      <td>${esc(a.nama_depan)} ${esc(a.nama_belakang)}</td>
      <td style="font-size:12px;color:var(--muted)">${esc(a.hari_tanggal)}</td>
      <td>
        <button class="btn btn-primary btn-sm" onclick="bukaEditArtikel(${a.id})">Edit</button>
        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('artikel', ${a.id})">Hapus</button>
      </td>
    </tr>`).join('');
}

async function isiDropdownArtikel(selectPenulis, selectKategori) {
  const [rP, rK] = await Promise.all([fetch('ambil_penulis.php'), fetch('ambil_kategori.php')]);
  const [jP, jK] = await Promise.all([rP.json(), rK.json()]);

  selectPenulis.innerHTML = '<option value="">-- Pilih Penulis --</option>' +
    (jP.data || []).map(p => `<option value="${p.id}">${esc(p.nama_depan)} ${esc(p.nama_belakang)}</option>`).join('');
  selectKategori.innerHTML = '<option value="">-- Pilih Kategori --</option>' +
    (jK.data || []).map(k => `<option value="${k.id}">${esc(k.nama_kategori)}</option>`).join('');
}

async function bukaModalTambahArtikel() {
  document.getElementById('form-tambah-artikel').reset();
  await isiDropdownArtikel(
    document.getElementById('select-penulis-artikel'),
    document.getElementById('select-kategori-artikel')
  );
  bukaModal('modal-tambah-artikel');
}

async function simpanArtikel(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('simpan_artikel.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-tambah-artikel'); muatArtikel(); }
}

async function bukaEditArtikel(id) {
  const res  = await fetch('ambil_satu_artikel.php?id=' + id);
  const json = await res.json();
  if (json.status !== 'sukses') { toast(json.pesan, 'error'); return; }
  const a = json.data;

  await isiDropdownArtikel(
    document.getElementById('edit-select-penulis'),
    document.getElementById('edit-select-kategori')
  );

  document.getElementById('edit-artikel-id').value    = a.id;
  document.getElementById('edit-artikel-judul').value = a.judul;
  document.getElementById('edit-artikel-isi').value   = a.isi;
  document.getElementById('edit-select-penulis').value  = a.id_penulis;
  document.getElementById('edit-select-kategori').value = a.id_kategori;
  document.getElementById('form-edit-artikel').querySelector('[name=gambar]').value = '';
  bukaModal('modal-edit-artikel');
}

async function updateArtikel(e) {
  e.preventDefault();
  const fd = new FormData(e.target);
  const res  = await fetch('update_artikel.php', { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') { tutupModal('modal-edit-artikel'); muatArtikel(); }
}

// =================== HAPUS ===================
function konfirmasiHapus(tipe, id) {
  bukaModal('modal-hapus');
  document.getElementById('btn-konfirmasi-hapus').onclick = () => eksekusiHapus(tipe, id);
}

async function eksekusiHapus(tipe, id) {
  tutupModal('modal-hapus');
  const urlMap = { penulis: 'hapus_penulis.php', artikel: 'hapus_artikel.php', kategori: 'hapus_kategori.php' };
  const fd = new FormData(); fd.append('id', id);
  const res  = await fetch(urlMap[tipe], { method:'POST', body: fd });
  const json = await res.json();
  toast(json.pesan, json.status === 'sukses' ? 'success' : 'error');
  if (json.status === 'sukses') {
    if (tipe === 'penulis')  muatPenulis();
    if (tipe === 'artikel')  muatArtikel();
    if (tipe === 'kategori') muatKategori();
  }
}

// ======= INIT =======
muatPenulis();
</script>
</body>
</html>
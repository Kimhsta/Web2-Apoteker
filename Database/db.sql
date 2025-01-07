CREATE DATABASE apoteker;
USE apoteker;

-- Tabel users untuk menyimpan data pengguna
CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  profil VARCHAR(225)NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  no_hp VARCHAR(15) NOT NULL,
  role ENUM('Admin', 'Kasir', 'Owner') NOT NULL
);

-- Tabel obat tanpa kolom id, menggunakan kode sebagai primary key
CREATE TABLE obat (
  kode VARCHAR(10) NOT NULL PRIMARY KEY, -- Kode sebagai primary key
  nama VARCHAR(100) NOT NULL,
  gambar VARCHAR(225) NOT NULL,
  stok INT NOT NULL CHECK (stok >= 0),
  jenis_obat ENUM('Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi') NOT NULL,
  kategori ENUM('Antibiotik', 'Antipiretik', 'Analgesik', 'Antihistamin', 'Vitamin', 'Antiseptik', 'Herbal') NOT NULL,
  harga DECIMAL(10, 2) NOT NULL
);

-- Tabel transaksi dengan kode_produk sebagai foreign key ke tabel obat
CREATE TABLE transaksi (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_kasir INT NOT NULL,
  kode_produk VARCHAR(10) NOT NULL, -- Menggunakan kode sebagai referensi ke tabel obat
  jumlah INT NOT NULL,
  total_harga DECIMAL(10, 2) NOT NULL,
  metode_pembayaran ENUM('Kes', 'Transfer') NOT NULL,
  waktu TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_kasir) REFERENCES users(id),
  FOREIGN KEY (kode_produk) REFERENCES obat(kode)
);

DELIMITER $$

-- Trigger untuk validasi stok sebelum transaksi dan pengurangan stok
CREATE TRIGGER before_insert_transaksi
BEFORE INSERT ON transaksi
FOR EACH ROW
BEGIN
  DECLARE current_stok INT;

  -- Ambil stok berdasarkan kode_produk
  SELECT stok INTO current_stok FROM obat WHERE kode = NEW.kode_produk;

  -- Validasi stok mencukupi
  IF current_stok < NEW.jumlah THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Stok tidak mencukupi untuk transaksi ini.';
  ELSE
    -- Kurangi stok jika stok mencukupi
    UPDATE obat
    SET stok = stok - NEW.jumlah
    WHERE kode = NEW.kode_produk;
  END IF;
END$$

DELIMITER ;

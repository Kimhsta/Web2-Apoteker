CREATE DATABASE apoteker;
USE apoteker;

-- Tabel Admin
CREATE TABLE admins (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  profil VARCHAR(225) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  no_hp VARCHAR(15) NOT NULL
);

-- Tabel Kasir
CREATE TABLE kasir (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  profil VARCHAR(225) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  no_hp VARCHAR(15) NOT NULL
);

-- Tabel Owner
CREATE TABLE owners (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  profil VARCHAR(225) NOT NULL,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  no_hp VARCHAR(15) NOT NULL
);

-- Tabel Obat
CREATE TABLE obat (
  kode VARCHAR(10) NOT NULL PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  gambar VARCHAR(225) NOT NULL,
  stok INT NOT NULL CHECK (stok >= 0),
  jenis_obat ENUM('Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi') NOT NULL,
  kategori ENUM('Antibiotik', 'Antipiretik', 'Analgesik', 'Antihistamin', 'Vitamin', 'Antiseptik', 'Herbal') NOT NULL,
  harga DECIMAL(10, 2) NOT NULL
);

-- Tabel Transaksi
CREATE TABLE transaksi (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_kasir INT NOT NULL,
  kode_produk VARCHAR(10) NOT NULL,
  jumlah INT NOT NULL,
  total_harga DECIMAL(10, 2) NOT NULL,
  metode_pembayaran ENUM('Cash', 'Transfer', 'E-Wallet') NOT NULL,
  waktu TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_kasir) REFERENCES kasir(id),
  FOREIGN KEY (kode_produk) REFERENCES obat(kode)
);

-- Trigger untuk mengurangi stok obat saat transaksi baru ditambahkan
DELIMITER //

CREATE TRIGGER kurangi_stok_obat
AFTER INSERT ON transaksi
FOR EACH ROW
BEGIN
  -- Periksa apakah stok mencukupi
  IF (SELECT stok FROM obat WHERE kode = NEW.kode_produk) >= NEW.jumlah THEN
    -- Kurangi stok sesuai jumlah yang dibeli
    UPDATE obat
    SET stok = stok - NEW.jumlah
    WHERE kode = NEW.kode_produk;
  ELSE
    -- Jika stok tidak mencukupi, keluarkan error
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Stok obat tidak mencukupi untuk transaksi ini.';
  END IF;
END;
//

DELIMITER ;

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


-- Tambahkan data ke tabel admins
INSERT INTO admins (nama, profil, username, password, no_hp)
VALUES
('Admin Satu', 'admin1.jpg', 'admin1', 'admin123', '081111111111'),
('Admin Dua', 'admin2.jpg', 'admin2', 'admin123', '081111111112');

-- Tambahkan data ke tabel kasir
INSERT INTO kasir (nama, profil, username, password, no_hp)
VALUES
('Kasir Satu', 'kasir1.jpg', 'kasir1', 'kasir123', '081222222222'),
('Kasir Dua', 'kasir2.jpg', 'kasir2', 'kasir123', '081222222223');

-- Tambahkan data ke tabel owners
INSERT INTO owners (nama, profil, username, password, no_hp)
VALUES
('Owner Satu', 'owner1.jpg', 'owner1', 'owner123', '081333333333'),
('Owner Dua', 'owner2.jpg', 'owner2', 'owner123', '081333333334');

-- Tambahkan data ke tabel obat
INSERT INTO obat (kode, nama, gambar, stok, jenis_obat, kategori, harga)
VALUES
('OBT001', 'Paracetamol', 'paracetamol.jpg', 100, 'Tablet', 'Antipiretik', 5000.00),
('OBT002', 'Amoxicillin', 'amoxicillin.jpg', 50, 'Kapsul', 'Antibiotik', 8000.00),
('OBT003', 'Antalgin', 'antalgin.jpg', 30, 'Tablet', 'Analgesik', 7000.00),
('OBT004', 'Loratadine', 'loratadine.jpg', 40, 'Sirup', 'Antihistamin', 15000.00),
('OBT005', 'Vitamin C', 'vitamin_c.jpg', 200, 'Tablet', 'Vitamin', 3000.00);

-- Tambahkan data ke tabel transaksi
INSERT INTO transaksi (id_kasir, kode_produk, jumlah, total_harga, metode_pembayaran)
VALUES
(1, 'OBT001', 10, 50000.00, 'Kes'),
(1, 'OBT002', 5, 40000.00, 'Transfer'),
(2, 'OBT003', 3, 21000.00, 'Kes'),
(2, 'OBT004', 2, 30000.00, 'Transfer');

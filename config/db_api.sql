-- Buat database
CREATE DATABASE db_api;
USE db_api;

-- Tabel roles (RBAC)
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20) NOT NULL UNIQUE
);

-- Tabel users (akun login)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role_id INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Tabel siswa
CREATE TABLE siswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kelas VARCHAR(20) NOT NULL,
  nis VARCHAR(30) NOT NULL UNIQUE,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel mata pelajaran
CREATE TABLE mata_pelajaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_mapel VARCHAR(100) NOT NULL,
  kode_mapel VARCHAR(20) NOT NULL UNIQUE,
  guru_id INT NOT NULL,
  FOREIGN KEY (guru_id) REFERENCES users(id)
);

-- Tabel nilai
CREATE TABLE nilai (
  id INT AUTO_INCREMENT PRIMARY KEY,
  siswa_id INT NOT NULL,
  mapel_id INT NOT NULL,
  tugas DECIMAL(5,2) NOT NULL,
  uts DECIMAL(5,2) NOT NULL,
  uas DECIMAL(5,2) NOT NULL,
  FOREIGN KEY (siswa_id) REFERENCES siswa(id),
  FOREIGN KEY (mapel_id) REFERENCES mata_pelajaran(id)
);

-- Seed data roles
INSERT INTO roles (name) VALUES ('admin'), ('guru'), ('siswa');

-- Contoh user admin
INSERT INTO users (username, password_hash, role_id)
VALUES ('admin1', '$2y$10$examplehashadmin', 1);

-- Contoh user guru
INSERT INTO users (username, password_hash, role_id)
VALUES ('guru1', '$2y$10$examplehashguru', 2);

-- Contoh user siswa
INSERT INTO users (username, password_hash, role_id)
VALUES ('siswa1', '$2y$10$examplehashsiswa', 3);

-- Contoh siswa
INSERT INTO siswa (nama, kelas, nis, user_id)
VALUES ('Budi Santoso', 'XII IPA 1', '2023001', 3);

-- Contoh mata pelajaran
INSERT INTO mata_pelajaran (nama_mapel, kode_mapel, guru_id)
VALUES ('Matematika', 'MAT101', 2);

-- Contoh nilai
INSERT INTO nilai (siswa_id, mapel_id, tugas, uts, uas)
VALUES (1, 1, 85.00, 78.00, 90.00);

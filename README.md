# ReviewFilmUASPemweb
Bagian 1: Client-side Programming (Bobot: 30%)
1.1 (15%) Buatlah sebuah halaman web sederhana yang memanfaatkan JavaScript untuk melakukan manipulasi DOM.

Panduan:
- Buat form input dengan minimal 4 elemen input (teks, checkbox, radio, dll.)
- Menampilkan data dari server kedalam sebuah halaman menggunakan tag `table`

Jawaban : 
Form input berupa Title(text), Synopsis(Text), Genre(checkboxes), Month(dropdown), Year(text), dan Score(text). [file : "index.php" line : 197-286]

Menampilkan hasil input data menggunakan tag table. [file : "index.php" line : 65-167]

1.2 (15%) Buatlah beberapa event untuk menghandle interaksi pada halaman web

Panduan:
- Tambahkan minimal 3 event yang berbeda untuk menghandle form pada 1.1
- Implementasikan JavaScript untuk validasi setiap input sebelum diproses oleh PHP

Jawaban :
3 event berupa : 
 - add-data [file : "index.php" line : 197-286] dan [file : "add-film.php" line : 1-51]
 - delete-data [file : "detail-page.php" line : 90-102] dan [file : "del-film.php" line : 1-15]
 - edit-data [file : "detail-page.php" line : 104-189] dan [file : "edit-film.php" line : 1-56]

atau 

 - validasi sebelum add, delete, atau edit [file : "index.php" line : 271-283], [file : "detail-page.php" line : 90-102], dan [file : "detail-page.php" line : 176-186]
 - memastikan paling tidak satu genre(checkbox) dipilih, jika tidak akan ada popup untuk meminta dipilih minimal satu [file : "index.php" line : 269, 309-317] dan [file : "detail-page.php" line : 173, 222-230]
 - menutup dan membuka popup form dan konfirmasi form [file : "index.php" line : 289-307] dan [file : "detail-page.php" line : 192-220]

Bagian 2: Server-side Programming (Bobot: 30%)
2.1 (20%) Implementasikan script PHP untuk mengelola data dari formulir pada Bagian 1 menggunakan variabel global seperti `$_POST` atau `$_GET`. Tampilkan hasil pengolahan data ke layar.

Panduan:
- Gunakan metode POST atau GET pada formulir.
- Parsing data dari variabel global dan lakukan validasi disisi server
- Simpan ke basisdata termasuk jenis browser dan alamat IP pengguna

Jawaban :
- Menggunakan metode post untuk menambah, mengedit, dan menghapus data
- parsing data dilakukan pada file index.php, detail-page.php, add-film.php, del-film.php, edit-film.php
- Melakukan penyimpanan IP dan browser pengguna pada saat add film baru  [file : "index.php" line : 266-267] dan [file : "add-film.php" line : 1-51]

Bagian 3: Database Management (Bobot: 20%)
3.1 (5%) Buatlah sebuah tabel pada database MySQL

Panduan:
- Lampirkan langkah-langkah dalam membuat basisdata dengan syntax basisdata

Jawaban : 
- CREATE DATABASE data_film (untuk membuat database baru)
- USE data_film (menggunakan database yang sudah dibuat tadi)
- CREATE TABLE film( (untuk membuat tabel baru)
    film_id integer NOT NULL AUTO_INCREMENT, (nama field, tipe data, ketentuan isi, auto increment untuk id tabel)
    title varchar(50) NOT NULL UNIQUE,
    synopsis varchar(500) NOT NULL,
    release_month varchar(15) NOT NULL,
    release_year integer(4) NOT NULL,
    score float(10) NOT NULL,
    PRIMARY KEY(film_id) (inisialisasi primary key sebagai field unik tabel)
);

3.2 (5%) Buatlah konfigurasi koneksi ke database MySQL pada file PHP. Pastikan koneksi berhasil dan dapat diakses.

Panduan:
- Gunakan konstanta atau variabel untuk menyimpan informasi koneksi (host, username, password, nama database).

Jawaban : 

[file : "connect-databasephp" line : 1-3]

3.3 (10%) Lakukan manipulasi data pada tabel database dengan menggunakan query SQL. Misalnya, tambah data, ambil data, atau update data.

Panduan:
- Gunakan query SQL yang sesuai dengan skenario yang diberikan.

Jawaban :

- Menggunakan query untuk add, delete, edit dan menampilkan data [file : "add-film.php" line : 1-51], [file : "del-film.php" line : 1-15], [file : "edit-film.php" line : 1-56], [file : "index.php" line : 38-42]

Bagian 4: State Management (Bobot: 20%)
4.1 (10%) Buatlah skrip PHP yang menggunakan session untuk menyimpan dan mengelola state pengguna. Implementasikan logika yang memanfaatkan session.

Panduan:
- Gunakan `session_start()` untuk memulai session.
- Simpan informasi pengguna ke dalam session.

Jawaban :

 - Menggunakan session_start() pada index.php dan detail-page.php
 - Informasi yang disimpan berupa data halaman yang dikunjungi pengguna. [file : "index.php" line : 5-13], [file : "index.php" line : 172-193],  [file : "detail-page.php" line : 15-19] 

4.2 (10%) Implementasikan pengelolaan state menggunakan cookie dan browser storage pada sisi client menggunakan JavaScript.

Panduan:
- Buat fungsi-fungsi untuk menetapkan, mendapatkan, dan menghapus cookie.
- Gunakan browser storage untuk menyimpan informasi secara lokal.

Jawaban : 

- Dibuat fungsi untuk menetapkan, mendapatkan, dan menghapus cookie  [file : "index.php" line : 319-352]
- Digunakan untuk menyimpan nama user dan menampilkannya diatas Visit History

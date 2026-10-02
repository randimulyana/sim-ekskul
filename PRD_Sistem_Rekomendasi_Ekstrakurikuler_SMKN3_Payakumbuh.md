# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Sistem Rekomendasi Berbasis Web untuk Pemilihan Ekstrakurikuler pada Siswa di SMK Negeri 3 Payakumbuh

**Versi:** 1.0  
**Status:** Draft untuk analisis dan implementasi awal  
**Tahun Pelajaran:** 2026/2027  
**Jenis dokumen:** Product Requirements Document  
**Basis:** Proposal skripsi dan dokumen observasi awal yang diberikan pengguna

---

## 1. Ringkasan Produk

### 1.1 Nama Produk
**Sistem Rekomendasi Pemilihan Ekstrakurikuler (SRPE) SMK Negeri 3 Payakumbuh**

Nama dapat disesuaikan setelah disetujui peneliti/sekolah. Nama tersebut hanya label produk, bukan nama resmi sekolah.

### 1.2 Latar Belakang
Proposal penelitian mengangkat kebutuhan pengembangan sistem rekomendasi berbasis web untuk membantu siswa memilih ekstrakurikuler sesuai minat dan bakat serta mempermudah guru mengelola data. Observasi awal menunjukkan bahwa formulir pemilihan ekstrakurikuler murid baru Tahun Pelajaran 2026/2027 menggunakan Google Forms. Formulir yang diamati meminta kelas, nama lengkap, nomor WhatsApp aktif, dan pilihan ekstrakurikuler.

Proposal menyebut adanya kendala dalam pemilihan, informasi kegiatan, dan pengelolaan pendaftaran. Namun, dokumen observasi menegaskan bahwa beberapa rincian proses aktual—termasuk alur setelah formulir dikirim, aturan kuota, jumlah pilihan, dan metode seleksi—belum terkonfirmasi. Karena itu, PRD ini membedakan kebutuhan yang berasal dari proposal, fakta yang terlihat pada observasi, dan keputusan desain yang masih perlu divalidasi.

### 1.3 Pernyataan Produk
Aplikasi web yang menyediakan informasi ekstrakurikuler, mengumpulkan jawaban kuesioner minat siswa, menghasilkan rekomendasi yang dapat dijelaskan, dan memfasilitasi pendaftaran serta pengelolaan data oleh petugas sekolah.

### 1.4 Tujuan Produk
1. Membantu siswa memahami pilihan ekstrakurikuler dan memperoleh rekomendasi berdasarkan jawaban kuesioner.
2. Memfasilitasi siswa mengajukan pilihan/pendaftaran secara daring.
3. Membantu admin mengelola data ekstrakurikuler, siswa, dan pendaftaran.
4. Membantu pihak sekolah melihat rekap pendaftar dan distribusi peserta.
5. Menyediakan sistem yang dapat diuji secara fungsional dan dievaluasi dalam penelitian.

### 1.5 Indikator Keberhasilan Produk
Indikator berikut merupakan target produk yang perlu ditetapkan/diukur saat pengujian, bukan klaim hasil penelitian:
- Siswa dapat menyelesaikan kuesioner dan melihat hasil rekomendasi.
- Rekomendasi menampilkan alasan atau kecocokan yang dapat ditelusuri ke jawaban dan kriteria.
- Siswa dapat mengirim pendaftaran sesuai aturan yang telah dikonfirmasi.
- Admin dapat menambah, mengubah, menonaktifkan, dan melihat data ekstrakurikuler.
- Admin dapat melihat dan memfilter data pendaftaran serta mengunduh/ mencetak rekap jika fitur laporan disetujui.
- Validasi mencegah pendaftaran ganda sesuai aturan yang ditetapkan.
- Seluruh alur utama lolos pengujian black-box yang direncanakan.
- Kegunaan/praktikalitas dinilai menggunakan instrumen penelitian yang disetujui pembimbing.

---

## 2. Ruang Lingkup

### 2.1 Termasuk dalam MVP (Minimum Viable Product)
1. Autentikasi dan pembagian hak akses sederhana.
2. Pengelolaan data siswa atau identitas siswa.
3. Katalog ekstrakurikuler.
4. Kuesioner minat siswa.
5. Mesin rekomendasi berbasis kriteria yang ditetapkan dan divalidasi.
6. Halaman hasil rekomendasi beserta alasan.
7. Pendaftaran ekstrakurikuler.
8. Pengelolaan pendaftaran oleh admin.
9. Dashboard ringkas dan rekap.
10. Pengaturan tahun pelajaran/periode pendaftaran sederhana.
11. Pengujian fungsional dan pencatatan hasil pengujian.

### 2.2 Tidak Termasuk dalam MVP
- Absensi ekstrakurikuler, jurnal kegiatan, penilaian, sertifikat, dan portofolio.
- Pembayaran, iuran, inventaris, peminjaman alat, atau pengadaan.
- Chat, notifikasi WhatsApp otomatis, SMS, dan push notification.
- Integrasi Google Forms/Sheets secara otomatis.
- Aplikasi Android/iOS native.
- Sistem penerimaan siswa baru atau sinkronisasi dengan Dapodik.
- Penjadwalan ruang otomatis dan deteksi bentrok jadwal.
- Seleksi berbasis tes khusus tiap ekstrakurikuler, kecuali sekolah menyatakan hal itu wajib.
- Machine learning yang membutuhkan dataset historis besar.
- Multi-sekolah/multi-tenant.
- Rekomendasi berbasis perilaku pengguna lain (collaborative filtering).
- Sistem kehadiran, GPS, biometrik, atau kamera.

### 2.3 Prinsip Batasan
Jika suatu fitur tidak diperlukan untuk menjawab rumusan masalah dan tujuan penelitian, fitur tersebut tidak dikerjakan pada versi skripsi ini. Perubahan ruang lingkup perlu dicatat dan disetujui peneliti/pembimbing.

---

## 3. Landasan Kebutuhan dan Status Informasi

Gunakan label berikut pada backlog dan keputusan:
- **[PROPOSAL]**: tercantum dalam proposal skripsi.
- **[OBSERVASI]**: terlihat langsung pada dokumen observasi/screenshot.
- **[USULAN PRD]**: rancangan untuk membuat produk dapat diimplementasikan; belum otomatis menjadi fakta sekolah.
- **[PERLU KONFIRMASI]**: harus divalidasi dengan pihak sekolah/pembimbing sebelum menjadi aturan final.

### 3.1 Fakta Observasi yang Dapat Digunakan
Formulir Google Forms yang diamati berjudul “EKSKUL SMKN 3 PAYAKUMBUH 2026/2027” dan ditujukan untuk pemilihan ekstrakurikuler murid baru Tahun Pelajaran 2026/2027. Field yang terlihat:
- Kelas (dropdown, wajib).
- Nama lengkap (teks, wajib).
- Nomor WhatsApp aktif (teks, wajib).
- Pilihan ekstrakurikuler (terlihat sebagai pilihan; status wajib dan jumlah pilihan belum dipastikan).

Pilihan kelas yang terlihat pada screenshot:
- BUSANA 1, BUSANA 2, BUSANA 3, BUSANA 4
- TKJ
- ANIMASI
- KULINER 1, KULINER 2, KULINER 3, KULINER 4
- KC KULIT & RAMBUT 1, KC KULIT & RAMBUT 2, KC SPA
- PERHOTELAN 1, PERHOTELAN 2, PERHOTELAN 3, PERHOTELAN 4
- ULW

Pilihan ekstrakurikuler yang terlihat:
- PASKIBRAKA
- PRAMUKA
- PIK-R (Pusat Informasi dan Konseling Remaja)
- SILAT TRADISI
- RANDAI
- MARCHING BAND
- MODELLING
- KESENIAN
- PADUAN SUARA
- ENGLISH CLUB
- JAPANESE CLUB
- TAHFIDZ

Daftar tersebut **belum tentu lengkap**. Jadikan data awal untuk seed lokal/demo saja dan tandai perlu validasi. Jangan menganggapnya daftar resmi final.

### 3.2 Informasi yang Belum Terkonfirmasi
- Apakah siswa hanya boleh memilih satu atau beberapa ekstrakurikuler.
- Apakah tersedia pilihan pertama/kedua.
- Apakah pendaftaran dibuka sepanjang waktu atau dalam periode tertentu.
- Apakah ada kuota dan bagaimana penanganan kelebihan peminat.
- Apakah pendaftaran otomatis diterima atau perlu persetujuan admin/pembina.
- Apakah ekstrakurikuler memiliki persyaratan/seleksi khusus.
- Jadwal, lokasi, pembina, deskripsi, prestasi, serta informasi resmi masing-masing ekskul.
- Kriteria dan bobot rekomendasi.
- Apakah siswa menggunakan akun atau cukup mengisi identitas.
- Proses yang dilakukan setelah formulir Google Forms dikirim.

Sistem harus menyediakan pengaturan yang tidak mengunci keputusan yang belum terkonfirmasi. Jangan mengisi nilai fiktif sebagai data resmi.

---

## 4. Pengguna dan Hak Akses

### 4.1 Peran Pengguna MVP

| Peran | Tujuan | Hak akses utama |
|---|---|---|
| Siswa | Melihat informasi, mengisi kuesioner, menerima rekomendasi, dan mendaftar | Melihat katalog; mengisi/memperbarui kuesioner sebelum submit; melihat hasil sendiri; membuat dan melihat pendaftaran sendiri |
| Admin/Pengelola | Mengelola data dan memantau proses | Mengelola ekstrakurikuler, periode, siswa, kriteria, pendaftaran, dan laporan |
| Pembina | Memantau pendaftar pada ekskul yang dibina | **Opsional/ditunda**. Jika dibutuhkan, hanya melihat data ekskul yang ditugaskan dan pendaftar terkait |

**Keputusan MVP yang disarankan:** gunakan dua peran saja, yaitu Siswa dan Admin. Peran Pembina ditambahkan hanya jika hasil wawancara menyatakan pembina perlu mengakses sistem secara langsung. Jangan membuat peran Kepala Sekolah, Wali Kelas, atau DUDI karena tidak diperlukan dalam ruang lingkup proposal ini.

### 4.2 Matriks Hak Akses

| Fitur | Siswa | Admin |
|---|---:|---:|
| Melihat katalog ekskul aktif | Ya | Ya |
| Mengisi kuesioner minat | Ya | Tidak perlu |
| Melihat rekomendasi sendiri | Ya | Dapat melihat hasil jika dibutuhkan untuk dukungan |
| Membuat pendaftaran | Ya | Dapat membuat/memperbaiki hanya untuk koreksi administratif dengan audit |
| Melihat pendaftaran sendiri | Ya | Ya, semua |
| Mengelola data ekskul | Tidak | Ya |
| Mengelola data siswa | Data sendiri terbatas | Ya |
| Mengelola kriteria/bobot | Tidak | Ya |
| Mengelola periode | Tidak | Ya |
| Mengubah status pendaftaran | Tidak | Ya |
| Melihat rekap seluruh pendaftar | Tidak | Ya |
| Mengelola akun admin | Tidak | Admin utama sesuai kebutuhan |

---

## 5. Alur Bisnis yang Diusulkan

Alur ini adalah rancangan produk, bukan klaim bahwa seluruh proses tersebut telah berjalan di sekolah.

### 5.1 Alur Siswa
1. Siswa membuka aplikasi melalui browser.
2. Siswa masuk menggunakan akun atau mengisi identitas sesuai keputusan autentikasi.
3. Siswa melihat halaman utama dan daftar ekstrakurikuler yang aktif.
4. Siswa membuka detail ekskul untuk membaca informasi yang tersedia.
5. Siswa mengisi kuesioner minat/bakat yang telah disetujui.
6. Sistem memvalidasi kelengkapan jawaban.
7. Sistem menghitung skor kecocokan untuk setiap ekskul aktif yang memiliki pemetaan kriteria.
8. Sistem menampilkan beberapa rekomendasi teratas, skor, dan alasan singkat.
9. Siswa dapat membuka detail rekomendasi dan menentukan pilihan secara sadar.
10. Siswa mengirim pendaftaran sesuai aturan jumlah pilihan dan periode.
11. Sistem menyimpan pendaftaran dan menampilkan nomor/referensi serta status.
12. Siswa dapat melihat status pendaftarannya.

### 5.2 Alur Admin
1. Admin masuk ke dashboard.
2. Admin mengelola periode/tahun pelajaran dan membuka atau menutup pendaftaran.
3. Admin memasukkan atau memperbarui data ekstrakurikuler yang sudah diverifikasi.
4. Admin mengatur kriteria dan pemetaan ekskul terhadap kriteria sesuai hasil analisis.
5. Admin melihat daftar siswa, rekomendasi, dan pendaftaran.
6. Admin memeriksa pendaftaran dan memperbarui status sesuai kebijakan sekolah.
7. Admin memantau ringkasan jumlah pendaftar per ekskul.
8. Admin mengekspor atau mencetak rekap apabila diperlukan.

### 5.3 Status Pendaftaran
Status yang disarankan:
- `submitted` — pendaftaran telah dikirim.
- `reviewed` — telah diperiksa admin.
- `accepted` — diterima.
- `rejected` — tidak diterima, dengan alasan jika sekolah menerapkan seleksi.
- `cancelled` — dibatalkan sesuai kebijakan.

Untuk implementasi awal, status dapat disederhanakan menjadi `submitted`, `accepted`, dan `rejected` jika sekolah tidak memerlukan pemeriksaan bertahap. Jangan menerapkan status penerimaan otomatis sebelum aturan sekolah dikonfirmasi.

---

## 6. Kebutuhan Fungsional

Prioritas: **P0** wajib untuk MVP; **P1** penting jika waktu memungkinkan; **P2** opsional/ditunda.

### FR-01 — Autentikasi
**Prioritas:** P0  
- Sistem menyediakan login bagi admin.
- Siswa dapat mengakses fitur personal dengan mekanisme identitas yang ditetapkan.
- Sistem membatasi halaman admin untuk pengguna berhak.
- Pengguna dapat logout.
- Pesan kesalahan login tidak membocorkan apakah username tertentu terdaftar.

**[PERLU KONFIRMASI]** Apakah siswa diberi akun, login dengan NIS, atau melakukan pendaftaran tanpa akun. Pilih satu cara yang sederhana dan disetujui sekolah. Hindari membuat password default yang sama untuk seluruh siswa.

### FR-02 — Profil/Identitas Siswa
**Prioritas:** P0  
Data minimal yang terlihat dari formulir:
- Nama lengkap.
- Kelas.
- Nomor WhatsApp aktif.

Data tambahan seperti NIS, jurusan, jenis kelamin, alamat, dan tanggal lahir hanya ditambahkan bila benar-benar dibutuhkan dan disetujui sekolah. Hindari mengumpulkan data pribadi yang tidak relevan.

Validasi:
- Nama wajib dan panjang masuk akal.
- Kelas dipilih dari daftar aktif yang dikelola admin.
- Nomor WhatsApp disimpan sebagai string, bukan angka, agar awalan 0 dan tanda + tidak hilang.
- Admin dapat memperbarui data dengan jejak waktu perubahan.

### FR-03 — Katalog Ekstrakurikuler
**Prioritas:** P0  
Siswa dapat melihat daftar ekskul aktif dan detailnya.

Atribut yang disarankan:
- Nama ekskul (wajib).
- Deskripsi singkat (disarankan).
- Kategori (opsional).
- Jadwal (opsional).
- Lokasi (opsional).
- Nama pembina (opsional).
- Persyaratan (opsional).
- Kuota (opsional; hanya jika terkonfirmasi).
- Status aktif/nonaktif.

Aturan:
- Hanya ekskul aktif yang ditampilkan untuk rekomendasi dan pendaftaran.
- Ekskul nonaktif tetap disimpan untuk menjaga riwayat pendaftaran.
- Admin dapat tambah, ubah, aktif/nonaktif, dan melihat detail ekskul.
- Sistem tidak boleh menghapus ekskul yang sudah memiliki riwayat pendaftaran secara permanen; gunakan soft delete/nonaktif.

### FR-04 — Kuesioner Minat
**Prioritas:** P0  
- Siswa mengisi kuesioner yang digunakan sebagai masukan mesin rekomendasi.
- Pertanyaan menggunakan skala jawaban yang konsisten dan mudah dipahami.
- Sistem menampilkan progres atau jumlah pertanyaan.
- Sistem memvalidasi jawaban wajib.
- Siswa dapat mengubah jawaban sebelum mengirim pendaftaran.
- Jawaban disimpan agar hasil dapat ditampilkan kembali.

**Catatan penting:** Isi pertanyaan tidak boleh dibuat seolah-olah merupakan instrumen baku. Butir pertanyaan, skala, indikator, dan keterkaitannya dengan ekstrakurikuler harus ditinjau peneliti, pembimbing, dan/atau ahli yang relevan.

### FR-05 — Mesin Rekomendasi
**Prioritas:** P0  
- Sistem menghasilkan rekomendasi berdasarkan jawaban kuesioner dan kriteria yang telah disepakati.
- Setiap ekskul memperoleh skor kecocokan yang dapat dihitung ulang.
- Sistem mengurutkan hasil berdasarkan skor dari tertinggi ke terendah.
- Sistem menampilkan maksimal sejumlah rekomendasi yang ditetapkan, misalnya tiga; jumlah final dapat dikonfigurasi.
- Sistem menampilkan alasan rekomendasi berdasarkan kriteria yang memperoleh nilai kecocokan.
- Sistem hanya merekomendasikan ekskul aktif.
- Jika data kriteria belum lengkap atau tidak ada ekskul yang dapat dinilai, tampilkan pesan yang jelas, bukan hasil palsu.

**Metode:** belum ditetapkan oleh dokumen observasi. Jangan langsung mengimplementasikan SAW, TOPSIS, AHP, Naive Bayes, KNN, atau metode lain tanpa analisis. Untuk implementasi, gunakan metode yang akhirnya dipilih dan dijelaskan pada Bab III serta dapat direproduksi. Jika metode berbobot dipilih, bobot dan normalisasi harus terdokumentasi dan dapat diuji.

### FR-06 — Hasil Rekomendasi
**Prioritas:** P0  
Tampilan hasil minimal:
- Nama ekskul.
- Skor kecocokan (jika metode menghasilkan skor yang bermakna).
- Urutan rekomendasi.
- Alasan ringkas yang diturunkan dari kriteria.
- Tautan ke detail ekskul.
- Tombol untuk memilih/mendaftar.

Berikan keterangan bahwa rekomendasi adalah alat bantu pertimbangan, bukan penentuan bakat secara psikologis atau jaminan keberhasilan siswa. Siswa tetap memilih sesuai keinginan dan ketentuan sekolah.

### FR-07 — Pendaftaran Ekstrakurikuler
**Prioritas:** P0  
- Siswa dapat mengirim pilihan ekskul selama periode dibuka.
- Sistem memvalidasi pilihan berdasarkan aturan yang telah dikonfirmasi.
- Sistem mencegah pendaftaran ganda sesuai aturan bisnis.
- Sistem menyimpan waktu pengajuan dan status.
- Siswa memperoleh konfirmasi pada layar.
- Siswa dapat melihat riwayat/status pendaftaran sendiri.

**[PERLU KONFIRMASI]** Jumlah pilihan, prioritas, boleh/tidaknya mengubah pilihan, kuota, dan kebutuhan persetujuan. Jangan mengasumsikan siswa hanya boleh memilih satu ekskul.

### FR-08 — Pengelolaan Pendaftaran
**Prioritas:** P0  
Admin dapat:
- Melihat daftar pendaftaran.
- Mencari berdasarkan nama siswa.
- Memfilter berdasarkan kelas, ekskul, periode, dan status.
- Membuka detail pendaftaran.
- Memperbarui status sesuai hak akses.
- Memberikan catatan/alasan jika status ditolak, bila kebijakan sekolah memerlukannya.
- Melihat waktu pendaftaran.

Perubahan status harus divalidasi dan tidak boleh membuat data menjadi tidak konsisten. Jika status ditolak, tampilkan alasan hanya jika tersedia dan sesuai kebijakan.

### FR-09 — Dashboard Admin
**Prioritas:** P0  
Menampilkan ringkasan:
- Jumlah ekskul aktif.
- Jumlah siswa terdata.
- Jumlah pendaftaran pada periode aktif.
- Jumlah pendaftar per ekskul.
- Ringkasan status pendaftaran.

Dashboard tidak perlu grafik kompleks. Kartu angka dan tabel ringkas sudah cukup untuk MVP. Angka harus berasal dari data aktual, bukan angka statis.

### FR-10 — Laporan/Rekap
**Prioritas:** P1  
- Admin dapat melihat rekap pendaftar berdasarkan ekskul, kelas, dan status.
- Sediakan tampilan yang siap dicetak.
- Ekspor CSV/XLSX dapat ditambahkan bila diperlukan dan waktu memungkinkan.
- Laporan harus memuat periode/tahun pelajaran dan waktu pembuatan.
- Data yang ditampilkan mengikuti filter yang dipilih.

Jika waktu terbatas, implementasikan tabel dan print browser terlebih dahulu sebelum menambahkan ekspor.

### FR-11 — Pengaturan Periode
**Prioritas:** P0  
- Admin dapat menentukan nama periode/tahun pelajaran.
- Admin dapat mengatur tanggal mulai dan berakhir jika sekolah menggunakan batas waktu.
- Admin dapat membuka/menutup pendaftaran.
- Sistem menolak pendaftaran ketika periode ditutup.
- Periode lama tetap dapat dilihat untuk riwayat.

**[PERLU KONFIRMASI]** Periode aktual, tanggal, dan apakah sekolah memang menggunakan pembukaan/penutupan pendaftaran.

### FR-12 — Pengaturan Kriteria Rekomendasi
**Prioritas:** P0 untuk metode berbobot; jika metode final tidak memerlukannya, sesuaikan  
- Admin/peneliti yang diberi hak dapat melihat kriteria.
- Kriteria mempunyai nama, deskripsi, dan status.
- Jika metode menggunakan bobot, simpan bobot dan sumber/versi penetapannya.
- Pemetaan hubungan antara kriteria dan ekskul dapat dikelola atau ditetapkan melalui seed/configuration yang terdokumentasi.
- Perubahan kriteria/bobot tidak boleh mengubah hasil rekomendasi lama tanpa jejak atau perhitungan ulang yang jelas.

Jangan memberi admin kemampuan mengubah bobot secara bebas bila bobot harus tetap sesuai instrumen penelitian. Pilihan aman untuk skripsi adalah bobot ditetapkan melalui konfigurasi/seed dan hanya dapat diubah oleh pengembang atau admin khusus setelah disetujui.

---

## 7. Kebutuhan Nonfungsional

### NFR-01 — Kemudahan Penggunaan
- Antarmuka berbahasa Indonesia.
- Label, instruksi, dan pesan kesalahan mudah dipahami siswa.
- Alur utama dapat digunakan tanpa pelatihan teknis yang panjang.
- Formulir tidak menampilkan terlalu banyak informasi sekaligus.

### NFR-02 — Responsif
- Mendukung desktop, tablet, dan ponsel.
- Elemen formulir dan tombol nyaman digunakan pada layar kecil.
- Tabel admin tetap dapat diakses melalui tampilan responsif.

### NFR-03 — Keamanan
- Password disimpan menggunakan hashing bawaan framework.
- Validasi dilakukan di sisi server, bukan hanya browser.
- Hak akses diperiksa pada route/controller/policy.
- CSRF protection aktif untuk form web.
- Data siswa tidak dapat diakses siswa lain.
- Rahasia aplikasi disimpan dalam environment, tidak di-commit ke repository.
- Batasi percobaan login sesuai kemampuan framework/infrastruktur.
- Gunakan HTTPS saat deployment.
- Hindari menampilkan data pribadi pada URL atau log yang tidak perlu.

### NFR-04 — Privasi
- Kumpulkan hanya data yang dibutuhkan untuk identifikasi, rekomendasi, dan pendaftaran.
- Batasi akses data pribadi untuk admin yang berwenang.
- Jangan menampilkan nomor WhatsApp siswa pada halaman publik.
- Tentukan kebijakan retensi/penghapusan data bersama sekolah.
- Sediakan pemberitahuan singkat mengenai tujuan penggunaan data jika diperlukan.

### NFR-05 — Konsistensi Data
- Gunakan foreign key dan constraint yang relevan.
- Operasi penyimpanan pendaftaran dilakukan secara transaksional bila melibatkan beberapa tabel.
- Cegah duplikasi berdasarkan aturan identitas dan periode yang disepakati.
- Gunakan soft delete atau status aktif untuk data yang mempunyai riwayat.

### NFR-06 — Kinerja
- Halaman umum dan daftar data harus tetap nyaman digunakan pada jumlah data skala sekolah.
- Gunakan pagination untuk daftar siswa/pendaftaran.
- Hindari query berulang yang tidak perlu.
- Target waktu respons dapat ditetapkan saat pengujian pada lingkungan deployment; jangan mengklaim performa sebelum diukur.

### NFR-07 — Kompatibilitas
- Mendukung browser modern seperti Chrome, Firefox, dan Edge versi yang masih didukung.
- Tidak membutuhkan instalasi aplikasi di perangkat siswa.

### NFR-08 — Pemeliharaan
- Struktur kode modular dan mengikuti konvensi framework.
- Validasi, perhitungan rekomendasi, dan aturan pendaftaran dipisahkan dari tampilan.
- Sediakan seed data untuk lingkungan pengembangan, dengan penanda bahwa data tersebut contoh.
- Dokumentasikan instalasi, konfigurasi, dan pengujian.

---

## 8. Rancangan Metode Rekomendasi: Persyaratan, Bukan Penetapan Algoritma

### 8.1 Tujuan
Menghasilkan urutan ekstrakurikuler yang paling sesuai berdasarkan jawaban siswa terhadap kuesioner dan kriteria yang telah disahkan.

### 8.2 Input
- Jawaban siswa terhadap setiap butir kuesioner.
- Pemetaan butir/indikator terhadap kriteria.
- Pemetaan kriteria terhadap ekstrakurikuler.
- Bobot atau aturan perhitungan, jika digunakan oleh metode terpilih.
- Status aktif ekstrakurikuler.

### 8.3 Output
Untuk setiap siswa:
- Daftar rekomendasi yang diurutkan.
- Skor atau nilai kecocokan jika relevan.
- Rincian/alasan yang dapat dijelaskan.
- Versi metode/kriteria yang digunakan.

### 8.4 Persyaratan Perhitungan
- Hasil perhitungan harus deterministik: input dan versi kriteria yang sama menghasilkan output yang sama.
- Nilai kosong ditangani secara eksplisit.
- Tidak boleh ada pembagian dengan nol atau hasil NaN.
- Skor ditampilkan dengan presisi yang konsisten.
- Hasil dapat diuji menggunakan kasus perhitungan manual.
- Algoritma, rumus, skala, bobot, dan pemetaan harus sesuai dengan metode pada proposal/Bab III yang disetujui.

### 8.5 Validasi Metode
Sebelum implementasi final:
1. Tetapkan indikator minat/bakat yang benar-benar relevan.
2. Validasi setiap pertanyaan dan pemetaan ke ekskul.
3. Tetapkan skala jawaban.
4. Tentukan metode rekomendasi dan alasan pemilihannya.
5. Tentukan bobot atau aturan perhitungan.
6. Buat contoh data kecil dan hitung manual.
7. Bandingkan hasil manual dengan keluaran aplikasi.
8. Dokumentasikan keterbatasan rekomendasi.

**Penting:** Jangan mengklaim sistem mengukur bakat secara psikometrik jika instrumen yang digunakan hanya kuesioner preferensi sederhana. Gunakan istilah “kecocokan berdasarkan jawaban kuesioner” jika tidak ada instrumen bakat tervalidasi.

---

## 9. Model Data Konseptual

Skema berikut adalah rancangan awal yang harus disesuaikan dengan aturan final. Nama tabel menggunakan bahasa Inggris agar konsisten dengan konvensi pengembangan.

### 9.1 Tabel `users`
| Kolom | Tipe konseptual | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| name | varchar | Nama pengguna |
| email/username | varchar, nullable sesuai autentikasi | Identitas login |
| password | varchar, nullable jika tanpa akun siswa | Password hash |
| role | enum/string | `admin` atau `student` untuk MVP |
| created_at, updated_at | timestamp | Timestamp |

### 9.2 Tabel `students`
| Kolom | Tipe konseptual | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| user_id | bigint, nullable | Relasi akun jika siswa login |
| full_name | varchar | Nama lengkap |
| class_id | bigint | Relasi kelas |
| whatsapp | varchar | Nomor WhatsApp |
| student_identifier | varchar, nullable | NIS/ID bila dikonfirmasi |
| created_at, updated_at | timestamp | Timestamp |

### 9.3 Tabel `classes`
- `id`
- `name`
- `is_active`
- `created_at`, `updated_at`

Daftar kelas awal diambil dari observasi, tetapi admin harus dapat memperbaruinya setelah memperoleh daftar resmi.

### 9.4 Tabel `extracurriculars`
- `id`
- `name`
- `slug` atau kode unik
- `description`, nullable
- `category`, nullable
- `coach_name`, nullable
- `schedule`, nullable
- `location`, nullable
- `requirements`, nullable
- `quota`, nullable
- `is_active`
- timestamps

### 9.5 Tabel `periods`
- `id`
- `name` (contoh: Tahun Pelajaran 2026/2027)
- `starts_at`, nullable
- `ends_at`, nullable
- `is_open`
- timestamps

### 9.6 Tabel `criteria`
Jika metode terpilih menggunakan kriteria eksplisit:
- `id`
- `name`
- `description`
- `weight`, nullable bila tidak digunakan
- `is_active`
- `version` atau relasi versi, jika diperlukan
- timestamps

### 9.7 Tabel `questions`
- `id`
- `criterion_id`
- `question_text`
- `answer_type` (misalnya skala)
- `sort_order`
- `is_required`
- `is_active`
- timestamps

Pilihan jawaban dapat disimpan pada tabel `question_options` jika setiap pertanyaan memiliki opsi berbeda; untuk skala seragam, dapat menggunakan konfigurasi sederhana yang terdokumentasi.

### 9.8 Tabel `student_answers`
- `id`
- `student_id`
- `period_id`
- `question_id`
- `answer_value`
- timestamps

Tambahkan unique constraint yang sesuai, misalnya kombinasi siswa, periode, dan pertanyaan, agar jawaban tidak terduplikasi.

### 9.9 Tabel `recommendation_runs` (opsional tetapi disarankan)
- `id`
- `student_id`
- `period_id`
- `method_name`
- `method_version`
- `criteria_snapshot` atau referensi versi kriteria
- `generated_at`

### 9.10 Tabel `recommendation_items`
- `id`
- `recommendation_run_id`
- `extracurricular_id`
- `score`, nullable jika metode tidak menghasilkan skor numerik
- `rank`
- `explanation`, nullable
- timestamps

### 9.11 Tabel `registrations`
- `id`
- `student_id`
- `period_id`
- `extracurricular_id`
- `priority`, nullable jika tidak ada pilihan berurutan
- `status`
- `admin_note`, nullable
- `submitted_at`
- timestamps

Constraint unik harus mengikuti aturan sekolah. Contoh: bila satu siswa hanya boleh mendaftar satu kali pada satu ekskul dalam satu periode, gunakan unique constraint pada kombinasi tersebut. Jangan memaksakan unique satu pendaftaran per siswa jika siswa ternyata boleh memilih beberapa ekskul.

### 9.12 Relasi Utama
- User dapat memiliki satu profil siswa (untuk akun siswa).
- Siswa memiliki banyak jawaban.
- Pertanyaan dapat terkait dengan satu kriteria.
- Satu periode memiliki banyak jawaban, hasil rekomendasi, dan pendaftaran.
- Satu hasil rekomendasi memiliki banyak item rekomendasi.
- Ekstrakurikuler memiliki banyak item rekomendasi dan pendaftaran.

### 9.13 Prinsip Database
- Gunakan foreign key.
- Gunakan index untuk kolom pencarian/filter yang sering dipakai.
- Gunakan `decimal` untuk skor/bobot bila diperlukan, bukan float tanpa pertimbangan.
- Simpan nomor telepon sebagai string.
- Hindari menyimpan data yang sama di banyak tempat kecuali untuk snapshot yang memang diperlukan.
- Data contoh harus jelas ditandai sebagai seed/demo.

---

## 10. Rancangan Halaman

### 10.1 Area Siswa
1. **Halaman masuk/identifikasi** — login atau form identitas sesuai keputusan.
2. **Beranda siswa** — ajakan mengisi kuesioner, ringkasan status, dan tautan katalog.
3. **Katalog ekstrakurikuler** — kartu/list ekskul aktif dengan pencarian sederhana.
4. **Detail ekstrakurikuler** — deskripsi, jadwal, pembina, lokasi, persyaratan, kuota jika tersedia.
5. **Kuesioner minat** — pertanyaan terstruktur dengan validasi.
6. **Hasil rekomendasi** — urutan rekomendasi, skor bila tersedia, alasan, dan tombol detail.
7. **Form pendaftaran** — pilihan ekskul sesuai aturan.
8. **Status pendaftaran** — status dan informasi pengajuan.

### 10.2 Area Admin
1. **Login admin**
2. **Dashboard**
3. **Data ekstrakurikuler** — daftar, tambah, edit, aktif/nonaktif.
4. **Data kelas** — daftar dan pengelolaan sederhana.
5. **Data siswa** — daftar, pencarian, detail, koreksi.
6. **Periode pendaftaran** — buka/tutup dan tanggal jika digunakan.
7. **Kuesioner/kriteria** — kelola atau tinjau sesuai desain metode.
8. **Hasil rekomendasi** — akses terbatas untuk pemeriksaan jika dibutuhkan.
9. **Data pendaftaran** — filter, detail, ubah status.
10. **Laporan** — rekap dan cetak.

### 10.3 Prinsip UI
- Desain bersih, konsisten, dan mudah dipahami siswa SMK.
- Utamakan mobile-first untuk halaman siswa.
- Gunakan bahasa Indonesia.
- Hindari dashboard penuh grafik yang tidak mendukung tugas utama.
- Tampilkan status dengan teks dan warna, jangan hanya warna.
- Sediakan empty state, loading state, dan error state.
- Formulir memberi petunjuk dan pesan validasi dekat dengan field.
- Jangan menampilkan skor seolah-olah persentase kemampuan objektif jika metode tidak mendukung interpretasi tersebut.

---

## 11. User Stories dan Acceptance Criteria

### US-01 — Melihat Ekstrakurikuler
**Sebagai siswa**, saya ingin melihat daftar dan detail ekskul agar memahami pilihan yang tersedia.

Acceptance criteria:
- Daftar hanya menampilkan ekskul aktif.
- Siswa dapat membuka detail setiap ekskul.
- Field yang belum diisi tidak ditampilkan sebagai informasi palsu.
- Jika belum ada data, sistem menampilkan pesan bahwa informasi belum tersedia.

### US-02 — Mengisi Kuesioner
**Sebagai siswa**, saya ingin mengisi kuesioner agar sistem dapat menghitung rekomendasi.

Acceptance criteria:
- Pertanyaan aktif ditampilkan.
- Jawaban wajib divalidasi.
- Siswa mendapat pesan jika ada jawaban yang belum diisi.
- Jawaban tersimpan dan dapat ditinjau sebelum rekomendasi dihitung.

### US-03 — Mendapatkan Rekomendasi
**Sebagai siswa**, saya ingin melihat rekomendasi dan alasannya agar dapat mempertimbangkan pilihan.

Acceptance criteria:
- Rekomendasi hanya dihitung dari jawaban yang valid.
- Hasil diurutkan sesuai metode.
- Sistem menampilkan alasan yang konsisten dengan data/kriteria.
- Jika tidak ada hasil yang valid, sistem menampilkan penjelasan dan langkah berikutnya.
- Hasil tidak menyatakan bahwa rekomendasi merupakan diagnosis bakat.

### US-04 — Mendaftar
**Sebagai siswa**, saya ingin mengirim pilihan ekstrakurikuler agar pilihan saya tercatat.

Acceptance criteria:
- Tombol daftar hanya tersedia ketika periode terbuka.
- Sistem menerapkan batas jumlah pilihan sesuai konfigurasi final.
- Sistem mencegah duplikasi sesuai aturan final.
- Setelah berhasil, sistem menampilkan konfirmasi dan status.
- Jika gagal, data tidak tersimpan sebagian.

### US-05 — Mengelola Ekskul
**Sebagai admin**, saya ingin mengelola data ekskul agar informasi yang dilihat siswa tetap relevan.

Acceptance criteria:
- Admin dapat membuat dan mengubah data.
- Nama ekskul wajib dan tidak duplikat.
- Admin dapat menonaktifkan ekskul.
- Ekskul yang sudah memiliki riwayat tidak dihapus permanen melalui antarmuka biasa.

### US-06 — Mengelola Pendaftaran
**Sebagai admin**, saya ingin memeriksa dan mengelola pendaftaran agar data peserta terorganisasi.

Acceptance criteria:
- Admin dapat mencari dan memfilter data.
- Detail menampilkan identitas dan pilihan yang diperlukan.
- Status hanya dapat diubah oleh role yang berwenang.
- Perubahan status tersimpan dan terlihat saat halaman dimuat ulang.

### US-07 — Melihat Rekap
**Sebagai admin**, saya ingin melihat jumlah pendaftar per ekskul agar mudah memantau pendaftaran.

Acceptance criteria:
- Ringkasan dihitung dari data pendaftaran aktual.
- Filter periode dan ekskul bekerja sesuai pilihan.
- Data kosong ditampilkan sebagai nol/empty state, bukan error.
- Laporan cetak mengikuti filter yang aktif.

---

## 12. Aturan Bisnis

Aturan yang belum dikonfirmasi harus dapat disesuaikan melalui konfigurasi atau ditunda.

| ID | Aturan | Status |
|---|---|---|
| BR-01 | Hanya ekskul aktif yang dapat direkomendasikan | Usulan PRD |
| BR-02 | Pendaftaran hanya dapat dilakukan ketika periode dibuka | Usulan PRD; konfirmasi mekanisme periode |
| BR-03 | Siswa wajib mengisi pertanyaan wajib sebelum rekomendasi | Usulan PRD |
| BR-04 | Rekomendasi dihitung menggunakan metode dan versi kriteria yang terdokumentasi | Kebutuhan penelitian |
| BR-05 | Jumlah pilihan per siswa mengikuti aturan resmi sekolah | Perlu konfirmasi |
| BR-06 | Kebijakan kuota mengikuti aturan resmi sekolah | Perlu konfirmasi |
| BR-07 | Kebijakan persetujuan/seleksi mengikuti aturan resmi sekolah | Perlu konfirmasi |
| BR-08 | Siswa hanya dapat melihat data pribadinya sendiri | Usulan keamanan |
| BR-09 | Ekskul yang memiliki riwayat pendaftaran tidak dihapus permanen melalui UI | Usulan integritas data |
| BR-10 | Perubahan status pendaftaran dilakukan oleh admin berwenang | Usulan PRD |

---

## 13. Validasi dan Penanganan Kasus Tepi

Sistem minimal menangani:
- Kuesioner belum lengkap.
- Tidak ada ekskul aktif.
- Ekskul belum memiliki pemetaan kriteria.
- Periode pendaftaran belum dibuka atau sudah ditutup.
- Siswa mencoba mendaftar dua kali.
- Siswa mencoba mengakses pendaftaran milik siswa lain.
- Admin menonaktifkan ekskul yang sudah memiliki pendaftar.
- Kuota penuh, jika kuota diterapkan.
- Data siswa tidak ditemukan atau identitas ganda.
- Perubahan kriteria setelah rekomendasi dibuat.
- Kegagalan penyimpanan di tengah proses.
- Daftar pendaftaran kosong.
- Pencarian/filter tidak menghasilkan data.

Untuk kasus yang belum memiliki kebijakan sekolah, tampilkan pesan informatif dan jangan membuat keputusan otomatis yang tidak disepakati.

---

## 14. Teknologi dan Arsitektur yang Disarankan

Bagian ini merupakan rekomendasi implementasi, bukan ketentuan proposal. Sesuaikan dengan lingkungan pengembangan peneliti.

### 14.1 Stack Sederhana
Jika pengembang menggunakan ekosistem Laravel:
- **Backend:** Laravel (gunakan versi stabil yang kompatibel dengan lingkungan).
- **Frontend:** Blade + Tailwind CSS.
- **Interaktivitas:** Alpine.js hanya bila dibutuhkan; hindari menambah framework frontend tanpa kebutuhan.
- **Database:** MySQL atau MariaDB.
- **Autentikasi:** starter kit Laravel yang sesuai.
- **Testing:** PHPUnit atau Pest.
- **Version control:** Git.

Tidak perlu menambahkan microservices, message broker, Kubernetes, atau arsitektur terdistribusi.

### 14.2 Struktur Logis
Pisahkan tanggung jawab secara proporsional:
- **Controller:** menerima request dan mengembalikan response.
- **Form Request/Validator:** validasi input.
- **Service:** aturan bisnis pendaftaran dan perhitungan rekomendasi.
- **Model:** relasi dan akses data.
- **Policy/Middleware:** otorisasi.
- **Blade:** presentasi.

Untuk proyek skala skripsi, repository pattern tidak wajib jika hanya menambah kompleksitas. Terapkan hanya bila ada alasan teknis yang jelas.

### 14.3 Komponen Utama
- `RecommendationService`: memvalidasi input dan menjalankan metode rekomendasi yang disahkan.
- `RegistrationService`: memvalidasi periode, aturan pilihan, duplikasi, dan penyimpanan.
- `ExtracurricularService` (opsional): bila aturan pengelolaan mulai kompleks.
- `ReportQuery` atau query terpisah: untuk rekap agar tidak membebani controller.

### 14.4 Keputusan Arsitektur
- Monolith Laravel.
- Satu database relasional.
- Server-rendered pages.
- Tidak membutuhkan API publik pada MVP.
- Tidak membutuhkan real-time websocket.
- Tidak membutuhkan AI generatif untuk menghitung rekomendasi. Perhitungan harus deterministik dan dapat diuji.

---

## 15. Pengujian dan Evaluasi

### 15.1 Pengujian Black-Box
Cakupan minimal:
1. Login valid dan tidak valid.
2. Pembatasan akses siswa/admin.
3. Menampilkan ekskul aktif/nonaktif.
4. Validasi data ekskul.
5. Validasi kuesioner wajib.
6. Perhitungan rekomendasi untuk beberapa kombinasi jawaban.
7. Urutan hasil rekomendasi.
8. Tampilan alasan rekomendasi.
9. Pendaftaran pada periode terbuka.
10. Penolakan pendaftaran saat periode tertutup.
11. Pencegahan pendaftaran ganda.
12. Perubahan status oleh admin.
13. Filter rekap.
14. Akses siswa terhadap data siswa lain.
15. Penanganan data kosong dan error.

Setiap test case mencatat: ID, skenario, data uji, langkah, hasil yang diharapkan, hasil aktual, dan status (berhasil/gagal).

### 15.2 Pengujian Perhitungan Rekomendasi
- Siapkan contoh jawaban dan perhitungan manual.
- Bandingkan keluaran service dengan hasil manual.
- Uji nilai minimum/maksimum skala.
- Uji jawaban kosong.
- Uji ekskul nonaktif.
- Uji bobot atau pemetaan yang tidak valid.
- Pastikan urutan stabil ketika skor sama; aturan tie-break harus terdokumentasi.

### 15.3 Evaluasi Pengguna
Instrumen UAT/praktikalitas dapat mencakup:
- Kemudahan memahami informasi ekskul.
- Kemudahan mengisi kuesioner.
- Kemudahan memahami rekomendasi.
- Kemudahan melakukan pendaftaran.
- Kemudahan admin mengelola data.
- Kejelasan status pendaftaran.
- Kesesuaian fungsi dengan kebutuhan.

Jumlah responden, skala, rumus persentase, kategori interpretasi, dan kriteria kelayakan mengikuti rancangan metodologi penelitian serta arahan pembimbing. Jangan menuliskan hasil pengujian sebelum pengujian benar-benar dilakukan.

### 15.4 Bukti Pengujian
Simpan:
- Daftar test case.
- Screenshot alur utama.
- Data uji tanpa data pribadi nyata jika memungkinkan.
- Hasil kuesioner evaluasi.
- Catatan bug dan perbaikannya.
- Versi aplikasi yang diuji.

---

## 16. Risiko dan Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Daftar ekskul belum final | Data aplikasi tidak sesuai kondisi sekolah | Minta daftar resmi dan gunakan CRUD admin |
| Kriteria rekomendasi belum disepakati | Rekomendasi tidak dapat dipertanggungjawabkan | Tunda finalisasi algoritma sampai indikator dan metode disetujui |
| Aturan jumlah pilihan belum jelas | Alur pendaftaran salah | Jadikan aturan konfigurasi dan konfirmasi sebelum rilis |
| Kuota/seleksi belum jelas | Sistem dapat menerima pilihan yang tidak sesuai kebijakan | Jangan aktifkan validasi kuota/seleksi sebelum ada keputusan |
| Data siswa sensitif | Kebocoran informasi | Minimalisasi data, otorisasi, HTTPS, dan pembatasan akses |
| Waktu skripsi terbatas | Fitur inti tidak selesai | Prioritaskan P0 dan tunda P1/P2 |
| Rekomendasi dianggap sebagai penilaian bakat mutlak | Salah tafsir oleh siswa | Beri penjelasan batasan dan alasan rekomendasi |
| Perubahan bobot mengubah hasil | Hasil penelitian sulit direproduksi | Simpan versi metode/kriteria pada hasil rekomendasi |
| AI Coding Agent mengarang kebutuhan | Implementasi melenceng | Wajib mengikuti bagian fakta/asumsi dan meminta klarifikasi |

---

## 17. Prioritas Pengembangan

### Fase 0 — Validasi Kebutuhan
- [ ] Konfirmasi daftar ekskul resmi.
- [ ] Konfirmasi daftar kelas dan format identitas siswa.
- [ ] Konfirmasi jumlah pilihan dan prioritas.
- [ ] Konfirmasi aturan periode.
- [ ] Konfirmasi kuota dan seleksi.
- [ ] Tentukan instrumen kuesioner.
- [ ] Tentukan metode rekomendasi bersama pembimbing.
- [ ] Tetapkan kebutuhan role.

**Keluaran:** keputusan kebutuhan dan aturan bisnis yang dapat dijadikan acuan.

### Fase 1 — Fondasi Aplikasi
- [ ] Buat proyek dan konfigurasi environment.
- [ ] Buat database dan migration.
- [ ] Implementasikan autentikasi dan role.
- [ ] Buat layout siswa dan admin.
- [ ] Buat seed data contoh yang diberi label demo.

### Fase 2 — Data dan Katalog
- [ ] CRUD kelas.
- [ ] CRUD ekstrakurikuler.
- [ ] Halaman katalog dan detail.
- [ ] Validasi dan otorisasi.

### Fase 3 — Kuesioner dan Rekomendasi
- [ ] Implementasikan pertanyaan final.
- [ ] Simpan jawaban.
- [ ] Implementasikan metode rekomendasi yang disahkan.
- [ ] Tampilkan hasil dan alasan.
- [ ] Uji perhitungan dengan contoh manual.

### Fase 4 — Pendaftaran dan Admin
- [ ] Implementasikan periode.
- [ ] Implementasikan pendaftaran.
- [ ] Terapkan aturan pilihan final.
- [ ] Implementasikan status pendaftaran.
- [ ] Buat dashboard dan rekap.
- [ ] Tambahkan print/export bila termasuk kebutuhan.

### Fase 5 — Pengujian dan Rilis
- [ ] Jalankan pengujian black-box.
- [ ] Perbaiki bug.
- [ ] Lakukan evaluasi pengguna/UAT sesuai metodologi.
- [ ] Siapkan data uji dan dokumentasi.
- [ ] Deploy untuk uji coba sesuai persetujuan sekolah.
- [ ] Buat panduan singkat penggunaan.

---

## 18. Definition of Done

Fitur dinyatakan selesai jika:
- Kebutuhan dan aturan bisnisnya jelas.
- Validasi sisi server tersedia.
- Otorisasi diterapkan untuk data yang dilindungi.
- Tampilan memiliki kondisi sukses, kosong, dan gagal.
- Tidak ada data contoh yang disamarkan sebagai data resmi.
- Pengujian terkait lulus.
- Perubahan kode terdokumentasi melalui Git.
- Tidak ada error kritis yang diketahui pada alur utama.
- Dokumentasi penggunaan atau konfigurasi diperbarui jika relevan.

Produk MVP siap diuji jika siswa dapat melihat katalog, mengisi kuesioner, menerima rekomendasi yang dapat dijelaskan, dan mengirim pendaftaran sesuai aturan final; sementara admin dapat mengelola data dan melihat rekap.

---

## 19. Instruksi Khusus untuk AI Coding Agent

Gunakan dokumen ini sebagai spesifikasi produk, tetapi jangan menganggap semua bagian sudah menjadi fakta sekolah.

### 19.1 Aturan Wajib
1. Baca PRD secara menyeluruh sebelum membuat perubahan kode.
2. Jangan mengarang daftar ekskul, pembina, jadwal, kuota, kriteria, bobot, atau aturan pendaftaran.
3. Bedakan fakta observasi, kebutuhan proposal, dan usulan desain.
4. Jika keputusan penting belum ada, buat daftar pertanyaan dan minta konfirmasi; jangan mengunci asumsi ke database atau kode.
5. Jangan menentukan algoritma rekomendasi sendiri sebelum metode disetujui.
6. Jangan membuat fitur di luar MVP tanpa permintaan eksplisit.
7. Jangan menggunakan AI/LLM untuk menentukan rekomendasi secara bebas; hasil harus deterministik dan dapat diuji.
8. Implementasikan validasi di server.
9. Terapkan pembatasan akses dan perlindungan data siswa.
10. Jangan menghapus data historis secara permanen tanpa kebutuhan dan persetujuan.
11. Jangan mengklaim pengujian berhasil jika belum dijalankan.
12. Jangan memasukkan data siswa asli ke repository, screenshot publik, atau seed demo.

### 19.2 Urutan Kerja yang Harus Diikuti
**Tahap A — Audit**
- Periksa struktur repository dan teknologi yang sudah ada.
- Identifikasi fitur, tabel, dan komponen yang telah tersedia.
- Jangan menimpa implementasi yang sudah berfungsi tanpa alasan.

**Tahap B — Analisis**
- Buat ringkasan kebutuhan yang sudah jelas.
- Buat daftar keputusan yang belum terkonfirmasi.
- Petakan kebutuhan ke modul, tabel, route, dan pengujian.
- Tunjukkan rencana implementasi sebelum perubahan besar.

**Tahap C — Implementasi Bertahap**
- Kerjakan satu fase/modul per perubahan.
- Gunakan migration, model, validation, authorization, service, dan test sesuai kebutuhan.
- Jalankan test setelah setiap modul.
- Laporkan file yang berubah, keputusan yang dibuat, perintah pengujian, serta hasil aktual.

**Tahap D — Review**
- Periksa keamanan akses siswa.
- Periksa konsistensi skor rekomendasi.
- Periksa duplikasi pendaftaran dan aturan periode.
- Periksa tampilan responsif.
- Pastikan dokumentasi dan test sesuai kode aktual.

### 19.3 Format Laporan Setiap Tahap
Setelah menyelesaikan satu fase, laporkan:
- Tujuan fase.
- Fitur yang selesai.
- File utama yang dibuat/diubah.
- Migration/command yang perlu dijalankan.
- Pengujian yang dijalankan dan hasil aktual.
- Hal yang belum selesai.
- Keputusan yang masih menunggu konfirmasi.

### 19.4 Prompt Awal yang Dapat Diberikan kepada AI Coding Agent
> Baca dan analisis PRD Sistem Rekomendasi Pemilihan Ekstrakurikuler SMK Negeri 3 Payakumbuh ini. Jangan langsung membangun seluruh aplikasi. Mulailah dengan mengaudit repository dan lingkungan yang tersedia. Buat ringkasan arsitektur saat ini, pemetaan kebutuhan MVP, daftar keputusan yang belum terkonfirmasi, rancangan database awal, serta rencana implementasi bertahap. Jangan mengarang data sekolah atau menetapkan metode rekomendasi yang belum disetujui. Setelah audit, tampilkan hasil analisis dan tunggu persetujuan sebelum melakukan perubahan besar.

---

## 20. Keputusan yang Harus Diselesaikan Sebelum Implementasi Final

| No. | Pertanyaan | Mengapa penting | Status |
|---:|---|---|---|
| 1 | Apakah siswa harus login atau cukup mengisi identitas? | Menentukan autentikasi dan relasi data | BELUM_TERKONFIRMASI |
| 2 | Apakah satu siswa boleh memilih satu atau beberapa ekskul? | Menentukan skema dan validasi pendaftaran | BELUM_TERKONFIRMASI |
| 3 | Apakah pilihan memiliki urutan prioritas? | Menentukan field prioritas dan alur UI | BELUM_TERKONFIRMASI |
| 4 | Apakah ada kuota per ekskul? | Menentukan validasi dan status penuh | BELUM_TERKONFIRMASI |
| 5 | Apakah pendaftaran perlu persetujuan admin/pembina? | Menentukan status dan alur pemeriksaan | BELUM_TERKONFIRMASI |
| 6 | Apa daftar resmi ekskul aktif? | Menjadi data katalog dan rekomendasi | BELUM_TERKONFIRMASI |
| 7 | Apa indikator minat/bakat yang digunakan? | Menjadi dasar kuesioner | BELUM_TERKONFIRMASI |
| 8 | Metode rekomendasi apa yang disetujui? | Menentukan rumus dan pengujian | BELUM_TERKONFIRMASI |
| 9 | Siapa yang menetapkan bobot dan pemetaan? | Menjamin hasil dapat dipertanggungjawabkan | BELUM_TERKONFIRMASI |
| 10 | Apakah siswa boleh mengubah pilihan setelah submit? | Menentukan aturan edit dan riwayat | BELUM_TERKONFIRMASI |
| 11 | Informasi ekskul apa yang resmi tersedia? | Mencegah konten fiktif | BELUM_TERKONFIRMASI |
| 12 | Apakah laporan perlu ekspor Excel/PDF? | Menentukan prioritas dan dependensi | BELUM_TERKONFIRMASI |

---

## 21. Kesesuaian dengan Proposal Skripsi

| Bagian proposal | Dukungan dalam PRD |
|---|---|
| Membantu siswa memilih sesuai minat dan bakat | Kuesioner, mesin rekomendasi, dan penjelasan hasil |
| Menyediakan informasi ekstrakurikuler | Katalog dan detail ekskul |
| Memfasilitasi pendaftaran daring | Modul pendaftaran |
| Mempermudah pengelolaan data oleh guru/sekolah | Dashboard, pengelolaan data, dan rekap |
| Menguji sistem yang dikembangkan | Pengujian black-box dan evaluasi pengguna sesuai metodologi |
| Fokus pada ekskul aktif yang tersedia di sekolah | Katalog hanya menggunakan data aktif yang telah diverifikasi |

PRD ini menerjemahkan tujuan proposal menjadi kebutuhan produk. PRD bukan pengganti Bab III, instrumen penelitian, atau persetujuan sekolah. Rumus rekomendasi dan kriteria harus konsisten dengan metodologi penelitian yang akhirnya disetujui.

---

## 22. Glosarium

| Istilah | Arti |
|---|---|
| PRD | Dokumen yang menjelaskan tujuan, ruang lingkup, pengguna, kebutuhan, dan kriteria penerimaan produk |
| MVP | Versi minimum aplikasi yang sudah dapat menjalankan alur inti |
| Rekomendasi | Saran pilihan yang dihasilkan dari data dan aturan perhitungan yang ditetapkan |
| Kriteria | Aspek yang digunakan dalam proses penilaian/kecocokan |
| Bobot | Tingkat kepentingan kriteria dalam metode berbobot |
| Kuesioner | Kumpulan pertanyaan untuk memperoleh jawaban siswa |
| Pendaftaran | Pencatatan pilihan siswa terhadap ekstrakurikuler |
| Black-box testing | Pengujian fungsi berdasarkan input dan output tanpa memeriksa detail internal kode |
| UAT | User Acceptance Testing, evaluasi apakah sistem memenuhi kebutuhan pengguna |

---

**Akhir dokumen PRD — Versi 1.0**

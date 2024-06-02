# SISTEM ABSENSI BERBASIS WEBSITE

Sistem absensi berbasis IoT ini memanfaatkan ESP32 dan sensor RFID-RC522 untuk mencatat kehadiran pengguna. Data absensi kemudian dikirim ke server web melalui API untuk diproses dan disimpan. Alat ini dirancang untuk memudahkan proses absensi dengan meningkatkan efisiensi dan akurasi pencatatan kehadiran.
Komponen Utama

1. ESP32: Sebagai mikrokontroler utama yang mengelola pembacaan data dari sensor RFID-RC522 dan mengirimkan data tersebut ke server web melalui koneksi Wi-Fi.
2. Sensor RFID-RC522: Digunakan untuk membaca kartu atau tag RFID yang digunakan oleh pengguna untuk melakukan absensi.
3. Website dengan API: Server web yang menerima dan memproses data absensi yang dikirim oleh ESP32.

## Fitur Utama

- Pembacaan RFID: Alat ini mampu membaca data dari kartu/tag RFID yang mendukung protokol ISO/IEC 14443 A/MIFARE.
- Koneksi Wi-Fi: Menggunakan modul Wi-Fi pada ESP32 untuk mengirim data ke server web.
- API Komunikasi: Sistem ini menggunakan API untuk mengirim data absensi ke server web, memastikan data dapat diterima dan diproses secara real-time.
- Notifikasi dan Logging: Setiap kali kartu RFID dibaca dan data absensi berhasil dikirim, sistem dapat memberikan notifikasi atau melakukan logging lokal.

## Cara Kerja

    Inisialisasi: Ketika alat diaktifkan, ESP32 akan menginisialisasi modul Wi-Fi dan sensor RFID-RC522.
    Pembacaan RFID: Saat kartu/tag RFID didekatkan ke sensor RFID-RC522, data unik dari kartu tersebut dibaca oleh sensor.
    Pengiriman Data: Data yang telah dibaca oleh sensor kemudian dikirimkan ke server web melalui API yang telah dikonfigurasi.
    Pencatatan Absensi: Server web memproses data yang diterima dan menyimpannya dalam database untuk keperluan pencatatan dan laporan absensi.

## Skema Alat

### Koneksi ESP32 ke RFID-RC522:

- VCC ke 3.3V pada ESP32
- GND ke GND pada ESP32
- RST ke pin GPIO yang tersedia pada ESP32 (misal GPIO 22)
- SDA ke pin GPIO yang tersedia pada ESP32 (misal GPIO 21)
- SCK ke pin GPIO yang tersedia pada ESP32 (misal GPIO 18)
- MOSI ke pin GPIO yang tersedia pada ESP32 (misal GPIO 23)
- MISO ke pin GPIO yang tersedia pada ESP32 (misal GPIO 19)

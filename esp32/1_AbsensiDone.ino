#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>

const char* ssid = "Nice";
const char* password = "11111111";
String mode;
String nama;

// Alamat I2C LCD, dapat berbeda tergantung pada perangkat Anda
#define LCD_ADDRESS 0x27

// Jumlah kolom dan baris pada LCD
#define LCD_COLUMNS 16
#define LCD_ROWS 2

// Inisialisasi LCD
LiquidCrystal_I2C lcd(LCD_ADDRESS, LCD_COLUMNS, LCD_ROWS);


#define RST_PIN     4   // Konfigurasi pin reset RC522 - sesuaikan dengan kebutuhan Anda
#define SS_PIN      5   // Konfigurasi pin SS RC522 - sesuaikan dengan kebutuhan Anda

MFRC522 rfid(SS_PIN, RST_PIN); // Buat objek MFRC522

// Definisi pin pada ESP32
const int relayPin1 = 25; // Ganti dengan pin yang sesuai
const int relayPin2 = 26; // Ganti dengan pin yang sesuai

bool status;

void  clearLcd(){
  lcd.setCursor(0, 0);
  lcd.print(" SELAMAT DATANG ");
  lcd.setCursor(0, 1);
  lcd.print(" SISTEM ABSENSI ");
}

void setup() {
  Serial.begin(115200);
  SPI.begin();               // Mulai komunikasi SPI
  rfid.PCD_Init();           // Inisialisasi modul RFID-RC522
  lcd.init();               // Inisialisasi LCD
  lcd.backlight();          // Aktifkan backlight LCD
  

  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
    lcd.setCursor(0, 0);
    lcd.print("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  // Inisialisasi pin sebagai output
  pinMode(relayPin1, OUTPUT);
  pinMode(relayPin2, OUTPUT);

  // Matikan relay saat awalnya
  digitalWrite(relayPin1, LOW);
  digitalWrite(relayPin2, HIGH);

  Serial.println("Waiting for an RFID card...");
  clearLcd();
}

void loop() {
  // Periksa apakah ada kartu RFID yang terdeteksi
  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial()) {
    Serial.println("Card detected!");

    // Baca nomor serial kartu
    Serial.print("Card UID: ");
    String cardUID = ""; // String untuk menyimpan UID

    // Konversi setiap byte UID menjadi string
    for (byte i = 0; i < rfid.uid.size; i++) {
      if (rfid.uid.uidByte[i] < 0x10) {
        cardUID += "0"; // Tambahkan '0' di depan jika kurang dari 0x10
      }
      cardUID += String(rfid.uid.uidByte[i], HEX); // Konversi byte menjadi string heksadesimal dan tambahkan ke string cardUID
    }
    
    Serial.println(cardUID); // Tampilkan UID dalam bentuk string


    if(WiFi.status() == WL_CONNECTED) {
    // Handle client requests only when connected to WiFi
    read_mode();

    if (mode == "read"){
      Serial.println("mode : "+ mode);
      read_uid(cardUID);
    }else if (mode == "add"){
      Serial.println("mode : "+ mode);
      send_uid(cardUID);
    } else {
      Serial.println("Error : "+ mode);
    }

    
    } 

    // Tambahkan logika atau aksi yang diperlukan setelah mendeteksi kartu RFID di sini

    // Hentikan deteksi kartu untuk mencegah membaca berulang
    rfid.PICC_HaltA();
    rfid.PCD_StopCrypto1();
  }
}

void read_mode(){
  HTTPClient http;

    // Alamat API yang dituju
    String serverAddress = "https://kel2iotapp.000webhostapp.com/api/read_mode.php";

    http.begin(serverAddress);  // Mulai koneksi ke server

    // Lakukan GET request
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      
      // Parsing JSON
      DynamicJsonDocument doc(1024); // Ukuran buffer JSON
      deserializeJson(doc, http.getStream());

      // Mengambil nilai dari parameter "kondisi"
      const char* kondisi = doc[0]["kondisi"];
      mode = String(kondisi);

      Serial.print("Nilai kondisi: ");
      Serial.println(mode);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }

    http.end(); // Selesai dengan koneksi HTTP
}

void send_uid(String cardUID){
  // Serial.println("cardUID Berhasil dimasukkan");
      HTTPClient http;

      // Alamat API yang dituju
      String serverAddress = "https://kel2iotapp.000webhostapp.com/api/input_uid.php";

      // Data yang ingin dikirim (misalnya UID)
      String data = "uid="+cardUID; // Ganti dengan data yang sesuai

      http.begin(serverAddress);  // Mulai koneksi ke server

      // Set header untuk mengirim data dalam format application/x-www-form-urlencoded
      http.addHeader("Content-Type", "application/x-www-form-urlencoded");

      // Lakukan POST request dengan data yang disediakan
      int httpResponseCode = http.POST(data);

      if (httpResponseCode > 0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        String response = http.getString(); // Dapatkan respons dari server
        Serial.println(response); // Tampilkan respons dari server
      } else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }

      http.end(); // Selesai dengan koneksi HTTP
}


void read_uid(String cardUID){
  HTTPClient http;

    // Alamat API yang dituju
    String serverAddress = "https://kel2iotapp.000webhostapp.com/api/absensi.php?uid="+cardUID;

    http.begin(serverAddress);  // Mulai koneksi ke server

    // Lakukan GET request
    int httpResponseCode = http.GET();

    if (httpResponseCode > 0) {
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      String response = http.getString(); // Dapatkan respons dari server

      if ( httpResponseCode == 200){
        lcd.setCursor(0, 0);
        lcd.print("BERHASIL ABSENSI");
        lcd.setCursor(0, 1);
        lcd.print(response);
        delay(2500);
        clearLcd();
      }else if  (httpResponseCode == 400){
        digitalWrite(relayPin1, HIGH);
        delay(500);
        digitalWrite(relayPin1, LOW);
        lcd.setCursor(0, 0);
        lcd.print(" GAGAL ABSENSI ");
        lcd.setCursor(0, 1);
        lcd.print("   COBA LAGI   ");
        delay(2500);
        clearLcd();
      }

      // Parsing JSON
      // DynamicJsonDocument doc(1024); // Ukuran buffer JSON
      // deserializeJson(doc, http.getStream());

      // // Mengambil nilai dari parameter "kondisi"
      // const char* name = doc[0]["nama"];
      // nama = String(name);

      // Serial.print("Nama : ");
      // Serial.println(nama);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
      lcd.setCursor(0, 0);
        lcd.print("  SERVER GAGAL  ");
        lcd.setCursor(0, 1);
        lcd.print(" HUBUNGI ADMIN ");
        delay(2500);
    }

    http.end(); // Selesai dengan koneksi HTTP
}


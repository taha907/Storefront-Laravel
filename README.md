# OneTap Bilgisayar — Ekipman Satış Sitesi

**TBL304 Web Programlama Projesi** — Laravel 11, MySQL, Bootstrap 5

Kocaeli merkezli bilgisayar ekipmanları (işlemci, ekran kartı, RAM, SSD, monitör) online satış platformu.

## Özellikler (Proje İsterleri)

| Rol | Özellikler |
|-----|------------|
| **Admin** | Ürün CRUD, fotoğraf yükleme, stok/fiyat, satışa sun/kaldır, sipariş onaylama, kargo aşamalarını ilerletme, kullanıcı yönetimi (dondurma/silme) |
| **User** | Kayıt/giriş, profil ve şifre güncelleme, ürün listeleme, sepet, bakiye öncelikli ödeme + kart simülasyonu, sipariş takibi/iptal (onay öncesi), teslim aldım, üyelik pasifleştirme |
| **API** | OpenWeatherMap hava durumu + Google Maps JavaScript API (iframe değil) |

## Gereksinimler

- PHP 8.2+
- Composer 2.x
- MySQL 8.x (veya MariaDB)
- Node.js (opsiyonel, sadece asset derleme için)

### Önerilen kurulum (Windows)

1. [Laragon](https://laragon.org/download/) veya XAMPP kurun (PHP + MySQL)
2. PATH'e PHP ve MySQL ekleyin

## Kurulum

```powershell
cd computer-shop
copy .env.example .env
# .env içinde DB_DATABASE, DB_USERNAME, DB_PASSWORD düzenleyin
# OPENWEATHER_API_KEY ve GOOGLE_MAPS_API_KEY (opsiyonel)

composer install
php artisan key:generate
php artisan storage:link

# MySQL'de veritabanı oluşturun:
# CREATE DATABASE konum_computer_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

php artisan migrate:fresh --seed
php artisan serve
```

Tarayıcı: **http://127.0.0.1:8000**

Otomatik kurulum: `.\setup.ps1` (PHP ve MySQL PATH'te olmalı)

## Demo Hesaplar

| Rol | E-posta | Şifre |
|-----|---------|-------|
| Admin | admin@onetapbilgisayar.com | admin123 |
| Kullanıcı | ahmet@test.com | user123 |

(5 kullanıcı + 20 ürün seeder ile gelir)

## SQL Yedek (Teslim Zorunluluğu)

```bash
mysqldump -u root -p konum_computer_shop > database/backup/konum_computer_shop.sql
```

## API Anahtarları

1. **Hava durumu:** https://openweathermap.org/api → `.env` → `OPENWEATHER_API_KEY`
2. **Harita:** https://console.cloud.google.com/ → Maps JavaScript API → `GOOGLE_MAPS_API_KEY`

Anahtar yoksa hava durumu demo veri gösterir; harita alanında bilgi mesajı çıkar.

## Klasör Yapısı

```
computer-shop/
├── app/Http/Controllers/   # Auth, Admin, Shop, User
├── app/Models/
├── app/Services/           # Cart, Order, Balance, Weather
├── database/migrations/
├── database/seeders/
├── resources/views/        # Bootstrap Blade şablonları
└── routes/web.php, api.php
```

## Sipariş Akışı

1. Kullanıcı sipariş verir → `pending` (iptal edilebilir, bakiye iadesi)
2. Admin onaylar → `approved` → aşamalar: tedarik → kutulama → kargo → yolda → teslim
3. Kullanıcı "Ürünlerimi Teslim Aldım" → `completed`

## Proje Teslimi

Sıkıştırılmış klasör: `ogrencino_ad_soyad.zip` içinde:

1. Tüm kaynak kod (`computer-shop/`)
2. `database/backup/konum_computer_shop.sql`
3. IEEE format rapor (Word + PDF)

## Ürün görselleri (internetten indirme)

```bash
php artisan products:download-images
```

Seeder çalıştırıldığında görseller otomatik indirilir ve `storage/app/public/products/` + veritabanına kaydedilir.

## Yayın (ücretsiz / düşük maliyet hosting)

| Seçenek | Uygunluk | Not |
|---------|----------|-----|
| **Oracle Cloud Free VPS** | En iyi ücretsiz Laravel | 1 VM, PHP+MySQL kurulumu sizde |
| **Render.com** | Orta | Ücretsiz katman uyur; MySQL için eklenti gerekir |
| **Railway.app** | Orta | Aylık kredi; kolay deploy |
| **InfinityFree** | Zayıf | Laravel 11 için önerilmez |
| **000webhost** | Zayıf | Sınırlı, artisan zor |

**Öneri (proje sunumu):** Oracle Cloud ücretsiz VPS veya üniversite sunucusu. Hızlı demo için `php artisan serve` + **ngrok** ile geçici public URL.

`.env` production: `APP_DEBUG=false`, `APP_URL=https://siteniz.com`

## Lisans

Eğitim projesi — TBL304

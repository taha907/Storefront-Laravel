# OneTap Bilgisayar — Ekipman Satış Platformu

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16+-4169E1?logo=postgresql)](https://www.postgresql.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?logo=bootstrap)](https://getbootstrap.com)
[![Deploy to Render](https://img.shields.io/badge/Deploy%20to-Render-46E3B7?logo=render)](https://render.com)

OneTap Bilgisayar, modern web teknolojileriyle geliştirilmiş, yüksek performanslı ve ölçeklenebilir bir bilgisayar ekipmanları (İşlemci, Ekran Kartı, RAM, SSD, Monitör) e-ticaret platformudur.

## 🚀 Özellikler

| Rol | Yetkiler & Yetenekler |
|-----|-----------------------|
| ⚡ **Admin** | Ürün CRUD işlemleri, dinamik fotoğraf yükleme, stok/fiyat yönetimi, ürün görünürlük kontrolü, sipariş onaylama ve gelişmiş kargo/lojistik aşamalarını yönetme, kullanıcı hesap yönetimi (dondurma/silme). |
| 🛒 **Kullanıcı** | Güvenli kayıt/giriş, profil ve şifre güncellleme, gelişmiş ürün filtreleme ve listeleme, dinamik sepet yönetimi, bakiye öncelikli cüzdan sistemi + kart simülasyonu ile güvenli ödeme, sipariş takibi ve kolay iptal/iade süreçleri. |
| 🔌 **Entegrasyonlar** | **OpenWeatherMap API** ile lokasyon bazlı anlık hava durumu analizi ve **Google Maps JavaScript API** entegrasyonu (Native SDK, iframe değildir). |

---

## 🛠️ Sistem Gereksinimleri

- **PHP**: 8.2 veya üzeri
- **Composer**: 2.x
- **Veritabanı**: PostgreSQL 15+
- **Node.js**: Asset derleme süreçleri için (Opsiyonel)

---

## 📦 Yerel Kurulum (Local Setup)

1. Projeyi bilgisayarınıza klonlayın ve proje dizinine girin:
   ```bash
   git clone [https://github.com/kullaniciadi/computer-shop.git](https://github.com/kullaniciadi/computer-shop.git)
   cd computer-shop

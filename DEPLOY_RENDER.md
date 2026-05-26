# Render ile Yayın — OneTap Bilgisayar (ücretsiz)

## Neden 419 veya Bad Gateway alırsınız?

| Hata | En sık neden |
|------|----------------|
| **419 Page Expired** (giriş) | `SESSION_DOMAIN=.onrender.com` → tarayıcı çerezi kaydetmez |
| **419** | `APP_KEY` yok veya deploy sonrası değişti |
| **419** | `APP_URL` yanlış (http yerine https, yanlış subdomain) |
| **Bad Gateway** | `APP_KEY` eksik → container kapanır |
| **Bad Gateway** | İlk açılış: ücretsiz plan 30–60 sn uyandırır, bekleyin |

Kayıt çalışıp giriş çalışmıyorsa → neredeyse her zaman **session çerezi** sorunudur.

---

## Render Environment — zorunlu liste

Render Dashboard → Web Service → **Environment** → aşağıdakileri ayarlayın.

### Olması gerekenler

| Key | Örnek / not |
|-----|-------------|
| `APP_NAME` | `OneTap Bilgisayar` |
| `APP_KEY` | Yerel `.env` satırı: `base64:Cn01xr4y2G2alYFE9...` (**aynısı**) |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://storefront-laravel.onrender.com` (kendi URL’niz, **https**) |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `sql17.freesqldatabase.com` (paneldeki host) |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | freesqldatabase veritabanı adı |
| `DB_USERNAME` | kullanıcı adı |
| `DB_PASSWORD` | şifre |
| `SESSION_DRIVER` | `file` |
| `SESSION_SECURE_COOKIE` | `true` |
| `CACHE_STORE` | `file` |
| `LOG_CHANNEL` | `stderr` |
| `OPENWEATHER_API_KEY` | (isteğe bağlı) |
| `GOOGLE_MAPS_API_KEY` | (isteğe bağlı) |

### Olmaması gerekenler (419 yapar)

| Key | Neden silinmeli |
|-----|-----------------|
| `SESSION_DOMAIN` | `.onrender.com` yazılıysa **mutlaka silin** |
| `SANCTUM_STATEFUL_DOMAINS` | Gerek yok, karışıklık çıkarır |
| `TRUSTED_PROXIES` | Kodda zaten `trustProxies('*')` var |

`SESSION_DOMAIN` satırını Render’da **Delete** ile kaldırın, boş string bırakmayın.

---

## Kurulum adımları

### 1. GitHub

```powershell
cd C:\Users\Arnolfini\Desktop\Web_Projesi\computer-shop
git add .
git commit -m "Render fix: session, trustProxies"
git push
```

### 2. Render

1. https://render.com → GitHub repo bağlı Web Service
2. **Runtime: Docker**
3. Environment tablosunu yukarıdaki gibi doldurun
4. **Manual Deploy** veya otomatik deploy bekleyin

### 3. Log kontrol

**Logs** sekmesinde şunu görmelisiniz:

```
Starting server on 0.0.0.0:10000
```

`ERROR: APP_KEY is not set` görürseniz → `APP_KEY` ekleyin.

### 4. Veritabanı (ilk kez)

Render **Shell** (ücretsiz planda bazen yok):

```bash
php artisan migrate --force
php artisan db:seed --force
```

Shell yoksa: yerelde `migrate:fresh --seed` → phpMyAdmin ile freesqldatabase’e SQL import (`database/backup/konum_computer_shop.sql`).

### 5. Tarayıcı

1. `storefront-laravel.onrender.com` için **tüm çerezleri silin**
2. Gizli pencerede `/giris` açın
3. `admin@onetapbilgisayar.com` / `admin123`

Giriş POST yanıtında `set-cookie` içinde `domain=.onrender.com` **olmamalı**. Sadece host adı veya domain yok olmalı.

---

## Google Maps

Referrer: `https://storefront-laravel.onrender.com/*`

---

## Yerel geliştirme (aynı proje)

| | Yerel | Render |
|---|--------|--------|
| Ayar | `.env` | Environment Variables |
| DB | `127.0.0.1` | freesqldatabase host |

```powershell
php artisan migrate:fresh --seed
php artisan serve
```

Render’a push etmek yereli bozmaz.

---

## Sorun giderme: "500 Server Error" (sepet / hesabım)

Sepet veya profil **500** veriyorsa genelde **`carts`**, **`cart_items`** veya **`user_balances`** tabloları eksiktir.

Deploy sonrası Render Shell:

```bash
php artisan migrate --force
```

Log’da `ensure_ecommerce_tables` migration’ı çalışmalı.

Shell yoksa: yerelde `php artisan migrate` → freesqldatabase phpMyAdmin’de `migrations` tablosunu kontrol edin.

---

## Hâlâ 419?

1. Environment ekranının **screenshot**’unu atın (şifreleri kapatabilirsiniz)
2. Giriş POST → **Response Headers** → `set-cookie` satırlarını kopyalayın
3. Render **Logs** son 20 satır

Bu üçü ile kesin teşhis konur.

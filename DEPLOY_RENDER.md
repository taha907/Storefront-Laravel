# Render ile Yayın — OneTap Bilgisayar

## 1. Git başlat (henüz yok)

```powershell
cd C:\Users\Arnolfini\Desktop\Web_Projesi\computer-shop
git init
git add .
git commit -m "OneTap Bilgisayar - Laravel 11"
```

## 2. GitHub

1. github.com → New repository → `onetap-bilgisayar`
2. `.env` dosyası repoda OLMAMALI (.gitignore'da)

```powershell
git branch -M main
git remote add origin https://github.com/KULLANICI_ADINIZ/onetap-bilgisayar.git
git push -u origin main
```

## 3. Ücretsiz MySQL (db4free.net)

- Host: `db4free.net`
- Veritabanı + kullanıcı + şifre oluştur
- Yerel SQL import: phpMyAdmin (db4free) veya deploy sonrası seed

## 4. Render

1. https://render.com → Sign up → Connect GitHub
2. **New +** → **Web Service** → repoyu seç
3. **Runtime: Docker** (Dockerfile otomatik bulunur)
4. **Environment Variables** ekle:

| Key | Value |
|-----|--------|
| APP_NAME | OneTap Bilgisayar |
| APP_KEY | (yerel .env APP_KEY kopyala) |
| APP_URL | https://XXX.onrender.com |
| DB_HOST | db4free.net |
| DB_DATABASE | ... |
| DB_USERNAME | ... |
| DB_PASSWORD | ... |
| OPENWEATHER_API_KEY | ... |
| GOOGLE_MAPS_API_KEY | ... |

5. **Create Web Service** → deploy bitene kadar bekle

## 5. İlk açılışta veri

Deploy sonrası Render **Shell** (varsa) veya yerelde db4free'e SQL import.

Veya Shell'de bir kez:
```bash
php artisan db:seed --force
php artisan products:download-images
```

## 6. Google Maps

Referrer: `https://SIZIN-URL.onrender.com/*`

## Sorun giderme: "Exited with status 1"

En sık nedenler:

1. **APP_KEY eksik** — Render → Environment → `APP_KEY` = yerel `.env` içindeki `base64:...` değeri
2. **MySQL bağlantısı** — `DB_HOST=db4free.net`, kullanıcı/şifre doğru; db4free panelinde uzaktan erişim açık olmalı
3. **Eski Dockerfile** — `migrate` başarısız olunca sunucu hiç başlamıyordu; güncel repo `docker/entrypoint.sh` kullanır (migrate hata verse bile site ayağa kalkar)

Deploy sonrası **Logs** sekmesinde `WARN: migrations failed` görürseniz önce DB değişkenlerini düzeltin, sonra **Shell**:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan products:download-images
```

`composer.lock` mutlaka GitHub'da olmalı (Docker build için).

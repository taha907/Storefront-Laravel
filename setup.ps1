# Konum Bilgisayar - Kurulum Scripti (Windows)
# Yönetici PowerShell'de çalıştırın veya PHP/Composer PATH'te olmalı

Write-Host "=== Konum Bilgisayar Ekipmanlari Satis Sitesi Kurulumu ===" -ForegroundColor Cyan

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "HATA: PHP bulunamadi. Laragon, XAMPP veya choco install php kurun." -ForegroundColor Red
    exit 1
}

if (-not (Test-Path .env)) {
    Copy-Item .env.example .env
    Write-Host ".env dosyasi olusturuldu." -ForegroundColor Green
}

if (-not (Test-Path vendor)) {
    Write-Host "Composer bagimliliklari yukleniyor..." -ForegroundColor Yellow
    composer install --no-interaction
}

php artisan key:generate --force
php artisan storage:link 2>$null

Write-Host "Veritabani: MySQL'de 'konum_computer_shop' olusturun, .env icindeki DB_* bilgilerini girin." -ForegroundColor Yellow
Read-Host "Hazir olunca Enter'a basin"

php artisan migrate:fresh --seed --force

Write-Host "SQL yedek aliniyor..." -ForegroundColor Yellow
New-Item -ItemType Directory -Force -Path database/backup | Out-Null
$dumpFile = "database/backup/konum_computer_shop.sql"
if (Get-Command mysqldump -ErrorAction SilentlyContinue) {
    $envContent = Get-Content .env | Where-Object { $_ -match '^DB_' }
    $dbName = ($envContent | Where-Object { $_ -match 'DB_DATABASE=' }) -replace 'DB_DATABASE=',''
    $dbUser = ($envContent | Where-Object { $_ -match 'DB_USERNAME=' }) -replace 'DB_USERNAME=',''
    $dbPass = ($envContent | Where-Object { $_ -match 'DB_PASSWORD=' }) -replace 'DB_PASSWORD=',''
    mysqldump -u $dbUser $(if($dbPass){"-p$dbPass"}) $dbName > $dumpFile
    Write-Host "Yedek: $dumpFile" -ForegroundColor Green
} else {
    Write-Host "mysqldump yok. Manuel: mysqldump -u root -p konum_computer_shop > $dumpFile" -ForegroundColor Yellow
}

Write-Host "`nSunucu baslatiliyor: http://127.0.0.1:8000" -ForegroundColor Green
Write-Host "Admin: admin@konumbilgisayar.com / admin123" -ForegroundColor Cyan
Write-Host "User:  ahmet@test.com / user123" -ForegroundColor Cyan
php artisan serve

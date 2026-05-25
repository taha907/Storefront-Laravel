-- Konum Bilgisayar Ekipmanlari - Veritabani Yedegi
-- Bu dosya migrate:fresh --seed SONRASI guncellenmelidir:
-- mysqldump -u root -p konum_computer_shop > database/backup/konum_computer_shop.sql
--
-- Asagidaki sema referans icindir. Canli veri icin yukaridaki komutu calistirin.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `konum_computer_shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `konum_computer_shop`;

-- Tablolar Laravel migration ile olusturulur.
-- Kurulum sonrasi mysqldump ile bu dosyayi guncelleyin.

-- Ornek admin (seeder ile ayni - sifre: admin123 bcrypt hash migrate sonrasi tabloda olur)
-- php artisan migrate:fresh --seed
-- php artisan tinker
-- >>> \App\Models\User::where('email','admin@konumbilgisayar.com')->first();

SET FOREIGN_KEY_CHECKS = 1;

-- NOT: Gercek teslim icin sunucudan alinan tam mysqldump dosyasini kullanin.

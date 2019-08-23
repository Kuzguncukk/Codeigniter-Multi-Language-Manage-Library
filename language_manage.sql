
-- @Kuzguncukk
-- kuzguncompany@gmail.com
--
-- Üretim Zamanı: 22 Ağu 2019, 22:17:01
-- Sunucu sürümü: 10.1.36-MariaDB
-- PHP Sürümü: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `deneme`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `language`
--

CREATE TABLE `language` (
  `lang_id` int(10) UNSIGNED NOT NULL,
  `lang_name` varchar(254) COLLATE utf8_turkish_ci NOT NULL,
  `lang_slug` varchar(254) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `language`
--

INSERT INTO `language` (`lang_id`, `lang_name`, `lang_slug`) VALUES
(202, 'Türkçe', 'turkish'),
(206, 'English', 'english');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `language_key`
--

CREATE TABLE `language_key` (
  `lk_id` int(11) NOT NULL,
  `lk_key` varchar(254) COLLATE utf8_turkish_ci NOT NULL,
  `lk_value` varchar(8000) COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `language_key`
--

INSERT INTO `language_key` (`lk_id`, `lk_key`, `lk_value`) VALUES
(58, 'Add New Language', 'a:2:{s:7:\"turkish\";s:13:\"Yeni Dil Ekle\";s:7:\"english\";s:16:\"Add New Language\";}'),
(59, 'List Languages', 'a:2:{s:7:\"turkish\";s:15:\"Dilleri Listele\";s:7:\"english\";s:14:\"List Languages\";}'),
(60, 'List Language Translations', 'a:2:{s:7:\"turkish\";s:25:\"Dil Çevirilerini Listele\";s:7:\"english\";s:26:\"List Language Translations\";}'),
(61, 'Language Name', 'a:2:{s:7:\"turkish\";s:8:\"Dil Adı\";s:7:\"english\";s:13:\"Language Name\";}'),
(62, 'Language Folder Name', 'a:2:{s:7:\"turkish\";s:16:\"Dil Klasör Adı\";s:7:\"english\";s:20:\"Language Folder Name\";}'),
(63, 'Actions', 'a:2:{s:7:\"turkish\";s:10:\"İşlemler\";s:7:\"english\";s:7:\"Actions\";}'),
(64, 'Language Key', 'a:2:{s:7:\"turkish\";s:13:\"Dil Anahtarı\";s:7:\"english\";s:12:\"Language Key\";}'),
(65, 'Update', 'a:2:{s:7:\"turkish\";s:9:\"Güncelle\";s:7:\"english\";s:6:\"Update\";}'),
(66, 'Edit', 'a:2:{s:7:\"turkish\";s:8:\"Düzenle\";s:7:\"english\";s:4:\"Edit\";}'),
(67, 'Delete', 'a:2:{s:7:\"turkish\";s:3:\"Sil\";s:7:\"english\";s:6:\"Delete\";}'),
(68, 'Update Language Information', 'a:2:{s:7:\"turkish\";s:25:\"Dil Bilgilerini Güncelle\";s:7:\"english\";s:27:\"Update Language Information\";}'),
(69, 'Update Current Language', 'a:2:{s:7:\"turkish\";s:21:\"Mevcut Dili Güncelle\";s:7:\"english\";s:23:\"Update Current Language\";}'),
(70, 'Add New Language Key', 'a:2:{s:7:\"turkish\";s:23:\"Yeni Dil Anahtarı Ekle\";s:7:\"english\";s:20:\"Add New Language Key\";}'),
(71, 'Enter Language Key', 'a:2:{s:7:\"turkish\";s:22:\"Dil Anahtarını Girin\";s:7:\"english\";s:18:\"Enter Language Key\";}'),
(72, 'Turn Back', 'a:2:{s:7:\"turkish\";s:9:\"Geri Dön\";s:7:\"english\";s:9:\"Turn Back\";}'),
(73, 'Translation', 'a:2:{s:7:\"turkish\";s:7:\"Çeviri\";s:7:\"english\";s:11:\"Translation\";}'),
(74, 'Translated Language', 'a:2:{s:7:\"turkish\";s:13:\"Çevrilen Dil\";s:7:\"english\";s:19:\"Translated Language\";}'),
(75, 'Translated Languages', 'a:2:{s:7:\"turkish\";s:18:\"Çevrilmiş Diller\";s:7:\"english\";s:20:\"Translated Languages\";}'),
(76, 'No translation language has been added yet.', 'a:2:{s:7:\"turkish\";s:32:\"Henüz çeviri dili eklenmemiş.\";s:7:\"english\";s:43:\"No translation language has been added yet.\";}'),
(77, 'Name of language to add', 'a:2:{s:7:\"turkish\";s:25:\"Eklenecek olan dilin adı\";s:7:\"english\";s:23:\"Name of language to add\";}'),
(78, 'Folder name of the language to be added', 'a:2:{s:7:\"turkish\";s:33:\"Eklenecek olan dilin klasör adı\";s:7:\"english\";s:39:\"Folder name of the language to be added\";}'),
(79, 'Select Language', 'a:2:{s:7:\"english\";s:15:\"Select Language\";s:7:\"turkish\";s:10:\"Dil Seçin\";}'),
(84, 'Key translations for %s', 'a:2:{s:7:\"english\";s:23:\"Key translations for %s\";s:7:\"turkish\";s:19:\"%s için çeviriler\";}'),
(85, 'No translation added', 'a:2:{s:7:\"english\";s:20:\"No translation added\";s:7:\"turkish\";s:19:\"Çeviri eklenmemiş\";}'),
(86, 'Loss Information', 'a:2:{s:7:\"english\";s:16:\"Loss Information\";s:7:\"turkish\";s:22:\"Kayıp Bilgilendirmesi\";}'),
(87, 'Error extracting Language File. Database and Write Permission', 'a:2:{s:7:\"english\";s:61:\"Error extracting Language File. Database and Write Permission\";s:7:\"turkish\";s:68:\"Dil Dosyası çıkarırken hata oluştu. (Veritabanı ve Yazma İzni\";}'),
(88, 'The name of this language has already been added', 'a:2:{s:7:\"english\";s:48:\"The name of this language has already been added\";s:7:\"turkish\";s:34:\"Bu dilin ismi daha önce eklenmiş\";}'),
(89, 'Congratulations Language File Created Successfully.', 'a:2:{s:7:\"english\";s:51:\"Congratulations Language File Created Successfully.\";s:7:\"turkish\";s:48:\"Tebrikler Dil Dosyası Başarıyla Oluşturuldu.\";}'),
(90, 'The specified id could not be found', 'a:2:{s:7:\"english\";s:35:\"The specified id could not be found\";s:7:\"turkish\";s:25:\"Belirtilen id bulunamadı\";}'),
(91, 'The specified language could not be found.', 'a:2:{s:7:\"english\";s:42:\"The specified language could not be found.\";s:7:\"turkish\";s:27:\"Belirtilen dil bulunamadı.\";}'),
(92, 'The language file was deleted successfully.', 'a:2:{s:7:\"english\";s:43:\"The language file was deleted successfully.\";s:7:\"turkish\";s:33:\"Dil dosyası başarıyla silindi.\";}'),
(93, 'Error deleting language folder.', 'a:2:{s:7:\"english\";s:31:\"Error deleting language folder.\";s:7:\"turkish\";s:35:\"Dil dosyası silerken hata oluştu.\";}'),
(94, 'Error deleting language information from database.', 'a:2:{s:7:\"english\";s:50:\"Error deleting language information from database.\";s:7:\"turkish\";s:54:\"Dil bilgileri veritabanından silinirken hata oluştu.\";}'),
(95, 'The language key was created successfully.', 'a:2:{s:7:\"english\";s:42:\"The language key was created successfully.\";s:7:\"turkish\";s:39:\"Dil anahtarı başarıyla oluşturuldu.\";}'),
(96, 'Error adding language key to database.', 'a:2:{s:7:\"english\";s:38:\"Error adding language key to database.\";s:7:\"turkish\";s:52:\"Dil anahtarı veritabanına eklenirken hata oluştu.\";}'),
(97, 'The language key was deleted successfully.', 'a:2:{s:7:\"english\";s:42:\"The language key was deleted successfully.\";s:7:\"turkish\";s:34:\"Dil anahtarı başarıyla silindi.\";}'),
(98, 'Error deleting language key from database.', 'a:2:{s:7:\"english\";s:42:\"Error deleting language key from database.\";s:7:\"turkish\";s:54:\"Dil anahtarı veritabanından silinirken hata oluştu.\";}'),
(99, 'The Language ID cannot be blank and must be numeric.', 'a:2:{s:7:\"english\";s:52:\"The Language ID cannot be blank and must be numeric.\";s:7:\"turkish\";s:62:\"Dil Kimliği boş bırakılamaz ve sayısal olmak zorundadır.\";}'),
(100, 'Language Name and Language Folder name cannot be left blank.', 'a:2:{s:7:\"english\";s:60:\"Language Name and Language Folder name cannot be left blank.\";s:7:\"turkish\";s:48:\"Dil Adı ve Dil Klasör adı boş bırakılamaz.\";}'),
(101, 'There is already a language for this language name.', 'a:2:{s:7:\"english\";s:51:\"There is already a language for this language name.\";s:7:\"turkish\";s:39:\"Bu dil adına ait zaten bir dil mevcut.\";}'),
(102, 'The language for this ID could not be found.', 'a:2:{s:7:\"english\";s:44:\"The language for this ID could not be found.\";s:7:\"turkish\";s:32:\"Bu kimliğe ait dil bulunamadı.\";}'),
(103, 'An error occurred while updating the Language Name and Language Folder name in the database.', 'a:2:{s:7:\"english\";s:92:\"An error occurred while updating the Language Name and Language Folder name in the database.\";s:7:\"turkish\";s:81:\"Veritabanındaki Dil Adı ve Dil Klasörü adı güncellenirken bir hata oluştu.\";}'),
(104, 'Language information was updated successfully.', 'a:2:{s:7:\"english\";s:46:\"Language information was updated successfully.\";s:7:\"turkish\";s:39:\"Dil bilgileri başarıyla güncellendi.\";}'),
(105, 'Language Error changing folder name, please change the folder name to %s manually.', 'a:2:{s:7:\"english\";s:82:\"Language Error changing folder name, please change the folder name to %s manually.\";s:7:\"turkish\";s:98:\"Dil Klasör adı değiştirilken hata oluştu lütfen klasör adını %s olarak elle değiştirin.\";}'),
(106, 'Language key successfully updated.', 'a:2:{s:7:\"english\";s:34:\"Language key successfully updated.\";s:7:\"turkish\";s:39:\"Dil anahtarı başarıyla güncellendi.\";}'),
(107, 'Error updating language key in database.', 'a:2:{s:7:\"english\";s:40:\"Error updating language key in database.\";s:7:\"turkish\";s:58:\"Dil anahtarı veritabanında güncellenirken hata oluştu.\";}'),
(110, '%s language folders do not appear because they are not added to the language table in the database.', 'a:2:{s:7:\"english\";s:99:\"%s language folders do not appear because they are not added to the language table in the database.\";s:7:\"turkish\";s:91:\"%s dil klasörleri veri tabanında language tablosuna eklenmediği için gözükmemektedir.\";}'),
(111, 'The %s language attached to the database does not appear because it cannot be found in the application>language folder.', 'a:2:{s:7:\"english\";s:119:\"The %s language attached to the database does not appear because it cannot be found in the application>language folder.\";s:7:\"turkish\";s:107:\"Veritabanında ekli olan %s dili application>language klasöründe bulunamadığı için gözükmemektedir.\";}');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`lang_id`),
  ADD UNIQUE KEY `lang_slug` (`lang_slug`);

--
-- Tablo için indeksler `language_key`
--
ALTER TABLE `language_key`
  ADD PRIMARY KEY (`lk_id`),
  ADD UNIQUE KEY `lk_id` (`lk_id`),
  ADD UNIQUE KEY `lk_key` (`lk_key`);
--
-- Tablo için AUTO_INCREMENT değeri `language`
--
ALTER TABLE `language`
  MODIFY `lang_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- Tablo için AUTO_INCREMENT değeri `language_key`
--
ALTER TABLE `language_key`
  MODIFY `lk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Oca 2020, 13:27:50
-- Sunucu sürümü: 10.1.37-MariaDB
-- PHP Sürümü: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `mydomaindatabase`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `domainler`
--

CREATE TABLE `domainler` (
  `id` int(10) UNSIGNED NOT NULL,
  `k_id` int(11) NOT NULL,
  `site_adi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `domainler`
--

INSERT INTO `domainler` (`id`, `k_id`, `site_adi`) VALUES
(1, 1, 'n11.com'),
(2, 1, 'bynogame.com'),
(3, 3, 'linkedin.com'),
(4, 3, 'facebook.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `domain_`
--

CREATE TABLE `domain_` (
  `id` int(10) UNSIGNED NOT NULL,
  `site` varchar(50) CHARACTER SET latin5 NOT NULL,
  `alexa_global` int(11) NOT NULL,
  `alexa_fark` int(11) NOT NULL,
  `alexa_turkiye` int(11) NOT NULL,
  `yas` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `title` varchar(500) CHARACTER SET latin5 NOT NULL,
  `meta` varchar(500) CHARACTER SET latin5 NOT NULL,
  `pagerank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `domain_`
--

INSERT INTO `domain_` (`id`, `site`, `alexa_global`, `alexa_fark`, `alexa_turkiye`, `yas`, `tarih`, `title`, `meta`, `pagerank`) VALUES
(1, 'n11.com/', 833, -83, 8, 19, '2019-08-07', 'n11.com - Al??veri?in U?urlu Adresi', 'Cep telefonu, TV, bilgisayar, saat, moda, bisiklet, tatil, kitap ve dahas? en uygun fiyatlar? ile online al??veri? sitesi ve al??veri?in u?urlu adresi n11.com\'da!', 6),
(2, 'n11.com/', 833, -83, 8, 19, '2019-08-07', 'n11.com - Al??veri?in U?urlu Adresi', 'Cep telefonu, TV, bilgisayar, saat, moda, bisiklet, tatil, kitap ve dahas? en uygun fiyatlar? ile online al??veri? sitesi ve al??veri?in u?urlu adresi n11.com\'da!', 6),
(3, 'bynogame.com/', 31253, -4064, 331, 11, '2019-08-07', 'Everything You Need for Online Games is Here', 'We are Friend of Gamers - Trusted &amp; Best Prices 7/24 Fast Delivery in ByNoGame Everything You Need for Online Games is Here', 5),
(4, 'bynogame.com/', 31253, -4064, 331, 11, '2019-08-07', 'Everything You Need for Online Games is Here', 'We are Friend of Gamers - Trusted &amp; Best Prices 7/24 Fast Delivery in ByNoGame Everything You Need for Online Games is Here', 5),
(5, 'asersoft.com.tr/', 10884174, 940396, 0, 6, '2019-08-07', 'ASERSOFT ', 'ASERSOFT, gerek i?letmelerin mevcut yaz?l?mlar? ile entegre ?al??acak, gerekse i?letmenin ihtiya?lar? ile ?rt??en yeni yaz?l?m veya mod?l geli?tirme uygulamalar? ile firmalara ihtiya? duyduklar? ??z?mler ?retir. ', 2),
(6, 'asersoft.com.tr/', 10884174, 940396, 0, 6, '2019-08-07', 'ASERSOFT ', 'ASERSOFT, gerek i?letmelerin mevcut yaz?l?mlar? ile entegre ?al??acak, gerekse i?letmenin ihtiya?lar? ile ?rt??en yeni yaz?l?m veya mod?l geli?tirme uygulamalar? ile firmalara ihtiya? duyduklar? ??z?mler ?retir. ', 2),
(7, 'n11.com/', 710, -204, 8, 19, '2019-09-12', 'n11.com - Al??veri?in U?urlu Adresi', 'Cep telefonu, TV, bilgisayar, saat, moda, bisiklet, tatil, kitap ve dahas? en uygun fiyatlar? ile online al??veri? sitesi ve al??veri?in u?urlu adresi n11.com\'da!', 6),
(8, 'n11.com/', 703, -205, 7, 19, '2019-09-13', 'n11.com - Al??veri?in U?urlu Adresi', 'Cep telefonu, TV, bilgisayar, saat, moda, bisiklet, tatil, kitap ve dahas? en uygun fiyatlar? ile online al??veri? sitesi ve al??veri?in u?urlu adresi n11.com\'da!', 6),
(9, 'linkedin.com/', 49, 17, 20, 16, '2019-09-13', 'LinkedIn: Log In or Sign Up', '500 million+ members | Manage your professional identity. Build and engage with your professional network. Access knowledge, insights and opportunities.', 10),
(10, 'linkedin.com/', 49, 17, 20, 16, '2019-09-13', 'LinkedIn: Log In or Sign Up', '500 million+ members | Manage your professional identity. Build and engage with your professional network. Access knowledge, insights and opportunities.', 10),
(11, 'facebook.com/', 4, 1, 5, 22, '2019-09-13', 'Taray?c?n? Güncelle | Facebook', '', 10),
(12, 'facebook.com/', 4, 1, 5, 22, '2019-09-13', 'Taray?c?n? Güncelle | Facebook', '', 10);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `k_id` int(10) UNSIGNED NOT NULL,
  `adi` varchar(50) CHARACTER SET latin5 NOT NULL,
  `soyadi` varchar(50) CHARACTER SET latin5 NOT NULL,
  `eposta` varchar(50) CHARACTER SET latin5 NOT NULL,
  `sifre` varchar(15) CHARACTER SET latin5 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`k_id`, `adi`, `soyadi`, `eposta`, `sifre`) VALUES
(1, 'Ay?e', 'Elgören', 'ayse@gmail.com', '12345'),
(2, 'a', 'a', 'a@gmail.com', '12345'),
(3, 'selin', 'can', 'selin@gmail.com', '12345');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `domainler`
--
ALTER TABLE `domainler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `domain_`
--
ALTER TABLE `domain_`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`k_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `domainler`
--
ALTER TABLE `domainler`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `domain_`
--
ALTER TABLE `domain_`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `k_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

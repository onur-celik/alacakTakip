DROP TABLE islemler;

CREATE TABLE `islemler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_id` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tutar` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tip` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO islemler VALUES("1","1","10/01/2013","cam balkon yapildi","1500","0");
INSERT INTO islemler VALUES("2","1","10/02/2013","Nesrine Odeme","500","1");
INSERT INTO islemler VALUES("3","1","10/03/2013","Ayseye Odenen","325","1");
INSERT INTO islemler VALUES("4","1","10/04/2013","Camlar onarildi","480","0");
INSERT INTO islemler VALUES("11","1","10/05/2013","Banka havalesi","100","1");
INSERT INTO islemler VALUES("17","1","10/20/2013","odeme yapildi..","55","1");



DROP TABLE  musteriler;

CREATE TABLE `musteriler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isimsoyisim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `adres` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon1` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon2` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon3` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `hesap_durumu` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO  musteriler VALUES("1","Onur Çelik","onurcelik adress","05397048108","tel 2","tel 3","1");
INSERT INTO  musteriler VALUES("27","Hedeler Hedesi","Hede Sok. Hede Apt No : hede, HEDE","1234","5678","9101112","0");




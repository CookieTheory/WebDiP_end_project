-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 21, 2022 at 01:59 PM
-- Server version: 5.5.62-0+deb8u1
-- PHP Version: 7.2.25-1+0~20191128.32+debian8~1.gbp108445

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WebDiP2021x066`
--

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik`
--

CREATE TABLE `dnevnik` (
  `dnevnik_id` int(11) NOT NULL,
  `vrijeme` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `korisnik_id` int(11) NOT NULL,
  `radnja_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dnevnik`
--

INSERT INTO `dnevnik` (`dnevnik_id`, `vrijeme`, `korisnik_id`, `radnja_id`) VALUES
(1, '2022-06-19 05:16:16', 1, 1),
(2, '2022-06-19 07:33:19', 1, 2),
(3, '2022-06-20 08:21:22', 2, 4),
(4, '2022-06-20 10:23:27', 3, 4),
(5, '2022-06-20 12:33:32', 6, 5),
(6, '2022-06-20 13:36:36', 4, 6),
(7, '2022-06-20 14:04:10', 5, 3),
(8, '2022-06-20 03:20:20', 4, 1),
(9, '2022-06-20 07:22:29', 4, 6),
(10, '2022-06-20 10:38:31', 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

CREATE TABLE `kategorija` (
  `kategorija_id` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `opis` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`kategorija_id`, `naziv`, `opis`) VALUES
(1, 'promet', 'Kategorija vezana uz prekšaje za promet'),
(2, 'nekretnine', 'Kategorija vezana uz prekšaje za nekretnine'),
(3, 'zaštita osobnih podataka', 'Kategorija vezana uz prekršaje za zaštitu osobnih podataka'),
(4, 'gospodarski prekršaji', 'Sve vezano uz gospodarske prekršaje'),
(5, 'rastava', 'Kategorija vezana uz brak'),
(6, 'Financijski prekršaji', 'Kategorija vezana uz prevare'),
(7, 'Javni red i mir', 'Kategorija vezana uz javni red i mir'),
(8, 'Žalbe na presudu', 'Kategorija vezana uz žalbe i slično'),
(9, 'Trgovinski prekršaji', 'Kategorija vezana uz trgovinske prekršaje'),
(10, 'Azil i međunarodna zaštita', 'Kategorija vezana uz azil i korisnike azila i međunarodne zaštite');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `korisnik_id` int(11) NOT NULL,
  `ime` varchar(45) NOT NULL,
  `prezime` varchar(45) NOT NULL,
  `godina_rodenja` int(5) NOT NULL,
  `korime` varchar(45) NOT NULL,
  `lozinka` varchar(45) NOT NULL,
  `sol` char(64) NOT NULL,
  `lozinka256` char(64) NOT NULL,
  `email` varchar(45) NOT NULL,
  `kolacici` int(4) NOT NULL,
  `datum_registracije` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `broj_prijava` int(3) NOT NULL,
  `uvjeti_koristenja` varchar(45) DEFAULT NULL,
  `blokiran` tinyint(4) NOT NULL,
  `verificiran` tinyint(4) NOT NULL,
  `uloga_uloga_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `ime`, `prezime`, `godina_rodenja`, `korime`, `lozinka`, `sol`, `lozinka256`, `email`, `kolacici`, `datum_registracije`, `broj_prijava`, `uvjeti_koristenja`, `blokiran`, `verificiran`, `uloga_uloga_id`) VALUES
(1, 'Ivan', 'Admin', 2001, 'ilucic', 'ilucic1', '736d2fb5ff6a62c1acfdbed31cc7c2abb08dce17c19b3c4c3f0a2f2be0c86e86', 'ff3b110b02716250bcf6d1e5a73d375600507838d2554dd52fc33aa08f403b54', 'ilucic@foi.hr', 111, '2022-06-20 09:47:19', 0, '1', 0, 1, 1),
(2, 'Mislav', 'Soldo', 1997, 'mislav', 'mislav1', 'e8bb51fdb815d361928965bf3c1e34ff300ab4b27e20083cb69154c90e5472d6', '03143b456fa1301cdf0a3c9935768c7da11fd9d9ee6a350d2f256ba1624a070f', 'ilucic@foi.hr', 100, '2022-06-20 11:48:15', 0, '1', 0, 1, 2),
(3, 'Branko', 'Kranjčec', 1993, 'branko', 'branko1', '97dec7b665e6bae6f43dda469a4c288ed17a44305255aabc46ddc660216f1a01', '2ac69bd5f1e0cb6813ed17ea274cfb4891b712de3807b80494c0fee6361f60e5', 'ilucic@foi.hr', 100, '2022-06-20 11:49:38', 0, '1', 0, 1, 3),
(4, 'Eduard', 'Grabar', 1994, 'eduard', 'eduard1', '044fb735773c92097b7c5bc8cef9ad305d4dcd40b5fac2fab4f64280faf3bb43', 'bcc2b5e7790c9d2274a38ca9afae5a5a7452153634bf3d13617fc087ea8e4321', 'ilucic@foi.hr', 111, '2022-06-20 11:52:23', 0, '1', 0, 0, 3),
(5, 'Marko', 'Milas', 1995, 'marko', 'milas1', 'e6bcc9003d5a7e48d5a8d95f913872c867f8046d258df2e90c5b354244f46189', '90e77647504f65dd5ce3be3ac868e1742b2d9c2ad9d10945389268bd3fae06e8', 'ilucic@foi.hr', 110, '2022-06-20 11:54:15', 0, '1', 0, 1, 2),
(6, 'Franjo', 'Štefanić', 2004, 'franjo', 'franjo1', '76b44dee4b3a052ef48c1c7ea547050944aa87b25202d5eefc6c82e1c8bcc8b4', 'd2105c6e701711515058dc5fead1402f9a667970c15ca4603953627713af2617', 'ilucic@foi.hr', 111, '2022-06-20 12:02:11', 3, '1', 1, 1, 2),
(7, 'Gabrijel', 'Novosel', 1987, 'gabrijel', 'gabrijel1', 'df5581484c6b5b2385a2ca30e1aa8f911960d753de1621f0b87a35a3b7838526', 'ea4439dc111583760ac6d97bb744498c045d647e730e394bbb6f14285c4dece9', 'ilucic@foi.hr', 101, '2022-06-20 12:05:08', 0, '1', 0, 1, 3),
(8, 'Jan', 'Hren', 1992, 'jan', 'jan1', '2a330d67fe5a2f51cb9ac7b5bfb8f048cf03ebe9c7baecc843034e1416692ea6', '3564cf3f844acb404037b6d45bab0bbb257d3b56b2acef9caef4ddbe5d86ed1a', 'ilucic@foi.hr', 111, '2022-06-20 17:36:30', 0, '1', 0, 1, 2),
(9, 'Domagoj', 'Lovrić', 1997, 'domi', 'domi1', '3a2dde6cab7467ed55210cf46947f94475c75487fa830b5e241ea474a41b0ad6', '8f79f8d2d9485cbc0b473c04df66b6da1a9b41cfe7c061b60cebefb1370f7c12', 'ilucic@foi.hr', 101, '2022-06-20 17:47:35', 0, '1', 0, 1, 3),
(10, 'Vesna', 'Braut', 1990, 'vesna', 'vesna1', 'b34115470f14ae0aa992e397a2f5e37dfc8b58f44a64195543bb4977da541772', 'c7a4a4cc7c26ca99f6bdaf33b26a15180cdda29b14b250e1bdee45aa8e859adc', 'ilucic@foi.hr', 101, '2022-06-20 17:48:12', 0, '1', 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `moderator_kategorije`
--

CREATE TABLE `moderator_kategorije` (
  `modkategorija_id` int(11) NOT NULL,
  `modmoderator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moderator_kategorije`
--

INSERT INTO `moderator_kategorije` (`modkategorija_id`, `modmoderator_id`) VALUES
(1, 5),
(2, 5),
(5, 5),
(3, 2),
(6, 2),
(7, 2),
(9, 6),
(10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `radnja`
--

CREATE TABLE `radnja` (
  `radnja_id` int(11) NOT NULL,
  `radnja` varchar(45) NOT NULL,
  `detalji` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `radnja`
--

INSERT INTO `radnja` (`radnja_id`, `radnja`, `detalji`) VALUES
(1, 'Prijava', 'Korisnik se prijavio'),
(2, 'Odjava', 'Korisnik se odjavio'),
(3, 'Registracija', 'Korisnik se registrirao'),
(4, 'Dodavanje bazi', 'Korisnik napravio unos u bazu'),
(5, 'Brisanje iz baze', 'Korisnik obrisao unos iz baze'),
(6, 'Pregled baze', 'Korisnik pristupio bazi');

-- --------------------------------------------------------

--
-- Table structure for table `savjetovanje`
--

CREATE TABLE `savjetovanje` (
  `savjetovanje_id` int(11) NOT NULL,
  `razlog` varchar(50) NOT NULL,
  `opis` varchar(100) NOT NULL,
  `odgovor` varchar(250) DEFAULT NULL,
  `stranka_id` int(11) NOT NULL,
  `odvjetnik_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `savjetovanje`
--

INSERT INTO `savjetovanje` (`savjetovanje_id`, `razlog`, `opis`, `odgovor`, `stranka_id`, `odvjetnik_id`) VALUES
(1, 'Krađa', 'Pokraden sam, policija pronašla sumnjivca, tražim savjetovanje kako da nastavim.', NULL, 7, 2),
(2, 'Rastava', 'Rastavljam se zbog varanja, tražim savjet kako da se rastavim bez gubitka imovine.', NULL, 7, 2),
(3, 'Sudar', 'Uzrokovao sam sudar, osoba me tuži, kako da riješim tužbu bez odlaska na sud.', 'Pokušajte zatražiti rješenje van suda s tužiteljom', 3, 2),
(4, 'Posuđeni novac', 'Posuđeni novac obitelj ne vraća', NULL, 3, 5),
(5, 'Tražim savjetovanje', 'Opljačkali su me te tražim savjetovanje kako da nastavim.', NULL, 1, 8),
(6, 'Uznemiravanje mira', 'Susjed je svaku noć glasan nakon 23 sata, ne želi prestati, kako legalno mogu okončati situaciju', NULL, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `naziv_statusa` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `naziv_statusa`) VALUES
(1, 'Neodređeno'),
(2, 'U trajanju'),
(3, 'Kriv'),
(4, 'Nije kriv');

-- --------------------------------------------------------

--
-- Table structure for table `sudski`
--

CREATE TABLE `sudski` (
  `sudski_id` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL,
  `radnja` varchar(45) NOT NULL,
  `dokaz` varchar(45) NOT NULL,
  `datum_pocetak` datetime NOT NULL,
  `datum_kraj` datetime DEFAULT NULL,
  `tuzitelj_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `kategorija_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sudski`
--

INSERT INTO `sudski` (`sudski_id`, `naziv`, `radnja`, `dokaz`, `datum_pocetak`, `datum_kraj`, `tuzitelj_id`, `status_id`, `kategorija_id`) VALUES
(1, 'Sudar', 'Sudar klijenta i optuženog', 'Kamera', '2022-06-23 14:14:00', '2022-06-30 14:38:00', 5, 4, 1),
(2, 'Rastava', 'Rastava obitelji', 'Rastavni papir', '2022-06-21 19:51:00', NULL, 5, 2, 5),
(3, 'Brzanje', 'Optuženi brzao na cesti', 'Kamera', '2022-06-20 19:52:00', NULL, 5, 2, 1),
(4, 'Vožnja pod utjecajem', 'Pijana vožnja', 'Alkotest', '2022-06-12 09:52:00', NULL, 5, 2, 1),
(5, 'Porez', 'Izbjegavanje poreza', 'Imovinski list', '2022-06-25 00:54:00', NULL, 5, 2, 2),
(6, 'Azil', 'Klijent traži azil', 'Prijetnja', '2022-06-27 20:04:00', NULL, 8, 2, 10),
(7, 'Prevara', 'Financijska prevara', 'Financijski papiri', '2022-06-30 22:55:00', NULL, 2, 2, 6),
(8, 'Druga prevara', 'Financijska prevara 2', 'Financije', '2022-06-28 22:55:00', NULL, 2, 2, 6),
(9, 'Uznemiravanje', 'Uznemiravanje javnog reda i mira', 'Svjedok', '2022-07-02 22:56:00', NULL, 2, 2, 7),
(10, 'Rastava 2', 'Druga rastava', 'Druga rastava', '2022-06-22 15:21:00', NULL, 5, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `uloga`
--

CREATE TABLE `uloga` (
  `uloga_id` int(11) NOT NULL,
  `naziv` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uloga`
--

INSERT INTO `uloga` (`uloga_id`, `naziv`) VALUES
(1, 'administrator'),
(2, 'moderator'),
(3, 'registrirani_korisnik'),
(4, 'neregistrirani_korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

CREATE TABLE `zahtjev` (
  `zahtjev_id` int(11) NOT NULL,
  `slika` varchar(45) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `argument_obrane` varchar(45) DEFAULT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zakljucak` varchar(45) DEFAULT NULL,
  `sudski_id` int(11) NOT NULL,
  `stranka_id` int(11) NOT NULL,
  `odvjetnik_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zahtjev`
--

INSERT INTO `zahtjev` (`zahtjev_id`, `slika`, `status`, `argument_obrane`, `datum`, `zakljucak`, `sudski_id`, `stranka_id`, `odvjetnik_id`) VALUES
(2, 'primjer5.jpg', 1, 'Moj klijent nije uzrokovao sudar i nedužan je', '2022-06-20 12:31:28', NULL, 1, 3, 2),
(3, 'primjer2.jpg', NULL, NULL, '2022-06-20 17:56:53', NULL, 2, 3, 2),
(4, 'primjer3.jpg', NULL, NULL, '2022-06-20 18:00:15', NULL, 5, 3, 2),
(5, 'primjer4.jpg', NULL, NULL, '2022-06-20 18:05:32', NULL, 6, 7, 6),
(6, 'primjer10.jpg', NULL, NULL, '2022-06-20 21:00:14', NULL, 7, 9, 6),
(7, 'primjer11.jpg', NULL, NULL, '2022-06-20 21:01:15', NULL, 9, 9, 5),
(8, 'primjer12.jpg', 1, NULL, '2022-06-20 21:01:24', NULL, 8, 9, 8),
(9, 'primjer1.jpg', 1, NULL, '2022-06-21 06:22:44', NULL, 10, 7, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD PRIMARY KEY (`dnevnik_id`),
  ADD KEY `fk_dnevnik_korisnik1_idx` (`korisnik_id`),
  ADD KEY `fk_dnevnik_radnja1_idx` (`radnja_id`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`kategorija_id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`korisnik_id`),
  ADD KEY `fk_korisnik_uloga1_idx` (`uloga_uloga_id`);

--
-- Indexes for table `moderator_kategorije`
--
ALTER TABLE `moderator_kategorije`
  ADD KEY `fk_moderator_kategorije_kategorija_idx` (`modkategorija_id`),
  ADD KEY `fk_moderator_kategorije_korisnik1_idx` (`modmoderator_id`);

--
-- Indexes for table `radnja`
--
ALTER TABLE `radnja`
  ADD PRIMARY KEY (`radnja_id`);

--
-- Indexes for table `savjetovanje`
--
ALTER TABLE `savjetovanje`
  ADD PRIMARY KEY (`savjetovanje_id`),
  ADD KEY `fk_savjetovanje_korisnik1_idx` (`stranka_id`),
  ADD KEY `fk_savjetovanje_korisnik2_idx` (`odvjetnik_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `sudski`
--
ALTER TABLE `sudski`
  ADD PRIMARY KEY (`sudski_id`),
  ADD KEY `fk_sudski_korisnik1_idx` (`tuzitelj_id`),
  ADD KEY `fk_sudski_status1_idx` (`status_id`),
  ADD KEY `fk_sudski_kategorija1_idx` (`kategorija_id`);

--
-- Indexes for table `uloga`
--
ALTER TABLE `uloga`
  ADD PRIMARY KEY (`uloga_id`);

--
-- Indexes for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD PRIMARY KEY (`zahtjev_id`),
  ADD KEY `fk_zahtjev_sudski1_idx` (`sudski_id`),
  ADD KEY `fk_zahtjev_korisnik1_idx` (`stranka_id`),
  ADD KEY `fk_zahtjev_korisnik2_idx` (`odvjetnik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dnevnik`
--
ALTER TABLE `dnevnik`
  MODIFY `dnevnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `kategorija_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `korisnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `radnja`
--
ALTER TABLE `radnja`
  MODIFY `radnja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `savjetovanje`
--
ALTER TABLE `savjetovanje`
  MODIFY `savjetovanje_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sudski`
--
ALTER TABLE `sudski`
  MODIFY `sudski_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `uloga`
--
ALTER TABLE `uloga`
  MODIFY `uloga_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `zahtjev`
--
ALTER TABLE `zahtjev`
  MODIFY `zahtjev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD CONSTRAINT `fk_dnevnik_korisnik1` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dnevnik_radnja1` FOREIGN KEY (`radnja_id`) REFERENCES `radnja` (`radnja_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `fk_korisnik_uloga1` FOREIGN KEY (`uloga_uloga_id`) REFERENCES `uloga` (`uloga_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `moderator_kategorije`
--
ALTER TABLE `moderator_kategorije`
  ADD CONSTRAINT `fk_moderator_kategorije_kategorija` FOREIGN KEY (`modkategorija_id`) REFERENCES `kategorija` (`kategorija_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_moderator_kategorije_korisnik1` FOREIGN KEY (`modmoderator_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `savjetovanje`
--
ALTER TABLE `savjetovanje`
  ADD CONSTRAINT `fk_savjetovanje_korisnik1` FOREIGN KEY (`stranka_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_savjetovanje_korisnik2` FOREIGN KEY (`odvjetnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sudski`
--
ALTER TABLE `sudski`
  ADD CONSTRAINT `fk_sudski_kategorija1` FOREIGN KEY (`kategorija_id`) REFERENCES `kategorija` (`kategorija_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sudski_korisnik1` FOREIGN KEY (`tuzitelj_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sudski_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD CONSTRAINT `fk_zahtjev_korisnik1` FOREIGN KEY (`stranka_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_zahtjev_korisnik2` FOREIGN KEY (`odvjetnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_zahtjev_sudski1` FOREIGN KEY (`sudski_id`) REFERENCES `sudski` (`sudski_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lut 2019, 18:30
-- Wersja serwera: 10.1.37-MariaDB
-- Wersja PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_pracownika` int(11) NOT NULL,
  `imie` varchar(128) COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(128) COLLATE utf8_bin NOT NULL,
  `FK_typ_uzytkownika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int(11) NOT NULL,
  `nazwa` varchar(128) COLLATE utf8_bin NOT NULL,
  `nazwa_img` varchar(128) COLLATE utf8_bin NOT NULL,
  `cena` double(10,2) NOT NULL,
  `ilosc_magazyn` int(11) NOT NULL,
  `FK_typ_produktu` int(11) NOT NULL,
  `promocja` int(11) DEFAULT NULL,
  `FK_id_rodzaj` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produktu`, `nazwa`, `nazwa_img`, `cena`, `ilosc_magazyn`, `FK_typ_produktu`, `promocja`, `FK_id_rodzaj`) VALUES
(2, 'JOSERA-Kids-2x15kg', 'JOSERA-Kids-2x15kg.jpg', 826.65, 14, 5, 5, 5),
(3, 'Carnilove-Salmon-Turkey-for-Large-Breed-Puppy-12kg', 'Carnilove-Salmon-Turkey-for-Large-Breed-Puppy-12kg.jpg', 99.99, 34, 5, 0, 5),
(4, 'EUKANUBA-Adult-Large-Breed-Lamb-Rice-2x12kg', 'EUKANUBA-Adult-Large-Breed-Lamb-Rice-2x12kg.jpg', 110.63, 60, 3, 2, 1),
(5, 'FITMIN-For-Life-Junior-Large-Breeds-3kg', 'FITMIN-For-Life-Junior-Large-Breeds-3kg.jpg', 35.00, 152, 2, 5, 1),
(6, 'HILLS-SP-Science-Plan-Canine-Adult-Advanced-Fitness-Large-Breed-Kurczak-12kg', 'HILLS-SP-Science-Plan-Canine-Adult-Advanced-Fitness-Large-Breed-Kurczak-12kg.jpg', 75.00, 77, 5, 0, 1),
(7, 'PURINA-Dog-Chow-Puppy-Large-Breed-Turkey-2-5kg', 'PURINA-Dog-Chow-Puppy-Large-Breed-Turkey-2-5kg.jpg', 49.99, 99, 3, 0, 1),
(8, 'ROYAL-CANIN-Mini-Adult-8kg-karma-sucha-dla-psow-doroslych-ras-malych', 'ROYAL-CANIN-Mini-Adult-8kg-karma-sucha-dla-psow-doroslych-ras-malych.jpg', 90.00, 11, 3, 10, 1),
(9, 'TROPIDOG-SUPER-PREMIUM-ADULT-MEDIUM-LARGE-BREED-LAMB-WITH-RICE-15kg', 'TROPIDOG-SUPER-PREMIUM-ADULT-MEDIUM-LARGE-BREED-LAMB-WITH-RICE-15kg.png', 120.99, 33, 1, 0, 1),
(10, 'TROPIDOG-SUPER-PREMIUM-JUNIOR-MEDIUM-LARGE-BREED-TURKEY-SALMON-EGGS-15kg', 'TROPIDOG-SUPER-PREMIUM-JUNIOR-MEDIUM-LARGE-BREED-TURKEY-SALMON-EGGS-15kg.png', 99.99, 12, 1, 0, 1),
(11, 'BRIT-CARE-Adult-Large-Breed-Lamb-Rice-12kg', 'BRIT-CARE-Adult-Large-Breed-Lamb-Rice-12kg.jpg', 125.99, 55, 1, 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzaj_produktu`
--

CREATE TABLE `rodzaj_produktu` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `rodzaj_produktu`
--

INSERT INTO `rodzaj_produktu` (`id`, `nazwa`) VALUES
(5, 'Akwarystyka'),
(3, 'Gryzonie'),
(2, 'KOT'),
(1, 'Pies'),
(4, 'Ptaki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_produktu`
--

CREATE TABLE `typ_produktu` (
  `id_typ_produktu` int(11) NOT NULL,
  `typ_produktu` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `typ_produktu`
--

INSERT INTO `typ_produktu` (`id_typ_produktu`, `typ_produktu`) VALUES
(3, 'Akcesoria'),
(5, 'Karma mokra'),
(1, 'Karma sucha'),
(4, 'Przekąski'),
(2, 'Zabawka');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_uzytkownika`
--

CREATE TABLE `typ_uzytkownika` (
  `id_typ_uzytkownika` int(11) NOT NULL,
  `typ` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `typ_uzytkownika`
--

INSERT INTO `typ_uzytkownika` (`id_typ_uzytkownika`, `typ`) VALUES
(2, 'Administrator'),
(4, 'Firma'),
(3, 'Osoba prywatna'),
(1, 'Pracownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) NOT NULL,
  `login` varchar(128) COLLATE utf8_bin NOT NULL,
  `haslo` varchar(128) COLLATE utf8_bin NOT NULL,
  `imie` varchar(128) COLLATE utf8_bin NOT NULL,
  `nazwisko` varchar(128) COLLATE utf8_bin NOT NULL,
  `miasto` varchar(128) COLLATE utf8_bin NOT NULL,
  `ulica` varchar(128) COLLATE utf8_bin NOT NULL,
  `kod` varchar(128) COLLATE utf8_bin NOT NULL,
  `email` varchar(128) COLLATE utf8_bin NOT NULL,
  `telefon` int(11) DEFAULT NULL,
  `FK_typ_uzytkownika` int(11) NOT NULL,
  `nazwa_firmy` varchar(128) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `login`, `haslo`, `imie`, `nazwisko`, `miasto`, `ulica`, `kod`, `email`, `telefon`, `FK_typ_uzytkownika`, `nazwa_firmy`) VALUES
(6, 'psa2', 'psa2', 'bartek', 'kowalski', 'gliwice', 'jakas', '02-452', 'ewqcj8903@gmail.com', NULL, 4, NULL),
(7, 'test12', 'sd', 'justyna', 'lewtak', 'kraków', 'zygmuntowska', '09-432', 'saj903@gmail.com', NULL, 3, NULL),
(8, 'psa', 'psa', '', '', '', '', '', 'asadasda@gmail.com', NULL, 2, NULL),
(9, 'psaewqeqw', 'psa', '', '', '', '', '', 'abc@gmail.com', NULL, 2, NULL),
(10, 'test11', 'test11', 'Marek', 'Zarzycki', 'Zabrze', 'pilsuckiego', '54-654', 'asdasdd@gmail.com', NULL, 3, NULL),
(12, 'asdasasd', 'adsada', '', '', '', '', '', 'asdadasdasd@gmail.com', NULL, 2, NULL),
(13, 'dfdafsdfdsf', 'dfdafsdfdsf', 'Paweł', 'Sajnaj', 'Warszawa', 'Skrajna', '03-209', '8903@gmail.com', 1254586523, 3, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie`
--

CREATE TABLE `zamowienie` (
  `id_zamowienie` int(11) NOT NULL,
  `FK_id_uzytkownika` int(11) NOT NULL,
  `czy_zaplacone` float(10,2) NOT NULL,
  `data_zamowienia` date NOT NULL,
  `koszt_zamowienia` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie_produkty`
--

CREATE TABLE `zamowienie_produkty` (
  `FK_id_zamowienia` int(11) NOT NULL,
  `FK_id_produktu` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_pracownika`),
  ADD KEY `FK_typ_uzytkownika` (`FK_typ_uzytkownika`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produktu`),
  ADD KEY `FK_typ_produktu` (`FK_typ_produktu`),
  ADD KEY `FK_id_rodzaj` (`FK_id_rodzaj`);

--
-- Indeksy dla tabeli `rodzaj_produktu`
--
ALTER TABLE `rodzaj_produktu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nazwa` (`nazwa`);

--
-- Indeksy dla tabeli `typ_produktu`
--
ALTER TABLE `typ_produktu`
  ADD PRIMARY KEY (`id_typ_produktu`),
  ADD UNIQUE KEY `typ_produktu` (`typ_produktu`);

--
-- Indeksy dla tabeli `typ_uzytkownika`
--
ALTER TABLE `typ_uzytkownika`
  ADD PRIMARY KEY (`id_typ_uzytkownika`),
  ADD UNIQUE KEY `typ` (`typ`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `FK_typ_uzytkownika` (`FK_typ_uzytkownika`);

--
-- Indeksy dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`id_zamowienie`),
  ADD KEY `FK_id_uzytkownika` (`FK_id_uzytkownika`);

--
-- Indeksy dla tabeli `zamowienie_produkty`
--
ALTER TABLE `zamowienie_produkty`
  ADD KEY `FK_id_produktu` (`FK_id_produktu`),
  ADD KEY `FK_id_zamowienia` (`FK_id_zamowienia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `rodzaj_produktu`
--
ALTER TABLE `rodzaj_produktu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `typ_produktu`
--
ALTER TABLE `typ_produktu`
  MODIFY `id_typ_produktu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `typ_uzytkownika`
--
ALTER TABLE `typ_uzytkownika`
  MODIFY `id_typ_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `id_zamowienie` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`FK_typ_uzytkownika`) REFERENCES `typ_uzytkownika` (`id_typ_uzytkownika`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`FK_typ_produktu`) REFERENCES `typ_produktu` (`id_typ_produktu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `produkty_ibfk_2` FOREIGN KEY (`FK_id_rodzaj`) REFERENCES `rodzaj_produktu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD CONSTRAINT `uzytkownicy_ibfk_1` FOREIGN KEY (`FK_typ_uzytkownika`) REFERENCES `typ_uzytkownika` (`id_typ_uzytkownika`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD CONSTRAINT `zamowienie_ibfk_1` FOREIGN KEY (`FK_id_uzytkownika`) REFERENCES `uzytkownicy` (`id_uzytkownika`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `zamowienie_produkty`
--
ALTER TABLE `zamowienie_produkty`
  ADD CONSTRAINT `zamowienie_produkty_ibfk_1` FOREIGN KEY (`FK_id_produktu`) REFERENCES `produkty` (`id_produktu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `zamowienie_produkty_ibfk_2` FOREIGN KEY (`FK_id_zamowienia`) REFERENCES `zamowienie` (`id_zamowienie`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

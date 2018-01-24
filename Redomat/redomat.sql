-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2016 at 10:29 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redomat`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calculate` (`id` NUMERIC) RETURNS TIME BEGIN
    DECLARE vrpo time;
    DECLARE vrza time;
    DECLARE rez time;
    DECLARE old time;
	DECLARE sifra numeric;
    
    select vrijeme_pocetka from obrada where broj_korisnik=id into vrpo;
	select vrijeme_zavrsetka from obrada where broj_korisnik=id into vrza;
    select sifra_aktivnost from obrada where broj_korisnik=id into sifra;
    select prosjek_aktivnost from aktivnost where sifra_aktivnost=sifra into old;
    set rez=TIME_TO_SEC(vrza)-TIME_TO_SEC(vrpo);
    if
		old>0
	then
		update aktivnost set prosjek_aktivnost=(old+rez)/2 where sifra_aktivnost=sifra;
	else
		update aktivnost set prosjek_aktivnost=TIME_TO_SEC(rez) where sifra_aktivnost=sifra;
	end if;
 RETURN (rez);
 END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `checkOIB` (`oib2` VARCHAR(11)) RETURNS TINYINT(1) BEGIN
    DECLARE vri time;
	declare rez boolean;
	select vrijeme_pocetka from obrada where oib=oib2 order by broj_korisnik desc limit 1 into vri;
    if
		vri is null
	then
		set rez=true;
	else
		set rez=false;
	end if;
 RETURN (rez);
 END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `compare` (`newdatum` DATETIME) RETURNS TINYINT(1) BEGIN
    DECLARE sifra numeric;
    DECLARE datum1 DATETIME;
    DECLARE result boolean;
    select max(broj_korisnik) from obrada into sifra;
    select datum from obrada where broj_korisnik=sifra into datum1;
    if
		newdatum=datum1 then
        set result=1;
    else
		set result=0;
    END IF;
    
 RETURN (result);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `get_current_number` () RETURNS INT(11) BEGIN
  DECLARE br INT;
  select max(sifra) from obrada into br;
  return br;
  
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `new_start` () RETURNS INT(11) begin
        return (select max(sifra) from obrada);
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `aktivnost`
--

CREATE TABLE `aktivnost` (
  `sifra_aktivnost` int(11) NOT NULL,
  `naziv_aktivnost` varchar(40) DEFAULT NULL,
  `prosjek_aktivnost` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aktivnost`
--

INSERT INTO `aktivnost` (`sifra_aktivnost`, `naziv_aktivnost`, `prosjek_aktivnost`) VALUES
(1, 'Izdaja potvrdi o praksi', '8'),
(2, 'Preuzimanje Dokumenata', '0'),
(3, 'Upis telematika', '0'),
(4, 'Ispis telematika', '0');

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `broj` int(11) NOT NULL,
  `oib` varchar(11) NOT NULL DEFAULT '',
  `satus` tinyint(1) DEFAULT NULL,
  `zadaca` decimal(10,0) DEFAULT NULL,
  `pocetak` time DEFAULT NULL,
  `kraj` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`broj`, `oib`, `satus`, `zadaca`, `pocetak`, `kraj`) VALUES
(1, '22222', NULL, NULL, NULL, NULL),
(2, '222', NULL, NULL, NULL, NULL),
(3, '233', NULL, NULL, NULL, NULL),
(4, '2', NULL, NULL, NULL, NULL),
(5, '234', NULL, NULL, NULL, NULL),
(6, '2', NULL, NULL, NULL, NULL),
(7, '55', NULL, NULL, NULL, NULL),
(8, '3', NULL, NULL, NULL, NULL),
(9, '999', NULL, NULL, NULL, NULL),
(10, '222', NULL, NULL, NULL, NULL),
(11, '33', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `obrada`
--

CREATE TABLE `obrada` (
  `broj_korisnik` int(11) NOT NULL,
  `sifra_aktivnost` int(11) DEFAULT NULL,
  `vrijeme_pocetka` time DEFAULT NULL,
  `vrijeme_zavrsetka` time DEFAULT NULL,
  `status_obrade` tinyint(1) DEFAULT NULL,
  `oib` varchar(12) DEFAULT NULL,
  `korisnicko_ime` varchar(20) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `broj` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obrada`
--

INSERT INTO `obrada` (`broj_korisnik`, `sifra_aktivnost`, `vrijeme_pocetka`, `vrijeme_zavrsetka`, `status_obrade`, `oib`, `korisnicko_ime`, `datum`, `broj`) VALUES
(1, 1, '09:31:04', '09:31:06', 1, '123', 'salter3', '2015-05-27 00:00:00', '1'),
(2, 1, '09:33:16', '09:33:30', 1, '123', 'salter3', '2015-05-27 00:00:00', '2'),
(3, 1, '12:46:22', '12:46:26', 1, '123', 'salter3', '2015-05-30 00:00:00', '1'),
(6, 1, '12:48:26', '12:48:40', 1, '123', 'salter3', '2015-05-30 00:00:00', '2'),
(7, 1, '15:20:56', '15:22:54', 1, '123', 'salter3', '2015-05-30 00:00:00', '3'),
(8, 1, '15:24:20', '15:24:32', 1, '123', 'salter3', '2015-05-30 00:00:00', '4'),
(9, 1, '15:24:42', '15:25:12', 1, '123', 'salter3', '2015-05-30 00:00:00', '5'),
(10, 1, '15:28:41', '15:28:52', 1, '123', 'salter3', '2015-05-30 00:00:00', '6'),
(11, 1, '15:30:08', '15:30:28', 1, '123', 'salter3', '2015-05-30 00:00:00', '7'),
(12, 1, '09:49:44', '09:50:02', 1, '123', 'salter3', '2015-05-30 00:00:00', '8'),
(13, 1, '09:58:18', '09:58:25', 1, '1234', 'salter3', '2015-06-02 00:00:00', '1'),
(14, 1, '09:59:18', '10:00:00', 1, 'kokok', 'salter3', '2015-06-02 00:00:00', '2'),
(15, 1, '10:02:41', '10:02:59', 1, '123555', 'salter3', '2015-06-02 00:00:00', '3'),
(16, 1, '10:04:31', '10:04:40', 1, '123456', 'salter3', '2015-06-02 00:00:00', '4'),
(17, 1, NULL, NULL, NULL, '123456789', NULL, '2015-06-02 00:00:00', '5'),
(18, 1, '12:08:40', '12:08:44', 1, '12312312312', 'salter1', '2016-04-17 00:00:00', '1'),
(19, 1, '12:08:46', '12:08:49', 1, '12345678911', 'salter1', '2016-04-17 00:00:00', '2'),
(20, 1, '16:29:01', '16:29:09', 1, '12312312312', 'salter1', '2016-04-17 00:00:00', '3'),
(21, 1, '16:29:12', NULL, 1, '12312312311', 'salter1', '2016-04-17 00:00:00', '4');

--
-- Triggers `obrada`
--
DELIMITER $$
CREATE TRIGGER `broj` BEFORE INSERT ON `obrada` FOR EACH ROW begin
			Declare sifra numeric;
            Declare br numeric;
            select max(broj_korisnik) from obrada into sifra;
            select broj from obrada where broj_korisnik=sifra into br;
            if
				compare(new.datum)=1
			then
				set new.broj=br+1;
			else
				set new.broj=1;
			end if;
		end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `st` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stat`
--

INSERT INTO `stat` (`st`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `zaposlenik`
--

CREATE TABLE `zaposlenik` (
  `korisnicko_ime` varchar(20) NOT NULL DEFAULT '',
  `salter` int(11) DEFAULT NULL,
  `lozinka` varchar(20) DEFAULT NULL,
  `status_rada` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zaposlenik`
--

INSERT INTO `zaposlenik` (`korisnicko_ime`, `salter`, `lozinka`, `status_rada`) VALUES
('salter1', 1, 'salter1', 0),
('salter2', 2, 'salter2', 0),
('salter3', 3, 'salter3', 0),
('salter4', 4, 'salter4', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivnost`
--
ALTER TABLE `aktivnost`
  ADD PRIMARY KEY (`sifra_aktivnost`);

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`broj`,`oib`);

--
-- Indexes for table `obrada`
--
ALTER TABLE `obrada`
  ADD PRIMARY KEY (`broj_korisnik`),
  ADD KEY `Vanjski` (`korisnicko_ime`);

--
-- Indexes for table `zaposlenik`
--
ALTER TABLE `zaposlenik`
  ADD PRIMARY KEY (`korisnicko_ime`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivnost`
--
ALTER TABLE `aktivnost`
  MODIFY `sifra_aktivnost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `broj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `obrada`
--
ALTER TABLE `obrada`
  MODIFY `broj_korisnik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `obrada`
--
ALTER TABLE `obrada`
  ADD CONSTRAINT `Vanjski` FOREIGN KEY (`korisnicko_ime`) REFERENCES `zaposlenik` (`korisnicko_ime`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

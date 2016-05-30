-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: oniddb
-- Generation Time: May 30, 2016 at 02:38 PM
-- Server version: 5.5.49
-- PHP Version: 5.2.6-1+lenny16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hillyers-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE IF NOT EXISTS `candidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `party_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_party_id` (`party_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `fname`, `lname`, `party_id`) VALUES
(1, 'Hillary', 'Clinton', 1),
(2, 'Bernie', 'Sanders', 1),
(3, 'Martin', 'O\'Malley', 1),
(4, 'Lawrence', 'Lessig', 1),
(5, 'Lincoln', 'Chafee', 1),
(6, 'Jim', 'Webb', 1),
(8, 'Donald', 'Trump', 2),
(9, 'John', 'Kasich', 2),
(10, 'Ted', 'Cruz', 2),
(11, 'Marco', 'Rubio', 2),
(12, 'Ben', 'Carson', 2),
(13, 'Jeb', 'Bush', 2),
(14, 'Jim', 'Gilmore', 2),
(15, 'Chris', 'Christie', 2),
(16, 'Carly', 'Fiorina', 2),
(17, 'Rick', 'Santorum', 2),
(18, 'Rand', 'Paul', 2),
(19, 'Mike', 'Huckabee', 2),
(20, 'George', 'Pataki', 2),
(21, 'Lindsey', 'Graham', 2),
(22, 'Bobby', 'Jindal', 2),
(23, 'Scott', 'Walker', 2),
(24, 'Rick', 'Perry', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `party` (`id`);

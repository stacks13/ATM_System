-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2019 at 05:07 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atm_system`
--
CREATE DATABASE IF NOT EXISTS `atm_system` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `atm_system`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deposit` (IN `card_n` INT, IN `acc_no` INT, IN `amount` INT, IN `atm_n` INT, OUT `status` INT, IN `com` VARCHAR(20))  MODIFIES SQL DATA
BEGIN
    DECLARE bal int;
    
    
    
    SELECT accounts.balance INTO bal
    FROM accounts
    WHERE accounts.account_no = acc_no;
 
   	START TRANSACTION;
    
   	INSERT INTO transactions
    VALUES (uuid(), com, card_n, amount, atm_n, now());
    
    UPDATE accounts
    SET accounts.balance=accounts.balance+amount
    WHERE accounts.account_no = acc_no;
    
    UPDATE atms
    SET atms.current_cash=atms.current_cash+amount
    WHERE atms.atm_no = atm_n;
    
    COMMIT;
    SET status = 0;

	INSERT INTO transaction_logs
    VALUES ('DEPOSIT', atm_n, card_n, now(), status);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdraw` (IN `amount` INT, IN `acc_no` INT, IN `atm_n` INT, IN `card_n` INT, OUT `status` INT, IN `com` VARCHAR(20))  MODIFIES SQL DATA
BEGIN
    DECLARE bal int;
    DECLARE atm_limit int;
    DECLARE atm_cash int;
 
    SELECT accounts.balance INTO bal
    FROM accounts
    WHERE accounts.account_no = acc_no;
 
 	SELECT atms.cash_limit, atms.current_cash INTO atm_limit, atm_cash
    FROM atms
    WHERE atms.atm_no = atm_n;
 
    IF amount > bal THEN
    	SET status = -2;
    ELSEIF amount > atm_limit THEN
        SET status = -3;
    ELSEIF amount > atm_cash THEN
        SET status = -4;
    ELSE
    	START TRANSACTION;
        
    	INSERT INTO transactions
        VALUES (uuid(), com, card_n, -amount, atm_n, now());
        
        UPDATE accounts
        SET accounts.balance=accounts.balance-amount
        WHERE accounts.account_no = acc_no;
        
        UPDATE atms
        SET atms.current_cash = atms.current_cash - amount
        WHERE atms.atm_no = atm_n;
        
        COMMIT;
        SET status = 0;
    END IF;
    
    INSERT INTO transaction_logs
    VALUES ('WITHDRAWAL', atm_n, card_n, now(), status);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_no` int(6) NOT NULL,
  `balance` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'CURRENT'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_holders`
--

CREATE TABLE `account_holders` (
  `customer_id` varchar(10) NOT NULL,
  `account_no` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atms`
--

CREATE TABLE `atms` (
  `atm_no` int(5) NOT NULL,
  `location` varchar(20) NOT NULL,
  `current_cash` int(11) NOT NULL DEFAULT '0',
  `cash_limit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atm_log`
--

CREATE TABLE `atm_log` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` varchar(20) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `transaction_id` varchar(10) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `card_no` int(16) NOT NULL,
  `account_no` int(6) NOT NULL,
  `pin` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` varchar(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `pan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `impression` varchar(1000) NOT NULL,
  `look_feel` int(11) NOT NULL,
  `hear` varchar(100) NOT NULL,
  `recommend` int(11) NOT NULL,
  `suggestion` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` varchar(10) NOT NULL,
  `comment` varchar(20) NOT NULL,
  `card_no` int(16) NOT NULL,
  `amount` int(10) NOT NULL,
  `atm_no` int(5) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `operation` varchar(10) NOT NULL,
  `atm_no` int(11) NOT NULL,
  `card_no` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_no`);

--
-- Indexes for table `account_holders`
--
ALTER TABLE `account_holders`
  ADD PRIMARY KEY (`customer_id`,`account_no`),
  ADD KEY `account_no` (`account_no`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `atms`
--
ALTER TABLE `atms`
  ADD PRIMARY KEY (`atm_no`);

--
-- Indexes for table `atm_log`
--
ALTER TABLE `atm_log`
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`card_no`,`account_no`),
  ADD KEY `account_no` (`account_no`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `pan` (`pan`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `atm_no` (`atm_no`),
  ADD KEY `card_no` (`card_no`);

--
-- Indexes for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD KEY `atm_no` (`atm_no`),
  ADD KEY `card_no` (`card_no`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_holders`
--
ALTER TABLE `account_holders`
  ADD CONSTRAINT `account_holders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `account_holders_ibfk_2` FOREIGN KEY (`account_no`) REFERENCES `accounts` (`account_no`);

--
-- Constraints for table `atm_log`
--
ALTER TABLE `atm_log`
  ADD CONSTRAINT `atm_log_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `atm_log_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `card_details`
--
ALTER TABLE `card_details`
  ADD CONSTRAINT `card_details_ibfk_1` FOREIGN KEY (`account_no`) REFERENCES `accounts` (`account_no`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`atm_no`) REFERENCES `atms` (`atm_no`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`card_no`) REFERENCES `card_details` (`card_no`);

--
-- Constraints for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD CONSTRAINT `transaction_logs_ibfk_1` FOREIGN KEY (`atm_no`) REFERENCES `atms` (`atm_no`),
  ADD CONSTRAINT `transaction_logs_ibfk_2` FOREIGN KEY (`card_no`) REFERENCES `card_details` (`card_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

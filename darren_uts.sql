-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 12:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darren_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `catid` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`catid`, `category`, `type`) VALUES
(1, 'Mie', 'Makanan'),
(2, 'Nasi Goreng', 'Makanan'),
(3, 'Kwetiau', 'Makanan'),
(4, 'Bakso', 'Makanan'),
(5, 'Ayam', 'Makanan'),
(6, 'Teh', 'Minuman'),
(7, 'Jus', 'Minuman'),
(8, 'Kopi', 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double NOT NULL,
  `tax` double NOT NULL,
  `discount` double NOT NULL,
  `total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `customer_name`, `order_date`, `subtotal`, `tax`, `discount`, `total`, `paid`, `due`, `payment_type`) VALUES
(1, 'Darren', '2023-11-21', 66000, 3300, 0, 69300, 70000, -700, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_details`
--

CREATE TABLE `tbl_invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_invoice_details`
--

INSERT INTO `tbl_invoice_details` (`id`, `invoice_id`, `product_id`, `product_name`, `qty`, `price`, `order_date`) VALUES
(1, 1, 21, 'Es Teh Manis', 2, 4000, '2023-11-21'),
(2, 1, 5, 'Mie Ayam', 2, 15000, '2023-11-21'),
(3, 1, 23, 'Jus Sirsak', 1, 13000, '2023-11-21'),
(4, 1, 15, 'Ayam Geprek', 1, 15000, '2023-11-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(11) NOT NULL,
  `pname` varchar(200) NOT NULL,
  `purchaseprice` float NOT NULL,
  `saleprice` float NOT NULL,
  `pstock` int(11) NOT NULL,
  `pdescription` varchar(250) NOT NULL,
  `pimage` varchar(200) NOT NULL,
  `catid` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `pname`, `purchaseprice`, `saleprice`, `pstock`, `pdescription`, `pimage`, `catid`) VALUES
(1, 'Mie Goreng', 10000, 11500, 20, 'Mie goreng adalah hidangan mi yang digoreng dengan berbagai bumbu dan bahan tambahan seperti sayuran, daging, dan telur.', '655b8ca294b7a.jpg', 1),
(2, 'Mie Kuah', 10000, 11500, 20, 'Mie kuah adalah hidangan mi yang disajikan dengan kuah kaldu yang lezat, seringkali dengan tambahan daging, sayuran, dan rempah-rempah.', '655b8ce6011c2.jpg', 1),
(3, 'Mie Aceh Goreng', 15000, 17000, 30, 'Mie Aceh goreng adalah varian mie goreng khas Aceh yang memiliki cita rasa pedas dan kaya rempah. Biasanya disajikan dengan irisan daging dan sayuran.', '655b8d6362709.jpeg', 1),
(4, 'Mie Aceh Kuah', 15000, 17000, 30, 'Mie Aceh kuah adalah varian mie kuah khas Aceh dengan kuah yang kaya rasa dan pedas. Biasanya disajikan dengan daging, sayuran, dan potongan cabai.', '655b8da826a97.jpeg', 1),
(5, 'Mie Ayam', 14000, 15000, 38, 'Mie ayam adalah hidangan mi yang disajikan dengan irisan daging ayam, kuah kaldu, dan biasanya diberi tambahan sayuran dan bumbu khusus.', '655b8de3aeca8.jpg', 1),
(6, 'Nasi Goreng Ayam', 12000, 13000, 100, 'Nasi goreng ayam adalah hidangan nasi yang digoreng dengan bumbu dan disajikan dengan potongan ayam, sayuran, telur, dan kadang-kadang diberi tambahan kecap atau sambal.', '655b8ed75ba84.jpg', 2),
(7, 'Nasi Goreng Telur', 13000, 14000, 100, 'Nasi goreng telur adalah hidangan nasi yang digoreng dengan tambahan telur dan bumbu, seringkali disajikan dengan irisan mentimun, tomat, dan bawang goreng', '655b8fdf23e52.jpeg', 2),
(8, 'Nasi Goreng Spesial', 15000, 16000, 100, 'Nasi goreng spesial adalah varian nasi goreng yang disajikan dengan berbagai tambahan seperti daging sapi, udang, sayuran, dan telur. Biasanya memiliki cita rasa yang kaya dan beragam.', '655b900aa28ff.jpg', 2),
(9, 'Nasi Goreng Gila', 16000, 17000, 100, 'Nasi goreng gila adalah varian nasi goreng yang memiliki rasa yang sangat pedas dan kuat. Biasanya disajikan dengan tambahan cabai, daging, dan bumbu khusus.', '655b902f5fcd7.jpg', 2),
(10, 'Kwetiau Goreng', 11000, 12000, 100, 'Kwetiau goreng adalah hidangan mi kwetiau yang digoreng dengan bumbu dan biasanya disajikan dengan daging, sayuran, dan kecap.', '655b9059e160d.jpg', 3),
(11, 'Kwetiau Rebus', 11000, 12000, 100, 'Kwetiau rebus adalah hidangan mi kwetiau yang dimasak dalam kuah kaldu yang lezat, biasanya dengan tambahan daging, sayuran, dan rempah-rempah.\r\n\r\n', '655b90958d0bf.jpeg', 3),
(12, 'Bakso Original', 10000, 11000, 100, 'Bakso original adalah hidangan bola daging yang terbuat dari daging sapi cincang yang diolah dengan bumbu khusus, biasanya disajikan dalam kuah kaldu dengan mie dan sayuran.', '655b90be30660.jpeg', 4),
(13, 'Bakso Mie', 12000, 13000, 100, 'Bakso mie adalah hidangan bakso yang disajikan dengan mie, biasanya dalam kuah kaldu yang lezat dan ditambahkan dengan sayuran segar.', '655b90dd6c0d6.jpg', 4),
(14, 'Bakso Urat', 14000, 16000, 100, 'Bakso urat adalah varian bakso yang mengandung urat sapi sebagai bahan utamanya. Biasanya disajikan dalam kuah kaldu dengan mie dan sayuran.', '655b910c361c7.jpg', 4),
(15, 'Ayam Geprek', 13000, 15000, 499, 'Ayam geprek adalah hidangan ayam goreng yang dihancurkan dan dilumuri dengan sambal pedas. Biasanya disajikan dengan nasi dan lauk pendamping.', '655b91374a386.jpg', 5),
(16, 'Ayam Bakar', 15000, 17000, 200, 'Ayam bakar adalah hidangan ayam yang dipanggang dengan bumbu khusus, menghasilkan cita rasa yang gurih dan kaya rempah.', '655b9158629d2.jpg', 5),
(17, 'Ayam Goreng', 11000, 13000, 200, 'Ayam goreng adalah hidangan ayam yang digoreng garing di luar namun tetap lembut di dalam. Biasanya disajikan dengan nasi dan lauk pendamping', '655b917ff2f21.jpg', 5),
(18, 'Teh Tawar', 2000, 3000, 500, 'Teh tawar adalah minuman teh tanpa tambahan gula atau pemanis lainnya, menyajikan rasa teh yang segar dan alami.', '655c19707ed62.jpg', 6),
(19, 'Teh Manis', 3000, 4000, 600, 'Teh manis adalah minuman teh yang diberi tambahan gula atau pemanis, memberikan rasa manis yang lezat. ', '655c1a2629963.jpg', 6),
(20, 'Teh Tarik', 5000, 6000, 600, 'Teh tarik adalah minuman teh khas Malaysia yang dibuat dengan cara menuangkan teh dari satu wadah ke wadah lain secara berulang, menciptakan tekstur dan rasa yang khasa. ', '655c1c4d307ea.jpg', 6),
(21, 'Es Teh Manis', 3000, 4000, 498, 'Es teh manis adalah minuman teh yang disajikan dengan es batu, memberikan sensasi dingin dan menyegarkan, sementara tetap memiliki rasa manis.', '655c1cc788e38.jpg', 6),
(22, 'Jus Alpukat', 9000, 1000, 200, 'Jus alpukat adalah minuman yang terbuat dari buah alpukat yang di-blender, menghasilkan tekstur krimi dan rasa yang lezat. Jus ini seringkali disajikan dingin.', '655c1ce6de418.jpg', 7),
(23, 'Jus Sirsak', 11000, 13000, 299, 'Jus sirsak adalah minuman yang terbuat dari buah sirsak yang di-blender, memberikan rasa segar dan asam manis yang khas.', '655c1d0c2edf8.jpeg', 7),
(24, 'Jus Mangga', 12000, 13000, 400, 'Jus mangga adalah minuman yang terbuat dari buah mangga yang di-blender, memberikan rasa manis dan segar yang khas buah mangga.', '655c1d7b83a45.jpg', 7),
(25, 'Kopi Hitam', 4000, 5000, 1000, 'Kopi hitam adalah minuman kopi yang diseduh tanpa tambahan susu atau gula, menghasilkan rasa kopi yang pekat dan kaya.', '655c1dc709d71.jpg', 8),
(26, 'Kopi Espresso', 7000, 8000, 1000, 'Kopi espresso adalah minuman kopi yang dibuat dengan mengekstrak kopi dengan tekanan tinggi, menghasilkan cairan kopi kental dengan rasa yang kuat.', '655c1dec479f7.jpg', 8),
(27, 'Kopi Americano', 8000, 9000, 1000, 'Kopi americano adalah minuman kopi yang terbuat dari espresso yang diencerkan dengan air panas, menghasilkan rasa kopi yang lebih ringan.', '655c1e46ef38e.jpg', 8),
(28, 'Kopi Capuccino', 9000, 10000, 1000, 'Kopi cappuccino adalah minuman kopi yang terdiri dari espresso, susu steamed, dan busa susu. Kopi ini memiliki rasio yang seimbang antara espresso, susu, dan busa susu, menciptakan minuman kopi yang kaya, lembut, dan berbusa.', '655c1e6506705.jpg', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `useremail`, `password`, `role`, `profile_image`) VALUES
(1, 'Darren Arqiarkaan', 'darren@gmail.com', '$2y$10$yZnvUU6LYvOql99Tog5dZO51f0gMAsLcFqpLBi6c55uxxDHu7uLpq', 'Admin', '655c623bbdd5e.jpg'),
(2, 'Darren Versi User', 'user@gmail.com', '$2y$10$t1Z6pwyyxGpDPsKOt0TbPuWDl4TSi2h6ZhAv6BE/2yWYy6JsB5Vpi', 'User', '655c62875c94b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `catid` (`catid`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `catid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_invoice_details`
--
ALTER TABLE `tbl_invoice_details`
  ADD CONSTRAINT `tbl_invoice_details_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice` (`invoice_id`),
  ADD CONSTRAINT `tbl_invoice_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`pid`);

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `tbl_category` (`catid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

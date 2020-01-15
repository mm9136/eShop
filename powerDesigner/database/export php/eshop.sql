-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2020 at 12:42 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `adress` text NOT NULL,
  `phone_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyer_id`, `user_id`, `adress`, `phone_number`) VALUES
(6, 9, 'mika', 'mika');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cartitem_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`cartitem_id`, `order_id`, `product_id`, `quantity`) VALUES
(87, 39, 21, 4),
(88, 40, 22, 4),
(89, 40, 23, 1),
(90, 41, 22, 1),
(91, 42, 21, 1),
(92, 42, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `buyer_id`, `status_id`, `total`, `date`) VALUES
(39, 6, 3, '2000.00', '2020-01-11 08:20:16'),
(40, 6, 3, '3250.00', '2020-01-11 09:24:08'),
(41, 6, 4, '700.00', '2020-01-11 09:24:28'),
(42, 6, 2, '1400.00', '2020-01-11 09:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `description`, `active`) VALUES
(21, 'HP LAPTOP', '500.00', 'Pavilion 15-ay061nm, CELERON N3060Â DUAL, 4GB DDR3L 1DM, HDD 500GB 5400RPM FIXED, INTEL HD GRAPHICS - UMA, 15.6 HD BRIGHTVIEW SLIM SVA, TURBO SILVER ', 1),
(22, 'DELL LAPTOP', '700.00', 'Features: 15.6 inch Full Truelife LED backlit (1366 x 768) High Performance 7th Gen Intel Core i5-7200U processor (3MB Cache, up to 3.10 GHz) 8GB DDR4', 1),
(23, 'Laptop Lenovo', '450.00', 'System Technologies - offering Backpack Lenovo Ip130 Lenovo Sub-Gaming Ip130 Notebook, Screen Size: 15.6\'\' Fhd 180, Battery Type: Lithium at Rs 58000/piece in Ahmednagar, Maharashtra.', 1),
(24, 'Laptop Asus', '600.00', 'Laptop ASUS X550L , Silver color, 15,6\", Processor intel core i7 4500U / 1.8 GHz, 8Go RAM, Windows 10, Battery chargor included, Mat screen', 1),
(25, 'ALIENWARE laptop', '2000.00', 'Alienware M15 R2 Custom Built VR Ready Thin and Light Gaming Laptop - 15.6\" Full HD (1920x1080) 60Hz - w/ nVIDIA RTX 2060 - Intel \"Coffee Lake\"', 1),
(26, 'RAZEN laptop', '700.00', 'Wholesale Razer Blade Pro 17: Gaming Laptop - 4k Touchscreen - Ulp Mechanical Keyboard - Intel Quad-core Overclocked I7-7820hk', 1),
(27, 'APPLE MACBOOK', '1200.00', 'Apple 16\" MacBook Pro with Touch Bar, 9th-Gen 6-Core Intel Core i7 2.6GHz, 16GB RAM, 512GB SSD, AMD Radeon Pro 5300M 4GB, Space Gray, Late 2019', 1),
(28, 'APPLE MACBOOK', '2100.00', 'Apple 16\" MacBook Pro with Touch Bar, 9th-Gen 6-Core Intel Core i7 2.6GHz, 16GB RAM, 512GB SSD, AMD Radeon Pro 5300M 4GB, Space Gray, Late 2019', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `rate_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'BUYER'),
(3, 'SELLER');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `name`) VALUES
(1, 'Potvrdjen'),
(2, 'Otkazan'),
(3, 'Storniran'),
(4, 'Na čekanju'),
(5, 'Kreiran');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `adress` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `name`, `adress`) VALUES
(1, 'Magacin Niš', 'Niš');

-- --------------------------------------------------------

--
-- Table structure for table `stockitem`
--

CREATE TABLE `stockitem` (
  `stock_item_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stockitem`
--

INSERT INTO `stockitem` (`stock_item_id`, `product_id`, `stock_id`, `quantity`) VALUES
(21, 21, 1, 13),
(22, 22, 1, 8),
(23, 23, 1, 6),
(24, 24, 1, 0),
(25, 25, 1, 0),
(26, 26, 1, 0),
(27, 27, 1, 0),
(28, 28, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `salt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role_id`, `firstname`, `lastname`, `email`, `password`, `active`, `salt`) VALUES
(1, 1, 'Mila', 'Marinkovic', 'milamarinkovic998@gmail.com', '50a58475dcf49c336d3b71a55f75a805ab05f06e9d920afebe5713030a191618', 1, '4313178056edce7c'),
(8, 3, 'Jovana', 'Jovic', 'jovana@gmail.com', '3e9cd8b732b6573aaab775c9afb9593c20c2f9fb4f5e526bb258e2318279b240', 1, '207f201148725e6b'),
(9, 2, 'Mika', 'Mikic', 'mika@gmail.com', '751187ec529bc99ac6828a98488917dbfdd2cc2e32088cb902ae43b5cb11bc10', 1, '78c5f704658b9c95');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyer_id`),
  ADD KEY `FK_FK_user_buyer2` (`user_id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cartitem_id`),
  ADD KEY `FK_FK_order_cart` (`order_id`),
  ADD KEY `FK_FK_product_cartItem` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_FK_buyer_order` (`buyer_id`),
  ADD KEY `FK_FK_status_order` (`status_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`rate_id`),
  ADD KEY `FK_FK_rate_product` (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `stockitem`
--
ALTER TABLE `stockitem`
  ADD PRIMARY KEY (`stock_item_id`),
  ADD KEY `FK_FK_stock_stockItem` (`stock_id`),
  ADD KEY `FK_Fk_produst_stockItem` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `FK_FK_role_user` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cartitem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stockitem`
--
ALTER TABLE `stockitem`
  MODIFY `stock_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buyer`
--
ALTER TABLE `buyer`
  ADD CONSTRAINT `FK_FK_user_buyer2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `FK_FK_order_cart` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `FK_FK_product_cartItem` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_FK_buyer_order` FOREIGN KEY (`buyer_id`) REFERENCES `buyer` (`buyer_id`),
  ADD CONSTRAINT `FK_FK_status_order` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `FK_FK_rate_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `stockitem`
--
ALTER TABLE `stockitem`
  ADD CONSTRAINT `FK_FK_stock_stockItem` FOREIGN KEY (`stock_id`) REFERENCES `stock` (`stock_id`),
  ADD CONSTRAINT `FK_Fk_produst_stockItem` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_FK_role_user` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

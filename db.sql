-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql301.infinityfree.com
-- Generation Time: Jun 28, 2024 at 05:18 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_35552496_t1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `user_city` varchar(255) DEFAULT NULL,
  `user_postal_code` varchar(10) DEFAULT NULL,
  `user_barangay` varchar(255) DEFAULT NULL,
  `user_street` varchar(255) DEFAULT NULL,
  `user_cell_number` varchar(20) DEFAULT NULL,
  `user_email_address` varchar(255) DEFAULT NULL,
  `isRemovable` tinyint(1) DEFAULT NULL,
  `status` enum('Processing','Shipping','Delivered') DEFAULT 'Processing',
  `expected_delivery_date` date DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `isRated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_category` enum('apparel','uniform','accessories','collectibles') NOT NULL,
  `product_link` varchar(500) NOT NULL,
  `product_isFeatured` tinyint(1) DEFAULT NULL,
  `avg_ratings` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`product_id`, `product_name`, `product_description`, `product_image`, `product_price`, `product_category`, `product_link`, `product_isFeatured`, `avg_ratings`) VALUES
(1, '2023 T1 Uniform Worlds Jersey', 'Unleash the champion within with the exclusive 2023 T1 Uniform Worlds Jersey. Designed for esports enthusiasts and T1 fans alike, this jersey embodies the spirit of competition and the legacy of excellence that T1 represents.', 'img/uniform/2023t1uniformworldsjersey.jpg', '4600.00', 'uniform', 'uniform/2023-T1-Uniform-Worlds-Jersey.php', 1, 5),
(2, '2023 T1 Thunder Stick', 'Experience the thunderous energy with the 2023 T1 Thunder Stick. Perfect for cheering on your favorite esports team at live events.', 'img/accessories/2023 t1 thunder stick.png', '2500.00', 'accessories', 'accessories/2023-T1-Thunder-Stick.php', 0, NULL),
(3, 'Dash Bag T1 Version', 'Carry your essentials in style with the Dash Bag T1 Version. Designed with T1 flair, it\'s the perfect companion for your daily adventures.', 'img/accessories/Dash Bag T1 version.jpg', '1500.00', 'accessories', 'accessories/Dash-Bag-T1-Version.php', 0, 3),
(4, 'Delight Bag T1 Version', 'Discover delight in every detail with the Delight Bag T1 Version. Functional and fashionable, it\'s a must-have for T1 enthusiasts.', 'img/accessories/Delight Bag T1 version.jpg', '1800.00', 'accessories', 'accessories/Delight-Bag-T1-Version.php', 0, NULL),
(5, 'T1 2023 Worlds Edition Ready Bag', 'Gear up for victory with the T1 2023 Worlds Edition Ready Bag. Designed for esports enthusiasts, this bag is ready for any adventure.', 'img/accessories/T1 2023 Worlds Edition Ready Bag.jpg', '3000.00', 'accessories', 'accessories/2023-T1-Worlds-Edition-Ready-Bag.php', 0, NULL),
(6, 'T1 Facemask', 'Stay protected with style using the T1 Facemask. Emblazoned with the iconic T1 logo, it\'s a statement of both safety and fandom.', 'img/accessories/T1 Facemask.png', '500.00', 'accessories', 'accessories/T1-Facemask.php', 0, NULL),
(7, 'T1 Logo Ball Cap - Black', 'Sport the sleek T1 Logo Ball Cap in Black. Whether at an esports event or out and about, this cap showcases your T1 pride in every step.', 'img/accessories/T1 Logo Ball Cap - Black.jpg', '800.00', 'accessories', 'accessories/T1-Logo-Ball-Cap-Black.php', 0, NULL),
(8, 'T1 Tote Bag', 'Carry your essentials with elegance using the T1 Tote Bag. A perfect blend of style and functionality, this tote is a must-have for T1 supporters.', 'img/accessories/T1 Tote Bag.jpg', '1200.00', 'accessories', 'accessories/T1-Tote-Bag.php', 0, NULL),
(9, 'T1 Watch Black Phantom', 'Elevate your style with the T1 Watch Black Phantom. This timepiece combines sophistication and esports passion for the ultimate accessory.', 'img/accessories/T1 Watch Black Phantom.jpg', '2800.00', 'accessories', 'accessories/T1-Watch-Black-Phantom.php', 0, NULL),
(10, 'T1 Watch Red Dragon', 'Complete your look with the T1 Watch Red Dragon. This sleek timepiece is a statement of T1 elegance and commitment to excellence.', 'img/accessories/T1 Watch Red Dragon.jpg', '3200.00', 'accessories', 'accessories/T1-Watch-Red-Dragon.php', 1, 5),
(11, '[T1 X MASTERCARD] Essential Applique Hoodie - Black', 'Elevate your style with the [T1 X MASTERCARD] Essential Applique Hoodie in Black. This hoodie combines comfort and fashion, making it a must-have for T1 fans.', 'img/apparel/[T1 X MASTERCARD] Essential Applique Hoodie - Black.jpg', '3500.00', 'apparel', 'apparel/[T1-X-MASTERCARD]-Essential-Applique-Hoodie-Black.php', 0, NULL),
(12, '[T1 X MASTERCARD] Essential Applique Hoodie - Grey', 'Stay cozy in style with the [T1 X MASTERCARD] Essential Applique Hoodie in Grey. Perfect for chilly days, this hoodie showcases your T1 pride.', 'img/apparel/[T1 X MASTERCARD] Essential Applique Hoodie - Grey.jpg', '3500.00', 'apparel', 'apparel/[T1-X-MASTERCARD]-Essential-Applique-Hoodie-Grey.php', 0, 4),
(13, '[T1 X MASTERCARD] Player Emblem Jersey', 'Gear up like a T1 player with the [T1 X MASTERCARD] Player Emblem Jersey. This jersey combines performance and style for the ultimate gaming experience.', 'img/apparel/[T1 X MASTERCARD] Player Emblem Jersey.jpg', '4500.00', 'apparel', 'apparel/[T1-X-MASTERCARD]-Player-Emblem-Jersey.php', 1, NULL),
(14, 'Faker Denim Shirt Jacket - Black', 'Rock the Faker Denim Shirt Jacket in Black for a bold and stylish look. This jacket is inspired by the legendary Faker\'s signature style.', 'img/apparel/Faker Denim Shirt Jacket - Black.jpg', '2800.00', 'apparel', 'apparel/Faker-Denim-Shirt-Jacket-Black.php', 0, NULL),
(15, 'FAKER X DECA T-Shirt - Black', 'Show your support for Faker and DECA with the FAKER X DECA T-Shirt in Black. This tee combines esports and fashion for a winning look.', 'img/apparel/FAKER X DECA T-Shirt - Black.jpg', '1800.00', 'apparel', 'apparel/FAKER-X-DECA-T-Shirt-Black.php', 0, NULL),
(16, 'T1 Summer Sweat Shorts', 'Stay cool and comfortable in the T1 Summer Sweat Shorts. Perfect for casual days or workouts, these shorts represent the T1 spirit.', 'img/apparel/T1 Summer Sweat Shorts.jpg', '1200.00', 'apparel', 'apparel/T1-Summer-Sweat-Shorts.php', 0, NULL),
(17, '2023 T1 Desk Mat Bundled', 'Enhance your gaming setup with the 2023 T1 Desk Mat Bundled. This set adds a touch of T1 flair to your workspace, combining style and functionality.', 'img/collectibles/2023 T1 Desk Mat Bundled.png', '1800.00', 'collectibles', 'collectibles/2023-T1-Desk-Mat-Bundled.php', 0, NULL),
(18, '2023 T1 Uniform Worlds Jersey Keychain', 'Carry a piece of T1 pride wherever you go with the 2023 T1 Uniform Worlds Jersey Keychain. A miniature tribute to the iconic T1 jersey.', 'img/collectibles/2023 T1 Uniform Worlds Jersey Keychain.jpg', '500.00', 'collectibles', 'collectibles/2023-T1-Uniform-Worlds-Jersey-Keychain.php', 0, NULL),
(19, 'Keria Birthday Keychain', 'Celebrate with style using the Keria Birthday Keychain. This keychain adds a touch of esports charm to your daily essentials.', 'img/collectibles/Keria Birthday Keychain.jpg', '300.00', 'collectibles', 'collectibles/Keria-Birthday-Keychain.php', 1, 5),
(20, 'T1 2023 Worlds Edition Desk Mat', 'Level up your desk aesthetics with the T1 2023 Worlds Edition Desk Mat. This desk mat showcases the excitement of the 2023 Worlds Edition.', 'img/collectibles/T1 2023 Worlds Edition Desk Mat.jpg', '1200.00', 'collectibles', 'collectibles/T1-2023-Worlds-Edition-Desk-Mat.php', 0, NULL),
(21, 'T1 2023 Worlds Edition Epoxy Keychain', 'Accessorize with the T1 2023 Worlds Edition Epoxy Keychain. This keychain captures the essence of T1\'s journey in the 2023 Worlds.', 'img/collectibles/T1 2023 Worlds Edition Epoxy Keychain.jpg', '400.00', 'collectibles', 'collectibles/T1-2023-Worlds-Edition-Epoxy-Keychain.php', 0, NULL),
(22, 'T1 2023 Worlds Player Desk Mat', 'Inspire your gaming sessions with the T1 2023 Worlds Player Desk Mat. This desk mat is a tribute to the dedication of T1\'s esports players.', 'img/collectibles/T1 2023 Worlds Player Desk Mat.jpg', '1500.00', 'collectibles', 'collectibles/T1-2023-Worlds-Player-Desk-Mat.php', 0, NULL),
(23, 'T1 Hero\'s Journey Room Spray', 'Immerse yourself in the T1 Hero\'s Journey Room Spray. This room spray captures the essence of T1\'s journey, bringing a fresh and invigorating scent.', 'img/collectibles/T1 Hero-s Journey Room Spray.png', '800.00', 'collectibles', 'collectibles/T1-Heros-Journey-Room-Spray.php', 0, NULL),
(24, 'T1 Logo Badge', 'Show your allegiance with the T1 Logo Badge. This badge is a symbol of your connection to the legendary T1 esports team.', 'img/collectibles/T1 Logo Badge.jpg', '200.00', 'collectibles', 'collectibles/T1-Logo-Badge.php', 0, NULL),
(25, 'T1 Logo Desk Mat Bundled', 'Upgrade your workspace with the T1 Logo Desk Mat Bundled. This set combines T1 style and functionality for a professional gaming setup.', 'img/collectibles/T1 Logo Desk Mat Bundled.jpg', '1600.00', 'collectibles', 'collectibles/T1-Logo-Desk-Mat-Bundled.php', 0, NULL),
(26, 'T1 Logo Notebook', 'Capture your thoughts in style with the T1 Logo Notebook. This notebook features the iconic T1 logo for a touch of esports inspiration.', 'img/collectibles/T1 Logo Notebook.jpg', '350.00', 'collectibles', 'collectibles/T1-Logo-Notebook.php', 0, NULL),
(27, 'T1 Pen', 'Write in esports style with the T1 Pen. This pen combines functionality and elegance, making it the perfect accessory for T1 enthusiasts.', 'img/collectibles/T1 Pen.jpg', '150.00', 'collectibles', 'collectibles/T1-Pen.php', 0, NULL),
(28, 'T1 Pro Notebook', 'Unleash your professional side with the T1 Pro Notebook. This notebook is designed for esports professionals and enthusiasts alike.', 'img/collectibles/T1 Pro Notebook.jpg', '400.00', 'collectibles', 'collectibles/T1-Pro-Notebook.php', 0, NULL),
(29, 'T1 Strap Keychain', 'Carry your keys with T1 style using the T1 Strap Keychain. This keychain is a subtle yet impactful way to showcase your esports passion.', 'img/collectibles/T1 Strap Keychain.jpg', '250.00', 'collectibles', 'collectibles/T1-Strap-Keychain.php', 0, NULL),
(30, 'T1 White Umbrella', 'Stay dry in style with the T1 White Umbrella. This umbrella features the iconic T1 logo, making it a practical yet fashionable accessory.', 'img/collectibles/T1 White Umbrella.jpg', '800.00', 'collectibles', 'collectibles/T1-White-Umbrella.php', 0, 3),
(31, '2023 T1 Champions Uniform Jersey', 'Celebrate the champions with the 2023 T1 Champions Uniform Jersey. This jersey is a symbol of T1\'s victories and commitment to excellence.', 'img/uniform/2023 T1 Champions Uniform Jersey.jpg', '4800.00', 'uniform', 'uniform/2023-T1-Champions-Uniform-Jersey.php', 0, NULL),
(32, '2023 T1 MSI Uniform Zip-up', 'Gear up for esports glory with the 2023 T1 MSI Uniform Zip-up. This zip-up combines comfort and style for the ultimate gaming experience.', 'img/uniform/2023 T1 MSI Uniform Zip-up.jpg', '4200.00', 'uniform', 'uniform/2023-T1-MSI-Uniform-Zip-up.php', 0, NULL),
(33, '2023 T1 Uniform Jacket', 'Stay warm and stylish with the 2023 T1 Uniform Jacket. This jacket is designed for T1 fans who embrace both fashion and esports passion.', 'img/uniform/2023 T1 Uniform Jacket.png', '3800.00', 'uniform', 'uniform/2023-T1-Uniform-Jacket.php', 0, NULL),
(34, '2023 T1 Uniform PINK Jersey', 'Show your support in style with the 2023 T1 Uniform PINK Jersey. This jersey is a vibrant tribute to T1\'s legacy and commitment to inclusivity.', 'img/uniform/2023 T1 Uniform PINK Jersey.jpg', '4600.00', 'uniform', 'uniform/2023-T1-Uniform-PINK-Jersey.php', 0, NULL),
(35, '2023 T1 Uniform Worlds Pants', 'Complete your T1 uniform with the 2023 T1 Uniform Worlds Pants. These pants blend comfort and esports style for a winning look.', 'img/uniform/2023 T1 Uniform Worlds Pants.jpg', '3200.00', 'uniform', 'uniform/2023-T1-Uniform-Worlds-Pants.php', 0, NULL),
(36, '2023 T1 VCT PACIFIC Uniform Jersey', 'Embrace the spirit of competition with the 2023 T1 VCT PACIFIC Uniform Jersey. This jersey is a symbol of T1\'s presence on the global esports stage.', 'img/uniform/2023 T1 VCT PACIFIC Uniform Jersey.jpg', '5000.00', 'uniform', 'uniform/2023-T1-VCT-PACIFIC-Uniform-Jersey.php', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviews_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cell_number` varchar(13) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT 'img/profile-picture/t1homebackground4.png',
  `reset_code` varchar(255) DEFAULT NULL,
  `reset_code_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviews_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviews_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

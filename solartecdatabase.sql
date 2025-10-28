-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 07:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `solartecdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(30) NOT NULL,
  `cat_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Installation '),
(2, 'Maintenance & Repairs');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_id` int(30) NOT NULL,
  `prod_name` varchar(1000) NOT NULL,
  `prod_price` float NOT NULL,
  `prod_desc` varchar(10000) NOT NULL,
  `prod_desc_short` varchar(200) NOT NULL,
  `prod_img` varchar(1000) NOT NULL,
  `prod_rating` float NOT NULL,
  `prod_icon` varchar(100) NOT NULL,
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_id`, `prod_name`, `prod_price`, `prod_desc`, `prod_desc_short`, `prod_img`, `prod_rating`, `prod_icon`, `cat_id`) VALUES
(1, 'Solar Panel Installation', 50, 'Our solar panel installation service is designed to make your transition to renewable energy seamless and cost-effective. We assess your energy needs, design a custom system using high-quality photovoltaic panels, and install it with precision. Our certified technicians handle everything — from permits and mounting to wiring and final activation. Whether you’re a homeowner looking to cut down on electricity bills or a company striving for sustainability, we deliver scalable solutions with long-term benefits.\r\n\r\n', 'We offer top-tier solar panel systems tailored to your home or business, ensuring efficiency and sustainability.', 'https://werecyclesolar.com/wp-content/uploads/2023/03/Solar-Disposal-New.png', 5, 'fa fa-solar-panel', 1),
(2, 'Wind Turbine Systems', 40, 'Our wind turbine systems provide an excellent solution for generating clean electricity, especially in regions with consistent wind flow. We supply both small-scale turbines for private use and larger models for agricultural or commercial properties. Each system is designed to optimize output while maintaining low noise and minimal visual impact. From site analysis and installation to performance monitoring, our team ensures reliable operation and sustainable energy production.', 'Harness the power of the wind with efficient, durable wind turbines ideal for remote and coastal areas.', 'https://www.windustry.com/image/horizontal-axis-wind-turbines.jpg', 5, 'fa fa-wind', 1),
(3, 'Hydropower Plant Design', 100, 'We specialize in designing micro and mini hydropower plants that convert river or stream flow into consistent renewable energy. These systems are ideal for rural areas or properties near natural water sources. Our engineering team handles the full design-build process — analyzing flow rates, installing turbines, and integrating the system with your power grid. With minimal environmental impact and high energy returns, hydropower is a strong addition to your green infrastructure.\r\n\r\n', 'Turn flowing water into energy with our custom-designed small-scale hydropower solutions.', 'https://esfccompany.com/upload/iblock/3e3/3e3f6ef5a5d6f23513258a25a2950c41.jpg', 5, 'fa fa-water', 1),
(4, 'System Maintenance & Monitoring', 150, 'Proper maintenance is key to the longevity and efficiency of any renewable energy system. We offer scheduled check-ups, performance diagnostics, cleaning, and repairs for solar, wind, and hydropower setups. Our smart monitoring solutions provide real-time data and alerts, helping you catch issues before they escalate. With remote access and regular reports, you stay in control and fully informed about your system\'s health.\r\n\r\n', 'Ensure your renewable systems run smoothly with expert maintenance and 24/7 monitoring tools.', 'https://westsunenergy.com.au/wp-content/uploads/2023/06/Solar-Maintenance-and-Repairs-600x400.jpg', 5, 'fa fa-lightbulb', 2),
(5, 'Infrastructure Monitoring & Support', 500, 'Comprehensive monitoring and support for IT infrastructure, ensuring uptime, performance optimization, and quick troubleshooting of technical issues.', 'Proactive monitoring and reliable support for your IT infrastructure to ensure optimal performance and swift issue resolution.', 'https://www.ewz.ch/content/site/ewz/webportal/en/ueber-ewz/jobs-karriere/fokusbereiche/engineering/_jcr_content/content/pagesection_1063943136/section_content/cols_1_1_1/layout-4-1/imagecomponent/image.ewzimg.width_imagexsmall.jpg/1728047940175.jpg', 4, 'fa fa-lightbulb', 2);

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `userid` int(10) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `hashedPassword` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`userid`, `fullname`, `password`, `hashedPassword`, `email`) VALUES
(1, 'orjoan ali ', 'orjaonali', '', 'orjoanali@gmail.com ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

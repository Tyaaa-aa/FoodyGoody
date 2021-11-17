-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2021 at 10:50 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_foodygoody`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_comments`
--

CREATE TABLE `tb_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `sComment` varchar(1000) NOT NULL,
  `likes` int(11) NOT NULL,
  `tsLastUpdated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_comments`
--

INSERT INTO `tb_comments` (`id`, `user_id`, `post_id`, `sComment`, `likes`, `tsLastUpdated`) VALUES
(110, 499, 156, 'This is a comment test yalls', 6, '2021-01-20 12:52:54'),
(123, 499, 167, 'no cus they look like u', 0, '2021-01-25 09:13:15'),
(124, 544, 167, 'ok', 0, '2021-01-25 09:23:04'),
(125, 499, 167, 'u suck', 0, '2021-01-25 09:24:43'),
(126, 544, 167, 'ok', 0, '2021-01-25 09:24:52'),
(127, 499, 167, 'i hate u', 0, '2021-01-25 09:24:58'),
(128, 544, 167, 'ok', 0, '2021-01-25 09:25:06'),
(129, 499, 167, 'say ok if u are a loser', 0, '2021-01-25 09:25:14'),
(130, 544, 167, 'loser', 0, '2021-01-25 09:25:20'),
(131, 499, 167, ':P sucky', 0, '2021-01-25 09:25:29'),
(132, 544, 167, 'sucker', 0, '2021-01-25 09:25:40'),
(133, 499, 167, 'u then', 0, '2021-01-25 09:25:46'),
(134, 544, 167, 'ok', 0, '2021-01-25 09:25:57'),
(136, 499, 176, 'Idk but I like meat haha', 0, '2021-01-29 12:28:44'),
(137, 547, 176, 'Show compassion', 0, '2021-01-29 12:30:04'),
(138, 499, 176, 'I show compassion by killing them painlessly', 1, '2021-01-29 12:30:18'),
(139, 547, 176, 'Punch your face', 0, '2021-01-29 12:31:24'),
(140, 499, 176, 'Call police animal abuse', 0, '2021-01-29 12:31:37'),
(142, 499, 102, 'I heard alton brown made a really simple and good cake recipe but its not really a rainbow though in his <a href=\"https://altonbrown.com/recipes/reloaded-gold-cake/\">website</a>', 1, '2021-02-04 07:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_forums`
--

CREATE TABLE `tb_forums` (
  `sForumname` varchar(1000) NOT NULL,
  `sForumimage` varchar(1000) NOT NULL,
  `sForumusers` int(11) NOT NULL,
  `sForumposts` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_forums`
--

INSERT INTO `tb_forums` (`sForumname`, `sForumimage`, `sForumusers`, `sForumposts`) VALUES
('f/FoodSOS', 'img/FoodSOS.jpg', 26, 42),
('f/HowTo101', 'img/forum-bg.jpg', 25, 18),
('f/FoodyCritic', 'img/critic.jpg', 13, 10),
('f/RecipeHub', 'img/Recipe.png', 49, 68),
('f/FoodQnA', 'img/qnA.jpg', 25, 56),
('f/FoodMemes', 'img/pizzzzza.jpg', 48, 97),
('f/FurryFoodys', 'img/chefcat.jpg', 37, 76);

-- --------------------------------------------------------

--
-- Table structure for table `tb_posts`
--

CREATE TABLE `tb_posts` (
  `post_id` int(11) NOT NULL,
  `sForumname` varchar(1000) NOT NULL,
  `sTitle` varchar(1000) NOT NULL,
  `sImage` varchar(255) NOT NULL,
  `sPost` varchar(1000) NOT NULL,
  `iUserid` int(11) NOT NULL,
  `tsLastUpdated` timestamp NULL DEFAULT current_timestamp(),
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_posts`
--

INSERT INTO `tb_posts` (`post_id`, `sForumname`, `sTitle`, `sImage`, `sPost`, `iUserid`, `tsLastUpdated`, `likes`) VALUES
(98, 'f/FurryFoodys', 'Food for feline friends featuring family fun', 'postIMG/IMG_5ffb3b4a6d6393.39645422.jpg', 'Recently came across a cookbook for cats and just wanted to ask if you guys knew about homecooked food for cats!!', 501, '2021-01-10 17:37:14', 21),
(99, 'f/FoodMemes', 'Real life food vs Anime food', 'postIMG/IMG_5ffb3b60c48463.53230076.png', 'I have to say I\'m a big fan of anime food. If you prefer real life food I just want you to know your opinion is wrong', 502, '2021-01-10 17:37:36', 26),
(100, 'f/HowTo101', 'Avocados and avocadon\'ts', 'postIMG/IMG_5ffd6f739451f7.42270809.jpg', 'AvocaDO pei me my qian and avocaDONT talk to me again! You butter not contact me! Or I\'ll make you fall into a pit. \"peww\"', 503, '2021-01-12 09:44:19', 35),
(101, 'f/FoodQnA', 'Food photoshoot locations?', 'postIMG/IMG_5ffb3b8589c341.44965489.jpg', 'As a professional photographer does anybody know any good locations for food photography?', 504, '2021-01-10 17:38:13', 39),
(102, 'f/RecipeHub', 'Rainbow cake recipe for my internet friends', 'postIMG/IMG_5ffb3b92913b34.15909535.jpg', 'As a genie stuck in a lamp its very rare to get guests over so i really want to impress my friends this weekend', 505, '2021-01-10 17:38:26', 47),
(103, 'f/FoodyCritic', 'Outrageous drive-thru experience at McDonald\'s', 'postIMG/IMG_5ffb3ba15b4ec2.20236798.jpg', 'A MCDONALDS DRIVE-THRU EMPLOYEE SCRATCHED UP MY BRAND NEW BEAUTIFUL BLUE SUBARI STI 2008 AWD MANUAL FLAT FOUR LIMITED EDITION SIGNED BY FAST & FURIOUS CAST MEMBERS AND BAPTISED WHEN IT WAS JUST 2 YEARS OLD VEHICULAR CAR!!! DON\'T EVER GO TO MCDONALDS AGAIN PLEASE BOYCOTT!!!', 506, '2021-01-10 17:38:41', 61),
(104, 'f/HowTo101', 'Fabricating Filipino food firetruck festival funhouses', 'postIMG/IMG_5ffb3bb23c13b6.77330368.jpg', 'Im secretly an indian but i like to hide that part of me and tell people im philipino and speak chinese to mask my natural born prodigal indian accent. i also smell like an indian thats why i take 6 hour showers', 507, '2021-01-10 17:38:58', 69),
(105, 'f/FoodSOS', 'How do I get the crispiest possible skin on my salmon?', 'postIMG/IMG_5ffb41e19fec84.01632233.jpg', 'I recently tried to score the skin of my salmon and ended up chopping the whole bloody thing in half. next thing i knew i was eating salmon fish fingers instead of a beautiful fillet. Also my friends wouldnt stop laughing at me and now i feel bad and stuffs :(', 500, '2021-01-10 18:05:21', 78),
(108, 'f/FoodSOS', 'KOI QUEUE DAMN LONG!', 'postIMG/IMG_5ffcfcca3f1049.91267550.jpg', 'This koi queue was insanely long even with the pandemic going around... asd', 500, '2021-01-12 01:35:06', 14),
(160, 'f/FoodMemes', 'PezzaHue', 'postIMG/IMG_600e6e71427a61.55430479.jpg', 'pizza kenna squeeze haha', 499, '2021-01-22 00:19:18', 4),
(167, 'f/FoodQnA', 'Do you eat frogs?', 'postIMG/IMG_600e8a622fdfe2.57852821.jpg', 'even after seeing this image?', 544, '2021-01-25 09:07:46', 5),
(171, 'f/FoodSOS', 'Idk how to open a can of mushroom soop doe<span> (edited)</span>', 'postIMG/IMG_601317da74cdb8.95253463.jpeg', 'im dense. just like this soup haha', 543, '2021-01-24 20:15:16', 1),
(176, 'f/FoodSOS', 'Y no vegetarian food?<span> (edited)</span>', 'postIMG/IMG_6013ff23affb40.86636522.jpg', 'Why no vegetarian food?', 547, '2021-01-29 12:25:15', 0),
(178, 'f/HowTo101', 'Shell out', 'postIMG/IMG_6014cf8b4559f1.76134403.jpeg', 'Try shell out! Fun to do fun to eat!!', 549, '2021-01-30 03:16:27', 3),
(182, 'f/HowTo101', 'editing a created post from tablet<span> (edited)</span>', 'postIMG/IMG_601bb940997801.38290389.jpg', 'tablet post', 554, '2021-02-04 09:06:46', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `sFname` varchar(100) NOT NULL,
  `sLname` varchar(100) NOT NULL,
  `sEmail` varchar(100) NOT NULL,
  `sPassword` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `sFname`, `sLname`, `sEmail`, `sPassword`, `role`) VALUES
(499, 'TyaTya', 'Tya', 'sirtya@gmail.com', '$2y$10$ztC3td9H69.2T7LSuGPz6eXAxSSVfue9jBUpSH6qAiFbMvCEM72Ce', 10),
(500, 'Restyaraunt', 'Business', 'Restyaraunt@gmail.com', '$2y$10$30UrfSOUNv/q/6kc28cb6.aENAjE91dadCKlyzJ38y0foCuznSl/S', 0),
(501, 'AreYouCold', 'Nicole', 'AreYouCold@gmail.com', '$2y$10$TSvgoC4W0yFR5aSo.Dw04O0L/yN3G888drK7fr3Y.lYJ1EFqYUItK', 0),
(502, 'TooDeePimp', 'Caelan', 'TooDeePimp@gmail.com', '$2y$10$UJcW3fS82fcuF1GlG55aiuCBoIH2PO8k/zG0eFE1nFLR5m9Z.ibd2', 0),
(503, 'PeiMeQian', 'px', 'PeiMeQian@gmail.com', '$2y$10$B6Hb6ZmCG5XQ1VsvsZMH2eS.Zy6eONdaeWwbUHjI8IiMQ.3A6TIDq', 0),
(504, 'IwantItThatWei_Hong', 'Ethan', 'IwantItThatWei_Hong@gmail.com', '$2y$10$Rys86BZ3j.CqC6I/nXTiHeSo6KY.7A6KdovR1tVz2FGM4TMmy0qse', 0),
(505, 'JiJidotcom', 'Jeanie', 'JiJidotcom@gmail.com', '$2y$10$tVqmrOaWJFW9JFIoJKJaD.ucCRuiF3nD7O5CUSqJmaIitXsfkJ70i', 0),
(506, 'Weiwei_InDaHOUSE', 'wj', 'Weiwei_InDaHOUSE@gmail.com', '$2y$10$m9C0LEdvzz3CE/13Q9RleOVZdUUTsb2KbWhLlKXvufkAyfKkBWmr.', 0),
(507, 'SmellyHolly', 'Jon', 'SmellyHolly@gmail.com', '$2y$10$/fVdzqGHRsBvDMVhIpHldO0Gc6UwYUHdthVNjmyb2B7kr3eErV4Nq', 0),
(510, 'Yeo', 'Jie', 'weijieyeo2001@gmail.com', '$2y$10$V/I3rlgbKEEAwkluiRKVmOpMaM3PH0Y8LMvdXtQUxNPGsEKMIJOw.', 0),
(543, 'ratana', 'satnam', 'sat@gmail.com', '$2y$10$XZPyClggKbe6rezzS9AHE.895TWMM9nTLDzwLUR1xnwq5vVBviymW', 0),
(544, 'Chan', 'Chan Pei Xuan', 'chanpx01@gmail.com', '', 0),
(547, 'Briyani', '224', 'briyani224@gmail.com', '$2y$10$.NN7hcwUYk5uBe0/fAFfFe0SMr2A7e/1TL5vkAT/HtfobPV09MYka', 0),
(548, 'Anna', 'Siva', 'annakeely.siva@gmail.com', '$2y$10$tMLukkKA192xpBQ..Qm5eO5LMy45/rUsIq3U1Bjm4FwT4NQogwCda', 0),
(549, 'Jayanthi', 'Michael', 'jayanthis04@yahoo.com.sg', '$2y$10$rK6ZekX6CFRVXAdqKs0mauDRJLPKtYSaiFmqRu.NTZ/j9a0iTIP4C', 0),
(551, 'submission', 'test', 'school@nyp.com', '$2y$10$RhCWcPsuFLhuxixJHnf9MulY653KN5FRA5QUatWZACo.awhS6.5zu', 0),
(555, 'admin', 'account', 'admin@foodygoody.com', '$2y$10$wOu7ElU89MNjDJEYloc6bOrzk6taQlKuyDrXBwPk9wkKSzulog0hG', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_comments`
--
ALTER TABLE `tb_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_forums`
--
ALTER TABLE `tb_forums`
  ADD UNIQUE KEY `sForumname` (`sForumname`) USING HASH;

--
-- Indexes for table `tb_posts`
--
ALTER TABLE `tb_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_comments`
--
ALTER TABLE `tb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `tb_posts`
--
ALTER TABLE `tb_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=556;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

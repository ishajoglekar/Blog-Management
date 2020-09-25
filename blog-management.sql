-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2020 at 01:43 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(15) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'Web Design'),
(2, 'PHP'),
(3, 'JAVA'),
(4, 'Android'),
(5, 'Artificial Intelligence');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(15) NOT NULL,
  `category_id` int(15) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `author` varchar(50) NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `category_id`, `name`, `content`, `author`, `post_image`, `created_at`, `updated_at`, `deleted`) VALUES
(27, 1, 'Wordpress', 'Working on a new theme for WordPress? Need to create an example site for a client? Whatever the reason, using dummy content can help display what a site might actually look like once it goes live. Instead of creating your own posts and pages, it’s easier to simply use some form of WordPress dummy content generator.\r\n\r\nLuckily, someone already developed such a method and it’s free to use. With a couple clicks of the mouse, you can show a WordPress theme with sample data ready.\r\n\r\nIn this tutorial, I’m going to show you the easiest and quickest way to display WordPress example content in your theme.', 'isha', '27.jpg', '2020-05-28 00:22:33', '2020-05-28 00:22:33', 0),
(28, 1, 'A HTML Post', '<h3>Lorem Ipsum</h3> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n<h3>Why do we use it?</h3>\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'isha', '28.jpg', '2020-05-28 00:25:46', '2020-05-28 00:25:46', 0),
(29, 3, 'Remote Work: Make it happen in 4 months', 'Nearly everyone has had an unpleasant experience while on a call with people who are outside the office. Whether it’s microphone difficulties, background noise, or software difficulties, conference calls are a frequent source of irritation. However, if you have prepared well, you can usually avoid teleconferencing issues.\r\n\r\nFirst, make sure that you have multiple means of joining any conference call that you have on your schedule. Second, make sure that whenever you have a conference call, you try to connect well in advance of the meeting time. This will often give you time to fix any issues with your connection before they annoy your co-workers (or worse, your manager).\r\n\r\nTo be honest, technical problems hardly matter at all, so long as you can fix them before they annoy other people. Be prepared and you can do just that.', 'isha', '29.jpg', '2020-05-28 00:27:59', '2020-05-28 00:27:59', 0),
(30, 5, 'Chatbots Life', '<h3>Are you looking for an AI blog rich in content?</h3> <p> If so, Chatbot’s Life is your proper destination. You can find a wide range of tools on the blog. The tools include boot camps, templates, courses, and community. </p> <aside>The most interesting section of this blog is the project section.</aside> <p> In this section, you can follow latest projects and start your project if you have the intention of starting any. If you are a blogger in AI niche, you can also write for this blog to gain exposure.</p>', 'isha', '30.jpg', '2020-05-28 00:33:13', '2020-05-28 00:33:13', 0),
(31, 3, 'Java Heap Sizing in a Container: Quickly & Easily', '<p>In the previous blog, We have seen that Java has made improvements to identify the memory based on a running environment i.e. either a physical machine or a Container (docker). The initial problem with java was that It wasn\'t able to figure out that it was running in a container and It used to capture the memory for whole hardware where the container was running. (Please see - ttps://blogs.oracle.com/java/java-on-container-like-a-pro)\r\n\r\nNow a Java Program running in a container is able to identify the cgroup limit and assign the memory (heap) according to that, (If we do not specify the min and max heap size, which we used to define earlier). So we can run our java program in a container and utilize hardware memory properly, but can we very sure that Java program is using heap size according to cgroup definition?\r\n\r\nWe have a solution to this problem as XshowSettings:category. This is a handy HotSpot JVM flag (option for the Java launcher java) is the -XshowSettings option. This option is described in the Oracle Java launcher description page as follows:</p>', 'isha', '31.jpg', '2020-05-28 00:38:05', '2020-05-28 00:38:05', 0),
(32, 3, 'Java Magazine on Lightweight Frameworks', '<h2>By Java Magazine Editor Andrew Binstock </h2>\r\n\r\n<p>Running Fast and Light Without All the Baggage\r\n\r\nThe emergence of <strong>microservices</strong> as the new architecture for applications has led to a fundamental change in the way we use frameworks. Previously, frameworks offered an omnibus scaffolding that handled most needs of monolithic applications. But as microservices have gained traction, applications now consist of orchestrated containers, each performing a single service. As such, those services require far less scaffolding—favoring instead lightweight frameworks that provide basic connectivity and then get out of the way.\r\n\r\nIn this issue, we examine three leading frameworks for microservices: Javalin (page 13), which is a very lightweight, unopinionated Kotlin-based web framework; Micronaut (page 23), which handles all feature injection at compile time and so loads extremely fast; and Helidon (page 34), which is a cloud native framework that generates a pure Java SE JAR ile that can be run as a service or a complete app. Helidon comes in two flavors: a minimal framework and a slightly heftier one for developers wanting additional services. </p>', 'isha', '32.jpg', '2020-05-28 00:39:18', '2020-05-28 00:39:18', 0),
(33, 4, 'Evaluating Natural Language Generation with BLEURT', '<p>In the last few years, research in natural language generation (NLG) has made tremendous progress, with models now able to translate text, summarize articles, engage in conversation, and comment on pictures with unprecedented accuracy, using approaches with increasingly high levels of sophistication.<br> Currently, there are two methods to evaluate these NLG systems: human evaluation and automatic metrics. With human evaluation, one runs a large-scale quality survey for each new version of a model using human annotators, but that approach can be prohibitively labor intensive. In contrast, one can use popular automatic metrics (e.g., BLEU), but these are oftentimes unreliable substitutes for human interpretation and judgement. The rapid progress of NLG and the drawbacks of existing evaluation methods calls for the development of novel ways to assess the quality and success of NLG systems.</p>', 'muskaanaswani', '33.jpg', '2020-05-28 00:41:52', '2020-05-28 00:41:52', 0),
(34, 3, 'Java Magazine on Containers', '<h4>Java Magazine on Containers</h4>\r\n<p>In our previous issue, we explored the use of lightweight frameworks— Javalin, Micronaut, and Helidon—to create microservices, which typically are deployed in the cloud. In that issue’s article on <strong> Helidon <strong>, we also showed how to package a service into a Docker container for deployment.\r\n<br><br>\r\n<p>In this issue, we continue the theme by examining how to build apps with containers in mind and how to deploy containers. For straight Java apps, the jlink and jdeps tools are excellent solutions for creating modularized, small, self-contained apps.</p>', 'muskaanaswani', '34.jpg', '2020-05-28 00:43:07', '2020-05-28 00:43:07', 1),
(35, 3, 'JOOQ', 'Java Object Oriented Querying is an SQL centric programming model in Java that allows writing SQL queries in a safe way with a powerful API. It’s relational model-centric than domain-centric which is used in many of the ORMs. Lukas Eder is the CEO and founder of Data Geekery, the company behind this programming model. JOOQ blog is an exhaustive library that contains highly specialized topics in Java and SQL including how-to articles, step by step guides, tricks and topics, best practices in Java programming, and more.', 'isha', '35.jpg', '2020-05-28 00:47:00', '2020-05-28 00:47:00', 0),
(36, 1, 'Planet PHP ', '<h4>Blog covers all PHP news in one place.</h4>\r\n<p> A close to complete list of all important PHP related weblogs.Supply Chain Management is a large part of the manufacturing world. This blog covers everything on innovative supply chain management strategies that will be helpful no matter what your role is within an engineering company</p>\r\n<p>\r\nLOREM IPSUM GENERATOR\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>', 'johndoe', '36.jpg', '2020-05-28 00:51:37', '2020-05-28 00:51:37', 0),
(37, 4, 'Android 11: Beta Plans', '<h4>Suscipit adipiscing bibendum est ultricies integer. </h4> <p>Elit at imperdiet dui accumsan. Auctor elit sed vulputate mi sit amet mauris commodo. Commodo ullamcorper a lacus vestibulum sed arcu non odio. Eu feugiat pretium nibh ipsum consequat nisl vel pretium. Felis eget nunc lobortis mattis aliquam. Vitae turpis massa sed elementum tempus egestas sed. Venenatis lectus magna fringilla urna porttitor. Amet justo donec enim diam vulputate ut. Metus vulputate eu scelerisque felis imperdiet proin fermentum leo vel. Sollicitudin aliquam ultrices sagittis orci a scelerisque. Augue ut lectus arcu bibendum at varius.</p>\r\n\r\n<aside>Purus in massa tempor nec feugiat. Proin sed libero enim sed faucibus turpis. Eget lorem dolor sed viverra ipsum. At elementum eu facilisis sed odio morbi quis. Aliquet eget sit amet tellus cras adipiscing.</aside> Sit amet commodo nulla facilisi nullam vehicula. Tristique et egestas quis ipsum suspendisse. Pharetra et ultrices neque ornare aenean. Id donec ultrices tincidunt arcu. Odio tempor orci dapibus ultrices in iaculis. Nec nam aliquam sem et tortor consequat.', 'johndoe', '37.jpg', '2020-05-28 00:53:49', '2020-05-28 00:53:49', 0),
(38, 3, 'Java Post 2', '<h4>Java Magazine on Containers</h4> <p>In our previous issue, we explored the use of lightweight frameworks— Javalin, Micronaut, and Helidon—to create microservices, which typically are deployed in the cloud. In that issue’s article on <strong> Helidon <strong>, we also showed how to package a service into a Docker container for deployment. <br><br> <p>In this issue, we continue the theme by examining how to build apps with containers in mind and how to deploy containers. For straight Java apps, the jlink and jdeps tools are excellent solutions for creating modularized, small, self-contained apps.</p>', 'isha', '38.jpg', '2020-05-28 01:08:03', '2020-05-28 01:08:03', 1),
(57, 4, 'John\\\'s Post', 'blah blah lorem ipsum blah blah', 'isha', '39.jpg', '2020-05-29 14:54:14', '2020-05-29 14:54:14', 0),
(58, 1, 'Jane\\\'s Post', 'lorem ipsum dolor sit ameut blah bkah', 'isha', '58.jpg', '2020-05-29 14:56:34', '2020-05-29 14:56:34', 0),
(59, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '59.jpg', '2020-05-29 15:07:36', '2020-05-29 15:07:36', 0),
(60, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '60.jpg', '2020-05-29 15:08:21', '2020-05-29 15:08:21', 0),
(61, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '61.jpg', '2020-05-29 15:08:27', '2020-05-29 15:08:27', 0),
(62, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '62.jpg', '2020-05-29 15:09:17', '2020-05-29 15:09:17', 0),
(63, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '63.jpg', '2020-05-29 15:10:22', '2020-05-29 15:10:22', 0),
(64, 4, 'blah blah\\\'s', 'Categories edit post krte h pehlr', 'isha', '64.jpg', '2020-05-29 15:10:35', '2020-05-29 15:10:35', 0),
(65, 3, 'My post \\\'\\\'', 'blh blha hfuguguwguw9gqwgwgwg', 'isha', '65.jpg', '2020-05-29 15:15:50', '2020-05-29 15:15:50', 0),
(66, 3, 'My post \\\'\\\'', 'blh blha hfuguguwguw9gqwgwgwg', 'isha', '66.jpg', '2020-05-29 15:16:50', '2020-05-29 15:16:50', 0),
(67, 1, 'abc\\\'', 'dsadfghyjukilo;.,m nbvcxswertyuiop\\\';/. sdfgh dfghj', 'isha', '67.jpg', '2020-05-29 15:20:40', '2020-05-29 15:20:40', 0),
(68, 1, 'abc\\\'', 'dsadfghyjukilo;.,m nbvcxswertyuiop\\\';/. sdfgh dfghj', 'isha', '68.jpg', '2020-05-29 15:20:48', '2020-05-29 15:20:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(15) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `is_remember` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `expires_at`, `is_remember`) VALUES
(69, 3, '35b637e10374a45b0a749bbe518e6fb32a4e47d568d9dab539ef8df9fafdc96c', '2020-05-27 02:25:25', 0),
(70, 3, 'c4e55703c4ad2f7551470a1d90b9f1e49616d8540b5c2567cfeb030e0701b653', '2020-05-27 02:41:16', 0),
(71, 3, '2527b5c0188cfbb6f393057ecdb0405ed13cdeb93975e54ce5309b01ce4342e2', '2020-05-27 02:57:41', 0),
(87, 3, 'c01ff9f27345cf409999f95bd65aae8955947f75183f24d741bf0dd7f4c76445', '2020-05-29 15:25:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(15) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `authority` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `password`, `email`, `authority`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'Muskaan', 'Aswani', 'muskaanaswani', '$2y$10$qvF7l8G/0hipm7vdS32pBOo919ynf7/5ufOn4tYPCh/VgRen2dkYa', 'muskan@gmail.com1', 1, '2020-05-23 17:41:54', '2020-05-23 17:41:54', 0),
(2, 'Ish', 'Joglekar', 'ishajoglekar', '$2y$10$Dh8jwv8xDH/vS3L.yjwvN.E3X4fYIhuffW.AZrWuGw6ynmXirEdsC', 'isha@sl.com', 0, '2020-05-23 17:43:46', '2020-05-23 17:43:46', 0),
(3, 'Isha', 'Joglekar', 'isha', '$2y$10$QqboS4/D9czwlUqk5.NM7.Kq0nTdbN8bf.iEsBbMsX.PXS5aMHEt.', 'isha@gmail.com', 1, '2020-05-24 18:02:01', '2020-05-24 18:02:01', 0),
(12, 'John ', 'Doe', 'johndoe', '$2y$10$Er2A.7OQHmIUoGA6xixIyedWTpVfk5XeTU036756LrwNY0BmH308C', 'john@gmail.com', 1, '2020-05-28 00:34:06', '2020-05-28 00:34:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_posts`
--

CREATE TABLE `users_posts` (
  `id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `post_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_posts`
--

INSERT INTO `users_posts` (`id`, `user_id`, `post_id`) VALUES
(27, 3, 1),
(28, 3, 28),
(29, 3, 29),
(30, 3, 30),
(31, 3, 31),
(32, 3, 32),
(33, 1, 33),
(35, 3, 35),
(36, 12, 36),
(37, 12, 37),
(39, 3, 39),
(40, 3, 40),
(41, 3, 41),
(42, 3, 42),
(43, 3, 43),
(44, 3, 44),
(45, 3, 45),
(46, 3, 46),
(47, 3, 39),
(48, 3, 48),
(49, 3, 49),
(50, 3, 50),
(51, 3, 51),
(52, 3, 52),
(53, 3, 53),
(54, 3, 54),
(55, 3, 55),
(56, 3, 56),
(57, 3, 39),
(58, 3, 58),
(59, 3, 59),
(60, 3, 60),
(61, 3, 61),
(62, 3, 62),
(63, 3, 63),
(64, 3, 64),
(65, 3, 65),
(66, 3, 66),
(67, 3, 67),
(68, 3, 68);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_posts`
--
ALTER TABLE `users_posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users_posts`
--
ALTER TABLE `users_posts`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

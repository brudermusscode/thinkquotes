-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2022 at 05:59 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `@thinkquotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `intern_main_cards`
--

CREATE TABLE `intern_main_cards` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `icon_color` varchar(25) NOT NULL DEFAULT '#f9a825',
  `slogan` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_main_cards`
--

INSERT INTO `intern_main_cards` (`id`, `sid`, `image`, `icon`, `icon_color`, `slogan`, `title`, `url`, `disabled`, `timestamp`) VALUES
(1, 1, '/intern/400/07.png', 'fingerprint', 'var(--colour-red)', 'Data, Cookies & more...', 'Privacy Policies', '/privacy', 0, 'current_timestamp()'),
(2, 1, '/intern/400/28.png', 'fact_check', 'var(--colour-green)', 'All about us', 'Imprint', '/imprint', 0, 'current_timestamp()'),
(3, 1, '/intern/400/30.png', 'gavel', 'var(--colour-blue)', 'Copyright stuff', 'Disclaimer', '/imprint#disclaimer', 0, 'current_timestamp()'),
(4, 1, '/intern/400/01.png', 'restore', 'var(--colour-lila)', 'What\'s new?', 'Updates', '/updates', 0, 'current_timestamp()'),
(5, 2, '/intern/400/31.png', 'supervised_user_circle', 'var(--colour-darkred)', 'We got you', 'Dev-Team', '/team', 0, 'current_timestamp()'),
(6, 2, '/intern/400/102.png', 'recent_actors', 'var(--colour-pink)', 'Sites we trust', 'Partners', '/partners', 1, 'current_timestamp()'),
(7, 2, '/intern/400/103.png', 'source', 'var(--colour-bluegrey)', 'Graphics, texts, etc.', 'Sources', '/sources', 1, 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `intern_main_sections`
--

CREATE TABLE `intern_main_sections` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL DEFAULT 'new section',
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_main_sections`
--

INSERT INTO `intern_main_sections` (`id`, `title`, `timestamp`) VALUES
(1, '', 'current_timestamp()'),
(2, 'Interesting', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `intern_team_members`
--

CREATE TABLE `intern_team_members` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_team_members`
--

INSERT INTO `intern_team_members` (`id`, `uid`, `rid`, `image`, `timestamp`) VALUES
(1, 1, 1, 'team/brudermusscode.png', 'current_timestamp()'),
(2, 0, 2, 'team/IMG_1472.JPG', 'current_timestamp()'),
(3, 4, 3, 'team/brudermusscode.png', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `intern_team_members_social`
--

CREATE TABLE `intern_team_members_social` (
  `id` int(11) NOT NULL,
  `type` enum('discord','web','twitch','youtube','github','facebook') NOT NULL,
  `icon` varchar(20) NOT NULL,
  `icon_color` varchar(25) NOT NULL DEFAULT 'var(--colour-orange)',
  `base_url` varchar(200) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_team_members_social`
--

INSERT INTO `intern_team_members_social` (`id`, `type`, `icon`, `icon_color`, `base_url`, `timestamp`) VALUES
(1, 'web', 'language', 'var(--colour-orange)', '', 'current_timestamp()'),
(2, 'twitch', 'stream', 'var(--colour-lila)', 'https://www.twitch.tv', 'current_timestamp()'),
(3, 'youtube', 'smart_display', 'var(--colour-red)', 'https://www.youtube.com', 'current_timestamp()'),
(4, 'github', 'memory', 'var(--colour-dark)', 'https://www.github.com', 'current_timestamp()'),
(5, 'facebook', 'psychology', 'var(--colour-blue)', 'https://www.facebook.com', 'current_timestamp()'),
(6, 'discord', 'discord', '#6570F7', 'https://www.discord.com', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `intern_team_members_social_added`
--

CREATE TABLE `intern_team_members_social_added` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_team_members_social_added`
--

INSERT INTO `intern_team_members_social_added` (`id`, `uid`, `sid`, `title`, `url`, `timestamp`) VALUES
(1, 1, 2, 'brudermusscode', 'brudermusscode', 'current_timestamp()'),
(2, 1, 1, 'ThinkQuotes', 'https://www.thinkquotes.de', 'current_timestamp()'),
(3, 1, 6, 'brudermusscode', 'https://discord.gg/rsaDVxJ68f', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `intern_team_ranks`
--

CREATE TABLE `intern_team_ranks` (
  `id` int(11) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `card_color` varchar(25) NOT NULL DEFAULT '#104e5b',
  `rank_name` varchar(20) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern_team_ranks`
--

INSERT INTO `intern_team_ranks` (`id`, `icon`, `card_color`, `rank_name`, `timestamp`) VALUES
(1, 'extension', '#104e5b', 'CEO', 'current_timestamp()'),
(2, 'design_services', 'var(--colour-darkred)', 'UI/UX Design', 'current_timestamp()'),
(3, 'architecture', 'var(--colour-dark)', 'Backend', 'current_timestamp()');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(255) NOT NULL,
  `uid` int(255) DEFAULT NULL,
  `aid` int(255) DEFAULT NULL,
  `sid` int(255) DEFAULT NULL,
  `quote_text` text DEFAULT NULL,
  `upvotes` int(255) NOT NULL DEFAULT 0,
  `isDraft` tinyint(1) NOT NULL DEFAULT 1,
  `deleted` enum('0','1','','') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `uid`, `aid`, `sid`, `quote_text`, `upvotes`, `isDraft`, `deleted`, `timestamp`) VALUES
(1, 1, 1, 1, 'Denke lieber an das, was du hast, als an das, was dir fehlt! Suche von den Dingen, die du hast, die besten aus und bedenke dann, wie eifrig du nach ihnen gesucht haben würdest, wenn du sie nicht hättest.', 4061, 0, '0', '2021-12-20 05:18:55'),
(2, 1, 2, 1, 'Wir denken selten an das, was wir haben, aber immer an das, was uns fehlt.', 4015, 0, '0', '2021-12-20 05:18:55'),
(3, 1, 3, 1, 'Verweile nicht in der Vergangenheit, träume nicht von der Zukunft. Konzentriere dich auf den gegenwärtigen Moment.', 3227, 0, '0', '2021-12-20 05:18:56'),
(4, 1, 4, 1, 'Es ist ein großer Fehler zu denken, dass ein Mensch immer gleich ist. Ein Mensch ist nie lange derselbe. Er verändert sich ständig. Nicht einmal für eine halbe Stunde bleibt er derselbe.', 2393, 0, '0', '2021-12-20 05:18:56'),
(5, 1, 5, 1, 'Freundschaft ist die reinste und höchste Form der Liebe. Es ist eine Form der Liebe ohne Bedingungen und Erwartungen, bei der man das Geben an sich genießt.', 2332, 0, '0', '2021-12-20 05:18:56'),
(6, 1, 3, 1, 'Jedes Leben hat sein Maß an Leid. Manchmal bewirkt eben dieses unser Erwachen.', 1900, 0, '0', '2021-12-20 05:18:56'),
(7, 1, 7, 1, 'Du siehst die Welt nicht so wie sie ist, du siehst die Welt so wie du bist.', 1900, 0, '0', '2021-12-20 05:18:56'),
(8, 1, 8, 1, 'Zeit ist überhaupt nicht kostbar, denn sie ist eine Illusion. Was dir so kostbar erscheint, ist nicht die Zeit, sondern der einzige Punkt, der außerhalb der Zeit liegt: das Jetzt. Das allerdings ist kostbar. Je mehr du dich auf die Zeit konzentrierst, auf Vergangenheit und Zukunft, desto mehr verpasst du das Jetzt, das Kostbarste, was es gibt.', 1892, 0, '0', '2021-12-20 05:18:57'),
(9, 1, 9, 1, 'Vergiss Sicherheit. Lebe, wo du fürchtest zu leben. Zerstöre deinen Ruf. Sei berüchtigt.', 1808, 0, '0', '2021-12-20 05:18:57'),
(10, 1, 10, 1, 'Dumme Gedanken hat jeder, aber der Weise verschweigt sie.', 1792, 0, '0', '2021-12-20 05:18:57'),
(11, 1, 8, 1, 'Du kannst dich nicht selber finden, indem du in die Vergangenheit gehst. Du findest dich selber, indem du in die Gegenwart kommst.', 1775, 0, '0', '2021-12-20 05:18:57'),
(12, 1, 12, 1, 'Zwei Dinge sind unendlich, das Universum und die menschliche Dummheit, aber bei dem Universum bin ich mir noch nicht ganz sicher.', 1736, 0, '0', '2021-12-20 05:18:58'),
(13, 1, 3, 1, 'Es gibt keinen Weg zum Glück. Glücklich-sein ist der Weg.', 1578, 0, '0', '2021-12-20 05:18:58'),
(14, 1, 12, 1, 'Phantasie ist wichtiger als Wissen, denn Wissen ist begrenzt.', 1408, 0, '1', '2021-12-20 05:18:58'),
(15, 1, 15, 1, 'Es gibt nur zwei Tage im Jahr, an denen man nichts tun kann. Der eine ist Gestern, der andere Morgen. Dies bedeutet, dass heute der richtige Tag zum Lieben, Glauben und in erster Linie zum Leben ist.', 1373, 0, '0', '2021-12-20 05:18:58'),
(16, 1, 3, 1, 'Wenn du ein Problem hast, versuche es zu lösen. Kannst du es nicht lösen, dann mache kein Problem daraus.', 1373, 0, '0', '2021-12-20 05:18:59'),
(17, 1, 17, 1, 'Der Kluge lernt aus allem und von jedem, der Normale aus seinen Erfahrungen und der Dumme weiß alles besser.', 1276, 0, '0', '2021-12-20 05:18:59'),
(18, 1, 18, 1, 'Diejenigen die wir lieben, können uns am meisten verletzen.', 1266, 0, '0', '2021-12-20 05:18:59'),
(19, 1, 19, 1, 'Immer die Wahrheit sagen bringt einem wahrscheinlich nicht viele Freunde, aber dafür die Richtigen.', 1232, 0, '0', '2021-12-20 05:18:59'),
(20, 1, 8, 1, 'Wenn du dein Hier und Jetzt unerträglich findest und es dich unglücklich macht, dann gibt es drei Möglichkeiten: Verlasse die Situation, verändere sie oder akzeptiere sie ganz. Wenn du Verantwortung für dein Leben übernehmen willst, dann musst du eine dieser drei Möglichkeiten wählen, und du musst die Wahl jetzt treffen.', 1229, 0, '0', '2021-12-20 05:18:59'),
(21, 1, 3, 1, 'Lerne loszulassen, das ist der Schlüssel zum Glück.', 1198, 0, '0', '2021-12-20 05:19:00'),
(22, 1, 22, 1, 'Mir ist egal ob du schwarz, weiß, hetero, bisexuell, schwul, lesbisch, klein, groß, fett, dünn, reich oder arm bist. Wenn du nett zu mir bist, werde ich auch nett zu dir sein. Ganz einfach.', 1159, 0, '0', '2021-12-20 05:19:00'),
(23, 1, 3, 1, 'Niemals in der Welt hört Hass durch Hass auf. Hass hört durch Liebe auf.', 1093, 0, '0', '2021-12-20 05:19:00'),
(24, 1, 24, 1, 'Wer glaubt, ein Christ zu sein, weil er die Kirche besucht, irrt sich. Man wird ja auch kein Auto, wenn man in eine Garage geht.', 1064, 0, '0', '2021-12-20 05:19:00'),
(25, 1, 12, 1, 'Wenn die Menschen nur über das sprächen, was sie begreifen, dann würde es sehr still auf der Welt sein.', 984, 0, '0', '2021-12-20 05:19:01'),
(26, 1, 5, 1, 'Fange an, diesen Moment zu leben und du wirst sehen - je mehr du lebst, desto weniger Probleme wird es geben.', 907, 0, '0', '2021-12-20 05:19:01'),
(27, 1, 3, 1, 'Wir sind, was wir denken. Alles, was wir sind, entsteht aus unseren Gedanken. Mit unseren Gedanken formen wir die Welt.', 885, 0, '0', '2021-12-20 05:19:01'),
(28, 1, 28, 1, 'Am Ende werden wir uns nicht an die Worte unserer Feinde erinnern, sondern an das Schweigen unserer Freunde.', 849, 0, '0', '2021-12-20 05:19:01'),
(29, 1, 10, 1, 'Glück entsteht oft durch Aufmerksamkeit in kleinen Dingen, Unglück oft durch Vernachlässigung kleiner Dinge.', 815, 0, '0', '2021-12-20 05:19:01'),
(30, 1, 5, 1, 'Vergiss die Idee, Jemand zu werden - du bist schon ein Meisterstück. Du kannst nicht verbessert werden. Du musst es nur erkennen, realisieren.', 795, 0, '0', '2021-12-20 05:19:02'),
(31, 1, 3, 1, 'Niemand rettet uns, außer wir selbst. Niemand kann und niemand darf das. Wir müssen selbst den Weg gehen.', 793, 0, '0', '2021-12-20 05:19:02'),
(32, 1, 15, 1, 'Falls du glaubst, dass du zu klein bist, um etwas zu bewirken, dann versuche mal zu schlafen, wenn eine Mücke im Raum ist.', 775, 0, '0', '2021-12-20 05:19:02'),
(33, 1, 18, 1, 'Liebe ist was dich lächeln lässt wenn du müde bist.', 760, 0, '0', '2021-12-20 05:19:02'),
(34, 1, 1, 1, 'Die Seele hat die Farbe deiner Gedanken.', 727, 0, '0', '2021-12-20 05:19:03'),
(35, 1, 35, 1, 'Es ist kein Anzeichen von seelischer Gesundheit sich an eine zutiefst gestörte Gesellschaft anpassen zu können.', 714, 0, '0', '2021-12-20 05:19:03'),
(36, 1, 15, 1, 'In der Wut verliert der Mensch seine Intelligenz.', 708, 0, '0', '2021-12-20 05:19:03'),
(37, 1, 18, 1, 'Was andere Menschen von dir denken ist nicht dein Problem.', 706, 0, '0', '2021-12-20 05:19:03'),
(38, 1, 24, 1, 'Das schönste Denkmal, das ein Mensch bekommen kann, steht in den Herzen der Mitmenschen.', 687, 0, '0', '2021-12-20 05:19:03'),
(39, 1, 12, 1, 'Wer keinen Sinn im Leben sieht, ist nicht nur unglücklich, sondern kaum lebensfähig.', 687, 0, '0', '2021-12-20 05:19:04'),
(40, 1, 40, 1, 'Ein weises Mädchen küsst, aber liebt nicht, hört zu, aber glaubt nicht und verlässt, bevor sie verlassen wird.', 677, 0, '0', '2021-12-20 05:19:04'),
(41, 1, 3, 1, 'Wer seinen Wohlstand vermehren möchte, der sollte sich an den Bienen ein Beispiel nehmen. Sie sammeln den Honig, ohne die Blumen zu zerstören. Sie sind sogar nützlich für die Blumen. Sammle deinen Reichtum, ohne seine Quellen zu zerstören, dann wird er beständig zunehmen.', 656, 0, '0', '2021-12-20 05:19:04'),
(42, 1, 3, 1, 'Es nützt nichts, nur ein guter Mensch zu sein, wenn man nichts tut!', 654, 0, '0', '2021-12-20 05:19:04'),
(43, 1, 3, 1, 'Der Weg liegt nicht im Himmel. Der Weg liegt im Herzen.', 647, 0, '0', '2021-12-20 05:19:04'),
(44, 1, 5, 1, 'Wenn du dich selbst liebst, liebst du deine Mitmenschen. Wenn du dich selbst hasst, hasst du deine Mitmenschen. Deine Beziehung zu den anderen ist nur ein Spiegelbild von dir selbst.', 642, 0, '0', '2021-12-20 05:19:05'),
(45, 1, 5, 1, 'Jeder Mensch kommt mit einem speziellen Schicksal auf diese Welt. Er hat etwas zu vollbringen, eine Nachricht zu vermitteln, eine Arbeit fertigzustellen.', 634, 0, '0', '2021-12-20 05:19:05'),
(46, 1, 22, 1, 'Liebe ist nur ein Wort, aber du selbst definierst es.', 624, 0, '0', '2021-12-20 05:19:05'),
(47, 1, 18, 1, 'Eines Tages wirst du aufwachen und keine Zeit mehr haben für die Dinge, die du immer wolltest. Tu sie jetzt.', 619, 0, '0', '2021-12-20 05:19:05'),
(48, 1, 12, 1, 'Ich fürchte mich vor dem Tag, an dem die Technologie unsere Menschlichkeit übertrifft. Auf der Welt wird es nur noch eine Generation aus Idioten geben.', 596, 0, '0', '2021-12-20 05:19:06'),
(49, 1, 49, 1, 'Man muß das Unmögliche versuchen, um das Mögliche zu erreichen.', 591, 0, '0', '2021-12-20 05:19:06'),
(50, 1, 50, 1, 'Ein tiefer Fall führt oft zu hohem Glück.', 589, 0, '0', '2021-12-20 05:19:06'),
(51, 1, 5, 1, 'Lebe dein Leben auf alle möglichen Arten - gut-schlecht, bitter-süß, dunkel-hell, Sommer-Winter. Lebe alle Dualitäten. Habe keine Angst Erfahrungen zu machen, denn umso mehr Erfahrung du hast, umso reifer wirst du werden.', 580, 0, '0', '2021-12-20 05:19:06'),
(52, 1, 52, 1, 'Der Schwache kann nicht verzeihen. Verzeihen ist eine Eigenschaft des Starken.', 577, 0, '0', '2021-12-20 05:19:06'),
(53, 1, 12, 1, 'Wenn ich mit meiner Relativitätstheorie recht behalte, werden die Deutschen sagen, ich sei Deutscher, und die Franzosen, ich sei Weltbürger. Erweist sich meine Theorie als falsch, werden die Franzosen sagen, ich sei Deutscher, und die Deutschen, ich sei Jude.', 568, 0, '0', '2021-12-20 05:19:07'),
(54, 1, 5, 1, 'Sei - versuche nicht, zu werden.', 566, 0, '0', '2021-12-20 05:19:07'),
(55, 1, 12, 1, 'Ich bin nicht sicher, mit welchen Waffen der dritte Weltkrieg ausgetragen wird, aber im vierten Weltkrieg werden sie mit Stöcken und Steinen kämpfen.', 546, 0, '0', '2021-12-20 05:19:07'),
(56, 1, 15, 1, 'Denke daran, dass etwas, was du nicht bekommst, manchmal eine wunderbare Fügung des Schicksals sein kann.', 528, 0, '0', '2021-12-20 05:19:07'),
(57, 1, 57, 1, 'Wenn du damit beginnst, dich denen aufzuopfern, die du liebst, wirst du damit enden, die zu hassen, denen du dich aufgeopfert hast.', 528, 0, '0', '2021-12-20 05:19:08'),
(58, 1, 3, 1, 'Du wirst morgen sein, was Du heute denkst.', 527, 0, '0', '2021-12-20 05:19:08'),
(59, 1, 12, 1, 'Das Schönste, was wir erleben können, ist das Geheimnisvolle.', 524, 0, '0', '2021-12-20 05:19:08'),
(60, 1, 10, 1, 'Was man ernst meint, sagt man am besten im Spaß.', 524, 0, '0', '2021-12-20 05:19:08'),
(61, 1, 28, 1, 'Ich habe zuviel Hass gesehen, als dass ich selber hassen möchte.', 503, 0, '0', '2021-12-20 05:19:08'),
(62, 1, 18, 1, 'Warten ist schmerzhaft. Vergessen ist schmerzhaft. Aber nicht zu wissen, was davon man tun soll, ist das Schlimmste.', 476, 0, '0', '2021-12-20 05:19:09'),
(63, 1, 8, 1, 'Wenn du dich jemals in einer Notsituation auf Leben und Tod befunden hast, wirst du wissen, dass es da kein Problem gab. Der Verstand hatte keine Zeit, mit der Situation herumzuspielen und ein Problem daraus zu machen. In einer wirklichen Notlage hält der Verstand an - du wirst vollkommen gegenwärtig im Jetzt und eine unendlich viel größere Kraft übernimmt die Führung. Deshalb gibt es so viele Berichte von ganz normalen Leuten, die plötzlich unglaublich mutig handeln konnten.', 474, 0, '0', '2021-12-20 05:19:09'),
(64, 1, 3, 1, 'Wenn du wissen willst, wer du warst, dann schau, wer du bist. Wenn du wissen willst, wer du sein wirst, dann schau, was du tust.', 472, 0, '0', '2021-12-20 05:19:09'),
(65, 1, 49, 1, 'Man braucht vor niemand Angst zu haben. Wenn man jemanden fürchtet, dann kommt es daher, daß man diesem Jemand Macht über sich eingeräumt hat. (Demian)', 471, 0, '0', '2021-12-20 05:19:09'),
(66, 1, 5, 1, 'Der Tod des Egos wird der Beginn deines wahren Lebens sein.', 466, 0, '0', '2021-12-20 05:19:09'),
(67, 1, 24, 1, 'Mit zwanzig Jahren hat jeder das Gesicht, das Gott ihm gegeben hat, mit vierzig das Gesicht, das ihm das Leben gegeben hat, und mit sechzig das Gesicht, das er verdient.', 462, 0, '0', '2021-12-20 05:19:10'),
(68, 1, 49, 1, 'Leute mit Mut und Charakter sind den anderen Leuten immer sehr unheimlich.', 441, 0, '0', '2021-12-20 05:19:10'),
(69, 1, 69, 1, 'Enttäuscht vom Affen, schuf Gott den Menschen. Danach verzichtete er auf weitere Experimente.', 438, 0, '0', '2021-12-20 05:19:10'),
(70, 1, 15, 1, 'Das Leben aller Lebewesen, seien sie nun Menschen, Tiere oder andere, ist kostbar, und alle haben dasselbe Recht, glücklich zu sein. Alles, was unseren Planeten bevölkert, die Vögel und die wilden Tiere sind unsere Gefährten. Sie sind Teil unserer Welt, wir teilen sie mit ihnen.', 430, 0, '0', '2021-12-20 05:19:10'),
(71, 1, 15, 1, 'Denke daran, dass Schweigen manchmal die beste Antwort ist.', 427, 0, '0', '2021-12-20 05:19:11'),
(72, 1, 12, 1, 'Welch triste Epoche, in der es leichter ist, ein Atom zu zertrümmern als ein Vorurteil!', 427, 0, '0', '2021-12-20 05:19:11'),
(73, 1, 73, 1, 'Das Problem dieser Welt ist, dass die intelligenten Menschen so voller Selbstzweifel und die Dummen so voller Selbstvertrauen sind.', 424, 0, '0', '2021-12-20 05:19:11'),
(74, 1, 74, 1, 'Ich werde lieber für das gehasst, was ich bin, als für das geliebt zu werden, was ich nicht bin.', 419, 0, '0', '2021-12-20 05:19:11'),
(75, 1, 12, 1, 'Persönlichkeiten werden nicht durch schöne Reden geformt, sondern durch Arbeit und eigene Leistung.', 408, 0, '0', '2021-12-20 05:19:11'),
(76, 1, 76, 1, 'Es gibt nur eine Sache die größer ist als die Liebe zur Freiheit: Der Hass auf die Person, die sie dir weg nimmt.', 407, 0, '0', '2021-12-20 05:19:12'),
(77, 1, 3, 1, 'Wer liebt, vollbringt selbst Unmögliches.', 401, 0, '0', '2021-12-20 05:19:12'),
(78, 1, 15, 1, 'Jede schwierige Situation, die du jetzt meisterst, bleibt dir in der Zukunft erspart.', 395, 0, '0', '2021-12-20 05:19:12'),
(79, 1, 24, 1, 'Tierschutz ist Erziehung zur Menschlichkeit.', 390, 0, '0', '2021-12-20 05:19:12'),
(80, 1, 80, 1, 'Lasse nie zu, dass du jemandem begegnest, der nicht nach der Begegnung mit dir glücklicher ist.', 388, 0, '0', '2021-12-20 05:19:12'),
(81, 1, 69, 1, 'Gib jedem Tag die Chance, der schönste deines Lebens zu werden.', 386, 0, '0', '2021-12-20 05:19:13'),
(82, 1, 82, 1, 'Am schlimmsten ist die Einsamkeit zu zweit.', 381, 0, '0', '2021-12-20 05:19:13'),
(83, 1, 24, 1, 'Viele Menschen wissen, dass sie unglücklich sind. Aber noch mehr Menschen wissen nicht, dass sie glücklich sind.', 379, 0, '0', '2021-12-20 05:19:13'),
(84, 1, 12, 1, 'Am Anfang gehören alle Gedanken der Liebe. Später gehört dann alle Liebe den Gedanken.', 377, 0, '0', '2021-12-20 05:19:13'),
(85, 1, 18, 1, 'Wir sind nicht das, was die Leute von uns erwarten, oder so wie sie sich uns wünschen. Wir sind, wer wir zu sein beschlossen haben. Den anderen die Schuld zu geben ist immer einfach. Damit kannst du dein ganzes Leben zubringen, aber letztlich bist du allein für deine Erfolge oder deine Niederlagen verantwortlich. (Aleph)', 375, 0, '0', '2021-12-20 05:19:13'),
(86, 1, 86, 1, 'Wenn du kritisiert wirst, dann musst du irgend etwas richtig machen. Denn man greift nur denjenigen an, der den Ball hat.', 372, 0, '0', '2021-12-20 05:19:14'),
(87, 1, 17, 1, 'Bedenke stets, daß alles vergänglich ist; dann wirst du im Glück nicht zu fröhlich und im Leid nicht zu traurig sein.', 368, 0, '0', '2021-12-20 05:19:14'),
(88, 1, 15, 1, 'Respektiere dich selbst, respektiere andere und übernimm Verantwortung für das was du tust.', 366, 0, '0', '2021-12-20 05:19:14'),
(89, 1, 19, 1, 'Üblicherweise steht hinter jedem Idiot eine großartige Frau.', 362, 0, '0', '2021-12-20 05:19:14'),
(90, 1, 28, 1, 'Ich habe einen Traum, dass meine vier Kinder eines Tages in einer Nation leben werden, in der man sie nicht nach ihrer Hautfarbe, sondern nach ihrem Charakter beurteilen wird.', 360, 0, '0', '2021-12-20 05:19:15'),
(91, 1, 8, 1, 'Jeder, der mit seinem Verstand identifiziert ist statt mit seiner wahren Stärke, dem tieferen, im Sein verankerten Selbst, wird die Angst als ständigen Begleiter haben.', 359, 0, '0', '2021-12-20 05:19:15'),
(92, 1, 74, 1, 'Niemand stirbt als Jungfrau... das Leben fickt uns alle.', 359, 0, '0', '2021-12-20 05:19:15'),
(93, 1, 28, 1, 'Wir müssen lernen, entweder als Brüder miteinander zu leben oder als Narren unterzugehen.', 359, 0, '0', '2021-12-20 05:19:15'),
(94, 1, 5, 1, 'Trauer bringt Tiefe. Freude bringt Höhe. Trauer bringt Wurzeln. Freude bringt Äste. Freude ist wie ein Baum der sich dem Himmel entgegenstreckt und Trauer ist wie die Wurzeln die in das Erdinnere hineinwachsen. Beides wird benötigt - je höher ein Baum wächst, desto tiefer verwurzelt er sich in der der Erde. So wird die Balance aufrechterhalten.', 358, 0, '0', '2021-12-20 05:19:15'),
(95, 1, 24, 1, 'Wir leben in einem gefährlichen Zeitalter. Der Mensch beherrscht die Natur, bevor er gelernt hat, sich selbst zu beherrschen.', 354, 0, '0', '2021-12-20 05:19:16'),
(96, 1, 9, 1, 'Binde zwei Vögel zusammen; sie werden nicht fliegen können obwohl sie nun vier Flügel haben.', 349, 0, '0', '2021-12-20 05:19:16'),
(97, 1, 3, 1, 'Groll mit uns herumtragen ist wie das Greifen nach einem glühenden Stück Kohle in der Absicht, es nach jemandem zu werfen. Man verbrennt sich nur selbst dabei.', 349, 0, '0', '2021-12-20 05:19:16'),
(98, 1, 1, 1, 'Unser Leben ist das, wozu unser Denken es macht.', 346, 0, '0', '2021-12-20 05:19:16'),
(99, 1, 99, 1, 'Jede kleine Ehrlichkeit ist besser als eine große Lüge.', 345, 0, '0', '2021-12-20 05:19:17'),
(100, 1, 102, 2, 'Zeig ma', 1, 0, '0', '2021-12-20 12:57:04'),
(101, 1, 9, 3, 'Some nice words', 0, 0, '0', '2021-12-20 14:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_authors`
--

CREATE TABLE `quotes_authors` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `author_name` varchar(124) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_authors`
--

INSERT INTO `quotes_authors` (`id`, `uid`, `author_name`, `timestamp`) VALUES
(1, 1, 'Mark Aurel', '2021-12-20 05:18:55'),
(2, 1, 'Arthur Schopenhauer', '2021-12-20 05:18:55'),
(3, 1, 'Buddha', '2021-12-20 05:18:56'),
(4, 1, 'G. I. Gurdjieff', '2021-12-20 05:18:56'),
(5, 1, 'Osho', '2021-12-20 05:18:56'),
(7, 1, 'Mooji', '2021-12-20 05:18:56'),
(8, 1, 'Eckhart Tolle', '2021-12-20 05:18:57'),
(9, 1, 'Rumi', '2021-12-20 05:18:57'),
(10, 1, 'Wilhelm Busch', '2021-12-20 05:18:57'),
(12, 1, 'Albert Einstein', '2021-12-20 05:18:58'),
(15, 1, 'Dalai Lama', '2021-12-20 05:18:58'),
(17, 1, 'Sokrates', '2021-12-20 05:18:59'),
(18, 1, 'Paulo Coelho', '2021-12-20 05:18:59'),
(19, 1, 'John Lennon', '2021-12-20 05:18:59'),
(22, 1, 'Eminem', '2021-12-20 05:19:00'),
(24, 1, 'Albert Schweitzer', '2021-12-20 05:19:00'),
(28, 1, 'Martin Luther King', '2021-12-20 05:19:01'),
(35, 1, 'Jiddu Krishnamurti', '2021-12-20 05:19:03'),
(40, 1, 'Marilyn Monroe', '2021-12-20 05:19:04'),
(49, 1, 'Hermann Hesse', '2021-12-20 05:19:06'),
(50, 1, 'William Shakespeare', '2021-12-20 05:19:06'),
(52, 1, 'Mahatma Gandhi', '2021-12-20 05:19:06'),
(57, 1, 'George Bernard Shaw', '2021-12-20 05:19:08'),
(69, 1, 'Mark Twain', '2021-12-20 05:19:10'),
(73, 1, 'Charles Bukowski', '2021-12-20 05:19:11'),
(74, 1, 'Kurt Cobain', '2021-12-20 05:19:11'),
(76, 1, 'Che Guevara', '2021-12-20 05:19:11'),
(80, 1, 'Mutter Teresa', '2021-12-20 05:19:12'),
(82, 1, 'Erich Kästner', '2021-12-20 05:19:13'),
(86, 1, 'Bruce Lee', '2021-12-20 05:19:14'),
(99, 1, 'Leonardo da Vinci', '2021-12-20 05:19:17'),
(102, 1, 'Zusmori', '2021-12-20 12:56:58');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_categories`
--

CREATE TABLE `quotes_categories` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `category_name` varchar(124) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_categories`
--

INSERT INTO `quotes_categories` (`id`, `uid`, `category_name`, `timestamp`) VALUES
(1, 1, 'Gedanken', '2021-12-20 05:18:55'),
(2, 1, 'Vergangenheit', '2021-12-20 05:18:56'),
(3, 1, 'Gegenwart', '2021-12-20 05:18:56'),
(4, 1, 'Veränderung', '2021-12-20 05:18:56'),
(5, 1, 'Freundschaft', '2021-12-20 05:18:56'),
(6, 1, 'Liebe', '2021-12-20 05:18:56'),
(7, 1, 'Erleuchtung', '2021-12-20 05:18:56'),
(8, 1, 'Leid', '2021-12-20 05:18:56'),
(9, 1, 'Seele', '2021-12-20 05:18:56'),
(12, 1, 'Illusion', '2021-12-20 05:18:57'),
(13, 1, 'Leben', '2021-12-20 05:18:57'),
(14, 1, 'Angst', '2021-12-20 05:18:57'),
(18, 1, 'Dummheit', '2021-12-20 05:18:58'),
(19, 1, 'Weg', '2021-12-20 05:18:58'),
(20, 1, 'Glück', '2021-12-20 05:18:58'),
(21, 1, 'Wissen', '2021-12-20 05:18:58'),
(26, 1, 'Glauben', '2021-12-20 05:18:58'),
(27, 1, 'Zukunft', '2021-12-20 05:18:58'),
(28, 1, 'Problem', '2021-12-20 05:18:59'),
(30, 1, 'Weisheit', '2021-12-20 05:18:59'),
(33, 1, 'Wahrheit', '2021-12-20 05:18:59'),
(38, 1, 'Urteilen', '2021-12-20 05:19:00'),
(39, 1, 'Rassismus', '2021-12-20 05:19:00'),
(40, 1, 'Körper', '2021-12-20 05:19:00'),
(41, 1, 'Rap', '2021-12-20 05:19:00'),
(43, 1, 'Hass', '2021-12-20 05:19:00'),
(44, 1, 'Religion', '2021-12-20 05:19:00'),
(50, 1, 'Krieg', '2021-12-20 05:19:01'),
(51, 1, 'Achtsamkeit', '2021-12-20 05:19:01'),
(54, 1, 'Ziel', '2021-12-20 05:19:02'),
(61, 1, 'Wut', '2021-12-20 05:19:03'),
(62, 1, 'Intelligenz', '2021-12-20 05:19:03'),
(69, 1, 'Reichtum', '2021-12-20 05:19:04'),
(75, 1, 'Schicksal', '2021-12-20 05:19:05'),
(80, 1, 'Zeit', '2021-12-20 05:19:05'),
(82, 1, 'Menschheit', '2021-12-20 05:19:06'),
(83, 1, 'Technologie', '2021-12-20 05:19:06'),
(84, 1, 'Erfolg', '2021-12-20 05:19:06'),
(101, 1, 'Tod', '2021-12-20 05:19:09'),
(106, 1, 'Ego', '2021-12-20 05:19:09'),
(109, 1, 'Mut', '2021-12-20 05:19:10'),
(110, 1, 'Charakter', '2021-12-20 05:19:10'),
(111, 1, 'Gott', '2021-12-20 05:19:10'),
(113, 1, 'Natur', '2021-12-20 05:19:10'),
(114, 1, 'Mensch', '2021-12-20 05:19:10'),
(115, 1, 'Welt', '2021-12-20 05:19:10'),
(117, 1, 'Tiere', '2021-12-20 05:19:10'),
(120, 1, 'Zweifel', '2021-12-20 05:19:11'),
(124, 1, 'Selbstbewusstsein', '2021-12-20 05:19:11'),
(128, 1, 'Arbeit', '2021-12-20 05:19:11'),
(131, 1, 'Freiheit', '2021-12-20 05:19:12'),
(135, 1, 'Freude', '2021-12-20 05:19:12'),
(139, 1, 'Schönheit', '2021-12-20 05:19:13'),
(140, 1, 'Einsamkeit', '2021-12-20 05:19:13'),
(141, 1, 'Beziehung', '2021-12-20 05:19:13'),
(148, 1, 'Schuld', '2021-12-20 05:19:13'),
(150, 1, 'Kritik', '2021-12-20 05:19:14'),
(152, 1, 'Vergänglichkeit', '2021-12-20 05:19:14'),
(155, 1, 'Verantwortung', '2021-12-20 05:19:14'),
(156, 1, 'Respekt', '2021-12-20 05:19:14'),
(158, 1, 'Frau', '2021-12-20 05:19:14'),
(163, 1, 'Identifikation', '2021-12-20 05:19:15'),
(166, 1, 'Sex', '2021-12-20 05:19:15'),
(169, 1, 'Trauer', '2021-12-20 05:19:15'),
(170, 1, 'Bewusstsein', '2021-12-20 05:19:16'),
(173, 1, 'Emotionen', '2021-12-20 05:19:16'),
(177, 1, 'Ehrlichkeit', '2021-12-20 05:19:17'),
(178, 1, 'Geilheit', '2021-12-20 12:57:17'),
(179, 1, 'Poem', '2021-12-20 14:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_categories_used`
--

CREATE TABLE `quotes_categories_used` (
  `id` int(255) NOT NULL,
  `qid` int(255) NOT NULL,
  `cid` int(255) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_categories_used`
--

INSERT INTO `quotes_categories_used` (`id`, `qid`, `cid`, `timestamp`) VALUES
(1, 2, 1, '2021-12-20 06:18:55'),
(2, 3, 2, '2021-12-20 06:18:56'),
(3, 3, 3, '2021-12-20 06:18:56'),
(4, 4, 4, '2021-12-20 06:18:56'),
(5, 5, 5, '2021-12-20 06:18:56'),
(6, 5, 6, '2021-12-20 06:18:56'),
(7, 6, 7, '2021-12-20 06:18:56'),
(8, 6, 8, '2021-12-20 06:18:56'),
(9, 7, 9, '2021-12-20 06:18:56'),
(10, 8, 2, '2021-12-20 06:18:57'),
(11, 8, 3, '2021-12-20 06:18:57'),
(12, 8, 12, '2021-12-20 06:18:57'),
(13, 9, 13, '2021-12-20 06:18:57'),
(14, 9, 14, '2021-12-20 06:18:57'),
(15, 10, 1, '2021-12-20 06:18:57'),
(16, 11, 2, '2021-12-20 06:18:57'),
(17, 11, 3, '2021-12-20 06:18:57'),
(18, 12, 18, '2021-12-20 06:18:58'),
(19, 13, 19, '2021-12-20 06:18:58'),
(20, 13, 20, '2021-12-20 06:18:58'),
(21, 14, 21, '2021-12-20 06:18:58'),
(22, 15, 13, '2021-12-20 06:18:58'),
(23, 15, 6, '2021-12-20 06:18:58'),
(24, 15, 2, '2021-12-20 06:18:58'),
(25, 15, 3, '2021-12-20 06:18:58'),
(26, 15, 26, '2021-12-20 06:18:58'),
(27, 15, 27, '2021-12-20 06:18:58'),
(28, 16, 28, '2021-12-20 06:18:59'),
(29, 17, 18, '2021-12-20 06:18:59'),
(30, 17, 30, '2021-12-20 06:18:59'),
(31, 18, 6, '2021-12-20 06:18:59'),
(32, 19, 5, '2021-12-20 06:18:59'),
(33, 19, 33, '2021-12-20 06:18:59'),
(34, 20, 13, '2021-12-20 06:18:59'),
(35, 20, 3, '2021-12-20 06:18:59'),
(36, 21, 33, '2021-12-20 06:19:00'),
(37, 22, 5, '2021-12-20 06:19:00'),
(38, 22, 38, '2021-12-20 06:19:00'),
(39, 22, 39, '2021-12-20 06:19:00'),
(40, 22, 40, '2021-12-20 06:19:00'),
(41, 22, 41, '2021-12-20 06:19:00'),
(42, 23, 6, '2021-12-20 06:19:00'),
(43, 23, 43, '2021-12-20 06:19:00'),
(44, 24, 44, '2021-12-20 06:19:00'),
(45, 24, 26, '2021-12-20 06:19:00'),
(46, 26, 13, '2021-12-20 06:19:01'),
(47, 26, 4, '2021-12-20 06:19:01'),
(48, 27, 1, '2021-12-20 06:19:01'),
(49, 28, 5, '2021-12-20 06:19:01'),
(50, 28, 50, '2021-12-20 06:19:01'),
(51, 29, 51, '2021-12-20 06:19:01'),
(52, 29, 20, '2021-12-20 06:19:01'),
(53, 30, 4, '2021-12-20 06:19:02'),
(54, 30, 54, '2021-12-20 06:19:02'),
(55, 31, 4, '2021-12-20 06:19:02'),
(56, 31, 19, '2021-12-20 06:19:02'),
(57, 32, 12, '2021-12-20 06:19:02'),
(58, 33, 6, '2021-12-20 06:19:02'),
(59, 34, 1, '2021-12-20 06:19:03'),
(60, 34, 9, '2021-12-20 06:19:03'),
(61, 36, 61, '2021-12-20 06:19:03'),
(62, 36, 62, '2021-12-20 06:19:03'),
(63, 37, 1, '2021-12-20 06:19:03'),
(64, 37, 28, '2021-12-20 06:19:03'),
(65, 38, 5, '2021-12-20 06:19:03'),
(66, 39, 13, '2021-12-20 06:19:04'),
(67, 40, 6, '2021-12-20 06:19:04'),
(68, 40, 30, '2021-12-20 06:19:04'),
(69, 41, 69, '2021-12-20 06:19:04'),
(70, 43, 19, '2021-12-20 06:19:04'),
(71, 44, 5, '2021-12-20 06:19:05'),
(72, 44, 6, '2021-12-20 06:19:05'),
(73, 44, 43, '2021-12-20 06:19:05'),
(74, 45, 13, '2021-12-20 06:19:05'),
(75, 45, 75, '2021-12-20 06:19:05'),
(76, 45, 54, '2021-12-20 06:19:05'),
(77, 46, 6, '2021-12-20 06:19:05'),
(78, 46, 41, '2021-12-20 06:19:05'),
(79, 47, 3, '2021-12-20 06:19:05'),
(80, 47, 80, '2021-12-20 06:19:05'),
(81, 48, 18, '2021-12-20 06:19:06'),
(82, 48, 82, '2021-12-20 06:19:06'),
(83, 48, 83, '2021-12-20 06:19:06'),
(84, 49, 84, '2021-12-20 06:19:06'),
(85, 50, 4, '2021-12-20 06:19:06'),
(86, 50, 19, '2021-12-20 06:19:06'),
(87, 51, 13, '2021-12-20 06:19:06'),
(88, 52, 2, '2021-12-20 06:19:06'),
(89, 54, 13, '2021-12-20 06:19:07'),
(90, 55, 50, '2021-12-20 06:19:07'),
(91, 56, 75, '2021-12-20 06:19:07'),
(92, 57, 6, '2021-12-20 06:19:08'),
(93, 57, 43, '2021-12-20 06:19:08'),
(94, 58, 1, '2021-12-20 06:19:08'),
(95, 61, 6, '2021-12-20 06:19:08'),
(96, 61, 43, '2021-12-20 06:19:08'),
(97, 62, 21, '2021-12-20 06:19:09'),
(98, 62, 8, '2021-12-20 06:19:09'),
(99, 63, 13, '2021-12-20 06:19:09'),
(100, 63, 3, '2021-12-20 06:19:09'),
(101, 63, 101, '2021-12-20 06:19:09'),
(102, 64, 3, '2021-12-20 06:19:09'),
(103, 65, 14, '2021-12-20 06:19:09'),
(104, 66, 13, '2021-12-20 06:19:09'),
(105, 66, 4, '2021-12-20 06:19:09'),
(106, 66, 106, '2021-12-20 06:19:09'),
(107, 67, 13, '2021-12-20 06:19:10'),
(108, 67, 80, '2021-12-20 06:19:10'),
(109, 68, 109, '2021-12-20 06:19:10'),
(110, 68, 110, '2021-12-20 06:19:10'),
(111, 69, 111, '2021-12-20 06:19:10'),
(112, 69, 82, '2021-12-20 06:19:10'),
(113, 69, 113, '2021-12-20 06:19:10'),
(114, 69, 114, '2021-12-20 06:19:10'),
(115, 70, 115, '2021-12-20 06:19:10'),
(116, 70, 113, '2021-12-20 06:19:10'),
(117, 70, 117, '2021-12-20 06:19:10'),
(118, 72, 38, '2021-12-20 06:19:11'),
(119, 73, 18, '2021-12-20 06:19:11'),
(120, 73, 120, '2021-12-20 06:19:11'),
(121, 73, 115, '2021-12-20 06:19:11'),
(122, 73, 28, '2021-12-20 06:19:11'),
(123, 73, 62, '2021-12-20 06:19:11'),
(124, 73, 124, '2021-12-20 06:19:11'),
(125, 74, 6, '2021-12-20 06:19:11'),
(126, 74, 43, '2021-12-20 06:19:11'),
(127, 74, 124, '2021-12-20 06:19:11'),
(128, 75, 128, '2021-12-20 06:19:11'),
(129, 76, 6, '2021-12-20 06:19:12'),
(130, 76, 43, '2021-12-20 06:19:12'),
(131, 76, 131, '2021-12-20 06:19:12'),
(132, 77, 6, '2021-12-20 06:19:12'),
(133, 78, 3, '2021-12-20 06:19:12'),
(134, 78, 27, '2021-12-20 06:19:12'),
(135, 80, 135, '2021-12-20 06:19:12'),
(136, 80, 20, '2021-12-20 06:19:12'),
(137, 81, 13, '2021-12-20 06:19:13'),
(138, 81, 3, '2021-12-20 06:19:13'),
(139, 81, 139, '2021-12-20 06:19:13'),
(140, 82, 140, '2021-12-20 06:19:13'),
(141, 82, 141, '2021-12-20 06:19:13'),
(142, 83, 135, '2021-12-20 06:19:13'),
(143, 83, 21, '2021-12-20 06:19:13'),
(144, 84, 6, '2021-12-20 06:19:13'),
(145, 84, 1, '2021-12-20 06:19:13'),
(146, 85, 13, '2021-12-20 06:19:13'),
(147, 85, 84, '2021-12-20 06:19:13'),
(148, 85, 148, '2021-12-20 06:19:13'),
(149, 86, 84, '2021-12-20 06:19:14'),
(150, 86, 150, '2021-12-20 06:19:14'),
(151, 87, 135, '2021-12-20 06:19:14'),
(152, 87, 152, '2021-12-20 06:19:14'),
(153, 87, 8, '2021-12-20 06:19:14'),
(154, 87, 20, '2021-12-20 06:19:14'),
(155, 88, 155, '2021-12-20 06:19:14'),
(156, 88, 156, '2021-12-20 06:19:14'),
(157, 89, 18, '2021-12-20 06:19:14'),
(158, 89, 158, '2021-12-20 06:19:14'),
(159, 90, 38, '2021-12-20 06:19:15'),
(160, 90, 39, '2021-12-20 06:19:15'),
(161, 91, 14, '2021-12-20 06:19:15'),
(162, 91, 9, '2021-12-20 06:19:15'),
(163, 91, 163, '2021-12-20 06:19:15'),
(164, 92, 13, '2021-12-20 06:19:15'),
(165, 92, 8, '2021-12-20 06:19:15'),
(166, 92, 166, '2021-12-20 06:19:15'),
(167, 93, 5, '2021-12-20 06:19:15'),
(168, 94, 135, '2021-12-20 06:19:15'),
(169, 94, 169, '2021-12-20 06:19:15'),
(170, 95, 170, '2021-12-20 06:19:16'),
(171, 96, 21, '2021-12-20 06:19:16'),
(172, 97, 61, '2021-12-20 06:19:16'),
(173, 97, 173, '2021-12-20 06:19:16'),
(174, 98, 13, '2021-12-20 06:19:16'),
(175, 98, 1, '2021-12-20 06:19:16'),
(176, 99, 33, '2021-12-20 06:19:17'),
(177, 99, 177, '2021-12-20 06:19:17'),
(178, 100, 178, '2021-12-20 13:57:17'),
(179, 101, 179, '2021-12-20 15:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_favorites`
--

CREATE TABLE `quotes_favorites` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `qid` int(255) NOT NULL,
  `deleted` enum('1','0') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_favorites`
--

INSERT INTO `quotes_favorites` (`id`, `uid`, `qid`, `deleted`, `timestamp`) VALUES
(1, 1, 13, '1', '2021-09-03 04:44:21'),
(2, 1, 15, '1', '2021-09-03 04:44:22'),
(3, 1, 35, '1', '2021-09-03 04:44:23'),
(4, 1, 34, '0', '2021-09-03 04:44:23'),
(5, 3, 18, '1', '2021-09-03 05:11:06'),
(6, 3, 34, '0', '2021-09-03 05:11:15'),
(7, 3, 13, '0', '2021-09-03 05:23:37'),
(8, 3, 29, '0', '2021-09-03 05:58:07'),
(9, 3, 16, '1', '2021-09-04 02:49:32'),
(10, 3, 31, '1', '2021-09-04 02:49:33'),
(11, 3, 32, '1', '2021-09-04 02:49:34'),
(12, 1, 27, '1', '2021-09-04 05:21:01'),
(13, 1, 39, '1', '2021-09-05 03:17:37'),
(14, 1, 36, '1', '2021-09-05 07:39:09'),
(15, 1, 16, '1', '2021-09-05 09:19:20'),
(16, 1, 29, '1', '2021-09-05 09:19:21'),
(17, 1, 40, '1', '2021-09-05 09:19:21'),
(18, 1, 42, '1', '2021-09-05 09:21:30'),
(19, 1, 47, '1', '2021-09-05 20:32:41'),
(20, 3, 2, '1', '2021-09-05 23:55:20'),
(21, 1, 31, '1', '2021-09-06 23:59:58'),
(22, 1, 32, '1', '2021-09-07 05:01:19'),
(23, 1, 28, '1', '2021-09-07 05:01:20'),
(24, 1, 41, '1', '2021-09-07 05:01:20'),
(25, 3, 15, '1', '2021-09-07 16:36:19'),
(26, 3, 42, '1', '2021-09-09 10:20:40'),
(27, 3, 1, '0', '2021-09-09 10:20:42'),
(28, 1, 33, '1', '2021-09-10 01:58:09'),
(29, 15, 40, '0', '2021-09-10 04:05:12'),
(30, 10, 28, '1', '2021-09-21 00:23:05'),
(31, 1, 1, '0', '2021-09-22 03:37:03'),
(32, 1, 54, '1', '2021-11-17 10:57:47'),
(33, 4, 1, '1', '2021-12-19 22:15:06'),
(34, 4, 2, '1', '2021-12-19 22:15:09'),
(35, 1, 2, '1', '2021-12-20 05:16:52'),
(36, 1, 100, '0', '2021-12-20 12:59:08'),
(37, 1, 67, '1', '2021-12-20 13:38:05'),
(38, 1, 3, '0', '2021-12-20 14:07:46'),
(39, 1, 10, '1', '2021-12-20 14:23:57'),
(40, 1, 8, '1', '2021-12-20 14:58:58'),
(41, 1, 7, '0', '2021-12-20 20:07:25'),
(42, 1, 12, '0', '2021-12-20 20:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_reports`
--

CREATE TABLE `quotes_reports` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `qid` int(255) NOT NULL,
  `cid` int(255) NOT NULL,
  `comment` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_reports`
--

INSERT INTO `quotes_reports` (`id`, `uid`, `qid`, `cid`, `comment`, `timestamp`) VALUES
(1, 3, 13, 2, '', '2021-09-09 06:14:16'),
(2, 1, 1, 3, 'sucks ass\r\n\r\n\r\n\r\nlolol', '2021-11-17 21:54:50'),
(3, 1, 40, 3, 'hello my friends lol', '2021-11-18 15:28:47'),
(4, 1, 1, 3, 'ass', '2021-12-15 23:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_reports_categories`
--

CREATE TABLE `quotes_reports_categories` (
  `id` int(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_reports_categories`
--

INSERT INTO `quotes_reports_categories` (`id`, `category`, `timestamp`) VALUES
(1, 'Duplicate', '2021-08-27 20:42:40'),
(2, 'Inappropriate language', '2021-08-27 20:42:40'),
(3, 'Copyrighted content', '2021-08-27 20:42:40'),
(4, 'Spam', '2021-08-27 20:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `quotes_sources`
--

CREATE TABLE `quotes_sources` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `source_name` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quotes_sources`
--

INSERT INTO `quotes_sources` (`id`, `uid`, `source_name`, `timestamp`) VALUES
(1, 0, 'zitatenzumnachdenken.com', '2021-12-20 03:42:25'),
(2, 1, 'Twitch', '2021-12-20 12:57:09'),
(3, 1, 'Book', '2021-12-20 14:39:01');

-- --------------------------------------------------------

--
-- Table structure for table `system_sessions`
--

CREATE TABLE `system_sessions` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `token` varchar(168) NOT NULL,
  `serial` varchar(168) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `remoteaddr` varchar(124) NOT NULL,
  `httpx` varchar(124) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_sessions`
--

INSERT INTO `system_sessions` (`id`, `uid`, `token`, `serial`, `timestamp`, `remoteaddr`, `httpx`) VALUES
(20, 3, '271114d9c57fce34d4f43f76bfbc01436f3b4583a36f2b6f6c78cd4c013f9a66aa5d62bd4cdf10cc6fcd77175472609cc673e816e1b7c1684a6f11e7ab0e6142', 'c6a58badfb185e5b4b5ebe2a1b86147fc43ea9f98f3019e6e72820d5cc7da80e8966a3fecbca540eb75479ed17db0febe8dd735066de719d0d21096980311433', '2021-08-29 04:08:23', '::1', '::1'),
(22, 1, 'dace9c9b8fd5b70e4bcf8400a540de952d995e158135178ca399bf3aa51ef9ae247b853cc7432a02dae836f42662638211a9681a785bd99e4677b6013cace0b9', 'd41b96eddf071ce5736a8003780a1d717edbfec0686019a1409d6df9576e00631b494c2f048a81dd77b88d30b777b85512e49e6712a63632c87ed27b7fc561b1', '2021-08-29 06:47:04', '::1', '::1'),
(23, 11, 'e0c288e1db3bf085a3e7e55eb678ef0b5db4070a7c5a19529d86c2531f100eb9f0843be4d7715415585cbd523745c3913bbefccf617683c2f803a29d8a11af16', 'efff985470558898d3cb3bea2728dfdf7ac1cbd58bb9769b50669380b9b290ec494b913e4139bfa549c4fd2d1d0f9c2ba892ef6fc9af724fadb254f501fab4a2', '2021-08-29 16:37:44', '::1', '::1'),
(25, 13, 'e83ed6c8da938d91b82487dd7db105e13930e7c81aca6bda2994d3245fafb2691d0bfe7e68d40f3b3de8737e9d42204546814608d19070d44e2aebb8eb4962ec', '518a3d2d5396cbf64e443a60db044a20e38550d5320380dc07800e2c1532f3cfe76c4a405ae1c3e0e46f6c23459c449043c163d59e2ebef88e23648f31507e08', '2021-08-29 16:41:59', '::1', '::1'),
(26, 14, '15fb844354d4c1366a6c9d7526e5cee1bea607a0cbdb00248edb0ef462d942dab1f808eb8eb1bfd9983eb1b24c1b596ae33cd7f4636de312525aba5ddc00f6bc', '8b5376c908427ea19f3261ca27bfd9eb6580fd262687ad7bf42b66d41f4b60312af5303e2843efd5a089625e01c12bce8f4a7bc70dc9e2a547de6fd265d7f4ee', '2021-08-30 01:57:12', '::1', '::1'),
(27, 15, 'c648d2733cfe14be8e1ba24f65027c1046594287288e4b5e8121ea488a5bc96eadd912582f045d8c77c7edb219cc737507010950c1b9220cf765e0be3aa4a07b', 'bdc2a340225e5cdd12790e5134aea5b659b309feb2d06697f76d2985d8450a36c0f63e679249924cd91d2573fe4c81d8076b7d422b6a5bba48cdbf16288cc399', '2021-08-31 14:51:43', '::1', '::1'),
(28, 9, '7b301bb6b633549471d07eb3ebaf8c6a569e9e7f3151d6de46e18dc03567775f1711e984e4ef1498a9b3693fa0dd1699ace79d25b4559c82fd3e3710ea3fd036', '4e30597e8544ad491832bf7487050ae03fa76acb12f26a91d5bd7bbf7258f252a95e646c2b17049fe660780a9d6dc7939b4b151c3ffc7c3a1121cc2e543e8ce4', '2021-09-04 14:26:31', '::1', '::1'),
(29, 16, '574d6ac7018acbe2859ba0649b4133caa33c892a63d1f7d2877d3985cd72681ffee19f241298419e79ccd4b82782d45c0750876174395b5cef5a7ba6384bbba2', '775786b1923688467deb56712ba6ff68721bee8cf18d3e39fca765ddc52ce37d989df2a5b11db5abfab57d022001aa5f0db02377d98286146efb7b5aed2796ee', '2021-09-07 03:55:32', '::1', '::1'),
(30, 17, '3b8ea55c20623381e4e8f2c23240af18b7c64bbd270321e39923487cff45ada7dea4c5a7cb6e69d69847e2370e6375dbf6c5649475cf46c1b7befd0e86228c38', '51940f1b25138ad191bf555f6add16e69c5da30d3f824be4f7b3908e8f6f425ada728f37af693ff5a561ce65b0076406ad94aaecdabadad65eaf18e59f5920f6', '2021-09-07 16:31:01', '::1', '::1'),
(31, 10, '72866712a32fb4bca50adf83ccc3213d5f36b9dd40d070661cf6e55bc61e27115244ec90e433a7179f8602191c9c4c863a5f9aacdce82faf2d2751840420d7bc', '7f996f41fff7f80550091d5718edcee3e1a2afd471169adc13ab47189af40ef7ddef0bff0734f9eafaff360ac61df7d9b6c88694f4896ae18358a41237f34841', '2021-09-11 09:11:06', '127.0.0.1', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `year` int(4) NOT NULL,
  `maintenance` enum('0','1') NOT NULL DEFAULT '1',
  `displayerrors` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `year`, `maintenance`, `displayerrors`) VALUES
(1, 'ThinkQuotes', 2021, '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `system_updates`
--

CREATE TABLE `system_updates` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `update_text` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_updates`
--

INSERT INTO `system_updates` (`id`, `uid`, `update_text`, `timestamp`) VALUES
(1, 1, '<p>\r\nThinkquotes just received some beauty updates and minor additions. See what\'s new below:\r\n</p>\r\n<p class=\"mt12\">\r\n<ul>\r\n<li><img src=\"https://icons.thinkquotes.de/openmoji/1F966.svg\"> A new, minimalistic logo in the center of the header</li>\r\n<li><img src=\"https://icons.thinkquotes.de/openmoji/1F351.svg\"> A wider view for quotes</li>\r\n<li><img src=\"https://icons.thinkquotes.de/openmoji/1F352.svg\"> Profile pages for you and others!</li>\r\n<li><img src=\"https://icons.thinkquotes.de/openmoji/1F336.svg\"> Upvote, report and add system for quotes</li>\r\n</p>\r\n<p class=\"mt12\">\r\nBearded greets,<br>\r\n&lt;brudermusscode/&gt;\r\n</p>', '2021-09-07 17:51:36'),
(2, 1, '<p><img src=\"https://icons.thinkquotes.de/openmoji/1F966.svg\"> Add multiple categories for one quote and get suggestions on authors, sources and categories based on your typing! <img src=\"https://icons.thinkquotes.de/openmoji/1F966.svg\"></p>', '2021-09-08 04:19:56'),
(3, 1, '<p>Quotes can be edited now! Add or remove new categories, change author and source or the text, which the quote is all about <img src=\"https://icons.thinkquotes.de/openmoji/1F355.svg\"></p>\r\n\r\n<p class=\"mt12\"><img src=\"https://icons.thinkquotes.de/openmoji/1F359.svg\"> The editor uses the exact same layout as the adding popup. </p>', '2021-09-08 04:49:17'),
(4, 1, '<p>ThinkQuotes now features a data privacy policy, disclaimer and imprint! The right is on our sid(t)e!</p>\r\n\r\n<p class=\"mt12\"><img src=\"https://icons.thinkquotes.de/openmoji/26A0.svg\"> Not every page is accessible, but they will be added in the future.</p>\r\n<p class=\"mt12\"><img src=\"https://icons.thinkquotes.de/openmoji/27A1.svg\"> Find it here:<br>\r\n<a href=\"https://hajimeno.thinkquotes.de/\">https://hajimeno.thinkquotes.de</a></p>', '2021-09-08 04:49:35'),
(5, 1, '<p>\r\n<img src=\"https://icons.thinkquotes.de/openmoji/1F34B.svg\"> An update page just has been added to the intern section of the website! Here you will find the same posts as you do in this discord channel. I am thinking about giving those updates in a small box on the bottom of the page as well. Just for the time of development ofc! <img src=\"https://icons.thinkquotes.de/openmoji/1FAD0.svg\">\r\n</p>', '2021-09-09 04:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `system_updates_images`
--

CREATE TABLE `system_updates_images` (
  `id` int(11) NOT NULL,
  `suid` int(11) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_updates_images`
--

INSERT INTO `system_updates_images` (`id`, `suid`, `image`) VALUES
(1, 1, '1.png'),
(3, 2, '2.png'),
(4, 3, '3.png'),
(5, 4, '4.png'),
(6, 5, '5.png');

-- --------------------------------------------------------

--
-- Table structure for table `system_urls`
--

CREATE TABLE `system_urls` (
  `id` int(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `url_maintenance` varchar(50) NOT NULL,
  `url_intern` varchar(50) NOT NULL,
  `url_mobile` varchar(50) NOT NULL,
  `url_error` varchar(50) NOT NULL,
  `url_css` varchar(50) NOT NULL,
  `url_js` varchar(50) NOT NULL,
  `url_img` varchar(50) NOT NULL,
  `url_icons` varchar(50) NOT NULL,
  `url_sounds` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_urls`
--

INSERT INTO `system_urls` (`id`, `url`, `url_maintenance`, `url_intern`, `url_mobile`, `url_error`, `url_css`, `url_js`, `url_img`, `url_icons`, `url_sounds`) VALUES
(1, 'http://localhost', 'http://localhost/m/maintenance', 'http://localhost/intern', '', 'http://localhost/404', 'http://localhost/assets/design/scss/compiled', 'http://localhost/assets/design/modules', 'http://localhost/assets/design/images', 'https://icons.thinkquotes.de', 'https://sounds.thinkquotes.de'),
(2, 'https://www.thinkquotes.de', 'https://www.thinkquotes.de/m/maintenance', 'https://www.thinkquotes.de/intern', '', 'https://www.thinkquotes.de/404', 'https://beauty.thinkquotes.de', 'https://hacks.thinkquotes.de', 'https://images.thinkquotes.de', 'https://icons.thinkquotes.de', 'https://sounds.thinkquotes.de');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(24) NOT NULL DEFAULT '',
  `mail` varchar(100) NOT NULL,
  `remoteaddr` varchar(100) NOT NULL,
  `httpx` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `mail`, `remoteaddr`, `httpx`, `timestamp`) VALUES
(0, 'Hurensohn', 'noreply@thinkquotes.de', '::1', '::1', '2021-12-20 02:30:57'),
(1, 'brudermusscode', 'justinleonseidel@gmail.com', '::1', '::1', '2021-12-17 19:29:51'),
(2, 'Ramastin', 'r4mastin@gmail.com', '::1', '::1', '2021-12-19 21:58:43'),
(6, '', 'JUSTINLEONSEIDEL@PROTONMAIL.COM', '127.0.0.1', '127.0.0.1', '2022-03-08 08:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `users_authentications`
--

CREATE TABLE `users_authentications` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `authCode` varchar(4) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_authentications`
--

INSERT INTO `users_authentications` (`id`, `uid`, `authCode`, `used`, `timestamp`) VALUES
(26, 1, '8745', 1, '2021-12-20 14:33:37'),
(27, 1, '5072', 0, '2022-03-08 09:44:50'),
(28, 1, '2618', 0, '2022-03-08 09:44:55'),
(29, 1, '8391', 0, '2022-03-08 09:44:58'),
(30, 1, '1042', 0, '2022-03-08 09:45:00'),
(31, 1, '3957', 0, '2022-03-08 09:45:02'),
(32, 1, '9571', 0, '2022-03-08 09:45:04'),
(33, 1, '6804', 0, '2022-03-08 09:45:06'),
(34, 1, '3124', 0, '2022-03-08 09:45:17'),
(35, 1, '7346', 0, '2022-03-08 09:45:20'),
(36, 6, '6213', 0, '2022-03-08 09:45:57'),
(37, 6, '1734', 0, '2022-03-08 09:46:12'),
(38, 6, '6483', 0, '2022-03-08 09:47:10'),
(39, 1, '7549', 0, '2022-03-08 09:47:15'),
(40, 1, '1650', 0, '2022-03-08 09:47:18'),
(41, 1, '3526', 0, '2022-03-08 09:47:20'),
(42, 1, '1450', 0, '2022-03-08 09:47:22'),
(43, 1, '3472', 0, '2022-03-08 09:47:24'),
(44, 1, '0163', 0, '2022-03-08 09:47:27'),
(45, 1, '6509', 0, '2022-03-08 09:47:30'),
(46, 1, '0647', 0, '2022-03-08 09:47:32'),
(47, 1, '9762', 0, '2022-03-08 09:47:34'),
(48, 1, '4201', 0, '2022-03-08 09:47:36'),
(49, 1, '2948', 0, '2022-03-08 09:47:38'),
(50, 1, '3679', 0, '2022-03-08 09:47:40'),
(51, 1, '1895', 0, '2022-03-08 09:47:42'),
(52, 1, '7490', 0, '2022-03-08 09:47:44'),
(53, 1, '6972', 0, '2022-03-08 09:47:46'),
(54, 1, '5190', 0, '2022-03-08 09:47:48'),
(55, 1, '3862', 0, '2022-03-08 09:47:50'),
(56, 1, '8650', 0, '2022-03-08 09:47:52'),
(57, 1, '4197', 0, '2022-03-08 09:47:55'),
(58, 1, '0245', 0, '2022-03-08 09:47:57'),
(59, 1, '9637', 0, '2022-03-08 09:47:59'),
(60, 1, '2451', 0, '2022-03-08 09:48:01'),
(61, 1, '2761', 0, '2022-03-08 09:48:03'),
(62, 1, '2586', 0, '2022-03-08 09:48:05'),
(63, 1, '7350', 0, '2022-03-08 09:48:07'),
(64, 1, '9248', 0, '2022-03-08 09:48:09'),
(65, 1, '3965', 0, '2022-03-08 09:48:11'),
(66, 1, '7428', 0, '2022-03-08 09:48:13'),
(67, 1, '4036', 0, '2022-03-08 09:48:15'),
(68, 1, '7169', 0, '2022-03-08 09:48:17'),
(69, 1, '7304', 0, '2022-04-17 19:58:10'),
(70, 1, '4261', 0, '2022-04-17 19:58:12'),
(71, 1, '6205', 0, '2022-04-17 19:58:14'),
(72, 6, '7290', 0, '2022-04-17 19:58:18');

-- --------------------------------------------------------

--
-- Table structure for table `users_friends`
--

CREATE TABLE `users_friends` (
  `id` int(11) NOT NULL,
  `uid1` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_friends_requests`
--

CREATE TABLE `users_friends_requests` (
  `id` int(11) NOT NULL,
  `sent` int(11) NOT NULL,
  `got` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(60) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions_in`
--

CREATE TABLE `users_permissions_in` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions_ranks`
--

CREATE TABLE `users_permissions_ranks` (
  `id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions_ranks_granted`
--

CREATE TABLE `users_permissions_ranks_granted` (
  `id` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` varchar(200) NOT NULL,
  `serial` varchar(200) NOT NULL,
  `timestamp` varchar(20) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`id`, `uid`, `token`, `serial`, `timestamp`) VALUES
(1, 1, '748a1ca6f483847a1b76cf8fc1d56c7b91a5add3fa8febb619683bd58c16774e7a13', '83b93ebcbcff4ccca75aad505c94e1ca2d6d1e719356f2b1278a1f12db2b6ef38796', '2021-12-17 20:30:31'),
(2, 1, '579e078f2267b233dfa6b0b029f3c0f4f3551aeefda0dbb5d00376e65fad9d469f02', '5eec8f5c405a8c10b80a2f50a9a5b28ac0facf09bb4ab34887ed9016e5857d71bcbc', '2021-12-17 21:43:53'),
(3, 1, 'd44757eabbf253e9e833c29fc77d150bb23e54a3229afbcb6cb2d84b53a0d2b30c79', '74dfc695ffa4d60b66e0f46344c0d12049b8622d2af326438ae224265c676f0e4cc8', '2021-12-18 00:38:41'),
(4, 1, '6962d421de259b04e27fddd5fea949c098aa24e5ab3a43bc443c348bc90cf92dfd41', '79c20593e6ac291f3d716fc61ac1de30e54237ee175d19d53f914effced03684c3ff', '2021-12-18 17:28:58'),
(5, 1, '635ae68b040b391f852f289d5af75ed6c3cefc8069f3d4518282407cb1e2f173d62f', '0bb85a62cbdec78de08fe50f016375a819eae513ba876618e6c6875c6467051aae4d', '2021-12-18 20:37:54'),
(6, 4, '9e535b376b4da942427f4b3c5652978c836b9c87fe7e9c4f40a36d937d94b8f8fadd', 'c5497e9a3c5a0ec1281e649137a07f34025c4c98049eb14346db600fa0115d9bff21', '2021-12-19 22:59:05'),
(7, 1, '0c4f69c7a739757ae00419e2ad563414ba5fd49945ff07b41858d31da49a1abad26d', '2d7366c6abe2708b0a42452f7c4dca048595a8cbaae8e1f1d9df6483c2518245a427', '2021-12-20 01:23:52'),
(8, 1, 'f4faf8c7f0f33b71b012351cbbb4ca2899d90ba27888d2fd756d5568c8a016bf753f', '89fbd5855267a7787df25f2adf70cc1c6bed3a49f9f577e22ff47af67f6528aa0385', '2021-12-20 01:29:10'),
(9, 1, '73b0865a3ef9c74fb874fa223df01a2ef98af9f5c28454d652c6518f1f3d300337bd', '60413ad80f09f2abbf95b53c8f33879ffa933beb955fe019110bbc963bf9d647af2a', '2021-12-20 01:30:58'),
(10, 1, 'cc301ea0d3daa3eb00a8f0ad7a5de07b4b5959819dcd9d1d00dd2ee08fef82f7da51', 'dd46df6543e6b06d716cfa0f5ee1b305572bd4ea664698ce7428d3c0ef1526b39b8d', '2021-12-20 01:33:37'),
(11, 1, 'abdcd190cf06737b14923668851ce6b03d80624e74dfd07bec3991a54eafc85c9ef5', 'e9f5b44e18f38a74ee8f6e6c1aeb10dc18c8011b44785ffe735459d0301f950b9edc', '2021-12-20 01:34:47'),
(12, 1, '51fb7324b8848321df1c9330b321964ccdee5e56f8b2fa58919ed3afb3a68eb7d995', '6b28aec18749ca8b2664929c96059450370ab22417e3d48ac23792920ffa30d691c0', '2021-12-20 01:36:36'),
(13, 1, 'c13e757738782b9305ee605bc509c6b82de5c62d5ffeeb6297233f0736b23f44f08a', 'e957731c029b6cd6bb350d55dcb2c71888f766442c4c33c12a9eb2b72a15613fd1b6', '2021-12-20 01:37:28'),
(14, 1, '98d72020ee1b3ff28d6bd1194c032d2197ecc6e59bb90af250ece9f77d46a77e5a80', '0fa96111f678491699cbb041c3689e7ffb0aaf532d91de023fa5f7b058f1d8055bfc', '2021-12-20 01:38:01'),
(15, 4, '6af76629b7b07649310a50cc7aadc899aa035240a6019d350bc0b9f8774d5a9dafe4', '915ceb39216b5541b4ecc491e2421613779675795e05115123daf1b7d7fd87945c8a', '2021-12-20 06:21:21'),
(16, 1, '539f5d9508d3b4ff920a02ab8279073d4fbf4d5e13e5502881ed7a8201e3a50ba284', 'e77a9e8db959e21d8eddc4e23de80d366114cfb633b650d4aa661735eb1561ab0f30', '2021-12-20 06:22:46'),
(17, 1, '6348eb7140c4349ef065471af1fa69ae4dacb0f60b33b2fb5c76bd4c66d868297230', 'e30b40aeacf2eb5880a55935283c9132026e113102971cdefd06d26cb46d314e0eb8', '2021-12-20 07:02:17'),
(18, 4, '14de94a00dc650a5d17df72fa9adbbedd5aff1e0ed6788f63cfbe852f4cd1af64a04', 'b3c21beb11485dacfd1479e39766ca4391d5a56c8d6b65e839125697d0a0de6a0982', '2021-12-20 07:05:19'),
(19, 1, 'c6e75ee050d7fc94d5821ea615b23696d73205b60ebf7904b503d795d7a0be5f5161', '828844aa8fb483b112f4229165710b510df7ca01e5ddec3552b10994ed02735c3531', '2021-12-20 07:31:34'),
(20, 1, '80231c0e719c5e19888ea4d024f8cf6eb416ad52d4ec694ee97d29074227df4c3fdc', '695fc48f20e4ba4e1f5aa2c2084316cbda846b5d448d3856436117badc27a42cbf56', '2021-12-20 13:14:05'),
(21, 1, 'd154e308612081a10ea8419dcb490b6a42932fec4f17e9525f559eeb42795cd8455c', '161cb1bd805d709389c39d96c1e02991c8eee749de917633236c440dff8e38e2683c', '2021-12-20 14:04:55'),
(22, 1, 'd6eb6eb97769bf82e33a0bd7e27db0fbac5df7a75a69ef6ca1eeb671661ba2c1f4cf', '1b35a0413a440503c7140f9692bd744a09b481e6b4b4e8a166d905fb6fb5cd081472', '2021-12-20 14:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `users_settings`
--

CREATE TABLE `users_settings` (
  `id` int(255) NOT NULL,
  `uid` int(255) NOT NULL,
  `admin` enum('1','0') NOT NULL DEFAULT '0',
  `post_permissions` enum('none','quote','full') NOT NULL DEFAULT 'quote',
  `send_friendrequests` enum('all','friendsoffriends','nobody') NOT NULL DEFAULT 'all',
  `show_profile` enum('all','friendsoffriends','friends','nobody') NOT NULL DEFAULT 'all',
  `show_profile_favorites` enum('all','friends','friendsoffriends','nobody') NOT NULL DEFAULT 'all',
  `check_friendrequests` enum('true','false') NOT NULL DEFAULT 'true',
  `check_updates` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_settings`
--

INSERT INTO `users_settings` (`id`, `uid`, `admin`, `post_permissions`, `send_friendrequests`, `show_profile`, `show_profile_favorites`, `check_friendrequests`, `check_updates`) VALUES
(1, 1, '1', 'full', 'all', 'all', 'all', 'true', '0'),
(2, 0, '0', 'quote', 'all', 'all', 'all', 'true', '0'),
(3, 2, '1', 'quote', 'all', 'all', 'all', 'true', '0'),
(4, 6, '0', 'quote', 'all', 'all', 'all', 'true', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `intern_main_cards`
--
ALTER TABLE `intern_main_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intern_main_sections`
--
ALTER TABLE `intern_main_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intern_team_members`
--
ALTER TABLE `intern_team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intern_team_members_social`
--
ALTER TABLE `intern_team_members_social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intern_team_members_social_added`
--
ALTER TABLE `intern_team_members_social_added`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intern_team_ranks`
--
ALTER TABLE `intern_team_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_authors`
--
ALTER TABLE `quotes_authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `author_name` (`author_name`);

--
-- Indexes for table `quotes_categories`
--
ALTER TABLE `quotes_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `quotes_categories_used`
--
ALTER TABLE `quotes_categories_used`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_favorites`
--
ALTER TABLE `quotes_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_reports`
--
ALTER TABLE `quotes_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_reports_categories`
--
ALTER TABLE `quotes_reports_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotes_sources`
--
ALTER TABLE `quotes_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `source_name` (`source_name`);

--
-- Indexes for table `system_sessions`
--
ALTER TABLE `system_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_updates`
--
ALTER TABLE `system_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_updates_images`
--
ALTER TABLE `system_updates_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_urls`
--
ALTER TABLE `system_urls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users_authentications`
--
ALTER TABLE `users_authentications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_friends`
--
ALTER TABLE `users_friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_friends_requests`
--
ALTER TABLE `users_friends_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions_in`
--
ALTER TABLE `users_permissions_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions_ranks`
--
ALTER TABLE `users_permissions_ranks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions_ranks_granted`
--
ALTER TABLE `users_permissions_ranks_granted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_settings`
--
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `intern_main_cards`
--
ALTER TABLE `intern_main_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `intern_main_sections`
--
ALTER TABLE `intern_main_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `intern_team_members`
--
ALTER TABLE `intern_team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `intern_team_members_social`
--
ALTER TABLE `intern_team_members_social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `intern_team_members_social_added`
--
ALTER TABLE `intern_team_members_social_added`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `intern_team_ranks`
--
ALTER TABLE `intern_team_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `quotes_authors`
--
ALTER TABLE `quotes_authors`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `quotes_categories`
--
ALTER TABLE `quotes_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `quotes_categories_used`
--
ALTER TABLE `quotes_categories_used`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `quotes_favorites`
--
ALTER TABLE `quotes_favorites`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `quotes_reports`
--
ALTER TABLE `quotes_reports`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quotes_reports_categories`
--
ALTER TABLE `quotes_reports_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `quotes_sources`
--
ALTER TABLE `quotes_sources`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_sessions`
--
ALTER TABLE `system_sessions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_updates`
--
ALTER TABLE `system_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_updates_images`
--
ALTER TABLE `system_updates_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_urls`
--
ALTER TABLE `system_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users_authentications`
--
ALTER TABLE `users_authentications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users_friends`
--
ALTER TABLE `users_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_friends_requests`
--
ALTER TABLE `users_friends_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_permissions_in`
--
ALTER TABLE `users_permissions_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_permissions_ranks`
--
ALTER TABLE `users_permissions_ranks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_permissions_ranks_granted`
--
ALTER TABLE `users_permissions_ranks_granted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users_settings`
--
ALTER TABLE `users_settings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

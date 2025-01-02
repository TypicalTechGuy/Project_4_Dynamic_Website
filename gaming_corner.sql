-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 10:44 AM
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
-- Database: `gaming_corner`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `published_date` datetime NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `user_id`, `published_date`, `content`, `image_url`, `category`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Marvel Rivals is The Hero Shooter We Didn\'t Know We Need', 1, '2024-12-27 18:55:00', 'One of 2024’s biggest success stories has been Marvel Rivals, a third-person PVP shooter starring Marvel heroes and baddies. The game has already picked up over 20 million players and shows no signs of stopping. Which is cool but also very surprising!\r\n\r\nI think I speak for many of us when I ask: Weren’t we done with hero shooters? After the market was saturated with them and Overwatch 2 turned out to be a slow-moving train wreck, it felt like the trend of having a colorful roster of heroes shoot each other over moving a payload was done. Concord, Sony’s failed hero shooter, seemed to really cement that when it launched and died in just about 4 weeks earlier this year. And yet, here we all are playing and loving Marvel Rivals, a free-to-play hero shooter with a big roster and plenty of payloads to move. Life is funny sometimes, huh?\r\n\r\nBecause Marvel Rivals is such a big hit, with many of us playing it, we’ve also been thinking about it a lot and writing up guides, stories, and other posts about it. So here’s everything we’ve written about Marvel Rivals in 2024 in one handy-dandy location.', 'img/articleImage/1735300549_capsule_616x353.jpg', 'Console', 'draft', '2024-12-27 11:55:49', '2024-12-27 11:56:20'),
(3, 'Naughty Dog co-founder says ‘ballooning budgets’ drove it to a Sony acquisition', 1, '2024-12-27 19:16:00', 'Andy Gavin, who co-founded Naughty Dog with Jason Rubin in 1986, is a surprisingly prolific LinkedIn poster who has recently been sharing some memories about the company’s early days. This week, he posted about the state of the studio’s finances over the years, describing how much it cost to make some of Naughty Dog’s early games and how those ever-increasing figures led the studio heads to agree to a Sony acquisition in 2000.\r\n\r\n“Our early 80s games cost less than $50,000 each to make,” Gavin wrote. “Rings of Power (‘88-91), saw budgets rise to about $100,000, but yielded slightly more than that in after tax profits in 1992. In 1993, we rolled that $100k from Rings into a self funded Way of the Warrior. But Crash Bandicoot (‘94-96) cost $1.6 million to make. By the time we got to Jak and Daxter (‘99-01), the budget busted the $15 million mark. By 2004, the cost of AAA games like Jak 3 had soared to $45-50 million — and they have been rising ever since.”\r\n\r\nAll of that led up to the Sony acquisition. As Gavin put it, “the stress of financing these ballooning budgets independently was enormous. […] Selling to Sony wasn’t just about securing a financial future for Naughty Dog. It was about giving the studio the resources to keep making the best games possible, without being crushed by the weight of skyrocketing costs and the paralyzing fear that one slip would ruin it all.”', 'img/articleImage/1735301804_Naughty-Dog-Logo.jpeg', 'Console', 'draft', '2024-12-27 12:16:44', '2024-12-27 12:17:16'),
(4, 'A Physical Deck of Balatro Cards Can Soon Be Yours For $16', 1, '2024-12-29 16:39:00', 'If your group chat is anything like Engadget\'s Slack, Balatro probably comes up several times a week. The indie poker-style title is one of the most talked-about games of the year for good reason: it\'s endlessly compelling. But what if you don\'t have a laptop, phone, Steam Deck, Switch or other console nearby and you need your fix, goshdarnit? That\'s where a physical deck of Balatro playing cards may come in handy.\r\n\r\nA $16 deck is up for preorder on Fangamer and it\'s expected to ship in March. The mockups show subtly pixellated cards that ape the game\'s art style. They have a red design on the rear — Balatro players will know that the red deck is the default set in the game.\r\n\r\nBut what of the game-changing jokers? I\'m afraid you only get four of those: Joker, Juggler, Blueprint and Gros Michel. Plus, they\'re just regular ol\' jokers here. That\'s a little disappointing, given how important jokers are in Balatro, but at least my personal favorite banana card is here. The same goes for the apparent lack of tarot, planet and spectral cards, which greatly modify each run.\r\n\r\nIt\'s fun that there\'s a physical Balatro deck on the way, but it\'s a bit of a bummer that it\'s a standard set of cards that doesn\'t really play into the convention-breaking ethos of the video game. Perhaps a board game along those lines is in the works. But for now I might have to pick up several of these decks. I\'m probably going to ruin at least one set by using a Sharpie to have 52 diamond cards.', 'img/articleImage/1735465231_Balatro_Cards.jpg', 'Retro', 'draft', '2024-12-29 09:40:31', '2024-12-29 09:41:15'),
(5, 'Balatro Breaks its CCU Record by Peaking at Over 38.5k Concurrent Players', 1, '2024-12-29 16:42:00', 'Indie hit Balatro is now experiencing a second wave of popularity. The poker roguelike continues to sell well on Steam, attracting more and more players this holiday season.\r\n\r\nAccording to SteamDB, Balatro peaked at 38,506 concurrent players on December 27. The previous record of 37.9k CCU was set on March 10, three weeks after launch.\r\n\r\nAs can be seen from the chart below, Balatro’s player count has been growing since the end of November. These are impressive results for a single-player indie game, especially given that there were no major content updates or DLCs (besides several free collaborations with other popular titles).\r\n\r\nBalatro currently has an “Overwhelmingly Positive” rating on Steam, with 98% of the 84.9k user reviews being positive. Interestingly, over 33k reviews have been left in the last 30 days, thanks to all the recent buzz surrounding the game.\r\n\r\nThis makes Balatro the highest-rated game release of 2024 on Steam, surpassing titles such as Black Myth: Wukong, Satisfactory, TCG Card Shop Simulator, and Tiny Glade.', 'img/articleImage/1735465387_saul-wants-to-show-you-his-lil-game.jpeg', 'Retro', 'draft', '2024-12-29 09:43:07', '2024-12-30 04:54:45'),
(6, 'What We\'re Expecting from Nintendo in 2025', 1, '2024-12-29 16:47:00', 'Soon it will be 2025, also known as the year Nintendo finally pulls back the curtain on its next console. After 2024 was filled with shaky rumors, alleged leaks, and nonstop speculation about the Nintendo Switch successor, we know for a fact Nintendo will share more about the next generation in less than 100 days. If that’s not exciting enough for you, the Nintendo Switch still has a few cards up its sleeve and 2025 will finally see the launch of Metroid Prime 4: Beyond, eight years after its initial announcement. And, as always, there will surely be some surprises along the way, with some possibly tied to a certain plumber’s 40th anniversary. Here’s what to expect from Nintendo in 2025.\r\n\r\nBefore we get into Switch 2, let’s recap what we already know is coming to Switch in 2025. Nintendo has been incredibly consistent at publishing a Switch game most months for the last two years, and while I’m not sure they’ll keep up that pace to the same degree in 2025, we already know about a fair number of games coming in the next few months.\r\n\r\nJanuary 16 marks the release of Donkey Kong Country Returns HD, a remaster of the 2010 Wii platformer that includes the extra levels from the 2013 3DS port. That’s right, this is the third time Nintendo is selling us Country Returns and it’s now been more than a decade since the last original Donkey Kong Country game with Tropical Freeze’s launch on Wii U. Hopefully Donkey Kong’s recent inclusion in Nintendo’s movies and theme parks will eventually result in a brand new video game, but for now you’re getting Country Returns again, and you better like it. As someone who’s bought and played both previous versions, it really is a fantastic platformer and one worth trying if you’ve never played it before.\r\n\r\nWe’re getting another HD remaster on March 20, but this one is much more exciting. After years of fan demand, Xenoblade Chronicles X Definitive Edition is finally landing on Switch, meaning the entire Xenoblade Chronicles series will be available in one place. Xenoblade Chronicles X is the odd one out in the series: It’s not directly tied to the trilogy and it was doomed to originally release on Wii U back in 2015, so this second chance at life will be many players’ first chance to dive into this enormous open world RPG. The visually enhanced Definitive Edition also adds brand new story content longtime fans will surely dissect and theorize about for years to come.\r\n\r\nRight now, those are the only firm release dates we have for Nintendo in 2025, but there are a few huge games coming sometime in the coming months. That includes Pokémon Legends: Z-A, Game Freak’s return to the Legends subseries after Arceus successfully shook things up back in 2022. We still know very little about what Legends: Z-A will entail, other than it centers around an “urban redevelopment plan” in the Kalos Region’s Lumiose City from Pokémon X & Y, and that Generation VI’s Mega Evolution is set to return in some way. Pokémon took a much needed year off in 2024 so it’s exciting to see what Legends: Z-A will look like after taking a bit more time in the oven.\r\n\r\nOne big third-party Nintendo Switch exclusive worth shouting out is Professor Layton and the New World of Steam, which is scheduled for release sometime in 2025. It’s the big return of Professor Layton and his assistant Luke after more than a decade out of the spotlight. I’m hopeful it will actually make it out on time – Level-5 has been a bit too eager to announce release windows before games are actually ready, but whenever this finally comes out it will be an exciting return for a series that’s always been heavily associated with Nintendo.', 'img/articleImage/1735728549_1735465696_what-to-expect-from-nintendo-in-2025_2k32.1200.jpg', 'Console', 'draft', '2024-12-29 09:48:16', '2025-01-01 10:49:09'),
(7, 'Master\'s Chief Returns to Fortnite Stirs Fan Upset', 3, '2024-12-30 11:53:00', 'Halo icon Master Chief returned to the Fortnite item shop last night after a lengthy absence, but his return has been marred by an unannounced change to the character\'s Xbox-exclusive design.\r\n\r\nPreviously, playing Fortnite on an Xbox console (or via Xbox Cloud Gaming) unlocked an additional, console-exclusive Matte Black version of the Master Chief skin. But when the Spartan returned to the Fortnite shop last night, new purchasers found this was no longer available.\r\n\r\nSeveral hours later, Fortnite maker Epic Games announced via the game\'s support account on X that the \"Matte Black style for The Master Chief is no longer unlockable\" and that the bonus was limited to players who had bought the outfit before this month.\r\n\r\nFortnite fans quickly pointed back to a post from Epic Games back in 2020 announcing the skin, which stated that players would unlock the Xbox-exclusive version \"at ANY point in the future\" and that there was \"no time limit for unlocking this style\".\r\n\r\nA community note has now been attached to Epic Games\' announcement today, pointing out the contradiction, while fans have said Epic Games has fumbled the announcement by only announcing the change after the skin returned on sale.\r\n\r\nEpic Games has not said why the Xbox exclusive has now ended, or whether similar PlayStation skins with console-exclusive variants (such as Horizon\'s Aloy) are also affected. We\'ve contacted the company for more.\r\n\r\nIn happier news, Fortnite has launched its Cyberpunk 2077 crossover, which includes skins for Johnny Silverhand and V.', 'img/articleImage/1735534454_master-chief.jpg', 'Console', 'draft', '2024-12-30 04:54:14', '2024-12-30 04:54:14'),
(8, 'Maimai Deluxe Character Popularity Poll Starts Today. Top Winner Will Win Prizes', 1, '2024-12-31 14:36:00', 'Sega Fave Co., Ltd. (Headquarters: Shinagawa-ku, Tokyo; President and COO: Sugino Yukio) will be holding the first popularity vote project for characters appearing in the arcade music game “maimai DX” series, “maimai DX Character Popularity Vote,” from 10:00 a.m. on Tuesday, August 20, 2024\r\n\r\nA total of 161 characters will participate, 33 from the main character category and 128 from the local character category, and votes will be accepted for each category. The characters that rank in the top 10 in each category will be turned into prizes in “Sega UFO Catcher Online”!\r\nVoting will be open from 10:00 on Tuesday, August 20th, 2024 to 23:59 on Friday, September 20th, 2024 on the special website. You can vote once a day for up to two main characters and up to three local characters.\r\n\r\nThose who participate in the voting for a total of 7 days during the voting period will receive 700 mai miles that can be used in the game. In addition, after voting, we will hold a campaign where 3 people who post their vote completion on X (formerly Twitter) will be drawn at random to win a set of “maimai deluxe best album Chiho” and “maimai deluxe best album Chiho 2”.\r\n\r\nBe sure to keep an eye out to see who will emerge from among these unique characters the winner of first place and the right to win a prize.', 'img/articleImage/1735630642_maimai-charas.jpg', 'Arcade', 'draft', '2024-12-31 07:37:22', '2024-12-31 07:37:55'),
(9, 'Valve\'s Newly Announced Deadlock Hits Peak of Near 90k Players', 1, '2024-12-31 14:39:00', 'Valve formally revealed Deadlock over the last weekend, and its closed beta hit a new peak of concurrent players not long after. The surprise MOBA shooter has 89,203 players at time of writing. It\'s just over double the original peak of 44,512 players in August 16.  Deadlock\'s existence has been known for some time, but Valve was insistent on keeping it secret up to this point. That move drew controversy after The Verge wrote about its time with the beta, and banned writer Sean Hollister after bypassing the prompt to not speak on the beta and talking about it.\r\n\r\nFor those curious, the current Deadlock peak is just above the 24-hour peak for Valve\'s older multiplayer titles like Team Fortress 2 (71,863 players) and Left 4 Dead 2 (27,904 players), plus the all-time peak for the first Left 4 Dead (30,616 players). Notably, it\'s also the first wholly new project from Valve in some time, and its newest title after last year\'s Counter-Strike 2 and Half-Life Alyx in 2020.\r\n\r\nAt time of writing, Deadlock is limited to playtesters and whoever they invite. It\'s unclear when Valve will release a wider, more open beta, or what other platforms the eventual, no-longer-secretive game will be for.', 'img/articleImage/1735630843_deadlock-title.png', 'PC', 'draft', '2024-12-31 07:40:43', '2024-12-31 07:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `authorrequest`
--

CREATE TABLE `authorrequest` (
  `RequestID` int(11) NOT NULL,
  `AuthorName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `RequestedDate` datetime DEFAULT current_timestamp(),
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorrequest`
--

INSERT INTO `authorrequest` (`RequestID`, `AuthorName`, `Email`, `RequestedDate`, `Status`, `Remarks`) VALUES
(1, 'Jane Doe', 'janedoe@gmail.com', '2025-01-02 16:22:10', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(4, 'Arcade'),
(1, 'Console'),
(2, 'PC'),
(3, 'Retro');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `created_at`, `bio`, `role`) VALUES
(1, 'Big', 'Diddy', '1000babyoilbottles@gmail.com', '$2y$10$chMuSrBjUAPib1HT9wTuI.jOB/Ah9EXw3IjOHO87wMRbrKmEOJ4EC', '2024-10-11 15:36:35', '', 'author'),
(3, 'Jane', 'Doe', 'janedoe@example.com', '$2y$10$1Ha1oP.YsOlsC7SD/6Uug.8bZ6rZoPBWZJuc2C.bQyn4fOqO7zFs.', '2024-12-30 04:28:00', NULL, 'user'),
(4, 'John', 'Doe', 'johndoe@example.com', '$2y$10$FD0k.LHKI6xdjMSuNn1vw.ZF2RkXHyXr0GUuwCjrr4uSNF.xIcfbO', '2024-12-31 10:27:57', NULL, 'user'),
(5, 'Kasane', 'Teto', 'kasaneteto@gmail.com', '$2y$10$.zOnCiajOd7SrsB9DkLCtuBejkk7vBIyhLATTRkhowaC6Qwm6xCgO', '2024-12-31 10:30:23', NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `authorrequest`
--
ALTER TABLE `authorrequest`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `authorrequest`
--
ALTER TABLE `authorrequest`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

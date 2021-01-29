-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 29. led 2021, 10:58
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `malirma_1`
--
CREATE DATABASE IF NOT EXISTS `malirma_1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `malirma_1`;

-- --------------------------------------------------------

--
-- Struktura tabulky `additional_objectives`
--

CREATE TABLE `additional_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `finish_date` date NOT NULL,
  `finished` int(11) NOT NULL,
  `comment` varchar(250) COLLATE utf8mb4_czech_ci NOT NULL,
  `medium_objectives_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `additional_objectives`
--

INSERT INTO `additional_objectives` (`id`, `name`, `finish_date`, `finished`, `comment`, `medium_objectives_id`) VALUES
(40, 'asdf', '2021-01-28', 0, 'asdff', 95),
(41, 'aaa', '2021-01-30', 0, 'aaa', 95);

-- --------------------------------------------------------

--
-- Struktura tabulky `main_objectives`
--

CREATE TABLE `main_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `finish_date` date DEFAULT NULL,
  `urgent` int(11) NOT NULL,
  `finished` int(11) NOT NULL,
  `users_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `main_objectives`
--

INSERT INTO `main_objectives` (`id`, `name`, `finish_date`, `urgent`, `finished`, `users_id`) VALUES
(125, 'testtt', '2021-01-14', 0, 1, 25),
(128, 'test', '2021-01-11', 0, 0, 25),
(129, 'test', '2021-01-22', 0, 0, 26),
(134, 'test', '2021-01-22', 0, 0, 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `medium_objectives`
--

CREATE TABLE `medium_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `finish_date` date NOT NULL,
  `finished` int(11) NOT NULL DEFAULT 0,
  `main_objectives_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `medium_objectives`
--

INSERT INTO `medium_objectives` (`id`, `name`, `finish_date`, `finished`, `main_objectives_id`) VALUES
(95, 'test1', '2021-01-22', 0, 134),
(96, 'bb', '2021-01-24', 0, 134);

-- --------------------------------------------------------

--
-- Struktura tabulky `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `id_creator` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `teams`
--

INSERT INTO `teams` (`id`, `name`, `id_creator`) VALUES
(1, 'test', 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `teams_additional_objectives`
--

CREATE TABLE `teams_additional_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `finish_date` int(11) NOT NULL,
  `finished` int(11) NOT NULL DEFAULT 0,
  `comment` int(11) NOT NULL,
  `teams_medium_objectives_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `teams_main_objectives`
--

CREATE TABLE `teams_main_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `finish_date` date NOT NULL,
  `finished` int(11) NOT NULL,
  `teams_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `teams_medium_objectives`
--

CREATE TABLE `teams_medium_objectives` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `finish_date` date NOT NULL,
  `finished` int(11) NOT NULL,
  `teams_main_objectives_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `teams_requests`
--

CREATE TABLE `teams_requests` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `permision` int(11) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `email`, `permision`) VALUES
(5, 'root', 'root', 'root', '$2y$10$eoJpq5TZAA0cOC1pNHx2uOxlFiup3hXXJVGnV3YkIqZWEYlQ9Skoa', 'root@gmail.com', 0),
(7, 'user', 'user', 'user', '$2y$10$.MngoR4NaOpmZ/gWWmGOxuRrXOJVtW.5NkiiYENEP01QqZinGJ5Me', 'user@gmail.com', 1),
(12, 'asdf', 'asdf', 'asdf', '$2y$10$uoVSLe2kM5xF7nD7Da9FvOUlOdfyRBs58QIm/NNzMsw431PcmXZtC', 'asdf@asdf.cz', 1),
(13, 'd', 'd', 'd', '$2y$10$6/sbPQlrRh7UA9ngNiMMaO/habCZvcX39h4wUyB4A/Z.qVsdsw0g2', 'd', 1),
(15, 'Mike', 'Oxlong', 'Pepehands', '$2y$10$Sls62UEC1qL6Iqz72xyIPO3.rpKtVsAWaon/w0TwxZOyE3v2nhLFu', 'iashjbiushf', 1),
(16, 'Zdravíčko', 'Šéfe', 'Rabadon420', '$2y$10$7p8bmJyym3JsSBkIpng/2.CS9dbIceWXm0YQAgFUXx55V6i9oN5kS', 'HulKotle@gmail.com', 1),
(17, 'asdff', 'asdff', 'asdff', '$2y$10$0eEXIDHIHzUYoJWBT7Khd.VHWCjuGTtxiLNFsxift5lN0FIx3gcSO', 'asdf@asdf.cz', 1),
(18, 'Abraka', 'Dabraka', 'adminus', '$2y$10$1xTYhZ1drMrYRX7L3l1qseDUM7ECt2IMSQtm3rVP7zvlkVaLlrzi2', 'adminus@adminus.cz', 1),
(19, 'n', 'n', 'nn', '$2y$10$.yzA/wJrzPm0qpPTRs.UmuKikl4cjpkEkr0aNrA40tNMs/d8RQ45G', 'n@n.n', 1),
(21, 'rozhodne ne', 'já', 'kotel', '$2y$10$PifBGQqERooQAeI8N1NgS.ItLLP8jObms4jfKnlY0GZvKeFlK8gjW', 'v@v.v', 1),
(22, 'Ufo', 'Porno', 'Mrdka', '$2y$10$TII.v1VQxsXgBA39L6ykMuBsFFEQSMae3gI8gbm6JFgcO7PJbA0/6', 'a@a.a', 1),
(23, 'Tt', 'Tt', 'tt', '$2y$10$877vGnjXssqKzNBYNZScAeityKzHy1XUtwaLlsKLHk8ryla4pYdnC', 'tt@gmail.com', 1),
(24, 'Asdf', 'Aasdf', 'asdfasf', '$2y$10$cNYI.4fKLlZ43xjCRTqBC.NqMDBcbt2/uc/zMj20QAVFJ80dnfdIO', 'asdf@email.cz', 1),
(25, 'Test', 'Test', 'test', '$2y$10$CJirTzjJYGdg.mr4pHZH6ugDRRZjGxh7yMLZVv81m4yWpDXtt45LG', 'test@test.com', 1),
(26, 'Martin', 'Malíř', 'martin', '$2y$10$rQrzjon6r.xcqO3SBzzHcO.hxS3mKlE9ukjOFo69wXyqLLNhQU0me', 'email.email@gmail.com', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users_teams`
--

CREATE TABLE `users_teams` (
  `id_users` int(11) UNSIGNED NOT NULL,
  `id_teams` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `users_teams`
--

INSERT INTO `users_teams` (`id_users`, `id_teams`) VALUES
(7, 1);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `additional_objectives`
--
ALTER TABLE `additional_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medium_objectives_id` (`medium_objectives_id`);

--
-- Klíče pro tabulku `main_objectives`
--
ALTER TABLE `main_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`) USING BTREE;

--
-- Klíče pro tabulku `medium_objectives`
--
ALTER TABLE `medium_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_objectives_id` (`main_objectives_id`);

--
-- Klíče pro tabulku `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_creator` (`id_creator`);

--
-- Klíče pro tabulku `teams_additional_objectives`
--
ALTER TABLE `teams_additional_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_medium_objectives_id` (`teams_medium_objectives_id`);

--
-- Klíče pro tabulku `teams_main_objectives`
--
ALTER TABLE `teams_main_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_id` (`teams_id`);

--
-- Klíče pro tabulku `teams_medium_objectives`
--
ALTER TABLE `teams_medium_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teams_main_objectives_id` (`teams_main_objectives_id`);

--
-- Klíče pro tabulku `teams_requests`
--
ALTER TABLE `teams_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_team` (`id_team`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users_teams`
--
ALTER TABLE `users_teams`
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_teams` (`id_teams`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `additional_objectives`
--
ALTER TABLE `additional_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pro tabulku `main_objectives`
--
ALTER TABLE `main_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT pro tabulku `medium_objectives`
--
ALTER TABLE `medium_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT pro tabulku `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `teams_additional_objectives`
--
ALTER TABLE `teams_additional_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `teams_main_objectives`
--
ALTER TABLE `teams_main_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `teams_medium_objectives`
--
ALTER TABLE `teams_medium_objectives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `teams_requests`
--
ALTER TABLE `teams_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `additional_objectives`
--
ALTER TABLE `additional_objectives`
  ADD CONSTRAINT `additional_objectives_ibfk_1` FOREIGN KEY (`medium_objectives_id`) REFERENCES `medium_objectives` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `main_objectives`
--
ALTER TABLE `main_objectives`
  ADD CONSTRAINT `main_objectives_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `medium_objectives`
--
ALTER TABLE `medium_objectives`
  ADD CONSTRAINT `medium_objectives_ibfk_1` FOREIGN KEY (`main_objectives_id`) REFERENCES `main_objectives` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`id_creator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `teams_additional_objectives`
--
ALTER TABLE `teams_additional_objectives`
  ADD CONSTRAINT `teams_additional_objectives_ibfk_1` FOREIGN KEY (`teams_medium_objectives_id`) REFERENCES `teams_medium_objectives` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `teams_main_objectives`
--
ALTER TABLE `teams_main_objectives`
  ADD CONSTRAINT `teams_main_objectives_ibfk_1` FOREIGN KEY (`teams_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `teams_medium_objectives`
--
ALTER TABLE `teams_medium_objectives`
  ADD CONSTRAINT `teams_medium_objectives_ibfk_1` FOREIGN KEY (`teams_main_objectives_id`) REFERENCES `teams_main_objectives` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `teams_requests`
--
ALTER TABLE `teams_requests`
  ADD CONSTRAINT `teams_requests_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `users_teams`
--
ALTER TABLE `users_teams`
  ADD CONSTRAINT `users_teams_ibfk_1` FOREIGN KEY (`id_teams`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_teams_ibfk_2` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

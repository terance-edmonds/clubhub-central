-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: clubhub-central.cpgx5fgyd1cs.eu-north-1.rds.amazonaws.com    Database: clubhub-central
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.16-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `club_community_chat`
--

DROP TABLE IF EXISTS `club_community_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_community_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) NOT NULL,
  `sender_club_member_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `club_community_chat_users_FK` (`sender_user_id`),
  KEY `club_community_chat_clubs_FK` (`club_id`),
  KEY `club_community_chat_club_members_FK` (`sender_club_member_id`),
  FULLTEXT KEY `club_community_chat_message_IDX` (`message`),
  CONSTRAINT `club_community_chat_club_members_FK` FOREIGN KEY (`sender_club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_community_chat_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_community_chat_users_FK` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_election_candidates`
--

DROP TABLE IF EXISTS `club_election_candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_election_candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `election_id` int(11) NOT NULL,
  `club_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `club_id` int(11) NOT NULL,
  `role` enum('PRESIDENT','TREASURER','SECRETARY') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_election_candidates_club_elections_FK` (`election_id`),
  KEY `club_election_candidates_users_FK` (`user_id`),
  KEY `club_election_candidates_club_members_FK` (`club_member_id`),
  KEY `club_election_candidates_clubs_FK` (`club_id`),
  CONSTRAINT `club_election_candidates_club_elections_FK` FOREIGN KEY (`election_id`) REFERENCES `club_elections` (`id`),
  CONSTRAINT `club_election_candidates_club_members_FK` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_election_candidates_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_election_candidates_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_election_voters`
--

DROP TABLE IF EXISTS `club_election_voters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_election_voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `election_id` int(11) NOT NULL,
  `club_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `club_id` int(11) NOT NULL,
  `did_vote` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_election_voters_club_elections_FK` (`election_id`),
  KEY `club_election_voters_users_FK` (`user_id`),
  KEY `club_election_voters_club_members_FK` (`club_member_id`),
  KEY `club_election_voters_clubs_FK` (`club_id`),
  CONSTRAINT `club_election_voters_club_elections_FK` FOREIGN KEY (`election_id`) REFERENCES `club_elections` (`id`),
  CONSTRAINT `club_election_voters_club_members_FK` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_election_voters_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_election_voters_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_election_votes`
--

DROP TABLE IF EXISTS `club_election_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_election_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `selected_candidate_id` int(11) DEFAULT NULL,
  `club_election_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('PRESIDENT','TREASURER','SECRETARY') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_election_votes_clubs_FK` (`club_id`),
  KEY `club_election_votes_club_election_voters_FK` (`voter_id`),
  KEY `club_election_votes_club_election_candidates_FK` (`selected_candidate_id`),
  KEY `club_election_votes_club_elections_FK` (`club_election_id`),
  CONSTRAINT `club_election_votes_club_election_candidates_FK` FOREIGN KEY (`selected_candidate_id`) REFERENCES `club_election_candidates` (`id`),
  CONSTRAINT `club_election_votes_club_election_voters_FK` FOREIGN KEY (`voter_id`) REFERENCES `club_election_voters` (`id`),
  CONSTRAINT `club_election_votes_club_elections_FK` FOREIGN KEY (`club_election_id`) REFERENCES `club_elections` (`id`),
  CONSTRAINT `club_election_votes_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_elections`
--

DROP TABLE IF EXISTS `club_elections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_elections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `public_results` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `club_id` int(11) NOT NULL,
  `start_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_datetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` enum('PENDING','READY','OPEN','CLOSED') NOT NULL DEFAULT 'PENDING',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_elections_clubs_FK` (`club_id`),
  FULLTEXT KEY `club_elections_title_IDX` (`title`,`description`),
  CONSTRAINT `club_elections_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_agenda`
--

DROP TABLE IF EXISTS `club_event_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `start_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `venue` varchar(100) NOT NULL,
  `note` text DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `end_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `club_event_agenda_FK` (`club_id`),
  KEY `club_event_agenda_FK_1` (`club_event_id`),
  FULLTEXT KEY `club_event_agenda_name_IDX` (`name`,`venue`,`note`),
  CONSTRAINT `club_event_agenda_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_agenda_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_budget_logs`
--

DROP TABLE IF EXISTS `club_event_budget_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_budget_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_event_id` int(11) NOT NULL,
  `club_event_budget_id` int(11) NOT NULL,
  `club_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` enum('INCOME','EXPENSE') NOT NULL,
  `club_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_event_budgets_logs_FK_3` (`user_id`),
  KEY `club_event_budgets_logs_FK_4` (`club_id`),
  KEY `club_event_budgets_logs_FK_2` (`club_member_id`),
  KEY `club_event_budgets_logs_FK` (`club_event_id`),
  KEY `club_event_budgets_logs_FK_1` (`club_event_budget_id`),
  KEY `club_event_budget_logs_description_IDX` (`description`(3072)) USING BTREE,
  CONSTRAINT `club_event_budgets_logs_FK` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_1` FOREIGN KEY (`club_event_budget_id`) REFERENCES `club_event_budgets` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_2` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_4` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_budgets`
--

DROP TABLE IF EXISTS `club_event_budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `type` enum('INCOME','EXPENSE') NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` float DEFAULT 0,
  `third_party` varchar(100) DEFAULT NULL,
  `payment_type` enum('CARD','BANK_TRANSFER','CASH','CHEQUE') NOT NULL DEFAULT 'CASH',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_budgets_FK` (`club_id`),
  KEY `club_event_budgets_FK_1` (`club_event_id`),
  FULLTEXT KEY `club_event_budgets_name_IDX` (`name`,`description`),
  CONSTRAINT `club_event_budgets_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_budgets_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_complains`
--

DROP TABLE IF EXISTS `club_event_complains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_complains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `complain` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_event_complains_FK` (`user_id`),
  KEY `club_event_complains_FK_1` (`club_event_id`),
  KEY `club_event_complains_FK_2` (`club_id`),
  CONSTRAINT `club_event_complains_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_event_complains_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`),
  CONSTRAINT `club_event_complains_FK_2` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_estimated_budgets`
--

DROP TABLE IF EXISTS `club_event_estimated_budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_estimated_budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `type` enum('INCOME','EXPENSE') NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` float DEFAULT 0,
  `third_party` varchar(100) DEFAULT NULL,
  `payment_type` enum('CARD','BANK_TRANSFER','CASH','CHEQUE') NOT NULL DEFAULT 'CASH',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_estimated_event_budgets_FK` (`club_id`),
  KEY `club_estimated_event_budgets_FK_1` (`club_event_id`),
  FULLTEXT KEY `club_event_estimated_budgets_name_IDX` (`name`,`description`),
  CONSTRAINT `club_event_estimated_budgets_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_estimated_budgets_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_group_members`
--

DROP TABLE IF EXISTS `club_event_group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_group_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `club_event_group_id` int(11) NOT NULL,
  `club_member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_event_group_members_FK` (`club_id`),
  KEY `club_event_group_members_FK_1` (`club_event_id`),
  KEY `club_event_group_members_FK_2` (`user_id`),
  KEY `club_event_group_members_FK_3` (`club_event_group_id`),
  KEY `club_event_group_members_FK_4` (`club_member_id`),
  CONSTRAINT `club_event_group_members_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_group_members_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`),
  CONSTRAINT `club_event_group_members_FK_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_event_group_members_FK_3` FOREIGN KEY (`club_event_group_id`) REFERENCES `club_event_groups` (`id`),
  CONSTRAINT `club_event_group_members_FK_4` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_groups`
--

DROP TABLE IF EXISTS `club_event_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `budget_permission` tinyint(1) DEFAULT 0,
  `details_permission` tinyint(1) DEFAULT 0,
  `registration_permission` tinyint(1) DEFAULT 0,
  `sponsor_permission` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_groups_FK` (`club_id`),
  KEY `club_event_groups_FK_1` (`club_event_id`),
  CONSTRAINT `club_event_groups_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_groups_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_packages`
--

DROP TABLE IF EXISTS `club_event_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_packages_FK` (`club_id`),
  KEY `club_event_packages_FK_1` (`club_event_id`),
  FULLTEXT KEY `club_event_packages_name_IDX` (`name`),
  CONSTRAINT `club_event_packages_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_packages_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Table for Packages';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_registrations`
--

DROP TABLE IF EXISTS `club_event_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_contact` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_registrations_FK` (`club_id`),
  KEY `club_event_registrations_FK_1` (`club_event_id`),
  FULLTEXT KEY `club_event_registrations_user_name_IDX` (`user_name`,`user_contact`,`user_email`),
  CONSTRAINT `club_event_registrations_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_registrations_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_event_sponsors`
--

DROP TABLE IF EXISTS `club_event_sponsors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_event_sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_sponsors_FK` (`club_id`),
  KEY `club_event_sponsors_FK_1` (`club_event_id`),
  KEY `club_event_sponsors_name_IDX` (`name`,`contact_person`,`contact_number`,`email`) USING BTREE,
  CONSTRAINT `club_event_sponsors_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_sponsors_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_events`
--

DROP TABLE IF EXISTS `club_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `image` text DEFAULT NULL,
  `state` enum('PROCESSING','ACTIVE','DEACTIVE') DEFAULT 'PROCESSING',
  `open_registrations` tinyint(1) DEFAULT 0,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_budget_submitted` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `incharge_budgets_verified` tinyint(1) DEFAULT 0,
  `president_budgets_verified` tinyint(1) DEFAULT 0,
  `incharge_budget_remarks` text DEFAULT NULL,
  `president_budget_remarks` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `club_events_FK` (`club_id`),
  FULLTEXT KEY `club_events_name_IDX` (`name`,`description`,`venue`),
  CONSTRAINT `club_events_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1036 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_gallery`
--

DROP TABLE IF EXISTS `club_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `image` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `club_gallery_FK` (`club_id`),
  CONSTRAINT `club_gallery_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_meeting`
--

DROP TABLE IF EXISTS `club_meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `time` datetime NOT NULL,
  `participants` int(11) NOT NULL,
  `attendence` int(11) DEFAULT NULL,
  `type` enum('CLOSED','COMMITTEE') NOT NULL DEFAULT 'CLOSED',
  PRIMARY KEY (`id`),
  KEY `club_meeting_clubs_FK` (`club_id`),
  CONSTRAINT `club_meeting_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_meeting_attendence`
--

DROP TABLE IF EXISTS `club_meeting_attendence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_meeting_attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_meeting_attendence_clubs_FK` (`club_id`),
  CONSTRAINT `club_meeting_attendence_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_meeting_member`
--

DROP TABLE IF EXISTS `club_meeting_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_meeting_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_member_documents`
--

DROP TABLE IF EXISTS `club_member_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_member_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `document` text NOT NULL,
  `club_member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_member_documents_FK` (`club_id`),
  KEY `club_member_documents_FK_1` (`user_id`),
  KEY `club_member_documents_FK_2` (`club_member_id`),
  CONSTRAINT `club_member_documents_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_member_documents_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_member_documents_FK_2` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_members`
--

DROP TABLE IF EXISTS `club_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `role` enum('MEMBER','PRESIDENT','TREASURER','SECRETARY','CLUB_IN_CHARGE') NOT NULL DEFAULT 'MEMBER',
  `state` enum('ACCEPTED','REJECTED','PROCESSING') NOT NULL DEFAULT 'PROCESSING',
  `is_deleted` tinyint(1) DEFAULT 0,
  `joined_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `club_members_FK` (`user_id`),
  KEY `club_members_FK_1` (`club_id`),
  CONSTRAINT `club_members_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_members_FK_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_post_logs`
--

DROP TABLE IF EXISTS `club_post_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_post_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `description` text DEFAULT NULL,
  `club_post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_post_logs_users_FK` (`user_id`),
  KEY `club_post_logs_clubs_FK` (`club_id`),
  KEY `club_post_logs_club_members_FK` (`club_member_id`),
  KEY `club_post_logs_club_posts_FK` (`club_post_id`),
  FULLTEXT KEY `club_post_logs_description_IDX` (`description`),
  CONSTRAINT `club_post_logs_club_members_FK` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_post_logs_club_posts_FK` FOREIGN KEY (`club_post_id`) REFERENCES `club_posts` (`id`),
  CONSTRAINT `club_post_logs_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_post_logs_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_posts`
--

DROP TABLE IF EXISTS `club_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `post_name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_datetime` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_posts_FK` (`club_id`),
  KEY `club_posts_users_FK` (`user_id`),
  FULLTEXT KEY `club_posts_post_name_IDX` (`post_name`,`description`),
  CONSTRAINT `club_posts_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_posts_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `club_requests`
--

DROP TABLE IF EXISTS `club_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_event_id` int(11) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_datetime` timestamp NULL DEFAULT current_timestamp(),
  `state` enum('PENDING','PROCESSING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `remarks` text DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_requests_club_events_FK` (`club_event_id`),
  KEY `club_requests_clubs_FK` (`club_id`),
  FULLTEXT KEY `club_requests_subject_IDX` (`subject`,`description`),
  CONSTRAINT `club_requests_club_events_FK` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`),
  CONSTRAINT `club_requests_clubs_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clubs`
--

DROP TABLE IF EXISTS `clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `state` enum('ACTIVE','DEACTIVE') NOT NULL DEFAULT 'DEACTIVE',
  `is_deleted` tinyint(1) DEFAULT 0,
  `club_in_charge_email` varchar(100) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_gallery`
--

DROP TABLE IF EXISTS `user_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_gallery_FK` (`user_id`),
  CONSTRAINT `user_gallery_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_invitations`
--

DROP TABLE IF EXISTS `user_invitations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `invitation_code` text NOT NULL,
  `is_valid` tinyint(1) DEFAULT 1,
  `club_role` enum('MEMBER','PRESIDENT','TREASURER','SECRETARY','CLUB_IN_CHARGE') DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_invitations_FK` (`user_id`),
  KEY `user_invitations_id_IDX` (`id`) USING BTREE,
  KEY `user_invitations_FK_1` (`club_id`),
  CONSTRAINT `user_invitations_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_invitations_FK_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_notification_state`
--

DROP TABLE IF EXISTS `user_notification_state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_notification_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `notification_id` int(11) NOT NULL,
  `mark_as_read` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_notification_state_users_FK` (`user_id`),
  KEY `user_notification_state_user_notifications_FK` (`notification_id`),
  CONSTRAINT `user_notification_state_user_notifications_FK` FOREIGN KEY (`notification_id`) REFERENCES `user_notifications` (`id`),
  CONSTRAINT `user_notification_state_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_notifications`
--

DROP TABLE IF EXISTS `user_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_password_tokens`
--

DROP TABLE IF EXISTS `user_password_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_password_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  `token` text NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_password_reset_users_FK` (`user_id`),
  CONSTRAINT `user_password_reset_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `role` enum('USER','ADMIN','SUPER_ADMIN') NOT NULL DEFAULT 'USER',
  `image` text DEFAULT NULL,
  `is_blacklisted` tinyint(1) DEFAULT 0,
  `is_verified` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id_IDX` (`id`) USING BTREE,
  FULLTEXT KEY `users_search_IDX` (`first_name`,`last_name`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'clubhub-central'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-21  9:20:25

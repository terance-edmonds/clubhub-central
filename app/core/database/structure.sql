-- `clubhub-central`.clubs definition

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.users definition

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
  KEY `users_search_IDX` (`first_name`,`last_name`,`email`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_events definition

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
  PRIMARY KEY (`id`),
  KEY `club_events_FK` (`club_id`),
  CONSTRAINT `club_events_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_members definition

CREATE TABLE `club_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL,
  `role` enum('MEMBER','PRESIDENT','TREASURER','SECRETARY','CLUB_IN_CHARGE') NOT NULL DEFAULT 'MEMBER',
  `state` enum('ACCEPTED','REJECTED','PROCESSING') NOT NULL DEFAULT 'PROCESSING',
  PRIMARY KEY (`id`),
  KEY `club_members_FK` (`user_id`),
  KEY `club_members_FK_1` (`club_id`),
  CONSTRAINT `club_members_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_members_FK_1` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.user_invitations definition

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_budgets definition

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
  CONSTRAINT `club_event_budgets_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_budgets_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_groups definition

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_packages definition

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
  CONSTRAINT `club_event_packages_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_packages_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Table for Packages';


-- `clubhub-central`.club_event_registrations definition

CREATE TABLE `club_event_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_contact` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `club_event_registrations_FK` (`club_id`),
  KEY `club_event_registrations_FK_1` (`club_event_id`),
  CONSTRAINT `club_event_registrations_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_registrations_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_sponsors definition

CREATE TABLE `club_event_sponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) NOT NULL,
  `club_event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `contact_number` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `club_event_sponsors_FK` (`club_id`),
  KEY `club_event_sponsors_FK_1` (`club_event_id`),
  CONSTRAINT `club_event_sponsors_FK` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`),
  CONSTRAINT `club_event_sponsors_FK_1` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_member_documents definition

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_budget_logs definition

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
  CONSTRAINT `club_event_budgets_logs_FK` FOREIGN KEY (`club_event_id`) REFERENCES `club_events` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_1` FOREIGN KEY (`club_event_budget_id`) REFERENCES `club_event_budgets` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_2` FOREIGN KEY (`club_member_id`) REFERENCES `club_members` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `club_event_budgets_logs_FK_4` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- `clubhub-central`.club_event_group_members definition

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
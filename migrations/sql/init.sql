/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`               int(10) unsigned NOT NULL AUTO_INCREMENT,
    `is_active`        int(10) unsigned NOT NULL DEFAULT '1',
    `phone`            varchar(45) CHARACTER SET utf8mb4 NOT NULL,
    `email`            varchar(45) CHARACTER SET utf8mb4 NOT NULL,
    `first_name`       varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
    `last_name`        varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
    `balance_prev`     decimal(10, 2)                    DEFAULT '0.00',
    `balance`          decimal(10, 2)                    DEFAULT '0.00',
    `password_hash`    varchar(60)                       NOT NULL,
    `auth_key`         varchar(32)                       NOT NULL,
    `access_token`     varchar(32)                       DEFAULT NULL,
    `recovery_token`   varchar(36)                       DEFAULT NULL,
    `recovery_sent_at` int unsigned DEFAULT NULL,
    `created_at`       int unsigned NOT NULL,
    `updated_at`       int unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`
(
    `id`         int unsigned NOT NULL AUTO_INCREMENT,
    `user_id`    int unsigned NOT NULL,
    `name`       varchar(45) CHARACTER SET utf8mb4 NOT NULL,
    `updated_at` int                               NOT NULL,
    `created_at` int                               NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_uniqe_un` (`user_id`,`name`),
    KEY          `fk_projects_user1_idx` (`user_id`),
    CONSTRAINT `fk_projects_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;;

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log`
(
    `id`       bigint NOT NULL AUTO_INCREMENT,
    `level`    int                                DEFAULT NULL,
    `category` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
    `log_time` double                             DEFAULT NULL,
    `prefix`   text CHARACTER SET utf8mb4,
    `message`  text CHARACTER SET utf8mb4,
    PRIMARY KEY (`id`),
    KEY        `idx_log_level` (`level`),
    KEY        `idx_log_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
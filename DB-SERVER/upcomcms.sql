SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for analytics
-- ----------------------------
DROP TABLE IF EXISTS `analytics`;
CREATE TABLE `analytics` (
  `customer` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`customer`,`date`,`type`),
  KEY `customer` (`customer`) USING BTREE,
  KEY `date` (`date`) USING BTREE,
  KEY `type` (`type`) USING BTREE,
  CONSTRAINT `an_customer` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of analytics
-- ----------------------------

-- ----------------------------
-- Table structure for bridge
-- ----------------------------
DROP TABLE IF EXISTS `bridge`;
CREATE TABLE `bridge` (
  `id` int(10) unsigned NOT NULL,
  `token` varchar(255) NOT NULL,
  `program_customer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `program_customer_id` (`program_customer_id`) USING BTREE,
  CONSTRAINT `bridge_ibfk_1` FOREIGN KEY (`program_customer_id`) REFERENCES `customers` (`program_customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bridge
-- ----------------------------

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `program_company_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`program_company_id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of companies
-- ----------------------------

-- ----------------------------
-- Table structure for counters
-- ----------------------------
DROP TABLE IF EXISTS `counters`;
CREATE TABLE `counters` (
  `id` int(10) unsigned NOT NULL,
  `customer` int(10) unsigned NOT NULL,
  `service` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `check_date` date NOT NULL,
  `start_date` date NOT NULL,
  `max_value` int(10) unsigned NOT NULL,
  `number_of_tariffs` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`) USING BTREE,
  CONSTRAINT `counters_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of counters
-- ----------------------------

-- ----------------------------
-- Table structure for counters_values
-- ----------------------------
DROP TABLE IF EXISTS `counters_values`;
CREATE TABLE `counters_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `counter` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `value2` int(10) unsigned NOT NULL,
  `mode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `counter` (`counter`) USING BTREE,
  CONSTRAINT `counters_values_ibfk_1` FOREIGN KEY (`counter`) REFERENCES `counters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of counters_values
-- ----------------------------

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `program_customer_id` int(10) unsigned NOT NULL,
  `password` varchar(255) NOT NULL,
  `personal_account` varchar(255) NOT NULL,
  `owner` blob NOT NULL,
  `program_house_id` int(10) unsigned NOT NULL,
  `flat` blob NOT NULL,
  `total_space` blob NOT NULL,
  `living_space` blob NOT NULL,
  `residents` blob NOT NULL,
  `phone` blob NOT NULL,
  `email` blob NOT NULL,
  `added_in_base` date NOT NULL,
  PRIMARY KEY (`program_customer_id`),
  KEY `program_house_id` (`program_house_id`) USING BTREE,
  KEY `personal_account` (`personal_account`) USING BTREE,
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`program_house_id`) REFERENCES `houses` (`program_house_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customers
-- ----------------------------

-- ----------------------------
-- Table structure for finances
-- ----------------------------
DROP TABLE IF EXISTS `finances`;
CREATE TABLE `finances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `accrued` decimal(9,2) NOT NULL,
  `penalty` decimal(9,2) NOT NULL,
  `recalculation` decimal(9,2) NOT NULL,
  `paid` decimal(9,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`) USING BTREE,
  CONSTRAINT `finances_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of finances
-- ----------------------------

-- ----------------------------
-- Table structure for houses
-- ----------------------------
DROP TABLE IF EXISTS `houses`;
CREATE TABLE `houses` (
  `program_house_id` int(10) unsigned NOT NULL,
  `address` varchar(255) NOT NULL,
  `program_company_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`program_house_id`),
  UNIQUE KEY `address` (`address`) USING BTREE,
  KEY `program_company_id` (`program_company_id`) USING BTREE,
  CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`program_company_id`) REFERENCES `companies` (`program_company_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of houses
-- ----------------------------

-- ----------------------------
-- Table structure for houses_counters
-- ----------------------------
DROP TABLE IF EXISTS `houses_counters`;
CREATE TABLE `houses_counters` (
  `id` int(10) unsigned NOT NULL,
  `house_id` int(10) unsigned NOT NULL,
  `service` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `transformation_coefficient` decimal(15,2) unsigned NOT NULL,
  `number_of_tariffs` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `house_id` (`house_id`) USING BTREE,
  CONSTRAINT `houses_counters_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`program_house_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of houses_counters
-- ----------------------------

-- ----------------------------
-- Table structure for houses_counters_values
-- ----------------------------
DROP TABLE IF EXISTS `houses_counters_values`;
CREATE TABLE `houses_counters_values` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `counter` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `value` int(10) unsigned NOT NULL,
  `value2` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `counter` (`counter`) USING BTREE,
  CONSTRAINT `houses_counters_values_ibfk_1` FOREIGN KEY (`counter`) REFERENCES `houses_counters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of houses_counters_values
-- ----------------------------

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `file` mediumblob NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `viewed` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`) USING BTREE,
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of messages
-- ----------------------------

-- ----------------------------
-- Table structure for odns
-- ----------------------------
DROP TABLE IF EXISTS `odns`;
CREATE TABLE `odns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `units` varchar(255) NOT NULL,
  `real_overall_consumption` decimal(15,2) unsigned NOT NULL,
  `estimated_overall_consumption` decimal(15,2) unsigned NOT NULL,
  `counters_consumption` decimal(15,2) unsigned NOT NULL,
  `norm_consumption` decimal(15,2) unsigned NOT NULL,
  `diff` decimal(15,2) NOT NULL,
  `total_square` decimal(15,2) unsigned NOT NULL,
  `distribution_coefficient` decimal(15,5) NOT NULL,
  `flat_square` decimal(15,2) unsigned NOT NULL,
  `odn_value` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`) USING BTREE,
  CONSTRAINT `odns_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of odns
-- ----------------------------

-- ----------------------------
-- Table structure for receipts
-- ----------------------------
DROP TABLE IF EXISTS `receipts`;
CREATE TABLE `receipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `file` mediumblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`) USING BTREE,
  CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `bridge` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of receipts
-- ----------------------------

-- ----------------------------
-- Table structure for sysconf
-- ----------------------------
DROP TABLE IF EXISTS `sysconf`;
CREATE TABLE `sysconf` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sysconf
-- ----------------------------
INSERT INTO `sysconf` VALUES ('update', '0');
INSERT INTO `sysconf` VALUES ('upd_date', NOW());

-- ----------------------------
-- Procedure structure for get_analytics
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_analytics`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `get_analytics`(IN `x_start_date` date, IN `x_days` int(10))
BEGIN
	SELECT FORMAT(`companies`.`program_company_id`,0) as 'companyID', `companies`.`name` as 'companyName', FORMAT(g.totalCustomers,0) as 'totalCustomers', IFNULL(f.hasLogin,0) as 'hasLogin', CONCAT(FORMAT((IFNULL(f.hasLogin,0)/g.totalCustomers*100),2),'%') as 'UC', IFNULL(f.activeUsers,0) as 'activeUsers', CONCAT(FORMAT((IFNULL(f.activeUsers,0)/g.totalCustomers*100),2),'%') as 'AUC'
	FROM `companies`
	LEFT JOIN (SELECT
		company,
		IFNULL((`users`+`activeUsers`),0) as 'hasLogin',
		IFNULL(`activeUsers`,0) as 'activeUsers'
	FROM
	(SELECT
		`company`,
		sum(if(d.group = 'User', count, 0)) as 'users',
		sum(if(d.group = 'ActiveUser', count, 0)) as 'activeUsers'
	FROM
	(SELECT
		(SELECT `program_company_id` FROM `companies` WHERE `program_company_id` IN (
			SELECT `program_company_id` FROM `houses` WHERE `program_house_id` IN (
				SELECT `program_house_id` FROM `customers` WHERE `program_customer_id` IN (
					SELECT `program_customer_id` FROM `bridge` WHERE `id`=`customer`
		)))) as 'company',
		(CASE `status` WHEN '2' THEN 'ActiveUser' ELSE 'User' END) AS `group`,
		count(`status`) as 'count'
	FROM
		(SELECT
			b.customer,
			max(b.status) as 'status'
		FROM
			(SELECT
				a.`customer`,
				CASE
						WHEN (a.type LIKE 'svl' AND a.typeCount>0) THEN 2
						WHEN (a.type LIKE 'fbk' AND a.typeCount>0) THEN 2
						WHEN (a.type LIKE 'dfl' AND a.typeCount>0) THEN 2
						WHEN (a.type LIKE 'hit' AND a.typeCount>10) THEN 2
						ELSE 1
				END as 'status'
			FROM
				(SELECT `customer`, `type`, count(*) as 'typeCount'
				 FROM `analytics`
				 WHERE `date` >= DATE_SUB(x_start_date,INTERVAL x_days day) AND `date` < x_start_date
				 GROUP BY `customer`,`type`
				) as a
			) as b
			GROUP BY `customer`
		) as c
		GROUP BY `company`, `status`
		) as d
	GROUP BY `company`
	) as e
	) as f
	ON `companies`.`program_company_id`=f.company
	
	LEFT JOIN
	(
		SELECT
			z.`program_company_id`, 
			(SELECT count(*) FROM customers as y WHERE y.`program_house_id` IN (
				SELECT x.`program_house_id` FROM houses as x WHERE x.`program_company_id`=z.`program_company_id`
			) AND y.`added_in_base` < x_start_date ) as 'totalCustomers'
		FROM `companies` as z
	) as g
	ON `companies`.`program_company_id`=g.`program_company_id`;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for get_counters_values
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_counters_values`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `get_counters_values`()
BEGIN
		START TRANSACTION;
	
	DROP TABLE IF EXISTS `tempIDsValues`;
	CREATE TEMPORARY TABLE `tempIDsValues`
		SELECT `id`	FROM `counters_values` AS `cv` WHERE `cv`.`mode` = 'site';

	UPDATE `counters_values` SET `mode` = 'program' WHERE `id` IN (SELECT `id` FROM `tempIDsValues`);
	
	SELECT 
		`c`.`customer` AS `customer_id`, 
    `cv`.`counter` AS `counter_id`, 
    `cv`.`date` AS `date`, 
    `cv`.`value` AS `value`, 
    `cv`.`value2` AS `value2`
	FROM 
		`counters_values` AS `cv` 
	LEFT JOIN 
		`counters` AS `c` ON `cv`.`counter` = `c`.`id` 
	WHERE 
		`cv`.`id` IN (SELECT `id` FROM `tempIDsValues`)
	ORDER BY 
		`customer_id` ASC, 
    `counter_id` ASC, 
    `date` ASC, 
    `cv`.`id` ASC;
	
	DROP TABLE IF EXISTS `tempIDsValues`;
	
	COMMIT;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for get_messages
-- ----------------------------
DROP PROCEDURE IF EXISTS `get_messages`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `get_messages`()
BEGIN
	SELECT 
		`customer`, 
    `date`, 
    `message`, 
    `file_name`, 
    `file_type`, 
    `file`,
    houses.program_house_id,
    houses.program_company_id 
	FROM 
		`messages`
  LEFT JOIN customers on messages.customer = customers.program_customer_id
  LEFT JOIN houses on customers.program_house_id = houses.program_house_id
	WHERE 
		`viewed` = 'no'
	ORDER BY 
		`customer` ASC, `date` ASC, `id` ASC;

	UPDATE `messages` SET 
   `viewed` = 'yes' 
  WHERE `viewed` = 'no';

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_companies
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_companies`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_companies`(IN `x_id` int(10) UNSIGNED, IN `x_name` varchar(255))
BEGIN
	IF (x_id > 0 AND LENGTH(x_name) > 0) THEN
		INSERT INTO `companies` SET 
			`program_company_id` = x_id, 
			`name` = x_name 
		ON DUPLICATE KEY UPDATE 
			`name` = x_name;
		SELECT ROW_COUNT() AS `status`;
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_counters
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_counters`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_counters`(IN `x_id` int(10) UNSIGNED, IN `x_customer` int(10) UNSIGNED, IN `x_service` varchar(255), IN `x_serial` varchar(255), IN `x_check_date` date, IN `x_start_date` date, IN `x_max_value` int(10) UNSIGNED, IN `x_number_of_tariffs` int(10) UNSIGNED)
BEGIN
	IF (
		x_id > 0 AND 
		x_customer > 0 AND 
		LENGTH(x_service) > 0 AND 		
		LENGTH(x_start_date) > 0 AND 
		x_max_value > 0 AND
		x_number_of_tariffs > 0
	) THEN
	INSERT INTO `counters` SET 
			`id` = x_id,
			`customer` = x_customer,
			`service` = x_service,
			`serial_number` = x_serial,
			`check_date` = x_check_date,
			`start_date` = x_start_date,
			`max_value` = x_max_value,
			`number_of_tariffs` = x_number_of_tariffs
		ON DUPLICATE KEY UPDATE 
			`customer` = x_customer,
			`service` = x_service,
			`serial_number` = x_serial,
			`check_date` = x_check_date,
			`start_date` = x_start_date,
			`max_value` = x_max_value,
			`number_of_tariffs` = x_number_of_tariffs;
	SELECT ROW_COUNT() AS `status`;
	ELSE
			SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_counters_values
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_counters_values`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_counters_values`(IN `x_counter` int(10) UNSIGNED, IN `x_date` date, IN `x_value` int(10) UNSIGNED, IN `x_value2` int(10) UNSIGNED)
BEGIN
	IF (x_counter > 0 AND LENGTH(x_date) > 0) THEN
		INSERT INTO `counters_values` SET 
			`counter` = x_counter,
			`date` = x_date,
			`value` = x_value,
			`value2` = x_value2,
			`mode` = 'program';
		SELECT ROW_COUNT() AS `status`;	
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_customers_bridge
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_customers_bridge`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_customers_bridge`(IN `x_id` int(10) UNSIGNED, IN `x_password` varchar(255), IN `x_salt` varchar(255), IN `x_account` varchar(255), IN `x_owner` varchar(255), IN `x_house` int(10) UNSIGNED, IN `x_flat` varchar(255), IN `x_total_space` varchar(255), IN `x_living_space` varchar(255), IN `x_residents` int(10) UNSIGNED, IN `x_phone` varchar(255), IN `x_email` varchar(255))
BEGIN
	IF (
		x_id > 0 AND 
		LENGTH(x_password) > 0 AND 
		LENGTH(x_salt) > 0 AND 
		LENGTH(x_account) > 0 AND 
		LENGTH(x_owner) > 0 AND 
		x_house > 0 
	) THEN
		SET @pass = SHA1(CONCAT(SHA1(x_password),SHA1(x_salt)));
		SET @aes_key = SHA1(CONCAT(SHA1(x_salt),SHA1(x_password)));
		INSERT INTO `customers` SET 
			`program_customer_id` = x_id, 
			`password` = @pass,
			`personal_account` = x_account,
			`owner` = AES_ENCRYPT(x_owner,@aes_key),
			`program_house_id` = x_house,
			`flat` = AES_ENCRYPT(x_flat,@aes_key),
			`total_space` = AES_ENCRYPT(x_total_space,@aes_key),
			`living_space` = AES_ENCRYPT(x_living_space,@aes_key),
			`residents` = AES_ENCRYPT(x_residents,@aes_key),
			`phone` = AES_ENCRYPT(x_phone,@aes_key),
			`email` = AES_ENCRYPT(x_email,@aes_key),
			`added_in_base` = NOW()
		ON DUPLICATE KEY UPDATE 
			`password` = @pass,
			`personal_account` = x_account,
			`owner` = AES_ENCRYPT(x_owner,@aes_key),
			`program_house_id` = x_house,
			`flat` = AES_ENCRYPT(x_flat,@aes_key),
			`total_space` = AES_ENCRYPT(x_total_space,@aes_key),
			`living_space` = AES_ENCRYPT(x_living_space,@aes_key),
			`residents` = AES_ENCRYPT(x_residents,@aes_key),
			`phone` = AES_ENCRYPT(x_phone,@aes_key),
			`email` = AES_ENCRYPT(x_email,@aes_key);
		SELECT ROW_COUNT() AS `status`;
		INSERT INTO `bridge` SET 
			`id` = x_id,
			`token` = '',
			`program_customer_id` = x_id
		ON DUPLICATE KEY UPDATE 
			`token` = '',
			`program_customer_id` = x_id;
		SELECT ROW_COUNT() AS `status`;
	ELSE
			SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_finances
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_finances`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_finances`(IN `x_customer` int(10) UNSIGNED, IN `x_date` date, IN `x_accrued` decimal(9,2), IN `x_penalty` decimal(9,2), IN `x_recalculation` decimal(9,2), IN `x_paid` decimal(9,2))
BEGIN
	IF (x_customer > 0 AND LENGTH(x_date) > 0) THEN
		INSERT INTO `finances` SET 
			`customer` = x_customer,
			`date` = x_date,
			`accrued` = x_accrued,
			`penalty` = x_penalty,
			`recalculation` = x_recalculation,
			`paid` = x_paid;
		SELECT ROW_COUNT() AS `status`;	
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_houses
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_houses`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_houses`(IN `x_id` int(10) UNSIGNED, IN `x_address` varchar(255), IN `x_company` int(10) UNSIGNED)
BEGIN
	IF (x_id > 0 AND LENGTH(x_address) > 0 AND x_company > 0) THEN
		INSERT INTO `houses` SET 
			`program_house_id` = x_id, 
			`address` = x_address, 
			`program_company_id` = x_company 
		ON DUPLICATE KEY UPDATE 
			`address` = x_address, 
			`program_company_id` = x_company;
		SELECT ROW_COUNT() AS `status`;
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_houses_counters
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_houses_counters`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_houses_counters`(IN `x_id` int(10) UNSIGNED, IN `x_house_id` int(10) UNSIGNED, IN `x_service` varchar(255), IN `x_model` varchar(255), IN `x_start_date` date, IN `x_transformation_coefficient` decimal(15,2) unsigned, IN `x_number_of_tariffs` int(10) UNSIGNED)
BEGIN
	IF (
		x_id > 0 AND 
		x_house_id > 0 AND 
		LENGTH(x_service) > 0 AND 		
		LENGTH(x_start_date) > 0 AND 
		x_number_of_tariffs > 0
	) THEN
	INSERT INTO `houses_counters` SET 
			`id` = x_id,
			`house_id` = x_house_id,
			`service` = x_service,
			`model` = x_model,
			`start_date` = x_start_date,
			`transformation_coefficient` = x_transformation_coefficient,
			`number_of_tariffs` = x_number_of_tariffs
		ON DUPLICATE KEY UPDATE 
			`house_id` = x_house_id,
			`service` = x_service,
			`model` = x_model,
			`start_date` = x_start_date,
			`transformation_coefficient` = x_transformation_coefficient,
			`number_of_tariffs` = x_number_of_tariffs;
	SELECT ROW_COUNT() AS `status`;
	ELSE
			SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_houses_counters_values
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_houses_counters_values`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_houses_counters_values`(IN `x_counter` int(10) UNSIGNED, IN `x_date` date, IN `x_value` int(10) UNSIGNED, IN `x_value2` int(10) UNSIGNED)
BEGIN
	IF (x_counter > 0 AND LENGTH(x_date) > 0) THEN
		INSERT INTO `houses_counters_values` SET 
			`counter` = x_counter,
			`date` = x_date,
			`value` = x_value,
			`value2` = x_value2;
		SELECT ROW_COUNT() AS `status`;	
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_messages
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_messages`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_messages`(IN `x_customer` int(10) UNSIGNED,  IN `x_message` text, IN `x_date` datetime, IN `x_file` mediumblob, IN `x_file_type` varchar(255), IN `x_file_name` varchar(255))
BEGIN
	IF (
		x_customer > 0 AND 
		LENGTH(x_message) > 0 AND 
		LENGTH(x_date) > 0
	) THEN
		INSERT INTO `messages` SET 
			`customer` = x_customer,
			`message` = x_message,
			`date` = x_date,
			`file` = x_file,
			`file_type` = x_file_type,
			`file_name` = x_file_name,
			`viewed` = 'yes';
		SELECT ROW_COUNT() AS `status`;	
	ELSE
			SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_odns
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_odns`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_odns`(IN `x_customer` int(10) UNSIGNED, IN `x_date` date, IN `x_type` varchar(255), IN `x_units` varchar(255), IN `x_real_overall_consumption` decimal(15,2) UNSIGNED, IN `x_estimated_overall_consumption` decimal(15,2) UNSIGNED, IN `x_counters_consumption` decimal(15,2) UNSIGNED, IN `x_norm_consumption` decimal(15,2) UNSIGNED, IN `x_diff` decimal(15,2), IN `x_total_square` decimal(15,2) UNSIGNED, IN `x_distribution_coefficient` decimal(15,5), IN `x_flat_square` decimal(15,2) UNSIGNED, IN `x_odn_value` decimal(15,2))
BEGIN
	IF (
			x_customer > 0 AND 
			LENGTH(x_date) > 0 AND 
			LENGTH(x_type) > 0 AND 
			LENGTH(x_units) > 0 AND 
			x_real_overall_consumption > 0 AND
			x_estimated_overall_consumption > 0 AND
			x_counters_consumption > 0 AND			
			LENGTH(x_diff) > 0 AND
			x_total_square > 0 AND
			LENGTH(x_distribution_coefficient) > 0 AND
			x_flat_square > 0 AND
			LENGTH(x_odn_value) > 0
	) THEN
		INSERT INTO `odns` SET 
			`customer` = x_customer,
			`date` = x_date,
			`type` = x_type,
			`units` = x_units,
			`real_overall_consumption` = x_real_overall_consumption,
			`estimated_overall_consumption` = x_estimated_overall_consumption,
			`counters_consumption` = x_counters_consumption,
			`norm_consumption` = x_norm_consumption,
			`diff` = x_diff,
			`total_square` = x_total_square,
			`distribution_coefficient` = x_distribution_coefficient,
			`flat_square` = x_flat_square,
			`odn_value` = x_odn_value;
		SELECT ROW_COUNT() AS `status`;	
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for set_receipts
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_receipts`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_receipts`(IN `x_customer` int(10) UNSIGNED, IN `x_date` date, IN `x_file` mediumblob,  IN `x_password` varchar(255), IN `x_salt` varchar(255))
BEGIN
DECLARE FCountRec INTEGER;
	IF (x_customer > 0 AND 
      LENGTH(x_date) > 0 AND 
      LENGTH(x_file) > 0 AND 
      LENGTH(x_password) > 0 AND 
      LENGTH(x_salt) > 0) 
   THEN
    SET FCountRec = 0;
    SELECT COUNT(customers.program_customer_id) into FCountRec
    FROM customers 
    WHERE customers.program_customer_id = x_customer;
    
    if FCountRec > 0
     then
		  SET @aes_key = SHA1(CONCAT(SHA1(x_salt),SHA1(x_password)));
		  INSERT INTO `receipts` SET 
			 `customer` = x_customer,
			 `date` = x_date,
			 `file` = AES_ENCRYPT(x_file,@aes_key);
	  	SELECT ROW_COUNT() AS `status`;	
     ELSE SELECT '-1' AS `status`;
     END IF;
 	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for truncate_tables
-- ----------------------------
DROP PROCEDURE IF EXISTS `truncate_tables`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `truncate_tables`()
BEGIN
	SET FOREIGN_KEY_CHECKS=0;
		TRUNCATE `companies`;
		TRUNCATE `houses`;
		TRUNCATE `customers`;
		TRUNCATE `bridge`;
		TRUNCATE `messages`;
		TRUNCATE `finances`;
		TRUNCATE `odns`;
		TRUNCATE `houses_counters`;
		TRUNCATE `houses_counters_values`;
		TRUNCATE `receipts`;
		TRUNCATE `counters`;
		TRUNCATE `counters_values`;
		SELECT '1' AS `status`;
	SET FOREIGN_KEY_CHECKS=1;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for update_date
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_date`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `update_date`()
BEGIN
	UPDATE `sysconf` SET `value` = NOW() WHERE `key` = 'upd_date';
	SELECT ROW_COUNT() AS `status`;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for update_mode
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_mode`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `update_mode`(IN `x_update` int(1))
BEGIN
	IF (x_update = 1) THEN
		UPDATE `sysconf` SET `value` = 1 WHERE `key` = 'update';
	ELSE
		UPDATE `sysconf` SET `value` = 0 WHERE `key` = 'update';
	END IF;
	UPDATE `sysconf` SET `value` = NOW() WHERE `key` = 'upd_date';
	SELECT ROW_COUNT() AS `status`;

END
;;
DELIMITER ;

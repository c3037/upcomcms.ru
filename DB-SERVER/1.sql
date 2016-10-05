-- ----------------------------
-- Table structure for finances
-- ----------------------------
ALTER TABLE `finances` ADD `saldo` decimal(9,2) NOT NULL;

-- ----------------------------
-- Procedure structure for set_finances
-- ----------------------------
DROP PROCEDURE IF EXISTS `set_finances`;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` PROCEDURE `set_finances`(IN `x_customer` int(10) UNSIGNED, IN `x_date` date, IN `x_accrued` decimal(9,2), IN `x_penalty` decimal(9,2), IN `x_recalculation` decimal(9,2), IN `x_paid` decimal(9,2), IN `x_saldo` decimal(9,2))
BEGIN
	IF (x_customer > 0 AND LENGTH(x_date) > 0) THEN
		INSERT INTO `finances` SET 
			`customer` = x_customer,
			`date` = x_date,
			`accrued` = x_accrued,
			`penalty` = x_penalty,
			`recalculation` = x_recalculation,
			`paid` = x_paid,
			`saldo` = x_saldo;
		SELECT ROW_COUNT() AS `status`;	
	ELSE
		SELECT '-1' AS `status`;
	END IF;

END
;;
DELIMITER ;
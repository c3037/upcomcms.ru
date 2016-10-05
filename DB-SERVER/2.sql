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
						WHEN (a.type LIKE 'pay' AND a.typeCount>0) THEN 2
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
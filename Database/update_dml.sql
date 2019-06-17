DELIMITER $$


DROP PROCEDURE IF EXISTS `update_post_table` $$
# Update Post Table
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_post_table`
( 
IN post_id varchar(30), IN post_time timestamp,
IN access_id varchar(3)
)
BEGIN
update post 
set post_time= post_time,access_id = access_id
where post_id = post_id;
END $$

DELIMITER ;
#Dont use it for later on

use BigApple;

ALTER TABLE relationship CHANGE request_status request_status enum('Accepted','Declined','Sent');


ALTER TABLE relationship DROP COLUMN  request_status;

SHOW CREATE TABLE relationship;

SHOW VARIABLES LIKE 'sql_mode';


ALTER TABLE relationship ADD COLUMN friendship_status varchar(20) NOT NULL;

DELETE from relationship;

use BigApple;

DELIMITER $$

#Function: To check for a new or an existing employee
DROP FUNCTION IF EXISTS `validate_user` $$
CREATE DEFINER=`root`@`localhost` FUNCTION `validate_user`(
e_ssn int
) 
RETURNS varchar(50) 

BEGIN

	DECLARE check_employee varchar(50);
    
	select ssn into check_employee from signin where ssn=e_ssn; 
    
	if check_employee!='NULL' Then
		return ("Employee subscribed to BigApple");
   else
		return ("New user registration. You have to sign up first!!");
	
	end if; 
END $$

DELIMITER ;


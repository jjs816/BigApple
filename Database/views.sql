# Views:

#Display Posts by all the users
CREATE OR REPLACE VIEW All_Posts_view AS 
SELECT post_id, first_name as Name
FROM wall as w natural join registered_employee as re 
where w.profile_name=re.profile_name;

#All Posts
select * from All_Posts_view;

#Specific posts
select post_id AS posts
from All_Posts_view
where Name='Gauri';

#Display Multimedia Contents of a specific location
CREATE OR REPLACE VIEW Multimedia_list_view AS
select m.multimedia_name as Name,m.Multimedia_type as Type,m.multimedia_content as Content
from multimedia_content as m, location as l
where l.post_id=m.post_id and l.name like '%Miami%' and (m.access_id='P' or m.access_id='F');

select * from Multimedia_list_view;



#Display friends list of any User.
Create OR Replace VIEW friendlist_view AS
select first_name as Friend,friendship_status as Status, request_time as Time
from relationship as r,registered_employee as e
where r.receiver_name=e.profile_name and r.sender_name = 'jjs816';

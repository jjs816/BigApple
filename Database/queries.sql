#Check for connections
select friendship_status as Status, request_time as Time
from relationship as r
where r.sender_name = 'jjs816' AND r.receiver_name='gss383';

#Display friends list of any User.
Create OR Replace VIEW friendlist_view AS
select first_name as Friend,friendship_status as Status, request_time as Time
from relationship as r,registered_employee as e
where r.receiver_name=e.profile_name and r.sender_name = 'jjs816';

#Display friends list by connection request status
select * 
from friendlist_view
where Status='Sent';

#Count Total likes by post for specific user
select l.post_id as Post,count(l.post_id) as Like_Count
from likes as l natural join wall as w 
where w.profile_name='jjs816'
group by l.post_id;



#Filter post by date
select post_title,post_desc
from post
where post_time between date_sub(now(), interval 10 year )
and date(now()) ;
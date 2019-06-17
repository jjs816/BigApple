use BigApple;
select * from signin
 where ssn = 742347663 and password='password';

ALTER TABLE registered_employee DROP COLUMN ssn;

SET FOREIGN_KEY_CHECKS=1;

SHOW ENGINE INNODB STATUS;



ALTER TABLE registered_employee
ADD COLUMN profile_created date AFTER access_id;


select * 
from signin
where ssn = jjs816 or profile_name = 'jjs816' and password='password';



DELETE FROM signin
WHERE ssn = 1111111111 ;

delete from employee
where ssn = 1111111111;


delete from registered_employee
where profile_name = 'test';



call insert_employee(1111111111,'test@nyu.edu');



select * from signin where profile_name = 'test' and password = '123' ;


SELECT * 
FROM registered_employee
where profile_name like 'jjs816%' or first_name='jjs816' or last_name='jjs816';


select *
from registered_employee
where first_name='Jay' and last_name='Shah';

select * from wall;

#Query selects all the post to be displayed on the wall of the user and his friends
select * from wall
where profile_name = 'jjs816'  and (access_id = 'T' or access_id='P') and deleted='no' or (profile_name in 
(select distinct receiver_name from relationship
where sender_name = 'jjs816' and friendship_status = 'Accepted' or friendship_status = 'sent' and relation_type = 'T' or 'F') and deleted='no'  and (access_id = 'T' or access_id='P'));

select distinct receiver_name from relationship
where sender_name = 'jjs816' and friendship_status = 'Accepted' or friendship_status = 'sent' and relation_type = 'T' or 'F';

select * from relationship;

select * from post;

UPDATE wall SET deleted='yes' WHERE post_id='post_1';


SELECT * FROM comment WHERE post_id='post_1';

select count(distinct like_id) as tot_likes from likes where post_id='post_1';

select count(distinct like_id) as tot_likes,viewer_name from likes where post_id='post_1' group by viewer_name;


select * from likes;
select * from wall where profile_name='jjs816' and deleted='no';

INSERT INTO likes VALUES('like_11','post_1',null,null,null,'jjs816',' 2018-02-02 09:10:30');


ALTER TABLE wall
ADD deleted varchar(30) default 'no';


ALTER TABLE post
DROP COLUMN deleted;


ALTER TABLE comment
ADD deleted varchar(30) default 'no';

ALTER TABLE location
ADD deleted varchar(30) default 'no';

ALTER TABLE likes
ADD deleted varchar(30) default 'no';

ALTER TABLE wall
ADD access_id varchar(30) default 'P';


SELECT * FROM comment WHERE post_id='post_2' and (access_id = 'P' or access_id= 'F') and deleted='no' ORDER BY comment_date ASC;


SELECT * FROM comment WHERE post_id='post_2';



call employee_acc;
call employee_signin;
call  registered_employee_acc;
call read_posts;
call  read_wall;
call  view_relationship;
call  multimedia_contents;
call  comment;
call  location;
call likes;



select count(post_id) as tot_post from wall where profile_name='jjs816' and deleted='no';

select count(l.like_id) as like_count from likes as l natural join wall  as w 
where l.post_id=w.post_id and w.profile_name='jjs816' and w.deleted='no';


UPDATE likes SET deleted='yes' WHERE like_id='like_1';


create index bindex on registered_employee(profile_name);


select * from likes where post_id='post_101';
select * from likes;

INSERT INTO likes VALUES('like_31','post_100',null,null,null,'jjs816','2010-07-22 22:30:12','no');
INSERT INTO likes VALUES('like_32','post_100',null,null,null,'ryk123','2010-07-22 22:30:12','yes');

SELECT count(distinct like_id) as tot_likes FROM likes WHERE post_id='post_94' and deleted='no';

SELECT count(distinct like_id) as tot_likes FROM likes WHERE post_id='post_94' and deleted='yes';


SELECT * FROM likes WHERE  post_id='post_100' and viewer_name='gss383';
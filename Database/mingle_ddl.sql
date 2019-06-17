create database BigApple;
use BigApple;

drop table if exists employee; 

#Create employee table
drop table if exists employee; 
create table employee(
ssn int primary key, email_id varchar(20) not null 
);

#Create sign in table
drop table if exists signin; 
create table signin
(
ssn int unique, 
password varchar(50) not null,
profile_name varchar(30) primary key,			
foreign key (ssn) References employee(ssn) 
on delete cascade											
);

#Create registered_employee  table
drop table if exists registered_employee; 
SET FOREIGN_KEY_CHECKS=1;
create table registered_employee
(
profile_name varchar(30) primary key, 
first_name varchar(20) not null , 
last_name varchar(20) not null,
address varchar (255),
designation varchar(20),
skills varchar(255),
interests varchar(255),
manager varchar(20),
level enum('A','B','C','D') default 'A',		
email_id varchar(50),				
profile_pic blob,
gender enum('Male','Female'),
access_id enum('P','T','F','S','FOF') default 'S',
foreign key (profile_name) References signin(profile_name) 
);


#Create post
											
drop table if exists post; 
create table post
(
post_id varchar(30), 
post_time timestamp not null,
post_title varchar(150), 
post_desc varchar(255), 
access_id varchar(5) default 'S',				
primary key (post_id)
);


#Create wall(post_id,profile_name)				
					
drop table if exists wall;
create table wall
(
post_id varchar(20), 
profile_name varchar(30),					
foreign key (profile_name) references registered_employee(profile_name) 
on delete cascade
on update cascade,
foreign key (post_id) references post(post_id) 
on delete cascade
on update cascade
);

#Create relationship table

drop table if exists relationship;					
create table relationship					
(					
sender_name varchar(30),					
receiver_name varchar(30),				
relation_type varchar(20),					
request_time timestamp,					
friendship_status varchar(20) NOT NULL,								
foreign key (sender_name) references registered_employee(profile_name) 
on delete cascade
on update cascade,					
foreign key (receiver_name) references registered_employee(profile_name) 
on delete cascade 
on update cascade,					 	 	 				
primary key(sender_name,receiver_name)
 );


#Create multimedia table

drop table if exists multimedia_content; 
create table multimedia_content
(
multimedia_id varchar(10) primary key, 
post_id varchar(20),
multimedia_name varchar(20),
Multimedia_type varchar(20),
multimedia_content blob,
access_id varchar(5) default 'S',
foreign key (post_id) references post(post_id) 
on delete cascade 
on update cascade 
);


#Create table Comment
drop table if exists comment;
create table comment
(
comment_id varchar(20) primary key, 
post_id varchar(20),				
comment_desc varchar(255),				
comment_date datetime,				
commentor_name varchar(30),
access_id varchar(5) default 'S',				
foreign key (commentor_name) references registered_employee(profile_name) 
on delete cascade 
on update cascade,					
foreign key (post_id) references post(post_id) 
on delete cascade 
on update cascade 
);

#Create 	location table		
drop table if exists location; 
create table location
(
loc_id varchar(20) primary key, 
post_id varchar(20),
name varchar(100),
description varchar(255),				
latitude varchar(30), 
longitude varchar(30),
access_id varchar(5) default 'S',
foreign key (post_id) references post(post_id) 
on delete cascade 
on update cascade 
);

#Create like table

drop table if exists likes;
create table likes
(
like_id varchar(20) primary key, 
post_id varchar(30),
multimedia_id varchar(10),
comment_id varchar(20),
loc_id varchar(20),
viewer_name varchar(20),
like_time datetime,
foreign key (post_id) references post(post_id) on delete cascade on update cascade,
foreign key (multimedia_id) references multimedia_content(multimedia_id) on delete cascade on update cascade,
foreign key (comment_id) references comment(comment_id) on delete cascade on update cascade,
foreign key (loc_id) references location(loc_id) on delete cascade on update cascade,
foreign key (viewer_name) references registered_employee(profile_name) on delete cascade on update cascade									
);











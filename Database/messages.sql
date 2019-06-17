use BigApple;

create table messages
(
sender varchar(50) not null,
receiver varchar(30) not null,			
message	varchar(30) not null,
primary key(sender,receiver)					
);



ALTER TABLE messages ADD seen varchar(1);

select * from messages;

drop table messages;
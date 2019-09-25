create database sns_php;

grant all on sns_php.* to dbuser@localhost identified by 'abc';

use sns_php

-- create table users (
--   id int not null auto_increment primary key,
--   username varchar(255),
--   email varchar(255) unique,
--   password varchar(255),
--   created datetime,
--   modified datetime
-- );

create table users (
  id int not null auto_increment primary key,
  username varchar(255),
  email varchar(255) unique,
  password varchar(255),
  icon varchar(255) default 'default.png',
  created datetime,
  modified datetime
);

desc users;


-- ALTER TABLE users CHANGE COLUMN loginid username varchar(255);


create table thread_list (
  id int not null auto_increment primary key,
  title varchar(255),
  createdby varchar(255),
  created datetime,
  modified datetime
);




create table comments (
  id int not null auto_increment primary key,
  writer varchar(255),
  content varchar(255),
  created datetime,
  thread_id int,
  comment_id int
);

--
-- create table threadcomment (
--   threadid int,
--   commentid int
-- );



-- select t.id, c.comment_id, u.username from thread_list as t
-- inner join comments as c
-- on t.id = c.thread_id
-- inner join users as u
-- on c.writer =u.id
-- order by t.id, c.comment_id;




select t.id, t.title, t.modified, u.icon, u.username, c.content from thread_list as t
inner join comments as c
on t.id = c.thread_id
and c.comment_id = 1
inner join users as u
on c.writer =u.id
order by t.id;


select t.id, t.title, t.modified, u.icon, u.username, c.content from thread_list as t
inner join comments as c
on t.id = c.thread_id
and c.comment_id = 1
inner join users as u
on c.writer =u.id
order by t.id
limit 2,10;

drop database yuexinchina;
create database yuexinchina;
use yuexinchina;

--文件表
drop table doc_file;
create table doc_file(
	file_id int primary key auto_increment,
	in_module varchar(30),
	file_key varchar(30),
	saved_path varchar(100),
	showed_name varchar(50),
	file_url varchar(150),
	file_desc varchar(50),
	file_sort int,
	ext_name varchar(10),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;
select * from doc_file;

--留言表
drop table message;
create table message(
	message_id int primary key auto_increment,
	email varchar(30),
	content text,
	phone varchar(30),
	uname varchar(30),
	reply text,
	reply_date date,
	rec_date timestamp default now()
) engine=innodb default charset=utf8 auto_increment=1;

--文本表
drop table content;
create table content(
	content_id int primary key auto_increment,
	content_type varchar(30),
	content_key varchar(50),
	subject varchar(150),
	content text,
	m_image varchar(100),
	rec_date timestamp default now()
) engine=innodb default charset=utf8 auto_increment=1;

--产品类别表
drop table p_sort;
create table p_sort(
	sort_id int primary key auto_increment,
	sort_name varchar(30),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

--产品表
drop table product;
create table product(
	product_id int primary key auto_increment,
	product_no varchar(30),
	product_name varchar(30),
	sort_id int not null,
	order_no int default 0,
	m_image varchar(100),
	ali_url varchar(80),
	is_recommend tinyint default 0,
	is_showhome tinyint default 0,
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

--用户表
drop table yuser;
create table yuser(
	user_id int primary key auto_increment,
	login_name varchar(20) unique,
	password varchar(20),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;
insert into yuser(login_name, password) values('admin', 'yuexinchina');

--统计器
drop table countor;
create table countor(
	count_id int primary key auto_increment,
	visit_count int,
	count_date varchar(10),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;
--insert into countor(visit_count, count_date)
--values(10, '2015.11.10'),(21, '2015.11.12'),(4, '2015.11.13'),(7, '2015.11.14'),(45, '2015.11.15'),(83, '2015.11.16');

select * from doc_file;
select * from message;
select * from content;
select * from p_sort;
select * from product;
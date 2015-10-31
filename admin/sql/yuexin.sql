drop database yuexinchina;
create database yuexinchina;
use yuexinchina;

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

drop table message;
create table message(
	message_id int primary key auto_increment,
	title varchar(30),
	content text,
	phone varchar(30),
	uname varchar(30),
	reply text,
	reply_date date,
	rec_date timestamp default now()
) engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into message(title, phone, uname, content) 
values('����1', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����2', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����3', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����4', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����1', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����6', '12345212', 'abc', '�����ۺٺٺǺ�'),
('����1', '12345212', 'abc', '�����ۺٺٺǺ�');

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

insert into content(content_type, content_key, content)

values('company', 'company_contact', '<p>�绰��020-34722228</p><p>���棺020-34722227</p><p>�ֻ���18122303373</p><p>��ϵ�ˣ�������������</p><p>Q Q��37559462</p><p>���������������豸</p><p>���䣺yuexin@yuexin80.com</p><p>������www.yuexinchina.com</p><p>���̣�http://pyyuexin.1688.com</p><p>Ӫ������վ��www.yuexin80.com</p><p>��ַ������ʡ�����з�خ����������Լ��ҵ��34��</p>');

drop table p_sort;
create table p_sort(
	sort_id int primary key auto_increment,
	sort_name varchar(30),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into p_sort(sort_name)
values('������������'),('��ֱ��������װ��'),('�ڹ���������װ��'),('ǿ��ˮ����װ��'),('��ˮ����װ��'),('ѹ����ˮ����װ��'),('���¸�ѹ��������װ��'),('������������װ��'),('��ˮ����װ��'),('��ˮ���鷿'),('�ۺ�������');

drop table product;
create table product(
	product_id int primary key auto_increment,
	product_no varchar(30),
	product_name varchar(30),
	sort_id int not null,
	order_no int default 0,
	m_image varchar(100),
	is_recommend tinyint default 0,
	is_showhome tinyint default 0,
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;


drop table template;
create table template(
	temp_id int primary key auto_increment,
	temp_type varchar(30),
	temp_key varchar(50),
	temp_value text,
	rec_date timestamp default now()
) engine=innodb default charset=utf8 auto_increment=1;

set names GBK;

insert into template(temp_type, temp_key, temp_value)
values('LABEL', '##site_name##', '����.�й�IP��ˮ�������һƷ��,�����ṩ��רҵ��IP��ˮ����豸ϵͳ�������'),
('LABEL', '##company_name##', '�������������豸���޹�˾'),
('LABEL', '##site_desc##', 'IP��ˮ�����, IPX12���������, IPX34�ڹ����������, IPX56ǿ��ˮ�����, IPX78��ˮ�����, UL��ˮ����װ��, �ձ�����������, �ֳ�ʽ��������װ��, IPX9K��ѹ����������, IPX8ѹ����ˮ�����������, IP56����������'),
('LABEL', '##key_words##', 'IP��ˮ�����, IPX12���������, IPX34�ڹ����������, IPX56ǿ��ˮ�����, IPX78��ˮ�����, UL��ˮ����װ��, �ձ�����������, �ֳ�ʽ��������װ��, IPX9K��ѹ����������, IPX8ѹ����ˮ�����������, IP56����������'),
('LABLE', '##notice##', '����,��ӭ��������վ��רҵ������IP��ˮ�����,�ڹ������������ѹ����ˮ������Ȳ�Ʒ.'),
('HTML', '##banner1##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner2##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner3##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner4##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##hot_sort##', '<a href="#">ҡ�����������</a><a href="#">ҡ�����������</a><a href="#">ǿ��ˮ�����</a>'),
('HTML', '##company_outline##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>�������������豸����</b>��˾��һ�Ҽ��з�������������Ϊһ��ĿƼ�����ҵ����˾רҵ����IPX��ˮ�����豸�������������鷿�����ˮѹ��ˮ��©�����������е�豸���Դ�����������˾��֡�����Ʒ��չ�г�����������֤�г����Է���Ӯ���г�����ƾ���ۺ�ļ��������������Ƚ��������豸�ͼ���豸��ʹ��YUEXIN���͡����š�Ʒ�ƵĲ�Ʒ�㷺Ӧ���ں��պ��졢�������졢�촬�����ϡ����ӵ繤��ͨ�ż���������е�������Ǳ�ʯ���Ǳ�ʯ�ͻ�����ҽ...<a href="##root_url##/companyInfo.html">����&gt;&gt;</a></p>'),
('HTML', '##contact##', '<p>�绰��020-34722228</p><p>���棺020-34722227</p><p>�ֻ���18122303373</p><p>��ϵ�ˣ�������������</p><p>Q Q��37559462</p><p>���������������豸</p><p>���䣺yuexin@yuexin80.com</p><p>������www.yuexinchina.com</p><p>���̣�http://pyyuexin.1688.com</p><p>Ӫ������վ��www.yuexin80.com</p><p>��ַ������ʡ�����з�خ����������Լ��ҵ��34��</p>'),
('HTML', '##company_infor##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>�������������豸����</b>��˾��һ�Ҽ��з�������������Ϊһ��ĿƼ�����ҵ����˾רҵ����IPX��ˮ�����豸�������������鷿�����ˮѹ��ˮ��©�����������е�豸���Դ�����������˾��֡�����Ʒ��չ�г�����������֤�г����Է���Ӯ���г�����ƾ���ۺ�ļ��������������Ƚ��������豸�ͼ���豸��ʹ��YUEXIN���͡����š�Ʒ�ƵĲ�Ʒ�㷺Ӧ���ں��պ��졢�������졢�촬�����ϡ����ӵ繤��ͨ�ż���������е�������Ǳ�ʯ���Ǳ�ʯ�ͻ�����ҽ...<a href="##root_url##/companyInfo.html">����&gt;&gt;</a></p>'),
('HTML', '##company_history##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>�������������豸����</b>��˾��һ�Ҽ��з�������������Ϊһ��ĿƼ�����ҵ����˾רҵ����IPX��ˮ�����豸�������������鷿�����ˮѹ��ˮ��©�����������е�豸���Դ�����������˾��֡�����Ʒ��չ�г�����������֤�г����Է���Ӯ���г�����ƾ���ۺ�ļ��������������Ƚ��������豸�ͼ���豸��ʹ��YUEXIN���͡����š�Ʒ�ƵĲ�Ʒ�㷺Ӧ���ں��պ��졢�������졢�촬�����ϡ����ӵ繤��ͨ�ż���������е�������Ǳ�ʯ���Ǳ�ʯ�ͻ�����ҽ...<a href="##root_url##/companyInfo.html">����&gt;&gt;</a></p>'),
('HTML', '##company_cert##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>�������������豸����</b>��˾��һ�Ҽ��з�������������Ϊһ��ĿƼ�����ҵ����˾רҵ����IPX��ˮ�����豸�������������鷿�����ˮѹ��ˮ��©�����������е�豸���Դ�����������˾��֡�����Ʒ��չ�г�����������֤�г����Է���Ӯ���г�����ƾ���ۺ�ļ��������������Ƚ��������豸�ͼ���豸��ʹ��YUEXIN���͡����š�Ʒ�ƵĲ�Ʒ�㷺Ӧ���ں��պ��졢�������졢�촬�����ϡ����ӵ繤��ͨ�ż���������е�������Ǳ�ʯ���Ǳ�ʯ�ͻ�����ҽ...<a href="##root_url##/companyInfo.html">����&gt;&gt;</a></p>'),
('HTML', '##company_style##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>�������������豸����</b>��˾��һ�Ҽ��з�������������Ϊһ��ĿƼ�����ҵ����˾רҵ����IPX��ˮ�����豸�������������鷿�����ˮѹ��ˮ��©�����������е�豸���Դ�����������˾��֡�����Ʒ��չ�г�����������֤�г����Է���Ӯ���г�����ƾ���ۺ�ļ��������������Ƚ��������豸�ͼ���豸��ʹ��YUEXIN���͡����š�Ʒ�ƵĲ�Ʒ�㷺Ӧ���ں��պ��졢�������졢�촬�����ϡ����ӵ繤��ͨ�ż���������е�������Ǳ�ʯ���Ǳ�ʯ�ͻ�����ҽ...<a href="##root_url##/companyInfo.html">����&gt;&gt;</a></p>'),
('IMAGE', '##barcode##', 'barcode.png');

drop table product;
create table product(
	product_id int primary key auto_increment,
	product_no varchar(30),
	product_name varchar(30),
	sort_id int not null,
	order_no int default 0,
	images varchar(100),
	is_recommend tinyint default 0,
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into product(product_name, product_no, sort_id, order_no, images, is_recommend)
values('YX-ZC400S�ۺ�','',1, 1, '20150901031909.jpg', 1),
('YX-ZC400�ۺ���','',1, 2, '20150901031749.jpg', 1),
('�������ƻ�����������װ','',2, 3, '20150901031432.jpg', 1),
('�������ƻ�����������װ','',3, 4, '20150901031251.jpg', 1),
('IPX800F600-','',1, 5, '20150901031045.jpg', 1),
('IPX800E600-','',1, 6, '20150901030919.jpg', 1),
('IPX800D 500','',1, 7, '20150901030716.jpg', 1),
('IPX800C500-','',1, 8, '20150901030449.jpg', 1),
('IPX800B500-','',1, 9, '20150901030220.jpg', 1),
('IPX800A500-','',1, 10, '20150901025902.jpg', 1),
('700F��ˮ����װ��','',1, 11, '20150901025446.jpg', 1);

insert into product(product_name, product_no, sort_id, order_no, images)
values('700D��ˮ����װ��','',1, 12, '20150901025259.jpg'),
('700C��ˮ����װ��','',1, 13, '20150901025023.jpg'),
('700B��ˮ����װ��','',1, 14, '20150901022745.jpg'),
('700A��ˮ����װ��','',1, 15, '20150901022554.jpg'),
('��ʽIPX56BSǿ��','',1, 16, '20150901022341.jpg'),
('��ʽIPX56Bǿ��ˮ','',1, 17, '20150901022218.jpg'),
('��ʽIPX5BSǿ��ˮ','',1, 18, '20150901022110.jpg'),
('��ʽIPX5Bǿ��ˮ��','',1, 19, '20150901021959.jpg'),
('����ʽIPX56ASǿ','',1, 20, '20150901021838.jpg');

drop table product_sort;
create table product_sort(
	sort_id int primary key auto_increment,
	sort_name varchar(30),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into product_sort(sort_name)
values('������������'),
('��ֱ��������װ��'),
('�ڹ���������װ��'),
('ǿ��ˮ����װ��'),
('��ˮ����װ��'),
('ѹ����ˮ����װ��'),
('���¸�ѹ��������װ��'),
('������������װ��'),
('��ˮ����װ��'),
('��ˮ���鷿'),
('�ۺ�������');

drop table news;
create table news(
	news_id int primary key auto_increment,
	news_title varchar(30),
	news_content text,
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into news(news_title, news_content)
values('��������ףȫ����������ڿ���', ''),
('��������ڡ�����ڹ�˾�ż�֪ͨ', ''),
('ף�����ų�Ϊ��֮��ķ�ˮ�����豸��Ӧ��', ''),
('IPX8��ˮ����� �¿��ϼ�! �����㣡', ''),
('����ͷ��ˮ���� �������Ź�������', ''),
('��70�����ı��������ŷ�չ��', ''),
('����ά��������������ǶԿͻ��ĳ�ŵ', ''),
('���µ����� �»��ͣ�IPX8����ѹ��ˮ�����', ''),
('��ӭ����ͻ����ҳ�ʵ�ؿ��죡', ''),
('�������ŲμӰٶ��ƶ��ƹ�Ӫ�����', ''),
('��ˮ������ �����Ƿ����ĺð���', ''),
('����������ǣ�� ���ع�ѧ������ˮ�����г�', '');

drop table cases;
create table cases(
	cases_id int primary key auto_increment,
	cases_title varchar(50),
	company varchar(50),
	cases_detail text,
	cases_image varchar(50), 
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into cases(cases_title, company, cases_detail, cases_image)
values('������������������ǩԼ�ɹ�', '������������', '', '20150622150115_7812.gif'),
('��������������ơ��ɿ�ʵ��-���ųɾ�', '�������������', '', '20150615154959_8650.jpg'),
('�����ڣ�ŷ�ܵƾ������Ź�ͬ����', '����ŷ�ܵƾ�', '', '20150601155025_0188.png'),
('Beide (UK) Product Service Limited�����豸���ų���', 'Beide (UK) Product Service Limited', '', '20150525160026_1102.png'),
('��������-�����Ｏ�Ŵ���Ƽ�����', '�����Ｏ��', '', '20150518161724_0429.jpg'),
('�������������š���Ϊ���Ż��ӭ��ո��ƪ��', '������������', '', '20150511161526_9621.png'),
('�н��Ƽ�����ѡ��- ����', '�н��Ƽ�����', '', '20150504161056_8940.png'),
('���Ϲ��-�綯������ɨ�� ���Ż���', '���Ϲ��', '', '20150427160445_8708.png'),
('������ף����н���Ѷ���������ź���', '����н���Ѷ����', '', '20150413165149_2344.png'),
('����Ϊ���ֿͳ����ݻ���', '���ֿͳ�', '', '20150407154200_8888.png'),
('���ݹ������������ɹ�', '���ݹ��������', '', '20150330141230_3148.png'),
('��ɽ�����鹤������Ƽ��ɷ����޹�˾', '��������Ƽ��ɷ����޹�˾', '', '20150328115145_5174.png');

drop table links;
create table links(
	links_id int primary key auto_increment,
	links varchar(100),
	links_title varchar(50),
	company varchar(50),
	links_image varchar(50), 
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into links(links_title, links, company, links_image)
values('Ȥ����', 'http://www.yuexinchina.com/', 'Ȥ����', '7mai.gif'),
('��Ʒ����', 'http://www.yuexinchina.com/', '��Ʒ����', 'styleweekly.gif'),
('�ξ���', 'http://www.yuexinchina.com/', '�ξ���', 'uuu9.gif');
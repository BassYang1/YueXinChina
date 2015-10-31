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
values('留言1', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言2', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言3', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言4', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言1', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言6', '12345212', 'abc', '哈哈噗嘿嘿呵呵'),
('留言1', '12345212', 'abc', '哈哈噗嘿嘿呵呵');

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

values('company', 'company_contact', '<p>电话：020-34722228</p><p>传真：020-34722227</p><p>手机：18122303373</p><p>联系人：陈先生（经理）</p><p>Q Q：37559462</p><p>旺旺：岳信试验设备</p><p>邮箱：yuexin@yuexin80.com</p><p>官网：www.yuexinchina.com</p><p>旺铺：http://pyyuexin.1688.com</p><p>营销型网站：www.yuexin80.com</p><p>地址：广州省广州市番禺区新造镇南约商业街34号</p>');

drop table p_sort;
create table p_sort(
	sort_id int primary key auto_increment,
	sort_name varchar(30),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into p_sort(sort_name)
values('汽车淋雨检测线'),('垂直滴雨试验装置'),('摆管淋雨试验装置'),('强喷水试验装置'),('浸水试验装置'),('压力浸水试验装置'),('高温高压喷淋试验装置'),('花洒淋雨试验装置'),('喷水试验装置'),('防水试验房'),('综合淋雨箱');

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
values('LABEL', '##site_name##', '岳信.中国IP防水试验机第一品牌,给您提供最专业的IP防水检测设备系统解决方案'),
('LABEL', '##company_name##', '广州岳信试验设备有限公司'),
('LABEL', '##site_desc##', 'IP防水试验机, IPX12滴雨试验机, IPX34摆管淋雨试验机, IPX56强喷水试验机, IPX78浸水试验机, UL喷水试验装置, 日标淋雨试验箱, 手持式淋雨试验装置, IPX9K高压喷淋试验箱, IPX8压力浸水试验机防尘箱, IP56防尘试验箱'),
('LABEL', '##key_words##', 'IP防水试验机, IPX12滴雨试验机, IPX34摆管淋雨试验机, IPX56强喷水试验机, IPX78浸水试验机, UL喷水试验装置, 日标淋雨试验箱, 手持式淋雨试验装置, IPX9K高压喷淋试验箱, IPX8压力浸水试验机防尘箱, IP56防尘试验箱'),
('LABLE', '##notice##', '您好,欢迎来到本网站！专业生产：IP防水试验机,摆管淋雨试验机和压力浸水试验机等产品.'),
('HTML', '##banner1##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner2##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner3##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##banner4##', '<a href="index.html" target="_blank"><img class="banner_img" src="##root_url##/images/banner.jpg" alt=""></a>'),
('HTML', '##hot_sort##', '<a href="#">摇摆淋雨试验机</a><a href="#">摇摆淋雨试验机</a><a href="#">强喷水试验机</a>'),
('HTML', '##company_outline##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>广州岳信试验设备有限</b>公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工、医...<a href="##root_url##/companyInfo.html">更多&gt;&gt;</a></p>'),
('HTML', '##contact##', '<p>电话：020-34722228</p><p>传真：020-34722227</p><p>手机：18122303373</p><p>联系人：陈先生（经理）</p><p>Q Q：37559462</p><p>旺旺：岳信试验设备</p><p>邮箱：yuexin@yuexin80.com</p><p>官网：www.yuexinchina.com</p><p>旺铺：http://pyyuexin.1688.com</p><p>营销型网站：www.yuexin80.com</p><p>地址：广州省广州市番禺区新造镇南约商业街34号</p>'),
('HTML', '##company_infor##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>广州岳信试验设备有限</b>公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工、医...<a href="##root_url##/companyInfo.html">更多&gt;&gt;</a></p>'),
('HTML', '##company_history##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>广州岳信试验设备有限</b>公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工、医...<a href="##root_url##/companyInfo.html">更多&gt;&gt;</a></p>'),
('HTML', '##company_cert##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>广州岳信试验设备有限</b>公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工、医...<a href="##root_url##/companyInfo.html">更多&gt;&gt;</a></p>'),
('HTML', '##company_style##', '<p><img src="##root_url##/images/company.jpg" width="200" height="150" alt="" class="com_img"><b>广州岳信试验设备有限</b>公司是一家集研发、生产、销售为一体的科技型企业，公司专业生产IPX防水试验设备、汽车淋雨试验房、真空水压防水试漏机等试验类机械设备。自创立以来，公司坚持“以新品拓展市场，以质量保证市场，以服务赢得市场”，凭借雄厚的技术力量，利用先进的生产设备和检测设备，使“YUEXIN”和“岳信”品牌的产品广泛应用于航空航天、汽车制造、造船、塑料、电子电工、通信技术、五金机械、仪器仪表、石油仪表、石油化工、医...<a href="##root_url##/companyInfo.html">更多&gt;&gt;</a></p>'),
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
values('YX-ZC400S综合','',1, 1, '20150901031909.jpg', 1),
('YX-ZC400综合淋','',1, 2, '20150901031749.jpg', 1),
('有流量计花洒淋雨试验装','',2, 3, '20150901031432.jpg', 1),
('无流量计花洒淋雨试验装','',3, 4, '20150901031251.jpg', 1),
('IPX800F600-','',1, 5, '20150901031045.jpg', 1),
('IPX800E600-','',1, 6, '20150901030919.jpg', 1),
('IPX800D 500','',1, 7, '20150901030716.jpg', 1),
('IPX800C500-','',1, 8, '20150901030449.jpg', 1),
('IPX800B500-','',1, 9, '20150901030220.jpg', 1),
('IPX800A500-','',1, 10, '20150901025902.jpg', 1),
('700F浸水试验装置','',1, 11, '20150901025446.jpg', 1);

insert into product(product_name, product_no, sort_id, order_no, images)
values('700D浸水试验装置','',1, 12, '20150901025259.jpg'),
('700C浸水试验装置','',1, 13, '20150901025023.jpg'),
('700B浸水试验装置','',1, 14, '20150901022745.jpg'),
('700A浸水试验装置','',1, 15, '20150901022554.jpg'),
('箱式IPX56BS强喷','',1, 16, '20150901022341.jpg'),
('箱式IPX56B强喷水','',1, 17, '20150901022218.jpg'),
('箱式IPX5BS强喷水','',1, 18, '20150901022110.jpg'),
('箱式IPX5B强喷水试','',1, 19, '20150901021959.jpg'),
('分体式IPX56AS强','',1, 20, '20150901021838.jpg');

drop table product_sort;
create table product_sort(
	sort_id int primary key auto_increment,
	sort_name varchar(30),
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into product_sort(sort_name)
values('汽车淋雨检测线'),
('垂直滴雨试验装置'),
('摆管淋雨试验装置'),
('强喷水试验装置'),
('浸水试验装置'),
('压力浸水试验装置'),
('高温高压喷淋试验装置'),
('花洒淋雨试验装置'),
('喷水试验装置'),
('防水试验房'),
('综合淋雨箱');

drop table news;
create table news(
	news_id int primary key auto_increment,
	news_title varchar(30),
	news_content text,
	rec_date timestamp default now()
)engine=innodb default charset=utf8 auto_increment=1;

set names GBK;
insert into news(news_title, news_content)
values('广州岳信祝全国人民中秋节快乐', ''),
('关于中秋节、国庆节公司放假通知', ''),
('祝贺岳信成为杰之洋的防水试验设备供应商', ''),
('IPX8浸水试验机 新款上架! 库存充足！', ''),
('摄像头防水测试 联威相信广州岳信', ''),
('看70周年阅兵！看岳信发展！', ''),
('定期维护—不变的我们是对客户的承诺', ''),
('创新的力量 新机型！IPX8正负压浸水试验机', ''),
('欢迎国外客户到我厂实地考察！', ''),
('广州岳信参加百度移动推广营销峰会', ''),
('防水试验箱 检测外壳防护的好帮手', ''),
('岳信与朗特牵手 开拓光学仪器防水试验市场', '');

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
values('西安立明电子与岳信签约成功', '西安立明电子', '', '20150622150115_7812.gif'),
('【深圳西西艾设计】可靠实验-岳信成就', '深圳西西艾设计', '', '20150615154959_8650.jpg'),
('（深圳）欧塑灯具与岳信共同出口', '深圳欧塑灯具', '', '20150601155025_0188.png'),
('Beide (UK) Product Service Limited试验设备岳信出口', 'Beide (UK) Product Service Limited', '', '20150525160026_1102.png'),
('岳信助攻-凯尔达集团打造科技创新', '凯尔达集团', '', '20150518161724_0429.jpg'),
('【济宁重汽集团】成为岳信伙伴迎来崭新篇章', '济宁重汽集团', '', '20150511161526_9621.png'),
('中建科技集团选择- 岳信', '中建科技集团', '', '20150504161056_8940.png'),
('湖南硅峰-电动环卫清扫车 岳信护航', '湖南硅峰', '', '20150427160445_8708.png'),
('热烈庆祝香港中建电讯集团与岳信合作', '香港中建电讯集团', '', '20150413165149_2344.png'),
('岳信为桂林客车保驾护航', '桂林客车', '', '20150407154200_8888.png'),
('广州广电计量检测合作成功', '广州广电计量检测', '', '20150330141230_3148.png'),
('唐山曹妃甸工大海宇光电科技股份有限公司', '工大海宇光电科技股份有限公司', '', '20150328115145_5174.png');

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
values('趣麦网', 'http://www.yuexinchina.com/', '趣麦网', '7mai.gif'),
('精品生活', 'http://www.yuexinchina.com/', '精品生活', 'styleweekly.gif'),
('游九网', 'http://www.yuexinchina.com/', '游九网', 'uuu9.gif');
<?php
	require_once("../include/common.php");
	require_once("../include/3rd/email.class.php");
	
	//邮箱服务器配置
	$emailServer = Config::getValueByKey("EMAIL_SERVER");//服务器
	$emailPort = Config::getValueByKey("EMAIL_PORT");//服务器端口
	$from = Config::getValueByKey("EMAIL_FROM");//发件人
	$user = Config::getValueByKey("EMAIL_USER");//帐号
	$password = Config::getValueByKey("EMAIL_PASSWORD");//密码
	
	//邮件内容
	$to = $message->email; //收件人
	$title = Config::getValueByKey("REPLY_TITLE");//主题
	$content = sprintf("<h1>%s</h1>", $message->reply);//内容
	$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
	
	$smtp = new smtp($emailServer, $emailPort, true, $user, $password);//true表示使用身份验证,否则不使用身份验证.
	$smtp->debug = true;//是否显示发送的调试信息
	$state = $smtp->sendmail($to, $from, $title, $content, $mailtype);
	Tool::logger(__METHOD__, __LINE__, sprintf("邮件发送: %s", $state), _LOG_INFOR);

	if(!empty($state)){
		$emailResult = true;
	}
?>
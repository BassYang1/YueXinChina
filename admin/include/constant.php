<?php
define("_TEMP_ROOT", str_replace("include\class", "", __dir__) . "template\\");
define("_WEB_ROOT", str_replace("include\class", "", __dir__) . "web\\");
define("_ROOT_URL", (strtoupper($_SERVER["HTTPS"]) == "ON" ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . "/web_admin/admin/web");

define("_QUERY_ALL", 0);
define("_NONE", 0);

define("_LOG_ERROR", "ERROR");
define("_LOG_DEBUG", "DEBUG");
define("_LOG_INFOR", "INFO");
define("_LOG_WARN", "WARN");
define("_IS_DEBUG", TRUE);

//是否启用cache
define("_ENABLE_CACHE", TRUE);



define("_TEMP_START", "__TEMP_S");
define("_TEMP_END", "__TEMP_E");

define("_PAGE_CONTENT", "##page_content##");
define("_COMP_PRODUCT_LIST", "##comp_product_list##");
define("_COMP_SORT_MENU", "##comp_sort_menu##");
define("_COMP_SORT_CONTACT", "##comp_company_contact##");
define("_COMP_RECOMMEND_PRODUCT_MENU", "##comp_recommend_product_menu##");
define("_COMP_COMPANY_OUTLINE", "##comp_company_outline##");
define("_COMP_COMPANY_NEWS", "##comp_company_news##");
define("_COMP_COMPANY_CASES", "##comp_company_cases##");
define("_COMP_COMPANY_LINKS", "##comp_company_links##");
define("_COMP_LATEST_NEWS", "##comp_latest_news##");
define("_COMP_COMPANY_INFOR", "##comp_company_infor##");


define("_IS_RECOMMEND_PRODUCT", 1);
define("_IS_NOT_RECOMMEND_PRODUCT", 0);


define("_SHOW_LIST", 0);
define("_SHOW_MENU", 1);
define("_SHOW_DETAIL", 2);

define("_ALL_PRODUCT", 0);

?>
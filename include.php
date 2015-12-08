<title><?php echo $page_title; ?>-<?php echo Company::content("site_name", false); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo Company::content("seo_key", false); ?>" />
<meta name="description" content="<?php echo Company::content("site_desc", false); ?>" />
<link href="css/base.css" rel="stylesheet" type="text/css" />
<link href="css/frame.css" rel="stylesheet" type="text/css" />
<!--flash jq-->
<script src="scripts/jquery-1.8.0.min.js" type="text/javascript"></script>
<script src="scripts/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
<script src="scripts/jQuery.hhShare.min.js" type="text/javascript"></script>
<!-- customized js-->
<script src="scripts/common.js" type="text/javascript"></script>
<script src="scripts/rollpic.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">
    function show(i) {
        if (i.style.display == "none") {
            i.style.display = "";
        } else {
            i.style.display = "none";
        }
    }
</script>
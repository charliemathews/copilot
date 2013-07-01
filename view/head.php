<!-- //Copyright 2013 Technical Solutions, LLC.
     //Confidential & Proprietary Information. -->

<!DOCTYPE html>
<head>

<title><?php echo APP_NAME, ' | ', APP_VERSION ; ?></title>

<link href="<?= SERVER_DOCRT ?>/view/style.css" rel="stylesheet" type="text/css">
<!-- because of mod_rewrite, any local links will not work on localhost. -->
<!-- contents of style.css are in <style> tags below -->
<style>
* {
	font-family: Helvetica,Arial,Verdana,sans-serif ;
}
html {
	font-size: 62.5%;  /* equals 10px */
}
body {

}
h2 {
	font-size: 1.7em ;
}
#meta {
	position: fixed ;
	bottom: 0px ;
	left: 0px ;
	font-size: 4em ;
	opacity: 0.1 ;
	text-align: left ;
	text-transform: uppercase ;
}
#meta_version {
	position: fixed ;
	bottom: 0px ;
	right: 0px ;
	font-size: 4em ;
	opacity: 0.1 ;
	text-align: right ;
	text-transform: uppercase ;
}
#msg_box {
	height:100%;
	width:100%;
	border:1px solid #ccc;
	font:16px/26px Georgia, Garamond, Serif;
	overflow:auto;
}
</style>

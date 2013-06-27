<?php require_once(SERVER_DOCRT.'/view/head.php'); ?>

</head>
<body>

<div id="meta_version">
<?= (DEV ? 	APP_NAME."<br>\n".
			APP_VERSION." ".APP_VERSION_TITLE
			: ERROR_ACCESS_DENIED) ?>
</div>

<div id="meta_all">
<?= (DEV ? 	"<br><br>\n".
			"SERVER: ".SERVER_NAME."<br>\n".
			"ROOT: ".SERVER_DOCRT."<br>\n".
			"SCRIPT: ".$_SERVER['SCRIPT_NAME']."<br>\n".
			"VERSION: ".APP_VERSION." ".APP_VERSION_TITLE."<br>\n".
			"TIME: ".SCRIPT_TIME."<br>\n"
			: ERROR_ACCESS_DENIED) ?>
</div>

<br>

<h2>Messages</h2>
<div style="height:130px;width:500px;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
	<?php $cp_instance->log->display_fancy('*') ; ?>
</div>

<?php require_once(SERVER_DOCRT.'/view/foot.php'); ?>
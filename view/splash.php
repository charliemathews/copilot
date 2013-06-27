<?php require_once(SERVER_DOCRT.'/view/head.php'); ?>

</head>
<body>

<div id="meta_version">
<?= (DEV ? 	APP_NAME."<br>\n".
			APP_VERSION." ".APP_VERSION_TITLE
			: ERROR_ACCESS_DENIED) ?>
</div>

<div id="meta">
<?= (DEV ? 	"<div>\n".
			SERVER_NAME."<br>\n".
			SCRIPT_TIME."<br>\n".
			"</div>\n"
			: ERROR_ACCESS_DENIED) ?>
</div>
<h2>Messages</h2>
<div style="height:130px;width:500px;border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
	<?php $cp_instance->log->displayFancy('*') ; ?>
</div>

<?php require_once(SERVER_DOCRT.'/view/foot.php'); ?>
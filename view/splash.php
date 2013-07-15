<?php require_once(SERVER_DOCRT.'/view/head.php'); ?>

</head>
<body>

<div id="meta_version">
<?= (DEV ? 	APP_NAME."<br>\n".
			APP_VERSION." ".APP_VERSION_TITLE
			: ERROR_ACCESS_DENIED) ?>
</div>

</div>
<h2>DEV: <?= DEV ?> and DEV_GUI: <?= DEV_GUI ?></h2>
<div id="msg_box">
	<?php $this->log->displayFancy('*') ; ?>
</div>

<?php require_once(SERVER_DOCRT.'/view/foot.php'); ?>
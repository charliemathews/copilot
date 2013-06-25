<?php require_once(SERVER_DOCRT.'/view/head.php'); ?>

</head>
<body>

<?= (DEV ? 	"<br><br>\n".
			"SERVER: ".SERVER_NAME."<br>\n".
			"ROOT: ".SERVER_DOCRT."<br>\n".
			"SCRIPT: ".$_SERVER['SCRIPT_NAME']."<br>\n".
			"VERSION: ".APP_VERSION." ".APP_VERSION_TITLE."<br>\n"
			: ERROR_ACCESS_DENIED) ?>

<?=  '<br><br>Log<br>' . $cp->log->display('LOG') ; ?>

<?php require_once(SERVER_DOCRT.'/view/foot.php'); ?>
<!-- //Copyright 2013 Technical Solutions, LLC.
     //Confidential & Proprietary Information. -->


</head>
<body>

<?= (DEV ? 	"<br><br>\n".
			"SERVER: ".SERVER_NAME."<br>\n".
			"ROOT: ".SERVER_DOCRT."<br>\n".
			"SCRIPT: ".$_SERVER['SCRIPT_NAME']."<br>\n".
			"VERSION: ".APP_VERSION." ".APP_VERSION_TITLE."<br>\n"
			: ERROR_ACCESS_DENIED) ?>

<br><br>
Sample RESTful API Routes<br>
<img src="view/sample.route.png"/>

</body>
</html>
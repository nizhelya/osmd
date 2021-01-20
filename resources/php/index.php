<!DOCTYPE html>

<html  manifest="Is.appcache" >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>is</title>
   <!-- <link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css"/>-->
    <link rel="stylesheet" type="text/css" href="resources/css/ext-all-gray.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/flat_grids.css"/>
    <script type="text/javascript" src="extjs/ext-all.js"></script>
    <script type="text/javascript" src="extjs/locale/ext-lang-ru.js"></script>
   <script type="text/javascript">
        Ext.ns("Ext.app.REMOTING_API");
        Ext.app.REMOTING_API = {"descriptor":"Ext.app.REMOTING_API","url":"php/router.php","type":"remoting","actions":{"QueryForm":[{"name":"getResults","len":4}],"QueryAddress":[{"name":"getResults","len":1}],"QueryTarifTables":[{"name":"getResults","len":1}],"QueryUserLogin":[{"name":"getResults","len":1},{"name":"registration","len":1},{"name":"login","len":1},{"name":"checkLogin","len":1},{"name":"checkMyFlat","len":3}],"QueryMyFlat":[{"name":"getResults","len":1},{"name":"createRecord","len":1},{"name":"updateRecords","len":1},{"name":"destroyRecord","len":1}]}};
        Ext.Direct.addProvider(Ext.app.REMOTING_API);
    </script>
       <script type="text/javascript" >  
        var login  = '<?php echo (isset($_GET['login']) &&  strlen($_GET['login'])) ? $_GET['login'] :null; ?>'
	var code  = '<?php echo (isset($_GET['code']) &&  strlen($_GET['code'])) ? $_GET['code'] :null; ?>'
	var remember  = '<?php echo (isset($_GET['remember']) &&  $_GET['remember']) ? $_GET['remember'] :null; ?>'
     </script>
    <script type="text/javascript" src="app.js"></script>
</head>
<body></body>
</html>
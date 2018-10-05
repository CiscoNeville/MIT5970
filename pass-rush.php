<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>


<?php


//Get the team name from the URL
$myTeam = htmlspecialchars($_GET["team"]);

echo "<h1>Yards per passing touchdown and rushing touchdown by $myTeam </h1><br><br>";
<HTML>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>



<?php



$myTeam = htmlspecialchars($_GET["teamId"]);


$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());


$teamQuery = "SELECT team.school FROM team WHERE team.id = $myTeam";
$teamResult = pg_query($teamQuery) or die('Query failed: ' . pg_last_error());
while ($teamLine = pg_fetch_array($teamResult, null, PGSQL_ASSOC)) {
$teamName = $teamLine[school];
}


echo "<h1>Showing how efficiently $teamName scored</h1><br><br>";

$offenseId = $myTeam;



$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());


$totalAttempts=0;
$successfulAttempts=0;
$failedAttempts=0;



$query = "SELECT drive.id, drive.scoring, team.school FROM drive INNER JOIN team ON drive.offense_id = team.id WHERE team.id = $offenseId AND drive.scoring = 't' GROUP BY team.school, drive.id, drive.scoring";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());


while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$totalAttempts++;
$successfulAttempts++;

}

echo "</table>\n";
echo "<h3>Number of drives that ended in a score: $successfulAttempts </h3>";
echo "<br><br>";



$query = "SELECT drive.id, drive.scoring, team.school FROM drive INNER JOIN team ON drive.offense_id = team.id WHERE team.id = $offenseId AND drive.scoring = 'f' GROUP BY team.school, drive.id, drive.scoring";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());


while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$totalAttempts++;
$failedAttempts++;


}
echo "</table>\n";
echo "<h3>Number of drives that did not end in a score: $failedAttempts </h3>";
echo "<br><br>";




echo "<h1> Total number of drives: $totalAttempts </h1>";



$ratio = $successfulAttempts / $totalAttempts;
$ratio = round($ratio * 100);
echo "<h2> Percentage of drives that ended in a score for $teamName= $ratio% </h2>";



// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);



?>

</body>
 
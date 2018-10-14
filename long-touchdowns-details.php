<html>
<head>
<link href="style1.css" rel="stylesheet" type="text/css" media="screen" />
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


echo "<h1>70+ yard touchdowns by $teamName </h1><br><br>";



$offenseId=$myTeam;


$query = "SELECT play.yards_gained, play.play_type_id, team.school, play.play_text FROM play INNER JOIN team ON play.offense_id = team.id WHERE play.offense_id = $offenseId AND play.yards_gained >= 70 GROUP BY play.yards_gained, play.play_type_id, team.school, play.play_text HAVING play.play_type_id = 67 OR play.play_type_id = 68 ORDER BY play.yards_gained DESC";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());


echo "<h3>70+ yard touchdowns</h3>";
echo "<table cellpadding=5>\n";
echo "\t<tr><td>Yards Gained</td><td></td><td>Pass/Rush TD</td><td></td><td>Play Text</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$playDisplay = "Pass";
if ($line[play_type_id] == 68) $playDisplay = "Rush";


    echo "\t<tr>\n";
 echo "\t\t<td>$line[yards_gained]</td>\n";
 echo "\t\t<td></td>\n";
 echo "\t\t<td>$playDisplay</td>\n";
 echo "\t\t<td></td>\n";
 echo "\t\t<td>$line[play_text]</td>\n";
    echo "\t</tr>\n";



}



// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);



?>

</body>

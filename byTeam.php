<HTML>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>



<?php


//Get the team name from the URL
$myTeam = htmlspecialchars($_GET["team"]);

echo "<h1>Listing of all of $myTeam 2 point plays</h1><br><br>";


// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());

// Performing SQL query
$offenseIdResult = pg_query($dbconn, "SELECT team.id  FROM team  WHERE team.school ILIKE '$myTeam'");
while ($row = pg_fetch_row($offenseIdResult)) {
$offenseId = $row[0];
}
//echo "<p>$myTeam has an offenseId of $offenseId</p>";



// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());

//initialize variables to keep track of total attempts, success, failure
$totalAttempts=0;
$successfulAttempts=0;
$failedAttempts=0;


// Performing SQL query for successful attempts
$query = "SELECT game.id, game.season, team.school, play.period, play.clock, play.play_text FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id     WHERE ((play.play_text ILIKE '%two-point%') OR (play.play_text ILIKE '%2 point%')) AND ((play.play_text  NOT ILIKE '%FAILED%') AND (play.play_text  NOT ILIKE '%NO GOOD%')) AND (play.offense_id=$offenseId)";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<h3>successes</h3>";
echo "<table cellpadding=2>\n";
echo "\t<tr><td>season</td><td>opponent</td><td>quarter</td><td>clock</td><td>play text</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$totalAttempts++;
$successfulAttempts++;


    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$line[school]</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";
 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
    echo "\t</tr>\n";
}
echo "</table>\n";
echo "<h3>Successful 2-point conversion attempts: $successfulAttempts </h3>";
echo "<br><br>";


// Performing SQL query for failed attempts
$query = "SELECT game.id, game.season, team.school, play.period, play.clock, play.play_text FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id     WHERE ((play.play_text ILIKE '%two-point%') OR (play.play_text ILIKE '%2 point%')) AND ((play.play_text  ILIKE '%FAILED%') OR (play.play_text  ILIKE '%NO GOOD%')) AND (play.offense_id=$offenseId)";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<h3>failures</h3>";
echo "<table cellpadding=2>\n";
echo "\t<tr><td>season</td><td>opponent</td><td>quarter</td><td>clock</td><td>play text</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$totalAttempts++;
$failedAttempts++;


    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$line[school]</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";
 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
    echo "\t</tr>\n";
}
echo "</table>\n";
echo "<h3>Failed 2-point conversion attempts: $failedAttempts </h3>";
echo "<br><br>";








echo "<h1> Total 2-point conversion attempts: $totalAttempts </h1>";



$ratio = $successfulAttempts / $totalAttempts;
$ratio = round($ratio * 100);
echo "<h2> Total 2-point success percentage for $myTeam= $ratio% </h2>";



// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);



?>

</body>




<html>
<head>
<link href="style1.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>


<?php


$myTeam = htmlspecialchars($_GET["teamId"]);
$playType = htmlspecialchars($_GET["playtype"]);

$playDisplay = 'Rush';
if ($playType == 67) $playDisplay = 'Pass';


echo "<h1> $playDisplay TD details for $myTeam </h1><br>";


$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());

$offenseId=$myTeam;

$query = "SELECT game.id, game.season, team.school, play.period, play.clock, play.play_text, play.yards_gained FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id  WHERE (play.play_type_id=$1) AND (play.offense_id=$2)  ORDER BY play.yards_gained DESC";
$result = pg_query_params($query, array($playType, $myTeam)) or die('Query failed: ' . pg_last_error());

echo "<h3> <a href ='http://saturdaycoach.com/touchdowns.php'> New Search </a></h3>"; 
echo "<table cellpadding=2>\n";
echo "\t<tr><td>season</td><td>opponent</td><td>quarter</td><td>clock</td><td>yards gained</td><td>play text</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {


    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$line[school]</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";
 echo "\t\t<td><center>$line[yards_gained]</center></td>\n";
 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
    echo "\t</tr>\n";
}



pg_free_result($result);


pg_close($dbconn);



?>





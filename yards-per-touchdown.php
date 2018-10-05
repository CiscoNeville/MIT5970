<html>
<head>
<link href="style1.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>


<?php



$myTeam = htmlspecialchars($_GET["teamId"]);

echo "<h1>Yards per passing touchdown and rushing touchdown by $myTeam </h1><br><br>";


$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());


$offenseId=$myTeam;


$query = "select play_type_id, avg(yards_gained) as avg_yards from play where offense_id=$offenseId group by play_type_id having play_type_id=67 or play_type_id=68";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());


echo "<h3>Avg. yards per pass/rush touchdowns</h3>";
echo "<h4>Click pass or rush for more details</h4>";
echo "<table cellpadding=5>\n";
echo "\t<tr><td>Pass/Rush TD</td><td></td><td>Avg. yards per TD</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

$playType = 'Rush';
if ($line[play_type_id] == 67) $playType = 'Pass';
$yards = round($line[avg_yards]);

    echo "\t<tr>\n";
 echo "\t\t<td><a href='/touchdown-details.php?teamId=$myTeam&playtype=$line[play_type_id]'>$playType</a></td>\n";
 echo "\t\t<td></td>\n";
 echo "\t\t<td>$yards</td>\n";
     echo "\t</tr>\n";


}



// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);



?>

</body>





















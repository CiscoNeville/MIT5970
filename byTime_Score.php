<HTML>
<head>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>



<?php


//Get the team name from the URL
$timeMax = htmlspecialchars($_GET["timeMax"]);
$timeMin = htmlspecialchars($_GET["timeMin"]);
$leadMax = htmlspecialchars($_GET["leadMax"]);
$leadMin = htmlspecialchars($_GET["leadMin"]);

echo "<h1>Listing of all of 2 point plays that match criteria</h1><br><br>";





// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());

//initialize variables to keep track of total attempts, success, failure
$totalAttempts=0;
$twoPointAttempts=0;
$onePointAttempts=0;
echo "<h3>time Min is $timeMin    time Max is $timeMax</h3>";
echo "<h3>Lead Min is $leadMin    Lead Max is $leadMax</h3>";

// Performing SQL query for successful 2 point attempts matching criteria 
$query = "SELECT game.id, game.season, play.offense_id, play.defense_id, play.period, play.clock, play.home_score, play.away_score, play.play_text FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id     WHERE ((play.play_text ILIKE '%two-point%') OR (play.play_text ILIKE '%2 point%')) AND ((play.play_text  NOT ILIKE '%FAILED%') AND (play.play_text  NOT ILIKE '%NO GOOD%'))AND (play.period = 4)  ";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<h3>two point attempts</h3>";
echo "<table cellpadding=2>\n";
echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Successful two point attempts</td></tr>";
echo "\t<tr><td>season</td><td>offense</td><td>defense</td><td>quarter</td><td>  clock (hh:mm:ss) </td><td>Score</td><td>play text</td><td>won game?</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

//get the clock and see if it is between min and max
$clockTimeRemaining = explode(":", $line[clock]);
$clockMinutesRemaining = $clockTimeRemaining[1];

//Is the offense the home team?
$offenseHomeTeamQ = pg_query($dbconn, "SELECT game_team.home_away  FROM game_team INNER JOIN team ON game_team.team_id=team.id INNER JOIN game ON game_team.game_id=game.id  WHERE team.id = '$line[offense_id]' AND game.id= '$line[id]'  ");
while ($row = pg_fetch_row($offenseHomeTeamQ)) {
$offenseTeamIsHome = $row[0];
}








//get score difference
$scoreDifference = $line[home_score] - $line[away_score] -2 ;
//If the offense is the away team, reverse this score result
if ($offenseTeamIsHome == 'away') {
$scoreDifference = $line[away_score] - $line[home_score] -2 ;
}



if (($clockMinutesRemaining >= $timeMin) && ($clockMinutesRemaining <= $timeMax - 1) && ($scoreDifference <= $leadMax) && ($scoreDifference >= $leadMin)) {

$totalAttempts++;
$successfulAttempts++;

// change offense.id and defense.id into team names
$offenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[offense_id]'");
while ($row = pg_fetch_row($offenseTeamResult)) {
$offenseTeam = $row[0];
}
$defenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[defense_id]'");
while ($row = pg_fetch_row($defenseTeamResult)) {
$defenseTeam = $row[0];
}

// see if offense won that game
$offenseWonGameResult = pg_query($dbconn, "SELECT game_team.winner  FROM game_team  INNER JOIN team ON game_team.team_id=team.id  WHERE game_team.game_id = '$line[id]' AND team.id = '$line[offense_id]'  ");
while ($row = pg_fetch_row($offenseWonGameResult)) {
$didOffenseWin = $row[0];
}
// make won game more readable for table  -  I don't think this logic is correct, but not sure.  Think I need an or offense is home statement added, or something like that
if (($didOffenseWin == 't') ) {
$didOffenseWin = "win";
$offenseWentForTwoAndWon++;
$offenseWentForTwoSucceededAndWon++;
}
else {$didOffenseWin = "loss";}



    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$offenseTeam ($offenseTeamIsHome)</td>\n";
 echo "\t\t<td>$defenseTeam</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";

if ($offenseTeamIsHome == 'away') {
 echo "\t\t<td>$line[home_score]-$line[away_score]</td>\n";
} else {
 echo "\t\t<td>$line[away_score]-$line[home_score]</td>\n";
}


 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
 echo "\t\t<td>$didOffenseWin</td>\n"; 
   echo "\t</tr>\n";
}
}


// Performing SQL query for failed 2 point attempts matching criteria 
$query = "SELECT game.id, game.season, play.offense_id, play.defense_id, play.period, play.clock, play.home_score, play.away_score, play.play_text FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id     WHERE ((play.play_text ILIKE '%two-point%') OR (play.play_text ILIKE '%2 point%')) AND ((play.play_text ILIKE '%FAILED%') OR (play.play_text ILIKE '%NO GOOD%'))AND (play.period = 4)  ";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Failed two point attempts</td></tr>";


// Printing results in HTML
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

//get the clock and see if it is between min and max
$clockTimeRemaining = explode(":", $line[clock]);
$clockMinutesRemaining = $clockTimeRemaining[1];


//Is the offense the home team?
$offenseHomeTeamQ = pg_query($dbconn, "SELECT game_team.home_away  FROM game_team INNER JOIN team ON game_team.team_id=team.id INNER JOIN game ON game_team.game_id=game.id  WHERE team.id = '$line[offense_id]' AND game.id= '$line[id]'  ");
while ($row = pg_fetch_row($offenseHomeTeamQ)) {
$offenseTeamIsHome = $row[0];
}






//get score difference
$scoreDifference = $line[home_score] - $line[away_score] ;
//If the offense is the away team, reverse this score result
if ($offenseTeamIsHome == 'away') {
$scoreDifference = $line[away_score] - $line[home_score] ;
}



if (($clockMinutesRemaining >= $timeMin) && ($clockMinutesRemaining <= $timeMax - 1) && ($scoreDifference <= $leadMax) && ($scoreDifference >= $leadMin)) {

$totalAttempts++;
$failedAttempts++;

// change offense.id and defense.id into team names
$offenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[offense_id]'");
while ($row = pg_fetch_row($offenseTeamResult)) {
$offenseTeam = $row[0];
}
$defenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[defense_id]'");
while ($row = pg_fetch_row($defenseTeamResult)) {
$defenseTeam = $row[0];
}

// see if offense won that game
$offenseWonGameResult = pg_query($dbconn, "SELECT game_team.winner  FROM game_team  INNER JOIN team ON game_team.team_id=team.id  WHERE game_team.game_id = '$line[id]' AND team.id = '$line[offense_id]'  ");
while ($row = pg_fetch_row($offenseWonGameResult)) {
$didOffenseWin = $row[0];
}
// make won game more readable for table
if ( ($didOffenseWin == 't') && ($offenseTeamIsHome == 'away') ) {
$didOffenseWin = "win";
$offenseWentForTwoAndWon++;
$offenseWentForTwoFailedButWon++;
}
else {$didOffenseWin = "loss";}



    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$offenseTeam ($offenseTeamIsHome)</td>\n";
 echo "\t\t<td>$defenseTeam</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";

if ($offenseTeamIsHome == 'home') {
 echo "\t\t<td>$line[home_score]-$line[away_score]</td>\n";
} else {
 echo "\t\t<td>$line[away_score]-$line[home_score]</td>\n";
}


 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
 echo "\t\t<td>$didOffenseWin</td>\n"; 
    echo "\t</tr>\n";
}
}










echo "</table>\n";

// compute and print final 2-point stats
$successRatio = $offenseWentForTwoSucceededAndWon / $successfulAttempts;
$successRatio = round($successRatio * 100);

$failedRatio =  $offenseWentForTwoFailedButWon / $failedAttempts;
$failedRatio = round($failedRatio * 100);

$ratio = $offenseWentForTwoAndWon / $totalAttempts;
$ratio = round($ratio * 100);


//echo "<h4> offenseWentForTwoSucceededAndWon is $offenseWentForTwoSucceededAndWon</h4>";
//echo "<h4> successfulAttempts is $successfulAttempts</h4>";


echo "<h4>Successful 2-point conversion attempts: $successfulAttempts </h4>";
echo "<h3> When teams went for 2 and got it they ultimately won the game: $successRatio % of the time </h3>";
echo "<h4>Failed 2-point conversion attempts: $failedAttempts </h4>";
echo "<h3> When teams went for 2 and failed they ultimately ended up winning the game anyways: $failedRatio % of the time </h3>";
echo "<h4> Total 2-point conversion attempts: $totalAttempts </h4>";
echo "<h1> Overall, when teams went for 2 they ultimately won the game: $ratio % of the time </h1>";
echo "<br><br><br><br><br><br>";






echo "<br><br>";


// Performing SQL query for 1 point attempts
$query = "SELECT game.id, game.season, play.offense_id, play.defense_id, play.period, play.clock, play.home_score, play.away_score, play.play_text FROM play INNER JOIN team ON play.defense_id=team.id INNER JOIN drive ON play.drive_id=drive.id INNER JOIN game ON drive.game_id=game.id     WHERE ((play.play_text ILIKE '%kick\)%') OR (play.play_text ILIKE '%extra point good%')) AND (play.period = 4)  ";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
echo "<h3>PAT attempts</h3>";
echo "<table cellpadding=2>\n";
echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>Successful PAT attempts</td></tr>";
echo "\t<tr><td>season</td><td>offense</td><td>defense</td><td>quarter</td><td>  clock (hh:mm:ss) </td><td>Score</td><td>play text</td><td>won game?</td></tr>";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {

//get the clock and see if it is between min and max
$clockTimeRemaining = explode(":", $line[clock]);
$clockMinutesRemaining = $clockTimeRemaining[1];

//Is the offense the home team?
$offenseHomeTeamQ = pg_query($dbconn, "SELECT game_team.home_away  FROM game_team INNER JOIN team ON game_team.team_id=team.id INNER JOIN game ON game_team.game_id=game.id  WHERE team.id = '$line[offense_id]' AND game.id= '$line[id]'  ");
while ($row = pg_fetch_row($offenseHomeTeamQ)) {
$offenseTeamIsHome = $row[0];
}








//get score difference
$scoreDifference = $line[home_score] - $line[away_score] -1 ;
//If the offense is the away team, reverse this score result
if ($offenseTeamIsHome == 'away') {
$scoreDifference = $line[away_score] - $line[home_score] -1 ;
}



if (($clockMinutesRemaining >= $timeMin) && ($clockMinutesRemaining <= $timeMax - 1) && ($scoreDifference <= $leadMax) && ($scoreDifference >= $leadMin)) {

$totalPatAttempts++;

// change offense.id and defense.id into team names
$offenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[offense_id]'");
while ($row = pg_fetch_row($offenseTeamResult)) {
$offenseTeam = $row[0];
}
$defenseTeamResult = pg_query($dbconn, "SELECT team.school  FROM team  WHERE team.id = '$line[defense_id]'");
while ($row = pg_fetch_row($defenseTeamResult)) {
$defenseTeam = $row[0];
}

// see if offense won that game
$offenseWonGameResult = pg_query($dbconn, "SELECT game_team.winner  FROM game_team  INNER JOIN team ON game_team.team_id=team.id  WHERE game_team.game_id = '$line[id]' AND team.id = '$line[offense_id]'  ");
while ($row = pg_fetch_row($offenseWonGameResult)) {
$didOffenseWin = $row[0];
}
// make won game more readable for table  -  I don't think this logic is correct, but not sure.  Think I need an or offense is home statement added, or something like that
if (($didOffenseWin == 't') ) {
$didOffenseWin = "win";
$offenseWentForPatAndWon++;
}
else {$didOffenseWin = "loss";}



    echo "\t<tr>\n";
 //echo "\t\t<td>$line[id]</td>\n";
 echo "\t\t<td>$line[season]</td>\n";
 echo "\t\t<td>$offenseTeam ($offenseTeamIsHome)</td>\n";
 echo "\t\t<td>$defenseTeam</td>\n";
 echo "\t\t<td>$line[period]</td>\n";
 echo "\t\t<td>$line[clock]</td>\n";

if ($offenseTeamIsHome == 'away') {
 echo "\t\t<td>$line[home_score]-$line[away_score]</td>\n";
} else {
 echo "\t\t<td>$line[away_score]-$line[home_score]</td>\n";
}


 echo "\t\t<td><a href=\"http://www.espn.com/college-football/recap?gameId=$line[id]\" target=\"_blank\" >$line[play_text]</a></td>\n";
 echo "\t\t<td>$didOffenseWin</td>\n"; 
   echo "\t</tr>\n";
}
}




echo "</table>\n";
















































































// compute and print final PAT stats
$patRatio = $offenseWentForPatAndWon / $totalPatAttempts;
$patRatio = round($patRatio * 100);




//echo "<h3>Successful 1-point PAT attempts: $successfulPats </h3>";
//echo "<h3>Failed 1-point PAT attempts: $failedPATs </h3>";
echo "<h1> Total 1-point PAT attempts: $totalPatAttempts </h1>";
echo "<h1> When teams went for 1 they ultimately won the game:  $patRatio % of the time </h1><br><br>";




// Free resultset
pg_free_result($result);

// Closing connection
pg_close($dbconn);



?>

</body>




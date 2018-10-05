<html>
<head>
<title> Saturday Coach - MIT 5970 project - 2 point plays by team </title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen"/>
</head>

<body>

<h3> Select the team you want to analyze.</h3>
<br>
<h3> Results will open in a new page</h3>
<h3>Showing the average number of yards for a passing touchdown and rushing touchdown by that team over the period of 2014-2017</h3>
<br>
<br>

<form action=yards-per-touchdown.php>
Choose team from all college football (FBS + FCS): <br>
 <select name="teamId">
 

<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());
$teamsResult = pg_query($dbconn, "SELECT team.school, team.id  FROM team ORDER BY team.school ASC ");
while ($row = pg_fetch_row($teamsResult)) {
$teamName = $row[0];
$teamId = $row[1];
echo "<option value=\"$teamId\">$teamName</option>";
}
pg_free_result($result);
pg_close($dbconn);
?>
</select> 
 <input type="submit" value="Submit">
</form>







</body>
</html>
  
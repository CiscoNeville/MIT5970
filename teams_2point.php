<HTML>
<head>
<title>Saturday Coach - MIT 5970 project - 2 point plays by team</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>

<h3> Select the team you want to analyze.</h3><br>
<h3> Results will open in a new page</h3>
<h3>Showing all the 2-point attempts by that team over the period of 2001-2017</h3><br><br>

<form action="/byTeam.php?$teamName">
Choose team from all college football (FBS + FCS): <br>
 <select name="team">
//OU has to come first
  <option value="Oklahoma">Oklahoma</option>  
<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());
$teamsResult = pg_query($dbconn, "SELECT team.school  FROM team ORDER BY team.school ASC ");
while ($row = pg_fetch_row($teamsResult)) {
$teamName = $row[0];
echo "<option value=\"$teamName\">$teamName</option>";
}
pg_free_result($result);
pg_close($dbconn);
?>
</select> 
 <input type="submit" value="Submit">
</form>

<br><br><br>

<form action="/byTeam.php?$teamName">
or - Choose team by conference:<br>Big12<br>
 <select name="team">
  <option value="Oklahoma">Oklahoma</option>  
  <option value="Oklahoma State">Oklahoma State</option>  
  <option value="Texas">Texas</option>  
  <option value="TCU">TCU</option>  
  <option value="Texas Tech">Texas Tech</option>  
  <option value="Baylor">Baylor</option>  
  <option value="Kansas">Kansas</option>  
  <option value="Kansas State">Kansas State</option>  
  <option value="Iowa State">Iowa State</option>  
  <option value="West Virginia">West Virginia</option> 
</select> 
 <input type="submit" value="Submit">
</form>

<br>

<form action="/byTeam.php?$teamName">
SEC<br>
 <select name="team">
  <option value="Alabama">Alabama</option>  
  <option value="Arkansas">Arkansas</option>  
  <option value="Auburn">Auburn</option>  
  <option value="Mississippi State">Mississippi State</option>  
  <option value="Ole Miss">Ole Miss</option>  
  <option value="LSU">LSU</option>  
  <option value="Texas A&M">Texas A&M</option>  
  <option value="Florida">Florida</option>  
  <option value="Georgia">Georgia</option>  
  <option value="Tennessee">Tennessee</option>  
  <option value="Vanderbilt">Vanderbilt</option>  
  <option value="Kentucky">Kentucky</option>  
  <option value="Missouri">Missouri</option>  
  <option value="South Carolina">South Carolina</option>  
</select> 
 <input type="submit" value="Submit">
</form>


<form action="/byTeam.php?$teamName">
ACC<br>
 <select name="team">
  <option value="Clemson">Clemson</option>  
  <option value="NC State">NC State</option>  
  <option value="Boston College">Boston College</option>  
  <option value="Syracuse">Syracuse</option>  
  <option value="Florida State">Florida State</option>  
  <option value="Wake Forest">Wake Forest</option>  
  <option value="Louisville">Louisville</option>  
  <option value="Virginia Tech">Virginia Tech</option>  
  <option value="Miami">Miami</option>  
  <option value="North Carolina">North Carolina</option>  
  <option value="Virginia">Virginia</option>  
  <option value="Pittsburgh">Pittsburgh</option>  
  <option value="Duke">Duke</option>  
  <option value="Georgia Tech">Georgia Tech</option>  
</select> 
 <input type="submit" value="Submit">
</form>



<form action="/byTeam.php?$teamName">
Big 10<br>
 <select name="team">
  <option value="Ohio State">Ohio State</option>  
  <option value="Maryland">Maryland</option>  
  <option value="Michigan State">Michigan State</option>  
  <option value="Indiana">Indiana</option>  
  <option value="Penn State">Penn State</option>  
  <option value="Rutgers">Rutgers</option>  
  <option value="Wisconsin">Wisconsin</option>  
  <option value="Northwestern">Northwestern</option>  
  <option value="Purdue">Purdue</option>  
  <option value="Iowa">Iowa</option>  
  <option value="Minnesota">Minnesota</option>  
  <option value="Illinois">Illinois</option>  
  <option value="Nebraska">Nebraska</option>  
  <option value="Michigan">Michigan</option>  
</select> 
 <input type="submit" value="Submit">
</form>


<form action="/byTeam.php?$teamName">
Pac-12<br>
 <select name="team">
  <option value="Stanford">Stanford</option>  
  <option value="Washington">Washington</option>  
  <option value="Oregon">Oregon</option>  
  <option value="Washington State">Washington State</option>  
  <option value="California">California</option>  
  <option value="Oregon State">Oregon State</option>  
  <option value="Colorado">Colorado</option>  
  <option value="USC">USC</option>  
  <option value="Arizona">Arizona</option>  
  <option value="Arizona State">Arizona State</option>  
  <option value="UCLA">UCLA</option>  
  <option value="Utah">Utah</option>  
</select> 
 <input type="submit" value="Submit">
</form>
<br><br>

<form action="/byTeam.php?$teamName">
Teams whose mascot is Tigers: <br>
 <select name="team">  
<?php
// Connecting, selecting database
$dbconn = pg_connect("host=localhost dbname=cfb user=neville password=")
    or die('Could not connect: ' . pg_last_error());
$teamsResult = pg_query($dbconn, "SELECT team.school  FROM team WHERE team.mascot ILIKE 'TIGERS' ORDER BY team.school ASC ");
while ($row = pg_fetch_row($teamsResult)) {
$teamName = $row[0];
echo "<option value=\"$teamName\">$teamName</option>";
}
pg_free_result($result);
pg_close($dbconn);
?>
</select> 
 <input type="submit" value="Submit">
</form>







</body>

</html>
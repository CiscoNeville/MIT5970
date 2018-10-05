<HTML>
<head>
<title>Saturday Coach - MIT 5970 project - 2 point plays by team</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>


<h3> Results will open in a new page</h3>
<h3>Showing all the 2-point attempts and 1 point attempts with the clock and score situation specified</h3><br><br>

<form action="/byTime_Score.php?$timeMax?$timeMin?$leadMax?$leadMin">
Show me all the 2 point attempts when the team that scored had a lead of at least 
 <select name="leadMin">
  <option value="-10">-10</option>
  <option value="-9">-9</option>
  <option value="-8">-8</option> 
  <option value="-7">-7</option>
  <option value="-6">-6</option> 
  <option value="-5">-5</option>
  <option value="-4">-4</option> 
  <option value="-3">-3</option>
  <option value="-2">-2</option> 
  <option value="-1">-1</option> 
  <option value="0">0</option>
  <option value="1">1</option> 
  <option value="2">2</option>
  <option value="3">3</option> 
  <option value="4">4</option>
  <option value="5">5</option> 
  <option value="6">6</option>
  <option value="7">7</option> 
  <option value="8">8</option>
  <option value="9">9</option> 
  <option value="10">10</option> 
</select> 

 but not more than 
 <select name="leadMax">
  <option value="-10">-10</option>
  <option value="-9">-9</option>
  <option value="-8">-8</option> 
  <option value="-7">-7</option>
  <option value="-6">-6</option> 
  <option value="-5">-5</option>
  <option value="-4">-4</option> 
  <option value="-3">-3</option>
  <option value="-2">-2</option> 
  <option value="-1">-1</option> 
  <option value="0">0</option>
  <option value="1">1</option> 
  <option value="2">2</option>
  <option value="3">3</option> 
  <option value="4">4</option>
  <option value="5">5</option> 
  <option value="6">6</option>
  <option value="7">7</option> 
  <option value="8">8</option>
  <option value="9">9</option> 
  <option value="10">10</option> 
</select> 

<br>
 and the there was at least 

 <select name="timeMax">
  <option value="15">15</option>
  <option value="14">14</option>
  <option value="13">13</option>
  <option value="12">12</option>
  <option value="11">11</option>
  <option value="10">10</option>
  <option value="9">9</option>
  <option value="8">8</option>
  <option value="7">7</option>
  <option value="6">6</option>
  <option value="5">5</option>
  <option value="4">4</option>
  <option value="3">3</option>
  <option value="2">2</option>
  <option value="1">1</option>
</select> 

but not less than 

 <select name="timeMin">
  <option value="14">14</option>
  <option value="13">13</option>
  <option value="12">12</option>
  <option value="11">11</option>
  <option value="10">10</option>
  <option value="9">9</option>
  <option value="8">8</option>
  <option value="7">7</option>
  <option value="6">6</option>
  <option value="5">5</option>
  <option value="4">4</option>
  <option value="3">3</option>
  <option value="2">2</option>
  <option value="1">1</option>
  <option value="0">0</option>
</select>


minutes left on the clock.
<br><br><br>

 <input type="submit" value="Submit">
</form>

<br><br><br>







</body>

</html>
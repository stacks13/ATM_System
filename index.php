<?php

setcookie(setcookie("details", "", time() - 3600));

?>


<!DOCTYPE html>
<html>
<head >
	
<!--	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->


	<title>page 1</title>
	<link rel="stylesheet" type="text/css" href="css/page1.css">
	
</head>
<body >

	
	<p id="p1" align="center">
		<img id="logo" src="img/lg.png" align="center">
		<h1 id="enterc" align="center"> grey hat republic bank</h1>
	</p>
	<div>
		<div id="strip">
			<marquee behavior="scroll" direction="left" id="m1">Enter your card and press button </marquee>
		</div>

		<form class="box" align="center" id="fpage1" >
			<input type="button" name="Enter" value="ENTER" style="font-family: hacked" align="center" onclick="location.href='login.php'">
		</form>


	</div>

</body>
</html>
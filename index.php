<?php

setcookie("details", "", time() - 3600, "/");

?>


<!DOCTYPE html>
<html>
<head >
	
<!--	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->


	<title>page 1</title>
	<link rel="stylesheet" type="text/css" href="css/page1.css">
	
</head>
<body >

    <p align="right"><a href="admin_login.php">ADMIN</a></p>

	
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
            <input type="button" value="Feedback" style="font-family: hacked" align="center" onclick="location.href='feedback.php'">

		</form>


	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $.ajax({
            type: "GET",
            url: 'http://192.168.137.29:5000/readRfid',
            success: function (d) {
                // console.log(data);
                // d = JSON.parse(data);
                if(d.success == 0){

                    id = d.id;
                    idd = btoa(id);
                    var date = new Date();
                    date.setTime(date.getTime() + (100*1000));
                    var expires = "expires="+ date.toUTCString();
                    document.cookie = `details=${idd};expires=${expires}; path=/`;

                    location.href = "login.php";
                }
            }
        });


    </script>

</body>
</html>
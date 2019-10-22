<?php

    if(!isset($_COOKIE['details'])){

    }
    if(isset($_POST['tag'])){
        if($_POST['tag'] == 'withdraw'){
            header("Location: enter_amount.php");
        }else if ($_POST['tag'] == 'deposit'){
            header("Location: enter_amount.php");
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>page3</title>
	<link rel="stylesheet" type="text/css" href="css/page2.css">
</head>
<body >
	<form class="box3" action="actions.php" method="POST">
		<input type="submit" name="tag" value="withdraw">
		<input type="submit" name="tag" value="deposit">
		<input type="submit" name="tag" value="change pin">
		<input type="submit" name="tag" value="CHECK BALANCE">
		<input type="submit" name="tag" value="cancel">
		
	</form>
</body>
</html>
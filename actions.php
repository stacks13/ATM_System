<?php

    if(!isset($_COOKIE['details'])){
        header('HTTP/1.0 403 Forbidden');
        die();
    }else {
        $details = explode("|", base64_decode($_COOKIE['details']), 2);
        print_r($details);
        if (isset($_POST['tag'])) {
            $action = $_POST['tag'];
            setcookie("details", base64_encode("$details[0]|$details[1]|$action"), time() + 100, "/");
            if ($_POST['tag'] == 'Withdraw') {
                header("Location: enter_amount.php");
            } else if ($_POST['tag'] == 'Deposit') {
                header("Location: enter_amount.php");
            } else if($_POST['tag'] == 'Check Balance'){
                header("Location: balance.php");
            } else if($_POST['tag'] == 'Change PIN'){

            } else if($_POST['tag'] == 'cancel'){
                header("Location: index.php");
            }
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
	<form class="box3" method="post">
		<input type="submit" name="tag" value="Withdraw">
		<input type="submit" name="tag" value="Deposit">
		<input type="submit" name="tag" value="Change PIN">
		<input type="submit" name="tag" value="Check Balance">
		<input type="submit" name="tag" value="cancel">
		
	</form>
</body>
</html>
<!DOCTYPE html>

<?php
    include_once "include/DB.php";
    $card_details = -1;
    if(isset($_COOKIE['details'])){
        if(base64_decode($_COOKIE['details']))
            $card_no_present = true;
    }
    if(isset($_POST['submit'])) {

        $pin = $_POST['pin'];
        if(!isset($_POST['card'])){
            $card = base64_decode($_COOKIE['details']);
        }else{
            $card = $_POST['card'];
        }
        $result = $conn->query("SELECT * FROM card_details WHERE card_no=$card and pin=$pin");

        if($result && $result->num_rows == 1){
            // correct
            $data = $result->fetch_assoc();
            $account_no = $data['account_no'];
            $card_details = 1;
            setcookie("details", base64_encode("$card|$account_no"), time() + 300, "/");
            header("Location: actions.php");
        }else{
            // wrong
            $card_details = 0;
        }
    }
?>

<html>
<head>
	<title>Page 2</title>


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/page2.css">

</head>
<body>
	
	<form class="box" action="" method="POST">
		<img id="logo" src="img/lg.png" align="center">
        <?php if(!isset($card_no_present)) {
            ?><input type="number" name="card" placeholder="Card Number"><?php
        }
        ?>

		<input type="password" size="4" pattern="[0-9]{4}" name="pin" placeholder="PIN">

        <?php
            if($card_details == 0){
                echo "<p style='color: red'>Invalid Card or PIN</p>";
            }
        ?>

		<input type="submit" name="submit" placeholder="Enter">
		
	</form>
</body>
</html>
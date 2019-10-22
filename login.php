<!DOCTYPE html>

<?php
    $card_details = -1;
    if(isset($_POST['submit'])) {
        $card = $_POST['card'];
        $pin = $_POST['pin'];
        $conn = new mysqli("localhost", "root", "", "atm_system");
        $result = $conn->query("SELECT * FROM card_details WHERE card_no=$card and pin=$pin");

        if($result != false){
            // correct
            $data = $result->fetch_assoc();
            $account_no = $data['account_no'];
            $card_details = 1;
            setcookie("details", base64_encode("$card||$account_no"), time() + (300), "/");
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
		<input type="number" name="card" placeholder="Card Number">
		<input type="password" name="pin" placeholder="PIN">

        <?php
            if($card_details == 0){
                echo "<p style='color: red'>Incorrect password</p>";
            }
        ?>

		<input type="submit" name="submit" placeholder="Enter">
		
	</form>
</body>
</html>
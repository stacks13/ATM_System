<!DOCTYPE html>

<?php
    include_once "include/DB.php";
    $login = -1;
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM admins WHERE id=$id and password=$password");

        if($result && $result->num_rows == 1){
            $data = $result->fetch_assoc();
            setcookie("admin", base64_encode($data['id']), time() + 300, "/");
            header("Location: add_money.php");
        }else{
            // wrong
            $login = -2;
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

        <input type="number" name="id" placeholder="ID">

		<input type="password" size="4" pattern="[0-9]{4}" name="password" placeholder="Password">

        <?php
            if($login==-2){
                echo "<p style='color: red'>Invalid ID or PIN</p>";
            }
        ?>

		<input type="submit" name="submit" placeholder="Enter">
		
	</form>
</body>
</html>
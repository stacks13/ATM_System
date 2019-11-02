<!DOCTYPE html>

<?php
    include_once "include/DB.php";
    $card_details = -1;
    if(isset($_POST['submit'])) {
        $impression = $_POST['impression'];
        $look_feel = $_POST['look_feel'];
        $hear = $_POST['hear'];
        $recommend = $_POST['recommend'];
        $suggestion = $_POST['suggestion'];

        $query = "INSERT INTO feedback (impression, look_feel, hear, recommend, suggestion)
                    VALUES ('$impression',$look_feel,'$hear',$recommend,'$suggestion')";

        $stmt = $conn->prepare($query);
        if($stmt->execute()){
            $success = true;
        }else{
            $success = false;
        }

    }
?>

<html>
<head>
	<title>Page 2</title>


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/page2.css">
    <style>
        form{
            color: white;

        }
        input[type=range] {
            -webkit-appearance: none;
            margin: 18px 0;
            width: 100%;
        }
        input[type=range]:focus {
            outline: none;
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            animate: 0.2s;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            background: #3071a9;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }
        input[type=range]::-webkit-slider-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
            -webkit-appearance: none;
            margin-top: -14px;
        }
        input[type=range]:focus::-webkit-slider-runnable-track {
            background: #367ebd;
        }
        input[type=range]::-moz-range-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            animate: 0.2s;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            background: #3071a9;
            border-radius: 1.3px;
            border: 0.2px solid #010101;
        }
        input[type=range]::-moz-range-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
        }
        input[type=range]::-ms-track {
            width: 100%;
            height: 8.4px;
            cursor: pointer;
            animate: 0.2s;
            background: transparent;
            border-color: transparent;
            border-width: 16px 0;
            color: transparent;
        }
        input[type=range]::-ms-fill-lower {
            background: #2a6495;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        }
        input[type=range]::-ms-fill-upper {
            background: #3071a9;
            border: 0.2px solid #010101;
            border-radius: 2.6px;
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
        }
        input[type=range]::-ms-thumb {
            box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
            border: 1px solid #000000;
            height: 36px;
            width: 16px;
            border-radius: 3px;
            background: #ffffff;
            cursor: pointer;
        }
        input[type=range]:focus::-ms-fill-lower {
            background: #3071a9;
        }
        input[type=range]:focus::-ms-fill-upper {
            background: #367ebd;
        }
        .box2{
            width: 500px;
            padding: 40px;
            position: absolute;
            /*top: 50%;*/
            left: 50%;
            transform: translate(-50%, 0%);
            background: #191919;
            text-align: center;

            box-shadow:  5px 5px 5px 5px black;
            border-radius: 24px;
        }

        .box2 input[type = "text"],.box input[type = "password"]{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #ffffff;
            padding: 14px 10px;
            width: 200px;
            outline: none;
            color: grey;
            border-radius: 24px;
            transition: 0.25s;
        }

        .box2 input[type = "text"]:focus ,.box input[type = "password"]:focus{
            width: 250px;
            color: white;
        }

        .box2 input[type = "submit"]{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            font-family: hacked;
            src: url("fonts/HACKED.ttf");

            border: 2px solid #2ecc71;
            padding: 14px 10px;
            width: 100px;
            outline: none;
            color: #ffffff;
            border-radius: 24px;
            transition: 0.25s;
        }


        .box2 input[type = "submit"]:hover{
            background: #2ecc71;
        }

    </style>
</head>
<body>

		<form class="box2" action="feedback.php" method="POST">

            <?php if(isset($_POST['submit'])){
                if($success){
                    echo '<p>Feedback submitted</p>';
                }else{
                    echo '<p>Error occured</p>';
                }

            }else{?>
            <h1><u>FEEDBACK</u></h1>
            <h2>What was your first impression when you used this ATM?</h2>
            <input type="text" name="impression" placeholder="Your answer">
            <hr color="white">
            <h2>On a scale of 1 to 5, how much would you rate the look and feel of this system?</h2>
            <input type="range" name="look_feel" width="100px" style="width: 200px;" value="1" min="1" max="5">

            <hr color="white">
            <h2>How did you first hear about us?</h2>
            <input type="text" name="hear" placeholder="Your answer">

            <hr color="white">
            <h2>How likely are you to recommend is to a friend or a colleague?</h2>
            <input type="range" name="recommend" width="100px" style="width: 200px;" value="1" min="1" max="5">

            <hr color="white">
            <h2>Any suggestions to make this even better?</h2>
            <input type="text" name="suggestion" placeholder="Your answer">
            <br>
            <input type="submit" value="SUBMIT" name="submit">

            <?php }?>
        </form>

</body>
</html>
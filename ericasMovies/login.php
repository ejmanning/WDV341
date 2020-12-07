<?php

$msg = "";

//set up session
session_start();

$_SESSION['validUser']= "no";

	//if the page was reached by a submitted login form...
	if(isset($_POST["submit"])) {
		//set username and password from form
		$inUsername = $_POST["loginUser"];
		$inPassword = $_POST["loginPass"];

		//connect to database
		include "dbConnectHost.php";

		//set up SQL SELECT query for username and password that were entered into form
		$sql = "SELECT event_user_name, event_user_password FROM event_user WHERE event_user_name = '$inUsername' AND event_user_password = '$inPassword'";

		//run SELCT query
		$result = $conn->query($sql);

		//if the query retrieves 1 record...
		if($result) {
			if($result->rowCount() == 1) {
				//user is a valid user
				$_SESSION['validUser'] = "yes";
				$_SESSION['inUsername'] = $inUsername;
				//set confirmation msg
			}
			//else, if 0 or more than 1 records were found...
			else {
				//user is not a valid user
				$_SESSION['validUser'] = "no";
				//set error msg
				$msg = "There was a problem with your username or password. Please try again.";
			}
		}
	}
	//else, if the user needs to see the login form...
	else {

	}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erica's Movies</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div id ="container">
<h1><?php echo $msg?></h1><br>

<?php
//if the user is a valid user...
if($_SESSION['validUser'] == "yes")
{
	header('location: index.php');
}
//else, if not a valid user...
else
{
	//show login form

?>

<h2>Please Log In</h2>
<form method="post" name="loginForm" action="login.php">
<p>Username: <input type="text" name="loginUser" /></p>
<p>Password: <input type="password" name="loginPass" /></p>
<p><input type="submit" name ="submit" value="Login"></p>
</form>
</div>
<?php
}
?>



</body>
</html>

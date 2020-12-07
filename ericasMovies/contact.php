<?php
session_start();
if($_SESSION['validUser'] == "yes") {
  $msg = "Welcome back " . $_SESSION['inUsername'] . "!" ;
} else {
  $msg = "";
}

$fname = "";
$lname = "";
$email = "";
$message = "";

$validForm = false;

$fnameErrMsg = "";
$lnameErrMsg = "";
$emailErrMsg = "";
$messageErrMsg = "";

if(isset($_POST["submitForm"])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  function validateFName() {
  	global $fname, $validForm, $fnameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
  	$fnameErrMsg = "";								//Clear the error message.
  	if($fname == "") {
  		$validForm = false;					//Invalid name so the form is invalid
  		$fnameErrMsg = "First name is required";	//Error message for this validation
  	}
  }

  function validateLName() {
  	global $lname, $validForm, $lnameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
  	$lnameErrMsg = "";								//Clear the error message.
  	if($lname == "") {
  		$validForm = false;					//Invalid name so the form is invalid
  		$lnameErrMsg = "Last name is required";	//Error message for this validation
  	}
  }

  function validateEmail() {
  	global $email, $validForm, $emailErrMsg;
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if($email == "") {
      $validForm = false;					//Invalid name so the form is invalid
      $emailErrMsg = "Email is required";	//Error message for this validation
    }
  	//Make sure email is valid, and if not post error message and make form invalid
  	if(!filter_var($email, FILTER_VALIDATE_EMAIL)==true) {
  			$validForm = false;
  			$emailErrMsg = "Please enter a valid email address.";
  	}
  }

  function validateMessage() {
  	global $message, $validForm, $messageErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
  	$messageErrMsg = "";								//Clear the error message.
  	if($message == "") {
  		$validForm = false;					//Invalid name so the form is invalid
  		$messageErrMsg = "Message is required";	//Error message for this validation
  	}
  }

  $validForm = true;

  validateFName();
  validateLName();
  validateEmail();
  validateMessage();

  if($validForm) {
    $subject = "Erica's Movies";
    $emailBody = "Thank you for reaching out to us at Erica's Movies! \n\n We will be getting back to you shortly. \n\nThanks, \nErica";
    $emailMessage = wordwrap($emailBody, 70);
    $fromEmail = "contact@ericamanning.com";
    $headers = "From: " . $fromEmail;

    if(mail($email, $subject, $emailMessage, $headers)) {
      $confirmationMsg = "Form successfully submitted!";
    }
    else {
      $confirmationMsg = "There was an issue processing your form. Please try again.";
    }

  }
  else {
    $confirmationMsg = "Please fill out the entire form.";
  }
}
else {
  $confirmationMsg = "";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Erica!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/contact.css">
</head>
  <body>

    <header>
      <h1>Erica's Movies <img src = "images/popcornLogo.png"></h1>
      <nav class = "navbar navbar-expand-md bg-dark navbar-dark">

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
					<span class="navbar-toggler-icon"></span>
				 </button>

				<div class = "collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="displayMovies.php">Movie Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="movieForm.php">Add a Movie</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
          <?php
          if($_SESSION['validUser'] == "yes") {
          ?>
          <li class="nav-item"><a class="nav-link" href='logout.php'>Logout</a></li>
        <?php } else {
          ?>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <?php } ?>
        </ul>
			</div>
    </nav>
    </header>
    <?php echo "<center><h1 class='msg'>$msg</h1></center>";?>
    <main>

      <form method="post" action="" name = "contactForm" id="contactForm">
        <h1>Contact Erica!</h1>
        <div class = "fill">
          <?php echo "<h1>$confirmationMsg</h1>" ?>
          <label for="fname">First Name:</label><br>
          <td class="error"><?php echo "$fnameErrMsg"; ?></td><br>
          <input type = "text" id="fname" name="fname"></input><br><br>

          <label for="lname">Last Name:</label><br>
          <td class="error"><?php echo "$lnameErrMsg"; ?></td><br>
          <input type = "text" id="lname" name="lname"></input><br><br>

          <label for="email">Email:</label><br>
          <td class="error"><?php echo "$emailErrMsg"; ?></td><br>
          <input type = "email" id="email" name="email"></input><br><br>

          <label for="message">Message:</label><br>
          <td class="error"><?php echo "$messageErrMsg"; ?></td><br>
          <textarea id ="message" name="message" cols="30" rows="10"></textarea><br><br>

          <input type="reset" id="reset" name="reset" value="Reset"></input>
          <input type="submit" id="submitForm" name="submitForm" value="Submit"></input>
        </div>

      </form>


  </body>
</html>

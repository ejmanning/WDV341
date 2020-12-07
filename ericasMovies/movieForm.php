<?php
session_start();
if($_SESSION['validUser'] == "yes") {
$msg = "Welcome back " . $_SESSION['inUsername'] . "!" ;
$titleErrMsg = "";
$descriptionErrMsg = "";
$directorErrMsg = "";
$dateErrMsg = "";
$ratingErrMsg = "";

$validForm = false;

$inTitle = "";
$inDescription = "";
$inDirector = "";
$inDate = "";
$inRating = "";

//Valid form PLAN
/*
  Title - Required
  Description - Required
  Director - Required
  Date - Required (date format)
  Rating - Required
*/

if(isset($_POST["submitForm"])) {
	//The form has been submitted and needs to be processed
  $inTitle = $_POST['movieTitle'];
	$inDescription= $_POST['movieDescription'];
	$inDirector = $_POST['movieDirector'];
	$inDate = $_POST['movieDate'];
  $inRating = $_POST['movieRating'];

  function validateTitle() {
  	global $inTitle, $validForm, $titleErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
  	$titleErrMsg = "";								//Clear the error message.
  	if($inTitle == "") {
  		$validForm = false;					//Invalid name so the form is invalid
  		$titleErrMsg = "Title is required";	//Error message for this validation
  	}
  }

  function validateDescription() {
    global $inDescription, $validForm, $descriptionErrMsg;
    $descriptionErrMsg = "";
    if($inDescription == "") {
      $validForm = false;
      $descriptionErrMsg = "Description is required";
    }
  }

  function validateDirector() {
    global $inDirector, $validForm, $directorErrMsg;
    $directorErrMsg = "";
    if($inDirector == "") {
      $validForm = false;
      $directorErrMsg = "Director is required";
    }
  }

  function validateDate() {
		global $inDate, $validForm, $dateErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
		$dateErrMsg = "";								//Clear the error message.
		if($inDate== "") {
			$validForm = false;					//Invalid name so the form is invalid
			$dateErrMsg = "Date is required";	//Error message for this validation
		}
	}

  function validateRating() {
    global $inRating, $validForm, $ratingErrMsg;
    $ratingErrMsg = "";
    if(!isset($_POST['movieRating'])){
      $validForm = false;
		  $ratingErrMsg = "Rating is required";
	  }
  }

  $validForm = true;

  validateTitle();
  validateDescription();
  validateDirector();
  validateDate();
  validateRating();

  if($validForm) {
    $message = "You have submitted the form. Preparing to put into database.";

    try {

      require 'dbConnectHost.php';	//CONNECT to the database

      //Create the SQL command string
      $sql = "INSERT INTO wdv341_movies (";
      $sql .= "movie_title, ";
      $sql .= "movie_description, ";
      $sql .= "movie_director, ";
      $sql .= "movie_date, ";
      $sql .= "movie_rating ";
      $sql .= ") VALUES (:title, :description, :director, :theDate, :rating)";

      //PREPARE the SQL statement
      $stmt = $conn->prepare($sql);

      //BIND the values to the input parameters of the prepared statement
      $stmt->bindParam(':title', $inTitle);
      $stmt->bindParam(':description', $inDescription);
      $stmt->bindParam(':director', $inDirector);
      $stmt->bindParam(':theDate', $inDate);
      $stmt->bindParam(':rating', $inRating);

      //EXECUTE the prepared statement
      $stmt->execute();

      $message = "The Movie has been added.";
    }

    catch(PDOException $e)
    {
      $message = "There has been a problem. The system administrator has been contacted. Please try again later.";

      error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
      error_log(var_dump(debug_backtrace()));

      //Clean up any variables or connections that have been left hanging by this error.

      //header('Location: files/505_error_response_page.php');	//sends control to a User friendly page
    }

  }

  else
  {
    $message = "Please fill out the entire form.";
  }
}

else
{
  //The form has not seen by the user.  Display the form so
  //the user can enter their data.
  $message = "";
}


?>

<!DOCTYPE html>
<html lang="'en'" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movie Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href ="css/movieForm.css">
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
          <li class="nav-item"><a class="nav-link" href="#">Add a Movie</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
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
      <h1 class = "message"><?php echo $message; ?></h3>
        <form method="post" action="" name = "movieForm" id="movieForm">
            <h1 class = "fill">Add a Movie!</h1>
            <div class = "fill">
              <label for="movieTitle">Movie Title:</label><br>
              <td class="error"><?php echo "$titleErrMsg"; ?></td><br>
              <input type = "text" id="movieTitle" name="movieTitle"></input><br><br>
            </div>

            <div class = "fill">
              <label for="movieDescription">Movie Description:</label><br>
              <td class="error"><?php echo "$descriptionErrMsg"; ?></td><br>
              <textarea id ="movieDescription" name="movieDescription" cols="30" rows="10"></textarea><br><br>
            </div>

            <div class = "fill">
              <label for="movieDirector">Movie Director:</label><br>
              <td class="error"><?php echo "$directorErrMsg";  ?></td><br>
              <input type = "text" id="movieDirector" name="movieDirector"></input><br><br>
            </div>

            <div class = "fill">
              <label for="movieDate">Date It Came Out:</label><br>
              <td class="error"><?php echo "$dateErrMsg";  ?></td><br>
              <input type = "date" id="movieDate" name="movieDate"></input><br><br>
            </div>

            <div class = "rate">
              <label for="movieRating">Movie Rating:</label><br>
              <td class="error"><?php echo "$ratingErrMsg"; ?></td><br>
              <fieldset class="movieRating">
                <input type="radio" id="star5" name="movieRating" value="5 stars" /><label for="star5" title="Rocks!">5 stars</label>
                <input type="radio" id="star4" name="movieRating" value="4 stars" /><label for="star4" title="Pretty good">4 stars</label>
                <input type="radio" id="star3" name="movieRating" value="3 stars" /><label for="star3" title="Meh">3 stars</label>
                <input type="radio" id="star2" name="movieRating" value="2 stars" /><label for="star2" title="Kinda bad">2 stars</label>
                <input type="radio" id="star1" name="movieRating" value="1 stars" /><label for="star1" title="Sucks big time">1 star</label>
              </fieldset><br><br><br><br>
            </div>


            <input type="reset" id="reset" name="reset" value="Reset"></input>
            <input type="submit" id="submitForm" name="submitForm" value="Submit"></input>
          </form>
        </main>
  </body>
</html>
<?php
} else {
  echo  "<center><h1 style='background-color: white;'>You must be logged in to add a movie</h1></center>";
  include 'login.php';

}

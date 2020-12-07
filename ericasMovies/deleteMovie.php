<?php
session_start();

if($_SESSION['validUser'] == "yes") {
	$msg = "Welcome back " . $_SESSION['inUsername'] . "!" ;
//connect to database
include "dbConnectHost.php";

//retrieve record id (eventId) from $_GET;
$movieId = $_GET['id'];

//create SQL DELETE query with record id
$sql = "DELETE FROM wdv341_movies WHERE movie_id = $movieId";

//run DELETE query
$result = $conn->query($sql);

//if the query runs successfully print  message telling the event was deleted
if($result)
{
	$deleteMsg = "<h3> The movie associated with ID #".$movieId." has been deleted.</h3>";
}
else
{
	$deleteMsg = "<h3>Uh-oh, we weren't able to delete the movie associated with ID #".$movieId." Please try again.</h3>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete Movie</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/deleteMovie.css">
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
		<div id="container">
		<?php echo $deleteMsg; ?>
		<p><a href="displayMovies.php"><button>Return to the list of movies.</button></a></p>
		</div>
	</main>

</body>
</html>
<?php
}
else {
  $msg = "";
	echo "<center><h1 style='background-color: white;'>You must be logged in to delete a movie.</h1></center>";
  include 'login.php';
}
?>

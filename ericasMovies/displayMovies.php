<?php
session_start();

if($_SESSION['validUser'] == "yes") {
	$msg = "Welcome back " . $_SESSION['inUsername'] . "!" ;
}
else {
  $msg = "";
}

//set up session
	try {

		require "dbConnectHost.php";	//CONNECT to the database

		//Create the SQL command string
		$sql = "SELECT ";
		$sql .= "movie_id, ";
		$sql .= "movie_title, ";
		$sql .= "movie_description, ";
		$sql .= "movie_director, ";
		$sql .= "movie_date, ";
		$sql .= "movie_rating "; //Last column does NOT have a comma after it.
		$sql .= "FROM wdv341_movies ";

		//PREPARE the SQL statement
		$stmt = $conn->prepare($sql);

		//EXECUTE the prepared statement
		$stmt->execute();

		//Prepared statement result will deliver an associative array
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
	}

	catch(PDOException $e)
	{
		$message = "There has been a problem. The system administrator has been contacted. Please try again later.";

		error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
		error_log($e->getLine());
		error_log(var_dump(debug_backtrace()));

		//Clean up any variables or connections that have been left hanging by this error.

		//header('Location: files/505_error_response_page.php');	//sends control to a User friendly page
	}


?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Erica's Movies</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel ="stylesheet" href = "css/displayMovies.css">
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
				<li class="nav-item"><a class="nav-link" href="#">Movie Gallery</a></li>
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

	<div id="container">
	<center>

        <h1>Erica's Movies</h1>
				<div class = "movies">
	        <?php
					while($row=$stmt->fetch()) {
					?>

					<div class="movieBlock">

							<span class="movieTitle"><strong><?php echo $row['movie_title']; ?></strong></span><br><br>

							<span class="movieDescription">Description: <?php echo $row['movie_description'] ?></span><br><br>

							<span class="movieDirector">Director: <?php echo $row['movie_director'] ?></span><br><br>

	            <span class="movieDate">Release Date: <?php echo $row['movie_date']  ?></span><br><br>

	            <span class="movieRating">Erica's Rating: <?php echo $row['movie_rating']  ?></span><br><br>

							<?php
							if($_SESSION['validUser'] == "yes") {
							?>
	              <?php $movie_id=$row['movie_id'];	//put movie_id into a variable for further processing  ?>
	              <a href='updateMovie.php?id=<?php echo $movie_id; ?>'><button>Update</button></a>
	              <a href='deleteMovie.php?id=<?php echo $movie_id; ?>'><input type="button" value="Delete"></a>
							<?php }
							else {

							}
							?>

					</div><!-- Close Movie Block -->
					<br>
	        <?php
					}
					?>

			</center>
		</div>
</body>
</html>

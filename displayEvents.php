<?php

//set up session
session_start();
if($_SESSION['validUser'] == "yes") {

	try {

		require "dbConnectHost.php";	//CONNECT to the database

		//Create the SQL command string
		$sql = "SELECT ";
		$sql .= "event_id, ";
		$sql .= "event_name, ";
		$sql .= "event_description, ";
		$sql .= "event_presenter, ";
		$sql .= "event_date, ";
		$sql .= "event_time "; //Last column does NOT have a comma after it.
		$sql .= "FROM wdv341_events ";

		//$sql = "SELECT * FROM wdv341_events";

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
	<title>Presenting Information Technology</title>

	<style>

		.eventBlock {
			width: 20%;
			border: 1px solid black;
		}

		.row {
			border: 1px solid black;
			padding: 2%;
			background-color: white;
		}

		.eventID {
			font-weight: bold;
			background-color: white;
		}

		.eventTitle, .eventDescription, .eventPresenter, .eventDate, .eventTime, .col-1-2 {
			background-color: white;
		}

		body {
			background-color: #cce0ff;
		}

		#container {
			width: 75%;
			margin: 2% 10%;
			border: 2px solid black;
			text-align: center;
			background-color: #828aff;

		}

		textarea {

		}


		.projectTitle {
			text-decoration: underline;
		}

		header {
			background-color: #828aff;
			border: 2px solid white;
		}


	</style>
</head>

<body>
<header>
	<center>
    	<h2>Administrator Options</h2>
		<p><a href="eventsForm.php"><button>Add New Event</button></a></p>
		<p><a href="displayEvents.php"><button>See Events</button></a></p>
		<p><a href="logout.php"><button>Logout</button></a></p>
	</center>
</header>
<div id="container">
<center>




    <main>

        <h1>Display Available Events</h1>

        <?php
			while( $row=$stmt->fetch(PDO::FETCH_ASSOC) ) {
		?>

				<div class="eventBlock">
					<div class="row">
						<span class="eventID"><strong><?php echo $row['event_id']; ?></strong></span>
					</div>
					<div class="row">
						<span class="eventTitle"><strong><?php echo $row['event_name']; ?></strong></span>
					</div>

					<div class="row">
						<span class="eventDescription"><?php echo $row['event_description'] ?></span>
					</div>

					<div class="row">
						<span class="eventPresenter"><?php echo $row['event_presenter'] ?></span>
					</div>

					<div class="row">
                        <div class="col-1-2">
                        	<span class="eventDate">Dates: <?php echo $row['event_date']  ?></span>
                        </div>

												<div class="col-1-2">
                        	<span class="eventTime">Time: <?php echo $row['event_time']  ?></span>
                        </div>
					</div>
					<div class="row">
              <?php $event_id=$row['event_id'];	//put event_id into a variable for further processing  ?>
              <a href='updateEvent.php?id=<?php echo $event_id; ?>'><button>Update</button></a>
              <a href='deleteEvent.php?id=<?php echo $event_id; ?>'><input type="button" value="Delete"></a>
          </div>



				</div><!-- Close Event Block -->
				<br>

        <?php
			}
		?>

	</center>
	</main>

	<footer>
    	<p>Copyright &copy; <script> var d = new Date(); document.write (d.getFullYear());</script> All Rights Reserved</p>

	</footer>
	</div>




</div>
</body>
</html>
<?php
}
else {
	header('location: login.php');
}
?>

<?php

	try {

		require "../dbConnect.php";	//CONNECT to the database

		//Create the SQL command string
		$sql = "SELECT ";
		$sql .= "event_id, ";
		$sql .= "event_name, ";
		$sql .= "event_description, ";
		$sql .= "event_presenter, ";
		$sql .= "event_date, ";
		$sql .= "event_time "; //Last column does NOT have a comma after it.
		$sql .= "FROM wdv341_events ";
		$sql .= "WHERE event_id = 1";

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

	$row=$stmt->fetch(PDO::FETCH_ASSOC);


	$outputObjusing = new stdClass();

	$outputObjusing->eventName = $row['event_name'];
	$outputObjusing->eventDescription = $row['event_description'];
	$outputObjusing->eventPresenter = $row['event_presenter'];
	$outputObjusing->eventDate = $row['event_date'];
	$outputObjusing->eventTime = $row['event_time'];
//
	$returnObj = json_encode($outputObjusing);	//create the JSON object
//
	echo $returnObj;							//send results back to calling program
?>

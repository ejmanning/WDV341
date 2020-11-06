<?php
$nameErrMsg = "";
$descriptionErrMsg = "";
$presenterErrMsg = "";
$dateErrMsg = "";
$timeErrMsg = "";

$validForm = false;

$inName = "";
$inDescription = "";
$inPresenter = "";
$inDate = "";
$inTime = "";

/*	FORM VALIDATION PLAN

	FIELD NAME	VALIDATION TESTS & VALID RESPONSES
	inName		Required Field		May not be empty

	inDescription	Required Field		May not be empty

  inPresenter Required Field		May not be empty

	inDate		Required Field		May not be empty

	inTime	Required Field		May not be empty

*/

function validateName()
{
	global $inName, $validForm, $nameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
	$nameErrMsg = "";								//Clear the error message.
	if($inName=="")
	{
		$validForm = false;					//Invalid name so the form is invalid
		$nameErrMsg = "Name is required";	//Error message for this validation
	}
}



if(isset($_POST["submitForm"]))
{
	//The form has been submitted and needs to be processed
  $inName = $_POST['eventName'];
	$inDescription= $_POST['eventDescription'];
	$inPresenter = $_POST['eventPresenter'];
	$inDate = $_POST['eventDate'];
  $inTime = $_POST['eventTime'];


	function validateDescription()
	{
		global $inDescription, $validForm, $descriptionErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
		$descriptionErrMsg = "";								//Clear the error message.
		if($inDescription=="")
		{
			$validForm = false;					//Invalid name so the form is invalid
			$descriptionErrMsg = "Description is required";	//Error message for this validation
		}
	}

	function validatePresenter()
	{
		global $inPresenter, $validForm, $presenterErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
		$presenterErrMsg = "";								//Clear the error message.
		if($inPresenter=="")
		{
			$validForm = false;					//Invalid name so the form is invalid
			$presenterErrMsg = "Presenter is required";	//Error message for this validation
		}
	}

	function validateDate()
	{
		global $inDate, $validForm, $dateErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
		$dateErrMsg = "";								//Clear the error message.
		if($inDate=="")
		{
			$validForm = false;					//Invalid name so the form is invalid
			$dateErrMsg = "Date is required";	//Error message for this validation
		}
	}



	function validateTime()
	{
		global $inTime, $validForm, $timeErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
		$timeErrMsg = "";								//Clear the error message.
		if($inTime=="")
		{
			$validForm = false;					//Invalid name so the form is invalid
			$timeErrMsg = "Time is required";	//Error message for this validation
		}
	}

	$validForm = true;					//Set form flag/switch to true.  Assumes a valid form so far

		validateName();
		validateDescription();
		validatePresenter();
		validateDate();
    validateTime();

		if($validForm)
		{
			$message = "You have submitted the form. Preparing to put into database.";
			echo "<center><p>Event Name: $inName</p>";
			echo "<p>Event Description: $inDescription</p>";
			echo "<p>Event Presenter: $inPresenter</p>";
			echo "<p>Event Date: $inDate</p>";
			echo "<p>Event Time: $inTime</p></center>";

			try {

				require 'dbConnectHost.php';	//CONNECT to the database

				//Create the SQL command string
				$sql = "INSERT INTO wdv341_events (";
				$sql .= "event_name, ";
				$sql .= "event_description, ";
				$sql .= "event_presenter, ";
				$sql .= "event_date, ";
				$sql .= "event_time ";
				$sql .= ") VALUES (:name, :description, :presenter, :theDate, :theTime)";

				//PREPARE the SQL statement
				$stmt = $conn->prepare($sql);

				//BIND the values to the input parameters of the prepared statement
				$stmt->bindParam(':name', $inName);
				$stmt->bindParam(':description', $inDescription);
				$stmt->bindParam(':presenter', $inPresenter);
				$stmt->bindParam(':theDate', $inDate);
				$stmt->bindParam(':theTime', $inTime);

				//EXECUTE the prepared statement
				$stmt->execute();

				$message = "The Event has been added.";
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
		$message = "Please enter your information on the form.";
	}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Events Form</title>
    <style>

    .error {
      color: red;
    }

    form {
      border: 2px solid black;
      background-color: lightblue;
      text-align: center;
      width: 70%;
      margin-left: 15%;
      margin-right: 15%;
      padding: 1%;
    }
    label {
      display: block;
      font: 1rem 'Fira Sans', sans-serif;
    }

    input,
    label {
      margin: .4rem 0;
    }

    h3 {
      text-align: center;
    }

    </style>
  </head>
  <body>
    <h3><?php echo $message; ?></h3>
    <form method="post" action="" name = "eventsForm" id="eventsForm">
      <h1>Add an Event</h1>
      <label for="eventName">Event Name:</label>
      <td class="error"><?php echo "$nameErrMsg"; //place error message on form  ?></td><br>
      <input type = "text" id="eventName" name="eventName"></input>


      <label for="eventDescription">Event Description:</label>
      <td class="error"><?php echo "$descriptionErrMsg"; //place error message on form  ?></td><br>
      <textarea id ="eventDescription" name="eventDescription" cols="30" rows="10"></textarea>


      <label for="eventPresenter">Event Presenter:</label>
      <td class="error"><?php echo "$presenterErrMsg"; //place error message on form  ?></td><br>
      <input type = "text" id="eventPresenter" name="eventPresenter"></input>


      <label for="eventDate">Event Date:</label>
      <td class="error"><?php echo "$dateErrMsg"; //place error message on form  ?></td><br>
      <input type = "date" id="eventDate" name="eventDate"></input>


      <label for="eventTime">Event Time:</label>
      <td class="error"><?php echo "$timeErrMsg"; //place error message on form  ?></td><br>
      <input type = "time" id="eventTime" name="eventTime"></input>


      <input type="reset" id="reset" name="reset" value="Reset"></input>
      <input type="submit" id="submitForm" name="submitForm" value="Submit"></input>



  </body>
</html>

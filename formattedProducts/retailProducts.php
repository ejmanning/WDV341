<?php

	try {

		require "../dbConnectHost.php";	//CONNECT to the database

		//Create the SQL command string
		$sql = "SELECT ";
		$sql .= "product_id, ";
		$sql .= "product_name, ";
		$sql .= "product_description, ";
		$sql .= "product_price, ";
		$sql .= "product_image, ";
		$sql .= "product_inStock, ";
		$sql .= "product_status, ";
		$sql .= "product_update_date ";
		$sql .= "FROM wdv341_products
						ORDER BY product_name DESC";


	//$sql = "SELECT * FROM wdv341_products";

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


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>8-1 PHP Formatted Content</title>

	<style>
		body {
			text-align: center;
			background-color: lightblue;
		}

		.productBlock	{

			width:300px;
			background-color: aquamarine;
			border:thin solid black;
			padding: 1%;
			margin: 1% auto;
			text-align: center;

		}

		.productImage img {
			display:block;
			margin-left:auto;
			margin-right:auto;
			width:280px;
			height:280px;
		}

		.productName {
			text-align:center;
			font-size: large;
			font-weight: bold;
		}

		.productDesc {
			margin-left:10px;
			margin-right:10px;
			text-align:justify;
		}

		.productPrice {
			text-align: center;
			font-size:larger;
			color:blue;
		}

		.productStatus {
			text-align:center;
			font-weight:bolder;
			color:darkslategray;
		}

		.productInventory {
			text-align:center;
		}

		.productLowInventory {
			color:red;
		}

	</style>
</head>

<body>

	<h1>DMACC Electronics Store!</h1>
	<h2>Products for your Home and School Office</h2>


<?php
while( $row=$stmt->fetch(PDO::FETCH_ASSOC) ) {
?>

<div class="productBlock">
	<div class="productImage">
		<image src="productImages/<?php echo $row['product_image'] ?>">
	</div>

		<div class="row">
			<p class="productName"><?php echo $row['product_name'] ?></p>
		</div>

		<div class="row">
			<p class="productDesc"><?php echo $row['product_description'] ?></p>
		</div>

		<div class="row">
			<p class="productPrice">$<?php echo $row['product_price'] ?></p>
		</div>

		<div class="row">
			<p class="productStatus"><?php echo $row['product_status'] ?></p>
		</div>

		<?php
			if ($row['product_inStock']<10) {
				$displayClass = "productInventory productLowInventory";
			}
			else {
				$displayClass = "productInventory";
			}
		?>

		<div class="row">
			<p class="<?php echo $displayClass ?>"><?php echo $row['product_inStock'] ?> in stock!</p>
		</div>
</div>

<?php
}
?>



<!--	<div class="productBlock">
		<div class="productImage">
			<image src="productImages/monitor.jpg">
		</div>
		<p class="productName">New 27" Monitor</p>
		<p class="productDesc">This is a new monitor. Available for desktop uses. A good choice for home office and school work.</p>
		<p class="productPrice">$159.00</p>
		<p class="productStatus">New Item!</p>
		<p class="productInventory"># In Stock!</p>
	</div> -->

</body>
</html>

<?php

	$productObj = new stdClass();

	$productObj->productName = "PHP Textbook";
	$productObj->productPrice = "$129.95";
	$productObj->productPageCount = 327;
	$productObj->productISBN = "13-1234435690";

	echo $productObj;
//
	$returnObj = json_encode($productObj);	//create the JSON object
//
	echo $returnObj;							//send results back to calling program
?>

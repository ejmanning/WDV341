<!DOCTYPE html>
<head>
</head>
<body>

<script>
<?php $yourName = 'Erica'; ?>
let yourName = "<?php echo $yourName ?>";

<?php $number1 = '5'; ?>
let number1 = "<?php echo $number1 ?>";

<?php $number2 = '7'; ?>
let number2 = "<?php echo $number2 ?>";

<?php $total = $number1 + $number2; ?>
let total = "<?php echo $total ?>";

</script>

<?php echo "<h1>$yourName</h1>"; ?>

<h2><?php echo "$yourName" ?></h2>

<p><?php echo "Number 1 = $number1" ?></p>

<p><?php echo "Number 2 = $number2" ?></p>

<p><?php echo "Total = $total" ?></p>
</body>
</html>

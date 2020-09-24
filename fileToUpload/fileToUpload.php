<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload File</title>
    <style>
      body {
        background-color: #4096ff;

      }

      form {
        border-top: thin solid black;
        border-bottom: thin solid black;
        padding: 2%;
        background-color: lightblue;
      }
    </style>

  </head>
  <body>
<br>
<br>
<center>
<h1>
<form action="upload.php" method="post" enctype="multipart/form-data">
  Select image to upload: <br><br>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
</h1>
</center>
</body>
</html>

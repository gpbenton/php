<html>
<head>
</head>
<body>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    if ($password !== getenv("calagg_password")) {
      die("Invalid password");
    }
    $listfile = fopen("urllist.txt", "w") or die ("Couldn't open file for writing");
    $urllist = $_POST["urllist"];
    $urlarray = explode("\n", $urllist, 10);
    $numurls = count($urlarray);
    for ($i = 0; $i < $numurls; $i++) {
      $url = validate_url($urlarray[$i]);
      fwrite($listfile, $url . "\n");
    }
    fclose($listfile);
  }

  function validate_url($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

   
<h1> Calendar Aggregator </h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <textarea name=urllist rows=10 cols=50>
<?php
      $listfile = fopen("urllist.txt", "r");
      if ($listfile) {
        while (!feof($listfile)) {
          echo fgets($listfile);
        }
        fclose ($listfile);
      }
    ?>

  </textarea>

  <input type="password" name="password">
  <input type="submit" name="Save" value="Save">
</form>
</body>
</html>

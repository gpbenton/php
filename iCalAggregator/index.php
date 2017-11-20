<html>
<head>
<style>
#centered { 
   margin: auto;
   text-align: center;
   padding: 10px;
}

#footer {
   font-size: small;
}

</style>
</head>
<body>

<?php
  $urlfilename = "/data/iCalAggregator/urllist.txt";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    if ($password !== getenv("calagg_password")) {
      die("Invalid password");
    }
    $listfile = fopen($urlfilename, "w") or die ("Couldn't open file for writing");
    $urllist = $_POST["urllist"];
    $urlarray = explode("\n", $urllist, 10);
    $numurls = count($urlarray);
    for ($i = 0; $i < $numurls; $i++) {
      $url = validate_url($urlarray[$i]);
      fwrite($listfile, $url . "\n");
    }
    fclose($listfile);
    # Remove existing file to clear cache
    if (file_exists("icalmerge.ics")) {
      unlink("icalmerge.ics")
    }
  }

  function validate_url($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

   
<h1 id="centered"> Calendar Aggregator </h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div id="centered">
  <textarea name=urllist rows=10 cols=110>
<?php
    if (file_exists($urlfilename)) {
      $listfile = fopen($urlfilename, "r");
      if ($listfile) {
        while (!feof($listfile)) {
          echo fgets($listfile);
        }
        fclose ($listfile);
      }
    } else {
      echo "insert calendar urls here";
    }
    ?>

  </textarea>
</div>

<div id="centered">
  <span>Password: </span><input type="password" name="password">
</div>
<div id="centered">
  <input type="submit" name="Save" value="Save">
</div>
</form>

<div id="centered">
  Get merged calendar from <a href="./merge.php">here</a>
</div>

<div id="footer">
<a href="https://github.com/gpbenton/php/tree/master/iCalAggregator">Calendar Aggregator</a> is powered by <a href="https://github.com/iCalcreator/iCalcreator">iCalcreator</a>
</div>
</body>
</html>

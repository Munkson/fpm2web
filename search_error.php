<?php
if(is_null($showpw)) {
    $showpw=FALSE;
}
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
<title>FPM2 export file search</title>
<script>

      function initForm() {
          if (document.forms['fpm2_search'].elements['keyid'].value === "") {
              document.forms['fpm2_search'].elements['keyid'].value = '<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>';
          }
          return true;
      }
      function clearForm() {
          if (document.forms['fpm2_search'].elements['keyid'].value === "<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>") {
              document.forms['fpm2_search'].elements['keyid'].value = '';
          }
          return true;
      }
</script>
</head>
<body onload="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
  <h2 class="software_function">FPM2 export file search</h2>
<?php include 'menu.php'?>
  <div class="page">
  <p>Search the encrypted password data records</p>
<?php if (count($error_messages) > 0) { ?>
      <ul class="error">
<?php foreach ($error_messages as $m) { ?>
      <li><?= $m; ?></li>
<?php } ?>
      </ul>
<?php } ?>
      <div class="inputform">
      <form action="search.php" method="POST" id="fpm2_search">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
<!--      <dt><label for="pass">Key ID passphrase:</label></dt><dd><input type="password" name="pass" ></dd> -->
      <dt><label for="keyword">Search keyword: </label></dt><dd><input type="text" name="keyword" size="40" value="" ></dd>
          <dt>Show Password?: </dt><dd><label for="showpw.yes">Yes </label><input type="radio" name="showpw" value="1" id="showpw.yes" <?php
                               if($showpw) { echo 'checked="checked"';}
?>>
<label for="showpw.no">No </label> <input type="radio" name="showpw" value="0" id="showpw.no" <?php
                               if(!$showpw) { echo 'checked="checked"';}
?>></dd>
      </dl>
      <input type="submit" name="submit" value="Search" >
      </form>
      </div>
        <?php include 'footer.php'?>
         </div>
</body>
</html>

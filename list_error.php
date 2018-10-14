<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
      <title>FPM2 Web : FPM2 export file viewer</title>
<script>

      function initForm() {
          if (document.forms['fpm2_list'].elements['keyid'].value === "") {
              document.forms['fpm2_list'].elements['keyid'].value = '<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>';
          }
          return true;
      }
      function clearForm() {
          if (document.forms['fpm2_list'].elements['keyid'].value === "<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>") {
              document.forms['fpm2_list'].elements['keyid'].value = '';
          }
          return true;
      }
</script>
</head>
<body onload="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
  <h2 class="software_function">FPM2 export file viewer</h2>
<?php include 'menu.php'?>
<hr>
   <div class="page">
  <p>List the encrypted password data records</p>
<?php if (count($error_messages) > 0) { ?>
      <ul class="error">
<?php foreach ($error_messages as $m) { ?>
      <li><?= $m; ?></li>
<?php } ?>
      </ul>
<?php } ?>
      <hr>
      <div class="inputform">
      <form action="list.php" method="POST" id="fpm2_list">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
<!--      <dt><label for="pass">Key ID passphrase:</label></dt><dd><input type="password" name="pass" ></dd> -->
      </dl>
      <input type="submit" name="submit" value="List" >
      </form>
      </div>
        <?php include 'footer.php'?>
   </div>
</body>
</html>

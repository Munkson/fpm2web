<?php
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
    <title>FPM2 Web : exported entry udpate form</title>
<script>

      function initForm() {
          if (document.forms['update_form'].elements['keyid'].value === "") {
              document.forms['update_form'].elements['keyid'].value = '<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>';
          }
          return true;
      }
      function clearForm() {
          if (document.forms['update_form'].elements['keyid'].value === "<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>") {
              document.forms['update_form'].elements['keyid'].value = '';
          }
          return true;
      }
</script>
</head>
<body onLoad="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
          <h2 class="software_function">FPM2 exported file edit &gt; confirmation of delete entry</h2>
<?php include 'menu.php'?>
  <div class="page">
<?php if (count($error_messages) > 0) { ?>
      <ul class="error">
<?php foreach ($error_messages as $m) { ?>
      <li><?= $m; ?></li>
<?php } ?>
      </ul>
<?php } ?>
      <div class="inputform">
      <form action="delete_entry.php" method="POST" id="update_form">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
      <dt><label for="title">Title: </label></dt><dd><?= htmlspecialchars($pwentry['title'], ENT_HTML5, "UTF-8") ?></dd>
      <dt><label for="category">Category: </label></dt><dd><?= htmlspecialchars($pwentry['category'], ENT_HTML5, 'UTF-8') ?></dd>
          <dt><label for="user">User: </label></dt><dd><?= htmlspecialchars($pwentry['user'], ENT_HTML5, "UTF-8") ?>&nbsp;</dd>
          <dt><label for="note">Note: </label></dt><dd><textarea id ="note" name="note" cols="60" rows="4" readonly><?= htmlspecialchars($pwentry['note'], ENT_HTML5, 'UTF-8') ?></textarea></dd>
          
      </dl>
<input type="hidden" name="title" value="<?= htmlspecialchars($pwentry['title'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="user" value="<?= htmlspecialchars($pwentry['user'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="n" value="<?= htmlspecialchars($n, ENT_HTML5, 'UTF-8') ?>" >
  <input type="submit" name="submit" value="Reallly Delete" >
      </form>
      </div>
<hr>

      <div class="inputform">
      <form action="open_element.php" method="POST" id="update_form">
<input type="hidden" name="title" value="<?= htmlspecialchars($pwentry['title'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="user" value="<?= htmlspecialchars($pwentry['user'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="n" value="<?= htmlspecialchars($n, ENT_HTML5, 'UTF-8') ?>" >

<input type="hidden" name="keyid" value="<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>">
      <input type="submit" name="submit" value="Back to Edit" >
      </form>

    </div>
        <?php include 'footer.php'?>
         </div>
</body>
</html>

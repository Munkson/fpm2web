<?php
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
    <title>FPM2 Web : exported entry udpate form</title>
<script>

      function switchPwVisiblity() {
          if (document.forms['showpwform'].elements['showpw'].checked) {
              document.forms['update_form'].elements['password'].setAttribute('type', 'text');
              document.forms['update_form'].elements['retypepassword'].setAttribute('type', 'text');
          } else {
              document.forms['update_form'].elements['password'].setAttribute('type', 'password');
              document.forms['update_form'].elements['retypepassword'].setAttribute('type', 'password');
          }
          return true;
      }

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
      function clearPwForm(pw) {
          var l = document.forms['update_form'].elements[pw].value.length;
          var pwentryswitch = document.forms['update_form'].elements[pw.concat('_entry')];
          if (pwentryswitch.value == '0') {
              if (l == <?= htmlspecialchars(strlen($pwentry['password']), ENT_HTML5, "UTF-8") ?>) {
                  document.forms['update_form'].elements[pw].value = '';
                  pwentryswitch.value = '1';
              }
          }
          return true;
          }
</script>
</head>
<body onLoad="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
          <h2 class="software_function">FPM2 exported file edit &gt; update entry</h2>
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
      <form action="update_entry.php" method="POST" id="update_form">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
      <dt><label for="title">Title: </label></dt><dd><input type="text" name="title" size="40" value="<?= htmlspecialchars($pwentry['title'], ENT_HTML5, "UTF-8") ?>" ></dd>
      <dt><label for="category">Category: </label></dt><dd><input type="text" name="category" size="40" value="<?= htmlspecialchars($pwentry['category'], ENT_HTML5, 'UTF-8') ?>" ></dd>
          <dt><label for="user">User: </label></dt><dd><input id="user" name="user" type="text" size="50" value="<?= htmlspecialchars($pwentry['user'], ENT_HTML5, "UTF-8") ?>"> &nbsp;</dd>
          <dt><label for="password">Password: </label></dt><dd><input id="password" name="password" type="password" size="40" value="<?= htmlspecialchars($pwentry['password'], ENT_HTML5, 'UTF-8') ?>" onfocus="clearPwForm('password');"></dd>
          <dt><label for="retypepassword">Retype password: </label></dt><dd><input id="retypepassword" name="retypepassword" type="password" size="40" value="<?= htmlspecialchars($pwentry['password'], ENT_HTML5, 'UTF-8') ?>" onfocus="clearPwForm('retypepassword');"></dd>
          <dt><label for="note">Note: </label></dt><dd><textarea id ="note" name="note" cols="60" rows="4"><?= htmlspecialchars($pwentry['note'], ENT_HTML5, 'UTF-8') ?></textarea></dd>
          
      </dl>
<input type="hidden" name="password_entry" value="0" >
<input type="hidden" name="retypepassword_entry" value="0" >
<input type="hidden" name="n" value="<?= htmlspecialchars($n, ENT_HTML5, 'UTF-8') ?>" >
      <input type="reset" name="reset" value="reset the change" >
      <input type="submit" name="submit" value="Update" >
      </form>

      <form id="showpwform">
    <label for="passwd">Show Password?: </label><input type="checkbox" name="showpw" value="1" id="showpw" onchange="switchPwVisiblity();">
      </form>

    </div>
        <?php include 'footer.php'?>
         </div>
</body>
</html>

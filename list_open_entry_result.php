<?php
$appTitle = 'FPM2 password entry detail ';

if(is_null($showpw)) {
    $showpw=FALSE;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" >
  <link rel="stylesheet" type="text/css" href="fpm2web.css">
  <title><?= htmlspecialchars($appTitle, ENT_HTML5, "UTF-8") ?></title>
<script>

      function switchPwVisiblity() {
          if (document.forms['showpwform'].elements['showpw'].checked) {
              document.forms['passwdform'].elements['passwd'].setAttribute('type', 'text');
          } else {
              document.forms['passwdform'].elements['passwd'].setAttribute('type', 'password');
          }
          return true;
      }
      function initForm() {
          if (document.forms['fpm2_update'].elements['keyid'].value === "") {
              document.forms['fpm2_update'].elements['keyid'].value = '<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>';
          }
          return true;
      }
      function clearForm() {
          if (document.forms['fpm2_update'].elements['keyid'].value === "<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>") {
              document.forms['fpm2_update'].elements['keyid'].value = '';
          }
          return true;
      }
</script>
</head>
<body onload="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
  <h2 class="software_function"><?= htmlspecialchars($appTitle, ENT_HTML5, "UTF-8") ?></h2>
<?php include 'menu.php'?>
<?php if (strlen($error_message) > 0) {
    ?>
    <div class="error"><?= $error_message; ?></div>
<?php }?>
    
    <div class="itemlist">
    <p>The password management record entries: </p>
	<dl>
	<dt>Title</dt>
	<dd><?= htmlspecialchars($a['title'], ENT_HTML5, 'UTF-8') ?></dd>
	<dt>Category</dt>
	<dd><?= htmlspecialchars($a['category'], ENT_HTML5, 'UTF-8') ?></dd>
	<dt>User</dt>
	<dd><input id="user" type="text" value="<?= htmlspecialchars($a['user'], ENT_HTML5, "UTF-8") ?>"> &nbsp;</dd>
	<dt>Password</dt>
          <dd><form id="passwdform"><input id = "passwd" name="passwd" type="password" value="<?= htmlspecialchars($a['password'], ENT_HTML5, "UTF-8") ?>"></form></dd>
	<dt>Note</dt>
	<dd><?= htmlspecialchars($a['note'], ENT_HTML5, "UTF-8") ?>&nbsp;</dd>
	</dl>

      <form id="showpwform">
    <label for="passwd">Show Password?: </label><input type="checkbox" name="showpw" value="1" id="showpw" onchange="switchPwVisiblity();">
      </form>

    </div>


      <div class="inputform">
      <form action="open_update_entry_form.php" method="POST" id="fpm2_update">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
      </dl>
    <input type="hidden" name="title" value="<?= htmlspecialchars($a['title'], ENT_HTML5, 'UTF-8') ?>" >
    <input type="hidden" name="category" value="<?= htmlspecialchars($a['category'], ENT_HTML5, 'UTF-8') ?>" >
    <input type="hidden" name="user" value="<?= htmlspecialchars($a['user'], ENT_HTML5, 'UTF-8') ?>" >
    <input type="hidden" name="n" value="<?= htmlspecialchars($n, ENT_HTML5, 'UTF-8') ?>" >
      <input type="submit" name="submit" value="Edit" >
      </form>
      </div>

<hr>
          <h3 class="delete_guide">If you want to delete this entry:</h3><span> push the "Delete" Button.</span>
     <div class="inputform">
      <form action="open_delete_entry_form.php" method="POST" id="update_form">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>" onfocus="clearForm();"></dd>
      </dl>
      <input type="submit" name="submit" value="Delete" >
<input type="hidden" name="title" value="<?= htmlspecialchars($a['title'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="user" value="<?= htmlspecialchars($a['user'], ENT_HTML5, "UTF-8") ?>" >
<input type="hidden" name="n" value="<?= htmlspecialchars($n, ENT_HTML5, 'UTF-8') ?>" >
      </form>
    </div>

          
<?php include 'footer.php'?>
 </body>
</html>

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
          }i
          return true;
      }
</script>
</head>
<body>
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
	<dd><?= htmlspecialchars($a['title'], ENT_HTML5, "UTF-8") ?></dd>
	<dt>Category</dt>
	<dd><?= htmlspecialchars($a['category'], ENT_HTML5, "UTF-8") ?></dd>
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

</body>
</html>

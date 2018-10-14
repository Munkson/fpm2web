<?php
$appTitle = 'FPM2 search result ';

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
	<table>
	<tr>
	<th>Title</th>
	<th>Category</th>
	<th>User</th>
	<th>Password</th>
	<th>Note</th>
	</tr>
<?php
    foreach ($entries as $a) { ?>
	<tr>
	<td><?= htmlspecialchars($a['title'], ENT_HTML5, "UTF-8") ?></td>
	<td><?= htmlspecialchars($a['category'], ENT_HTML5, "UTF-8") ?></td>
	<td><?= htmlspecialchars($a['user'], ENT_HTML5, "UTF-8") ?></td>
<?php if($showpw) {?>
     <td><?= htmlspecialchars($a['password'], ENT_HTML5, "UTF-8") ?></td>
<?php } else {?>
     <td>************</td>
<?php } ?>
	<td><?= htmlspecialchars($a['note'], ENT_HTML5, "UTF-8") ?></td>
	</tr>
<?php } ?>
	</table>
</div>

      <div class="inputform">
      <form action="search.php" method="POST" id="fpm2_search">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8"); ?>" onfocus="clearForm();"></dd>
          <dt></dt><dd>After the form submission, please type your passphrase when your GnuPG key agent brings you up a passphrase entry form.</dd>
<!--      <dt><label for="pass">Key ID passphrase:</label></dt><dd><input type="password" name="pass" ></dd> -->
      </dl>
      <dt><label for="keyword">Search keyword: </label></dt><dd><input type="text" name="keyword" size="40" value="<?= htmlspecialchars($keyword, ENT_HTML5, "UTF-8"); ?>" ></dd>
          <dt><label for="keyword">Show Password?: </label></dt><dd><label for="showpw.yes">Yes </label><input type="radio" name="showpw" value="1" id="showpw.yes" <?php
                               if($showpw) { echo 'checked="checked"';}
?>>
<label for="showpw.no">No </label> <input type="radio" name="showpw" value="0" id="showpw.no" <?php
                               if(!$showpw) { echo 'checked="checked"';}
?>></dd>
      <input type="submit" name="submit" value="Search" >
      </form>
      </div>

</body>
</html>

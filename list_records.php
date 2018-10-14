<?php
$appTitle = 'FPM2 password entry list';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" >
  <link rel="stylesheet" type="text/css" href="fpm2web.css">
  <title><?= htmlspecialchars($appTitle, ENT_HTML5, "UTF-8") ?></title>
</head>
<body>
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
  <h2 class="software_function"><?= htmlspecialchars($appTitle, ENT_HTML5, "UTF-8") ?></h1>
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
	</tr>
<?php
    $imax = count($entries['title']);
    for ($i = 0; $i < $imax; $i++) { ?>
	<tr>
	<td><?= htmlspecialchars($entries['title'][$i], ENT_HTML5, "UTF-8") ?></td>
	<td><?= htmlspecialchars($entries['category'][$i], ENT_HTML5, "UTF-8") ?></td>
	<td><?= htmlspecialchars($entries['user'][$i], ENT_HTML5, "UTF-8") ?></td>
	<td><form action="open_element.php" method="POST">
        <input type="hidden" name="keyid" value="<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>">
        <input type="hidden" name="n" value="<?= htmlspecialchars($i, ENT_HTML5, "UTF-8") ?>">
        <input type="submit" name="submit" value="open">
        </form></td>
	</tr>
<?php } ?>
	</table>
</div>
<hr>
<div>&copy; 2018 Hiroshi Kubo, all rights reserved. </div>
                <div>License : This software is distributed under the GNU General Public License version 3 or later.</div></body>
</html>

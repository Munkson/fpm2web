<?php
$appTitle = 'FPM2 export file upload -- success';
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
  <h2 class="software_function"><?= htmlspecialchars($appTitle, ENT_HTML5, "UTF-8") ?></h2>
<?php include 'menu.php'?>
<?php if (strlen($error_message) > 0) {
    ?>
    <div class="error"><?= $error_message; ?></div>
<?php }?>
    
    <div class="itemlist">
    <p>The uploaded password management record entries: </p>
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
	</tr>
<?php } ?>
	</table>
</div>
</body>
</html>

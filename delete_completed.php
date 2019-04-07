<?php
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
    <title>FPM2 Web : exported entry delete result</title>
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
          <h2 class="software_function">FPM2 exported file edit &gt; deleted</h2>
<?php include 'menu.php'?>
  <div class="page">
<?php if (count($error_messages) > 0) { ?>
      <ul class="error">
<?php foreach ($error_messages as $m) { ?>
      <li><?= $m; ?></li>
<?php } ?>
      </ul>
<?php } ?>
           <p>The number <?= htmlspecialchars($n, ENT_HTML5, "UTF-8") ?>  entry is deleted.</p>
        <?php include 'footer.php'?>
         </div>
</body>
</html>

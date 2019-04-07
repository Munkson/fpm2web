<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" >
<link rel="stylesheet" type="text/css" href="fpm2web.css">
<title>FPM2 export file upload</title>
<script>

      function initForm() {
          if (document.forms['fpm2_load'].elements['keyid'].value === "") {
              document.forms['fpm2_load'].elements['keyid'].value = '<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>';
          }
          return true;
      }
      function clearForm() {
          if (document.forms['fpm2_load'].elements['keyid'].value === "<?= htmlspecialchars($gnupgid, ENT_HTML5, "UTF-8") ?>") {
              document.forms['fpm2_load'].elements['keyid'].value = '';
          }
          return true;
      }
</script>
</head>
<body onload="initForm();">
  <img src="head_banner.jpg" alt="A bridge from FPM2 to PHP&amp;GnuPG" ><br>
  <h1 class="software_name">FPM2 Web</h1>
  <h2 class="software_function">FPM2 export file upload</h2>
<?php include 'menu.php'?>
           <hr>
  <div class="page">
 <p>You can upload the password database export file from fpm2 password manager. </p><p>The uploaded file will be encrypted with the GnuPG public key specified in the form by key ID .</p>
<?php if (strlen($error_message) > 0) { ?>
      <h2 class="error">
      <p><?= $error_message; ?></p>      
      </h2>
<?php } ?>
           <hr>
      <div class="inputform">
      <form action="load.php" enctype="multipart/form-data" method="POST" id="fpm2_load">
      <dl>
      <dt><label for="keyid">GnuPG Key ID:</label></dt><dd><input type="text" name="keyid" size="40" value="" onfocus="clearForm();"><br /></dd>
<!--      <dt><label for="filename">Destination file name:</label></dt><dd><input type="text" name="filename" ><br /></dd> -->
      <dt><label for="fpm2_file">Specify the file you want to upload :</label></dt><dd><input type="file" name="fpm2_file" ></dd>
      </dl>
      <input type="submit" name="submit" value="Upload" >
      </form>
      </div>
        <?php include 'footer.php'?>
   </div>
</body>
</html>

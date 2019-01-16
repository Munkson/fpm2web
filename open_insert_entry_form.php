<?php
/**
 * Copyright 2018 Hiroshi Kubo <gdevmjc@gmail.com>, all rights reserved.
 */
/* Section: class loading */
include 'fpm2web_config.php';

/* Section: variable setting */
/* error meessage to be displayed in error page. */
$error_message = '';
$error_messages = array();

/* Section: request information retrieval */
/* HTTP requst method */
$method = $_SERVER['REQUEST_METHOD'];

/* Section 2: basic dipatcher */


if ($method == 'HEAD') {
    goto end;
}
if ($method == 'GET') {
    /* error page without error message displays initial upload form. */
    $gnupgid="Your GnuPG ID for encryption";
    goto error;
}
if ($method != 'POST') {
    goto fatal;
}

/* Section 3: POST variable  validation */
$gnupgid=$_POST['keyid'];
$n = $_POST['n'];
$title =  '';
$user =  '';
$category =  '';


$pwentry = null;
try {
    if (strlen($gnupgid) < 4) {
        $error_message = 'Key ID length is too short.';
        goto error;
    }
} catch (Exception $e) {
    array_push($error_messages,$e->getMessage());
}

/** The end of the logic. */
/** View dispatchin section. */
include 'insert_entry_form.php';
goto end;
?>
<?php
error:
include 'list_error.php';
goto end;

fatal:
include 'fatal.php';

end:
;
?>

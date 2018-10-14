<?php
/**
 * Copyright 2018 Hiroshi Kubo <kurigadani.hiroshi@gmail.com>, all rights reserved.
 */
/* Section: class loading */
include 'class/Fpm2Xml.php';
include 'class/GnuPGFileEndec.php';
include 'fpm2web_config.php';
$backupfname = $fname . $backupext;

/* Section: variable setting */
/* error meessage to be displayed in error page. */
$error_message = '';

/* Section: request information retrieval */
/* HTTP requst method */
$method = $_SERVER['REQUEST_METHOD'];
/* The uploaded file size */
$filesize = 0;

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

/* Section 2: POST variable  validation */
$gnupgid=$_POST['keyid'];
$filesize = $_FILES['fpm2_file']['size'];


if ($filesize == 0)  {
    $error_message ='The uploaded file is empty.';
    goto error;
}
$entries;
try {
    /** parse the XML for result display. */
    $fpm2Xml = new Fpm2Xml();
    /** entries will be used afterward. 
        'title', 'category', 'user' member is supposed to be stored. 
    */
    $entries = $fpm2Xml->parseXml($_FILES['fpm2_file']['tmp_name']);

    if (count($entries) < 3 || count($entries['title']) < 1) {
        $error_message = 'File content is vague. No password entry.';
        goto error;
    }

    
    if (strlen($gnupgid) < 4) {
        $error_message = 'Key ID length is too short. The file is not stored.';
    } else {
        $gpgf = new GnuPGFileEndec();
        $e = $gpgf->fileEnc($_FILES['fpm2_file']['tmp_name'], $gnupgid);
        # echo $e;
        $writefilepath = $datapath . '/' . $fname;
        $backupfilepath = $datapath . '/' . $backupfname;
        # echo $writefilepath;
        $gpgf->fileWrite($writefilepath, $backupfilepath, $e);
        
    }
} catch (Exception $e) {
    $error_messsage =  $e->getMessage(); 
}

/** The end of the logic. */
/** View dispatchin section. */

include 'loaded.php';
goto end;
?>
<?php
error:
include 'load_error.php';
goto end;

fatal:
include 'fatal.php';

end:
;
?>

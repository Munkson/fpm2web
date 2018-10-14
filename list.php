<?php
/**
 * Copyright 2018 Hiroshi Kubo <kurigadani.hiroshi@gmail.com>, all rights reserved.
 */
/* Section: class loading */
include 'class/Fpm2Xml.php';
include 'class/GnuPGFileEndec.php';
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

/* Section 2: POST variable  validation */
$gnupgid=$_POST['keyid'];
$passphrase = $_POST['pass'];

$entries = NULL;
try {
    if (strlen($gnupgid) < 4) {
        $error_message = 'Key ID length is too short.';
        goto error;
    } else {
        $readfilepath = $datapath . '/' . $fname;
        $gpgf = new GnuPGFileEndec();
        $r = $gpgf->fileRead($readfilepath, $gnupgid, $passphrase);
        if ( is_string($r[0]) ) {
            /** parse the XML for result display. */
            $fpm2Xml = new Fpm2Xml();
            /** entries will be used afterward. 
                'title', 'category', 'user' member is supposed to be stored. 
            */
            $entries = $fpm2Xml->parseXmlString($r[0]);
            
            if (count($entries) < 3 || count($entries['title']) < 1) {
                array_push($error_messages,'File content is vague. No password entry.');
                goto error;
            }
        } else {
            if (!$r[1]) {
                array_push($error_messages,'The file does not exist.');
            } else {
                if (!$r[0]) {
                    array_push($error_messages,'Empty.');
                } else {
                
                    if (!$r[5]) {
                        array_push($error_messages,'Decryption failed. ');
                    }
                    if (!$r[4]) {
                        array_push($error_messages,'Invalid passphrase. ');
                    }
                    if (!$r[3]) {
                        array_push($error_messages,'Key ID must be wrong. ');
                    }
                    if (!$r[2]) {
                        array_push($error_messages,'Invalid passphrase');
                    }
                }
            }
            goto error;
        }

    }
} catch (Exception $e) {
    array_push($error_messages,$e->getMessage());
}

/** The end of the logic. */
/** View dispatchin section. */

include 'list_records.php';
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

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

/* Section 3: POST variable  validation */
$gnupgid=$_POST['keyid'];
$keyword = $_POST['keyword'];
$n = $_POST['n'];
$title =  $_POST['title'];
$user =  $_POST['user'];

$showpw= $_POST['showpw'];
if (is_null($showpw) ||  $showpw == '0' ) {
    $showpw = FALSE;
} else {
    $showpw = TRUE;
}
    

$entries = array();
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
            $tmpentries = $fpm2Xml->parseXmlGetNthStringWithP($r[0], $n);
            
            if (count($tmpentries) < 1 ) {
                array_push($error_messages,'File content is vague. No password entry.');
                goto error;
            } else {
            }

            $entries = array();
            /** Check if the nth entry has the same title and user id */
            $mismatch_warning = TRUE;
            foreach ($tmpentries as $a) {
                $pos = strripos($a['title'], $title);
                if (is_int($pos) && $pos >= 0 && strlen($a['title']) == strlen($title)) {
                    $pos = strripos($a['user'], $user);
                    if (is_int($pos) && $pos >= 0 && strlen($a['user']) == strlen($user)) {
                        $mismatch_warning = FALSE;
                    }
                }
                array_push($entries, $a);
            }
            if ($mismatch_warning) {
                array_push($error_messages,'The entry must be changed.');
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

include 'list_open_entry_result.php';
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

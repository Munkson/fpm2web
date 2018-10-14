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
$title =  $_POST['title'];
$user =  $_POST['user'];
$category =  $_POST['category'];
$note =  $_POST['note'];
$password =  $_POST['password'];
$retypepassword =  $_POST['retypepassword'];

/* Array to convey the user input to the file update method.*/
$ni = array();
$ni['title'] = $title;
$ni['category'] = $category;
$ni['user'] = $user;
$ni['password'] = $password;
$ni['note'] = $note;

$pwentry = null;
try {
    if (strlen($gnupgid) < 4) {
        $error_message = 'Key ID length is too short.';
        goto error;
    } else {
        if ( $retypepassword != $password ) {
            array_push($error_messages,'The two password fields do not match.');
        
            $readfilepath = $datapath . '/' . $fname;
            $gpgf = new GnuPGFileEndec();
            $r = $gpgf->fileRead($readfilepath, $gnupgid, $passphrase);
            if ( is_string($r[0]) ) {
                $fpm2Xml = new Fpm2Xml();
                $tmpentries = $fpm2Xml->parseXmlGetNthStringWithP($r[0], $n);
                
                if (count($tmpentries) > 0 ) {
                    
                /** Check if the nth entry has the same title and user id */
                    $mismatch_warning = TRUE;
                    foreach ($tmpentries as $a) {
                        #                echo $title, strlen($title);
                        #                echo $a['title'], strlen($a['title']);
                        $pos = strripos($a['title'], $title);
                        if (is_int($pos) && $pos >= 0 && strlen($a['title']) == strlen($title)) {
                            $pos = strripos($a['user'], $user);
                            if (is_int($pos) && $pos >= 0 && strlen($a['user']) == strlen($user)) {
                                $mismatch_warning = FALSE;
                                $pwentry = $a;
                                break;
                            }
                        }
                    }
                    #            echo $pwentry['title'];
                    if ($mismatch_warning) {
                        array_push($error_messages,'The entry must be changed.');
                    }
                } else {
                    array_push($error_messages,'File content is vague. No password entry.');
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
            }
            goto error;
        } else {

            $readfilepath = $datapath . '/' . $fname;
            $gpgf = new GnuPGFileEndec();
            $r = $gpgf->fileRead($readfilepath, $gnupgid, $passphrase);
            if ( is_string($r[0]) ) {
                /** parse the XML for result display. */
                /** entries will be used afterward. 
                    'title', 'category', 'user' member is supposed to be stored. 
                */
                $fpm2Xml = new Fpm2Xml();
                $outstr = $fpm2Xml->parseXmlReplaceNthPasswordItemByArg($r[0], $n, $ni);

                if (is_string($outstr) && strlen($outstr) > 0) {
                    $e = $gpgf->stringEnc($outstr, $gnupgid);
                    $writefilepath = $datapath . '/' . $fname;
                    $backupfilepath = $datapath . '/' . $backupfname;
                    # echo $writefilepath;
                    $gpgf->fileWrite($writefilepath, $backupfilepath, $e);
                } else {
                    array_push($error_messages,'XML update is somehow failed.');
                }
                
                
                $r = $gpgf->fileRead($readfilepath, $gnupgid, $passphrase);
                #            if ( is_string($r[0]) ) {
                if ( is_string($outstr) ) {
                    #               $tmpentries = $fpm2Xml->parseXmlGetNthStringWithP($r[0], $n);
                    $tmpentries = $fpm2Xml->parseXmlGetNthStringWithP($outstr, $n);
                    
                    if (count($tmpentries) < 1 ) {
                        array_push($error_messages,'File content is vague. No password entry.');
                        goto error;
                    }
                    
                    /** Check if the nth entry has the same title and user id */
                    $mismatch_warning = TRUE;
                    foreach ($tmpentries as $a) {
                        #                   echo $title, strlen($title);
                        #                   echo $a['title'], strlen($a['title']);
                        $pos = strripos($a['title'], $title);
                        if (is_int($pos) && $pos >= 0 && strlen($a['title']) == strlen($title)) {
                            $pos = strripos($a['user'], $user);
                            if (is_int($pos) && $pos >= 0 && strlen($a['user']) == strlen($user)) {
                                $mismatch_warning = FALSE;
                                $pwentry = $a;
                                break;
                            }
                        }
                    }
                    if ($mismatch_warning) {
                        array_push($error_messages,'The entry has not changed as entered.');
                    }
                }
                #            echo $pwentry['title'];
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
    }
} catch (Exception $e) {
    array_push($error_messages,$e->getMessage());
}

/** The end of the logic. */
/** View dispatchin section. */
include 'update_entry_form.php';
goto end;
?>
<?php
error:
include 'update_entry_form.php';
goto end;

fatal:
include 'fatal.php';

end:
;
?>

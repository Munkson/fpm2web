<?php
/**
 * Copyright 2018 Hiroshi Kubo <gdevmjc@gmail.com>, all rights reserved.
 * GnuPG File Encryption- Decryption
 */
class GnuPGFileEndec
{
    /**
     * @param  string $filepath the file path to the file.
     * @param  string $keyid GnuPG key id
     * @return return the encrypted file data
     */
    
    public function stringEnc($fcontent, $keyid) {
        $gpg = new gnupg();
        $c = NULL;
        try {
            $gpg->addencryptkey($keyid);
            $c = $gpg->encrypt($fcontent);
        } catch (Exception $e) {
            throw $e;
        }
        return $c;
    }
    /**
     * @param  string $filepath the file path to the file.
     * @param  string $keyid GnuPG key id
     * @return return the encrypted file data
     */
    
    public function fileEnc($filepath, $keyid) {
        $gpg = new gnupg();
        $c = NULL;
        try {
            $fcontent = file_get_contents($filepath);
            $gpg->addencryptkey($keyid);
            $c = $gpg->encrypt($fcontent);
        } catch (Exception $e) {
            throw $e;
        }
        return $c;
    }

    /**
     * @param  string $filepath the file path to the file.
     * @param  string $backupfilepath the backup file path
     * @param  string $fcontent
     * @return return result code
     */
    
    public function fileWrite($filepath, $backupfilepath, $fcontent) {
        $res = NULL;
        /** get the current umask for back up . */
        $umaskback = umask();
        try {
            if (file_exists($filepath) ) {
                error_log('File already exists. Replacing.' , 0);
                $stat = stat($filepath);
                if ( $stat['size'] > 0 ) {
                    error_log( "renaming $filepath -> $backupfilepath", 0);
                    rename($filepath, $backupfilepath);
                }
            }
            error_log('Opening the file ' . $filepath, 0);
            
            umask(066);
            $res = fopen($filepath, "w");
            if ($res != NULL) {
                if ( flock($res, LOCK_EX) ) {
                    $ss = $fcontent;
                    $flen = strlen($fcontent);
                    do {
                        /* write every 1Kbytes, making chances to terminate the process */
                        $wb = fwrite($res, $ss, 1024);
                        if ($wb == $flen) { break; }
                        $ss = substr($ss, $wb);
                        $flen = strlen($ss);
                        # echo "Progress... $wb, $flen";
                    } while ($flen > 0);
                    fflush($res);
                    fclose($res);
                    $res = NULL;
                }
            } else {
                error_log('File open error: ' . $filepath, 0);
            }
            umask($umaskback);
            
        } catch (Exception $e) {
            throw $e;
        } finally {
            /* rewind the umask status */
            umask($umaskback);
            /** release the file descriptor. */
            if ($res != NULL) {
                fclose($res);
                $res = NULL;
            }
        }
        return 0;
    }
        
    /**
     * @param  string $filepath the file path to the file.
     * @param  string $backupfilepath the backup file path
     * @param  string $fcontent
     * @return return result for each process.
     * $result[0] : decrypted file content
     * $result[1] : file existance flag
     * $result[2] : file readability flag
     * $result[3] : gnupg keyid validation  flag
     * $result[4] : gnupg passpharase validation  flag
     * $result[5] : gnupg decrypt flag
     */
    
    public function fileRead($filepath, $keyid, $passphrase) {
        $result = array();
        array_push($result, NULL, NULL, NULL, NULL, NULL, NULL);
        try {
            if (file_exists($filepath) ) {
                error_log( 'File exists : ' . $filepath, 0);
                $result[1] = TRUE;
                $fcontent = file_get_contents($filepath);
                if (!$fcontent) {
                    $result[2] = FALSE;
                } else {
                    $result[2] = TRUE;
                }
                /* keyid validation */
                $gpg = new gnupg();
                $c = NULL;
                $keyinfo = $gpg->keyinfo($keyid);
                if (!$keyinfo) {
                    $result[3] = FALSE;
                } else {
                    error_log( $keyid . $c, 0);
                    $result[3] = TRUE;
                }
                
                if ($result[2] && $result[3]) {
                    /* private key preparation with passphrase */
                    error_log('length of passphrase: ' . strlen($passphrase), 0);
                    $r = $gpg->adddecryptkey($keyid, $passphrase);
                    if (!$r) {
                        error_log( 'adding key failed.', 0);
                        $result[4] = FALSE;
                    } else {
                        error_log( 'adding key sccessful.', 0);
                        $result[4] = TRUE;
                        $c = $gpg->decrypt($fcontent);
                        if (!$c) {
                            error_log( 'decrypt failed.', 0);
                            $result[5] = FALSE;
                        } else {
                            error_log( 'decrypt sccessful.', 0);
                            $result[5] = TRUE;
                            $result[0] = $c;
                        }
                    }
                }
                
            } else {
                error_log('No file ' . $filepath, 0);
                $result[1] = FALSE;
            }
        } catch (Exception $e) {
            throw $e;
        }
        error_log('returning', 0);
        return $result;
    }
}

?>

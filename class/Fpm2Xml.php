<?php
/**
 * Copyright 2018 Hiroshi Kubo <kurigadani.hiroshi@gmail.com>, all rights reserved.
 * FPM2 XML export file handler
 */
class Fpm2Xml
{
    /**
     * input: the file path to the FPM export file.
     * It is supposed to align to the XML schema of fpm2 application.
     *    'title', 'category', 'user' member is supposed to be stored. 

     */
    
    public function parseXml($filepath) {
        $domdoc = new DOMDocument();
        $tab = NULL;
        try {
            $fcontent = file_get_contents($filepath);
            $tab = $this->parseXmlString($fcontent);
        } catch (Exception $e) {
            throw $e;
        }

        return $tab;
    }


    /**
     * @param $fcontent The string, supposed to be XML.
     */

    public function parseXmlString($fcontent) {
        $domdoc = new DOMDocument();
        try {
            $domdoc->loadXML($fcontent);
            $i = 0;
            $itemlist = $domdoc->getElementsByTagName('PasswordItem');
            
            $numRow = array();
            $titleRow = array();
            $categoryRow = array();
            $userRow = array();
            $noteRow = array();
            
            foreach ($itemlist as $item) {
                $titleNode = $item->getElementsByTagName('title');
                $categoryNode = $item->getElementsByTagName('category');
                $userNode = $item->getElementsByTagName('user');
                $noteNode = $item->getElementsByTagName('notes');
                #	 echo $titleNode[0]->nodeValue, PHP_EOL;
                $titleRow[$i] = $titleNode[0]->nodeValue;
                #	 echo $categoryNode[0]->nodeValue, PHP_EOL;
                $categoryRow[$i] = $categoryNode[0]->nodeValue;
                #	 echo $userNode[0]->nodeValue, PHP_EOL;
                $userRow[$i] = $userNode[0]->nodeValue;
                $noteRow[$i] = $noteNode[0]->nodeValue;
                $i+=1;
            }
        } catch (Exception $e) {
            throw $e;
        }

        $tab = array();
        $tab['title'] = $titleRow;
        $tab['category'] = $categoryRow;
        $tab['user'] = $userRow;
        $tab['note'] = $noteRow;
        return $tab;
    }

    /**
     * @param $fcontent The string, supposed to be XML.
     */

    public function parseXmlStringWithP($fcontent) {
        $domdoc = new DOMDocument();
        $tab = NULL;
        try {
            $domdoc->loadXML($fcontent);
            $i = 0;
            $itemlist = $domdoc->getElementsByTagName('PasswordItem');
            
            $tab = array();
            foreach ($itemlist as $item) {
                $titleNode = $item->getElementsByTagName('title');
                $categoryNode = $item->getElementsByTagName('category');
                $userNode = $item->getElementsByTagName('user');
                $noteNode = $item->getElementsByTagName('notes');
                $pwNode = $item->getElementsByTagName('password');
                #	 echo $titleNode[0]->nodeValue, PHP_EOL;
                $e = array();
                $e['title'] = $titleNode[0]->nodeValue;
                #	 echo $categoryNode[0]->nodeValue, PHP_EOL;
                $e['category'] = $categoryNode[0]->nodeValue;
                #	 echo $userNode[0]->nodeValue, PHP_EOL;
                $e['user'] = $userNode[0]->nodeValue;
                if ( is_object($noteNode[0]) ) {
                    $e['note'] = $noteNode[0]->nodeValue;
                } else {
                    $e['note'] = '';
                }
                $e['password'] = $pwNode[0]->nodeValue;
                array_push($tab, $e);
                $i+=1;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $tab;
    }

    /**
     * @param $fontent
     * @param $n the position of the list of the XML password entries
     * @return array of passwordItem entries.
     */
    
    public function parseXmlGetNthStringWithP($fcontent, $n) {
        $domdoc = new DOMDocument();
        $tab = NULL;
        try {
            
            $domdoc->loadXML($fcontent);
            $tab = array();

            $itemlist = $domdoc->getElementsByTagName('PasswordItem');

            $i = 0;
            foreach ($itemlist as $item) {
                $titleNode = $item->getElementsByTagName('title');
                $categoryNode = $item->getElementsByTagName('category');
                $userNode = $item->getElementsByTagName('user');
                $noteNode = $item->getElementsByTagName('notes');
                $pwNode = $item->getElementsByTagName('password');

                $e = array();
                $e['title'] = $titleNode->item(0)->nodeValue;
                $e['category'] = $categoryNode->item(0)->nodeValue;
                $e['user'] = $userNode->item(0)->nodeValue;
                if ( is_object($noteNode->item(0)) ) {
                    $e['note'] = $noteNode->item(0)->nodeValue;
                } else {
                    $e['note'] = '';
                }
                $e['password'] = $pwNode->item(0)->nodeValue;
                if ($n == $i) { /** Only get the Nth item */
                    array_push($tab, $e);
                }
                $i+=1;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $tab;
    }



    /**
     * @param $fontent
     * @param $n the position of the list of the XML password entries
     * @param $ni the new value for the n th passwordItem
     * @return replaced string of XML
     */
    
    public function parseXmlReplaceNthPasswordItemByArg($fcontent, $n, $ni) {
        $domdoc = new DOMDocument();
        $tab = NULL;
        try {
            
            $domdoc->loadXML($fcontent);
            $tab = array();

            $itemlist = $domdoc->getElementsByTagName('PasswordItem');

            $i = 0;
            foreach ($itemlist as $item) {
                if ($n == $i) { /** Only change the Nth item */
                    $titleNode = $item->getElementsByTagName('title');
                    $categoryNode = $item->getElementsByTagName('category');
                    $userNode = $item->getElementsByTagName('user');
                    $noteNode = $item->getElementsByTagName('notes');
                    $passwordNode = $item->getElementsByTagName('password');

                    $newTitleElement = $domdoc->createElement('title',  $ni['title']);
                    $newCategoryElement = $domdoc->createElement('category',  $ni['category']);
                    $newUserElement = $domdoc->createElement('user',  $ni['user']);
                    $newPasswordElement = $domdoc->createElement('password',  $ni['password']);
                    $newNoteElement = $domdoc->createElement('notes',  $ni['note']);

                    $oldTitleNode = $titleNode->item(0);
                    $item->replaceChild($newTitleElement, $oldTitleNode);
                    $oldCategoryNode = $categoryNode->item(0);
                    $item->replaceChild($newCategoryElement, $oldCategoryNode);
                    $oldUserNode = $userNode->item(0);
                    $item->replaceChild($newUserElement, $oldUserNode);
                    $oldPasswordNode = $passwordNode->item(0);
                    $item->replaceChild($newPasswordElement, $oldPasswordNode);
                    $oldNoteNode = $noteNode->item(0);
                    if (is_object($oldNoteNode)) {
                        $item->replaceChild($newNoteElement, $oldNoteNode);
                    } else {
                        $item->appendChild($newNoteElement);
                    }
                }
                $i+=1;
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $domdoc->saveXML();
    }
}

?>

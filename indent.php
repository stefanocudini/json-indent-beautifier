<?php

/*
if(isset($_POST['urljson']) and !empty($_POST['urljson'])):

    $url = filter_var($_POST['urljson'], FILTER_VALIDATE_URL);

    if($url)
        $j = indent(file_get_contents($url));
    else
    {
        $j = 'json url error';
        $access = '['.$_SERVER['REMOTE_ADDR'].'] "'.$_POST['urljson'].'" "'.$_SERVER['HTTP_REFERER'].'"'."\n";
        error_log('json-indent-beautifier error urljson:'.$access);
    }
else*/
if(isset($_POST['json'])):
    $code = trim(strip_tags($_POST['json']));
    echo indent(stripslashes($code));
    exit(0);
endif;

function indent($json) {

    $result    = '';
    $pos       = 0;
    $strLen    = strlen($json);
    $indentStr = '  ';
    $newLine   = "\n";

    for($i = 0; $i <= $strLen; $i++) {

        // Grab the next character in the string
        $char = substr($json, $i, 1);

        // If this character is the end of an element,
        // output a new line and indent the next line
        if($char == '}' || $char == ']') {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line
        if ($char == ',' || $char == '{' || $char == '[') {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
    }

    return $result;
}
?>
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

	$code = strip_tags($_POST['json']);
	$j = indent(stripslashes($code));

endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Json Beautifier</title>
<style>
	@import url('style.css');
</style>
<script type="text/javascript">
    function selectText(containerid) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
        }
    }
</script>
</head>

<body>

<div id="wrapper">

  <h1><img src="logo.png" /> <b>{</b>JSON Indent Beautifier<b>}</b></h1>

  <form id="form1" name="form1" method="post" action="">
  <label>&nbsp;JSON ugly:<br />
  <textarea id="rawjson" name="json" cols="100" rows="5"></textarea>
  </label>
  <br />
  <!--label>&nbsp;URL: <input id="urljson" name="urljson" type="text" size="81" /></label><br /-->
  <br />
  <div id="buttons">
    <input type="submit" name="submit" value="Indent" />
    <?php if(isset($j)): ?>    
    <input type="button" onclick="javascript:selectText('indented')" value="Copy" />
    <?php endif; ?>
  </div>
  </form>
  <?php if(isset($j)): ?>
  <pre id="indented"><?php echo $j; ?></pre>
  <?php endif; ?>
</div>

	<div id="copy"><a href="http://labs.easyblog.it/">Labs</a> &bull; <a rel="author" href="http://labs.easyblog.it/stefano-cudini/">Stefano Cudini</a></div>

<script src="/labs-common.js"></script>
</body>
</html>
<?php

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

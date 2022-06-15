<?php

require_once('ascii_art.php');
$x = new AsciiArt('example.jpg');
$color = $x->getBackgroundColor()->getHexValue();
?>
<html>
<head>
<title>ASCII art demo</title>
</head>
<body bgcolor="#<?php echo $color; ?>">
<?php
$x->setFontSize(6);
$x->show(range("a", "z"), 0.25, true, true);
?>
</body>
</html>


<p> &copy; PHP Motors. All rights reserved. 
<br>
All images used are believed to be in "Fair Use". Please notify the author if any are not and they will be removed.
<br>
<?php
$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$pfile = $break[count($break) - 1];
//echo $pfile;
echo "Last Updated: " .date("d F , Y",filemtime($pfile));
?>
</p>
<html>
<?php
include "medea.php";
$n = 2;
$fr = $data[$n]['fr'];
$lat = $data[$n]['lat'];
for ($i = 0; $i < count($fr); $i++) {
   echo sprintf("%d : %s \t ..... %s <br>\n", $i, $lat[$i], $fr[$data[$n]['ord'][$i]]);
}
?>
</html>

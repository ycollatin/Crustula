<?php
echo '<p class="juste">Optime. nunc tibi gratum erit ';
$debut = True;
foreach ($suivants as $s) {
   if (!$debut) echo ' uel ';
   echo '<a href="'.$s.'.php">HIC</a>';
   $debut = False;
}
echo  ' ire.</p>';
?>   

<?php
/*
###############################################################################
#
#    This file is part of CRVSTVLA
#
#    CRVSTVLA is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    CRVSTVLA is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with CRVSTVLA; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
###############################################################################
*/
$incl = $_POST['incl'];
if ($incl) 
    include "../texte.php";
else {
$titre = "EXCERPTA EX AVCTORIBVS";
include "../css.inc";
echo "<html>\n<head>\n<title>CRVSTVLA - $titre </title>\n</head>\n";
echo "<body>\n";
echo "<p class=\"titre\">$titre</p>\n";
echo "<form method=\"post\">\n";
$d = dir("./");
while($entry=$d->read()) {
   $breue = str_replace(".php","",$entry);
   if (preg_match("/.*php$/", $entry) && $entry != 'index.php')
      echo '<input type="submit" name="incl" value="'.$breue.'"><br>'."\n";
}
$d->close();
?>
</form>
</body>
</html>
<?php } ?>


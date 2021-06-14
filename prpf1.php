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

// A aimait B
// A et B étaient <dans un lieu public>
// C est arrivée
// C était (grand|fort|beau)
// C <a fait un exploit>
// C <a fait un (autre) exploit>
// B regardait C
// A <a fait d'autres exploits>
// B est reparti avec (B|C)

*/
define ('br', "<br/>\n");

class Statio
{
   var $sujet;
   var $verbe;
   function gall();
   function lat();
   function paquet();
}

class Narratio 
{
    var $stationes;
    var $statN;

    function Narratio ()
    {
        $this->$statN = 0;
    }

    function porro ()
    {
        $this->statN++;
    }
    function paquet()
    {

    }
}
?>
<html>
<head>
<title>CRVSTVLA - Praesens et perfectvm tempvs</title>
<?php 
   include "css.inc";
   include "meta.inc.php";   
?>
</head>
<body>
<p class="titre">
    PRÉSENT ET PASSÉ COMPOSÉ
</p>



<p class="redi"><a href='./'>reditus</a> <a href="gpl.html" target="gpl">Licentia GPL</a></p>
</body>
</html>

/**
 * This file may be considered as a part of  CRVSTVLA
 *  under the same licensing terms (see below)
 * Design and implementation : Christian Delfosse, Nov 2013
 *   email is chdelfosse at gmail dot com
 */
/**
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
$(document).ready(
  function(){
    const testedPHPs=new Array("amo.php","gal.php","adv4.php","sov.php","sov1.php","sov2.php","sov3.php","sov4.php");
    var inProduction=true; // avoid testing against the above ; url override is possible, see below
    $.urlParam = function(name){// based on http://www.jquery4u.com/snippets/url-parameters-jquery/
      var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
      if (results==null)
	return null;
	else
	  return results[1] || 0;
	};
    $.getScript("js/wrapper_02.js",// get auxiliary functions, adapted from http://stackoverflow.com/questions/950087/how-to-include-a-javascript-file-in-another-javascript-file
      function() {// and wait till included (callback)
	dataForPosting=new Object();
	if (decodeURIComponent($.urlParam('test')))
	  inProduction=false;// this is how inProduction can be changed
	baseURL=decodeURIComponent($.urlParam('url'));
	if (baseURL=='null')
	  baseURL="amo.php";
	if (baseURL.slice(-3)!='php')
	  baseURL+=".php";
	if ( inProduction && ($.inArray(baseURL, testedPHPs)==-1))// relocate to the file : we do not know how to handle it yet
	  document.location.href=baseURL;
	$.get(baseURL,handleIt);// call the .php file desired and provide a way to record data (see recordData.php)
	return;
      });
  });
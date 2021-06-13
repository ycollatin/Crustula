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

/*
 * these are the auxiliary functions
 * they are place here so that the main structure is visible in wrapper_01.js
 *
 * the necessary variables are also placed here
 */
    var priorSent="",respSent,statusSent, questSent, prevSolution="", progressSoFar, meta,numeri,schema;
    var respS, respO, sententia, phprec, motprec, respF, respK;
    var nbq,niveau,r1,r2, r1_text, r2_text;//for ablatif.php
    var baseURL, dataForPosting;

function showProps(obj) {// adapted from : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Working_with_Objects
  var result = "";
  for (var i in obj) {
    if (obj.hasOwnProperty(i)) {
      result += i + " = " + obj[i] + "\n";
    }
  }
  return result+"\n=============================";
}

function handleIt(data){//process the data that come
  // future use : collect the info in a DB (student follow-up)
  function waitDebugger(){// open a possibility to set a breakpoint
    var i=0;
  }
  var timeWhenDisplayed;
  var maybeError="correct";
  var $data=$(data.split("\n"));
  $("#contents").html(data);
  timeWhenDisplayed=new Date();
  prevSolution=extractSolution($data);
  progressSoFar=extractProgress($data);
  if ($('.faux').length)
    maybeError=extractError($(".faux").text());

  dataForPosting["maybeError"]=maybeError;
  dataForPosting["solution"]=prevSolution;
  dataForPosting["progress"]=progressSoFar;
  console.log(showProps(dataForPosting));
  $("input[type*='submit']").click(//replace the behavior of the "send" button
    function(event){
      var timeToRespond;
      priorSent=$("input[name*='priorsent']").val();
      respSent=$("input[name*='resp']");
      if (respSent.length>1){
	respSent=event.currentTarget.value;
      } else
	respSent=respSent.val();
      if (respSent)
	respSent=respSent.replace(/v/g,'u');// change an irritating behavior
      statusSent=$("input[name*='status']").val();
      questSent=$("input[name*='quest']").val();
      meta=$("input[name*='meta']").val();
      schema=$("input[name*='schema']").val();
      numeri=$("input[name*='numeri']").val();
      phprec=$("input[name*='phprec']").val();
      nbq=$("input[name*='nbq']").val();
      niveau=$("input[name*='niveau']").val();
      respF=$("select[name*='respF'] option:selected").val();
      respK=$("select[name*='respK'] option:selected").val();
      respS=$("select[name*='respS'] option:selected").val();
      respO=$("select[name*='respO'] option:selected").val();
      r1=$("select[name*='r1'] option:selected").val();
      r2=$("select[name*='r2'] option:selected").val();
      r1_text=$("select[name*='r1'] option:selected").text();
      r2_text=$("select[name*='r2'] option:selected").text();
      sententia=$("input[name*='sententia']").val();
      // prove that we collected relevant information
      timeToRespond=new Date().getTime()-timeWhenDisplayed.getTime();
      dataForPosting={priorsent:priorSent,resp:respSent,status:statusSent,quest:questSent,
		      respS:respS, respO:respO, sententia:sententia, baseURL:baseURL,
		      timeToRespond:timeToRespond/1000., whenDisplayed:timeWhenDisplayed.toISOString(),
		      questionAsked:priorSent||sententia||phprec,meta:meta,numeri:numeri,schema:schema,
		      phprec:phprec,motprec:motprec, respF:respF, respK:respK,nbq:nbq,niveau:niveau,
		      r1:r1,r2:r2, r1_text:r1_text, r2_text:r2_text};
      event.preventDefault();

      $.post("recordData.php?rnd="+Math.random(),dataForPosting,waitDebugger);//the normal behavior of the form
      $.post(baseURL,dataForPosting,handleIt);//the normal behavior of the form
    });
}
function extractError(text){
  var maybeError, toAdd=8;
  var i=text.indexOf('pondisti');
  if (i==-1){
    i=text.indexOf("aux");// target is "Faux."
    toAdd=5;
  }
  var j=text.indexOf(".",i+toAdd);
  maybeError=text.slice(i+toAdd,j).trim().replace("«","").replace("»","");//what we answered
  return maybeError;
}
function extractSolution($data) {// as it says ...
  const pattern0=/gallice : (.*)<br>/;
  const pattern1=/[Ss]olutio : (.*)<br>/;
  const pattern2=/Phrase précédente/;
  var solutionFound="pas trouvé";
  var patterns=new Array(pattern0,pattern1)
  try {
    $data.each(
      function(i,line){// loop on line in reponse
	$.each(patterns,
	       function(j, pattern){// loop on patterns
		 if (pattern.test(line)){
		   solutionFound=pattern.exec(line)[1];
		   //console.log(solutionFound+" at line "+i+" with pattern " +j);
		   throw solutionFound;// exit two loops
		 }});});
  }
  catch(whatFound){
    return solutionFound.replace("&laquo;","").replace("&raquo;","");
  }
  // not found using those methods, find another one (see gal.php for example)
  try {
    $data.each(
      function(i,line){
	if (pattern2.test(line))
	  throw i;
      });
  } catch (i) {
    var upTo;
    solutionFound=$data[i+1];
    upTo=solutionFound.indexOf("<div");
    if (upTo==-1)
      return solutionFound;
    else
      return solutionFound.slice(0,upTo);
  }
}

function extractProgress($data) {// as it says ...
  const pattern0=/([0-9]+)\/([0-9]+)<br>/;
  var patterns=new Array(pattern0);//in case we find other ways of expressing progress
  var matched, currentQuestion, outOf;
  try {
    $data.each(
      function(i,line){// loop on line in reponse
	$.each(patterns,
	       function(j, pattern){// loop on patterns
		 if (pattern.test(line)){
		   matched=pattern.exec(line);
		   currentQuestion=parseInt(matched[1],10);
		   outOf=parseInt(matched[2],10);
		   console.log(solutionFound+" at line "+i+" with pattern " +j);
		   throw matched;// exit two loops
		 }});});
  }
  catch(whatFound){
    return new Array(currentQuestion, outOf);
  }
  return new Array(-1,-1);
}


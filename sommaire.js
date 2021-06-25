$(window).load(function(){
    addCrustula();
});

var xml;
var crustula;
var liste = $("ol#crustula");

function getCookie(name) {
    // copied from:
    //https://stackoverflow.com/questions/5968196/how-do-i-check-if-a-cookie-exists
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
            end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

function lingua(){
    let lang = new URLSearchParams(window.location.search).get("preferred_language");
    if (! lang) lang = "fr_FR.UTF-8";
    return lang;
}

function addCrustula(){
    $.get("index."+lingua()+".html", function(data){
	let reBody = new RegExp("<body>[\\s\\S]*</body>", "m");
	data = data.match(reBody);
	data=data[0];
	xml = $.parseXML(data);
	crustula = xml.documentElement.getElementsByTagName("a");
	let dejavu = new Array();
	for (let i=0; i < crustula.length; i++){
	    let href=$(crustula[i]).attr("href");
	    if (href && href.match(/\.php$/) && ! dejavu.includes(href)){
		let li = $("<li>");
		li.append($(crustula[i].outerHTML)); // make a deep copy
		liste.append(li);
		dejavu.push(href);
	    }
	}
    })
}

var i18ndiv = document.querySelector("#i18n");
var body = document.querySelector("body");

var languages = {
    fr: "French language",
    en: "English language",
    ru: "Russian language"
}

if (! i18ndiv) {
    i18ndiv = document.createElement("div");
    i18ndiv.setAttribute("id", "i18n");
    var innerHTML = "";
    for (lang in languages)  {
	innerHTML += "<image src='images/" + lang +
	    ".png' alt='" + languages[lang] +
	    "' onclick='preferLanguage(\"" + lang +
	    "\")'/>";
    }
    i18ndiv.innerHTML = innerHTML;
    body.insertBefore(i18ndiv, body.childNodes[0]);
}

/**
 * select the preferred language
 * this one will be kept in a cookie, with seven-days duration
 **/
function preferLanguage(lang) {
    document.cookie = "preferred_language=" + lang + "; SameSite=Strict; max-age=604800";
    document.location = "index.php";
}

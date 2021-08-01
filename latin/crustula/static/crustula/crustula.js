// positionne le focus dans le premier input de type texte

function focusInput(){
    var input1 = document.querySelector('input[type="text"]');
    if (input1) {
	input1.focus();
    }
}

// ajoute une vérification au formulaire pour empêcher l'envoi de
// réponse vide
function checkSubmit(){
    var form = document.querySelector("form");
    if (form) {
	var input1 = form.querySelector('input[type="text"]');
	form.onsubmit = function(){
	    var ok = input1.value.length > 0;
	    return ok;
	}
    }
}
window.onload = function(){
    focusInput();
    checkSubmit();
}

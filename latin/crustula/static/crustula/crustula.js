// positionne le focus dans le premier input de type texte

function focusInput(){
    var input1 = document.querySelector('input[type="text"]');
    if (input1) {
	input1.focus();
    }
}

window.onload = focusInput;

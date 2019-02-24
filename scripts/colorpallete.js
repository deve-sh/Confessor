/*
	JavaScript Code to set the background of Body to a random gradient every time it is loaded.
*/

const body = document.getElementsByTagName('body')[0];

body.style.background = "#00b4db linear-gradient(to top, #00b4db, #0083b0)";

var xhr = new XMLHttpRequest();

xhr.open('GET','files/gradients.json');

xhr.onload = function(){
	let gradients = JSON.parse(xhr.responseText);
	var bgcolor = gradients[Math.floor(Math.random() * gradients.length)];
	bgcolor = `linear-gradient(to top,${[...bgcolor.colors].toString()})`;
	body.style.background = bgcolor;
}

xhr.send();
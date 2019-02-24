/* Script to Set the Footer to the bottom of the page. */

function footsetter(){
		if(document.getElementsByTagName('footer')[0]){
			if(screen.height>document.getElementsByTagName('footer')[0].offsetTop){
				document.getElementsByTagName('footer')[0].offsetTop = screen.height - document.getElementsByTagName('footer')[0].clientHeight;
			}
		}

		console.log(document.getElementsByTagName('footer')[0]);
}

window.addEventListener('DOMContentLoaded',footsetter(),false);
window.addEventListener('resize',footsetter());
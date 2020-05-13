$(document).ready(function(){
	var menuStyle = getComputedStyle(menu);
	openMenu.onclick = function () {
		if (menuStyle.display == "none"){
			menu.classList.add("active");
			this.innerHTML = "Close";
		}
		else {
			menu.classList.remove("active");
			this.innerHTML = "Open"
		}
	}
});

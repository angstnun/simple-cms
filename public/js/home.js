window.onload = function() {
	let navbarToggle = document.getElementsByClassName('toggle-navbar-items');
	navbarToggle[0].addEventListener('click', showNavbarItems);
}

function addClassToElement(element, classes) {
	for(var i=0;i<classes.length;i++) {
		element.classList.add(classes[i])
	}
}

function getStyle(element, name)
{
    return element.currentStyle ? element.currentStyle[name] : window.getComputedStyle ? window.getComputedStyle(element, null).getPropertyValue(name) : null;
}

function showNavbarItems() {

	var navbarItems = document.getElementsByClassName('navbar-items');
	var display = getStyle(navbarItems[0], 'display');
	if ('none' === display ) {
		navbarItems[0].style.setProperty('display', 'flex', 'important');
	} else {
		navbarItems[0].style.setProperty('display', 'none', 'important')
	}
}
/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
(function () {
	var body = document.querySelector('body');
	var openBtn = document.getElementById('menu-toggle');
	var overlay = document.querySelector('.mobile-nav-overlay');
	var menu = document.getElementById('primary-menu-wrap');
	var menuContent = menu.querySelector('#primary-menu > .content-width');
	menuContent.insertAdjacentHTML('beforeend', '<div id="menu-close">╳</div>'); // Insert Close btn
	var closeBtn = document.getElementById('menu-close');

	// Open/close mobile menu
	openBtn.addEventListener('click', () => {
		openNav();
	});
	
	closeBtn.addEventListener('click', () => {
		closeNav();
	});
	
	function openNav() {
		body.classList.add('menu--active');
		openBtn.setAttribute('aria-expanded', 'true');
		menu.setAttribute('aria-expanded', 'true');
		return;
	}
	
	function closeNav() {
		body.classList.remove('menu--active');
		openBtn.setAttribute('aria-expanded', 'false');
		menu.setAttribute('aria-expanded', 'false');
		return;
	}
	
	overlay.addEventListener('click', () => {
		body.classList.remove('menu--active');
		openBtn.setAttribute('aria-expanded', 'false');
		menu.setAttribute('aria-expanded', 'false');
	});

	// Get all the link elements within the menu.
	var links = menu.getElementsByTagName('a')
	var subMenus = menu.getElementsByTagName('ul')

	// Set menu items with submenus to aria-haspopup="true".
	for (var i = 0, len = subMenus.length; i < len; i++) {
		subMenus[i].parentNode.setAttribute('aria-haspopup', 'true')
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for (i = 0, len = links.length; i < len; i++) {
		links[i].addEventListener('focus', toggleFocus, true)
		links[i].addEventListener('blur', toggleFocus, true)
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus () {
		var self = this

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while (self.className.indexOf('nav-menu') === -1) {
			// On li elements toggle the class .focus.
			if (self.tagName.toLowerCase() === 'li') {
				if (self.className.indexOf('focus') !== -1) {
					self.className = self.className.replace(' focus', '')
				} else {
					self.className += ' focus'
				}
			}
			
		self = self.parentElement
		}
	}
	
})();
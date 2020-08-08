/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens and enables tab
 * support for dropdown menus.
 */
(function () {
	var body = document.querySelector('body');
	var openBtn = document.getElementById('menu-toggle');
	var overlay = document.createElement('div');
	var menu = document.getElementById('primary-menu-wrap');
	var menuContent = menu.querySelector('#primary-menu > .content-width');
	menuContent.insertAdjacentHTML('beforeend', '<div id="menu-close">╳</div>'); // Insert Close btn
	var closeBtn = document.getElementById('menu-close');

	// Open/close mobile menu
	openBtn.addEventListener('click', () => {
		createOverlay();
		openNav();
	});

	closeBtn.addEventListener('click', () => {
		destroyOverlay();
		closeNav();
	});

	if (window.screen.width > 1024) {
		destroyOverlay();
	}

	if (window.screen.width < 1024) {
		const height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
		menu.style['min-height'] = height + 'px';
	}

	function openNav() {
		body.classList.add('menu--active');
		openBtn.setAttribute('aria-expanded', 'true');
		menu.setAttribute('aria-expanded', 'true');
		// bodyScrollLock.disableBodyScroll(menu);
		return;
	}

	function closeNav() {
		body.classList.remove('menu--active');
		openBtn.setAttribute('aria-expanded', 'false');
		menu.setAttribute('aria-expanded', 'false');
		// bodyScrollLock.enableBodyScroll(menu);
		return;
	}

	function createOverlay() {
		overlay.classList.add('mobile-nav-overlay');
		menu.insertAdjacentElement('afterend', overlay);
		overlay.addEventListener('click', () => {
			destroyOverlay();
			closeNav();
		});
	}

	function destroyOverlay() {
		overlay.remove();
	}

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
	function toggleFocus() {
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
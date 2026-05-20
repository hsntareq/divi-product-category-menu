document.addEventListener('DOMContentLoaded', function() {
	var menus = document.querySelectorAll('.dpcm-menu');

	menus.forEach(function(menu) {
		var triggerMode = menu.classList.contains('dpcm-menu--trigger-click') ? 'click' : 'hover';
		var items = menu.querySelectorAll('.dpcm-menu__item--has-children');

		items.forEach(function(item) {
			var toggle = item.querySelector('.dpcm-menu__toggle');
			if (!toggle) {
				return;
			}

			var closeItem = function() {
				item.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			};

			var openItem = function() {
				item.classList.add('is-open');
				toggle.setAttribute('aria-expanded', 'true');
			};

			toggle.addEventListener('click', function(event) {
				event.preventDefault();

				var isOpen = item.classList.contains('is-open');
				items.forEach(function(otherItem) {
					var otherToggle = otherItem.querySelector('.dpcm-menu__toggle');
					otherItem.classList.remove('is-open');
					if (otherToggle) {
						otherToggle.setAttribute('aria-expanded', 'false');
					}
				});

				if (!isOpen) {
					openItem();
				}
			});

			if (triggerMode === 'hover') {
				item.addEventListener('mouseleave', closeItem);
			}

			item.addEventListener('keydown', function(event) {
				if ('Escape' === event.key) {
					closeItem();
					toggle.focus();
				}
			});
		});

		document.addEventListener('click', function(event) {
			if (!menu.contains(event.target)) {
				items.forEach(function(item) {
					var toggle = item.querySelector('.dpcm-menu__toggle');
					item.classList.remove('is-open');
					if (toggle) {
						toggle.setAttribute('aria-expanded', 'false');
					}
				});
			}
		});
	});
});

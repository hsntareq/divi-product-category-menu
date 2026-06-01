document.addEventListener('DOMContentLoaded', function() {
	var menus = document.querySelectorAll('.dpcm-menu');

	menus.forEach(function(menu) {
		var triggerMode = menu.classList.contains('dpcm-menu--trigger-click') ? 'click' : 'hover';
		var rowWidthScopeEnabled = menu.classList.contains('dpcm-menu--width-scope-row');
		var tabButtons = menu.querySelectorAll('.dpcm-tax-nav__btn');
		var taxPanels = menu.querySelectorAll('.dpcm-tax-panel');
		var isMobileLayout = function() {
			return window.matchMedia('(max-width: 980px)').matches;
		};

		var updateDropdownScopeMetrics = function() {
			if (!rowWidthScopeEnabled) {
				menu.style.removeProperty('--dpcm-dropdown-width');
				menu.style.removeProperty('--dpcm-dropdown-offset');
				return;
			}

			var row = menu.closest('.et_pb_row');
			if (!row) {
				menu.style.setProperty('--dpcm-dropdown-width', '100%');
				menu.style.setProperty('--dpcm-dropdown-offset', '0px');
				return;
			}

			var rowRect = row.getBoundingClientRect();
			var menuRect = menu.getBoundingClientRect();
			var width = Math.max(0, rowRect.width);
			var offset = rowRect.left - menuRect.left;

			menu.style.setProperty('--dpcm-dropdown-width', width + 'px');
			menu.style.setProperty('--dpcm-dropdown-offset', offset + 'px');
		};

		updateDropdownScopeMetrics();
		window.addEventListener('resize', updateDropdownScopeMetrics);

		var closeMenu = function() {
			menu.classList.remove('dpcm-menu--open');

			tabButtons.forEach(function(button) {
				button.classList.remove('is-active');
				button.setAttribute('aria-selected', 'false');
			});

			taxPanels.forEach(function(panel) {
				if (panel.classList.contains('is-active')) {
					deactivateTaxPanel(panel);
				}
			});
		};

		var deactivateTaxPanel = function(panel) {
			panel.classList.remove('is-active');
			panel.setAttribute('hidden', 'hidden');

			panel.querySelectorAll('.dpcm-tax-mega__panel').forEach(function(mega) {
				mega.classList.remove('is-active');
				mega.setAttribute('hidden', 'hidden');
			});
		};

		var activateTaxItemInPanel = function(panel, item) {
			var targetId = item.getAttribute('data-dpcm-term-target');
			if (!targetId) {
				return;
			}

			var taxItems = panel.querySelectorAll('.dpcm-tax-item');
			var megaPanels = panel.querySelectorAll('.dpcm-tax-mega__panel');

			taxItems.forEach(function(otherItem) {
				var isActive = otherItem === item;

				otherItem.classList.toggle('is-active', isActive);
			});

			megaPanels.forEach(function(mega) {
				var isActive = mega.id === targetId && panel.classList.contains('is-active');
				mega.classList.toggle('is-active', isActive);
				if (isActive) {
					mega.removeAttribute('hidden');
				} else {
					mega.setAttribute('hidden', 'hidden');
				}
			});
		};

		var activateTaxPanel = function(targetId) {
			updateDropdownScopeMetrics();
			menu.classList.add('dpcm-menu--open');

			tabButtons.forEach(function(button) {
				var isActive = button.getAttribute('data-dpcm-tax-target') === targetId;
				button.classList.toggle('is-active', isActive);
				button.setAttribute('aria-selected', isActive ? 'true' : 'false');
			});

			taxPanels.forEach(function(panel) {
				var isActive = panel.id === targetId;
				panel.classList.toggle('is-active', isActive);
				if (isActive) {
					panel.removeAttribute('hidden');
					var firstItem = panel.querySelector('.dpcm-tax-item');
					if (firstItem) {
						activateTaxItemInPanel(panel, firstItem);
					}
				} else {
					deactivateTaxPanel(panel);
				}
			});
		};

		tabButtons.forEach(function(button) {
			button.addEventListener('click', function(e) {
				e.stopPropagation(); // Prevent outside click handler from firing

				if (isMobileLayout()) {
					var targetId = button.getAttribute('data-dpcm-tax-target');
					var isActive = button.classList.contains('is-active');

					if (isActive && menu.classList.contains('dpcm-menu--open')) {
						closeMenu();
						return;
					}

					activateTaxPanel(targetId);
					return;
				}

				if (triggerMode !== 'click') {
					return;
				}

				activateTaxPanel(button.getAttribute('data-dpcm-tax-target'));
			});

			button.addEventListener('mouseenter', function() {
				if (isMobileLayout()) {
					return;
				}

				if (triggerMode !== 'hover') {
					return;
				}

				activateTaxPanel(button.getAttribute('data-dpcm-tax-target'));
			});

			button.addEventListener('focus', function() {
				if (isMobileLayout()) {
					return;
				}

				if (triggerMode !== 'hover') {
					return;
				}

				activateTaxPanel(button.getAttribute('data-dpcm-tax-target'));
			});
		});

		taxPanels.forEach(function(panel) {
			var taxItems = panel.querySelectorAll('.dpcm-tax-item');

			taxItems.forEach(function(item) {
				var head = item.querySelector('.dpcm-tax-item__head');
				var link = item.querySelector('.dpcm-tax-item__link');
				var hasChildren = item.classList.contains('dpcm-tax-item--has-children');

				item.addEventListener('mouseenter', function() {
					if (isMobileLayout()) {
						return;
					}

					activateTaxItemInPanel(panel, item);
				});

				if (head) {
					head.addEventListener('click', function(event) {
						if (!isMobileLayout() && triggerMode !== 'click') {
							return;
						}

						event.stopPropagation();
						activateTaxItemInPanel(panel, item);
					});
				}

				if (triggerMode === 'click' && head) {
					head.addEventListener('click', function(event) {
						var clickedLink = event.target.closest('.dpcm-tax-item__link');

						if (clickedLink && hasChildren && !item.classList.contains('is-active')) {
							event.preventDefault();
						}

						if (!clickedLink || hasChildren) {
							event.stopPropagation();
							activateTaxItemInPanel(panel, item);
						}
					});
				}

				if (link) {
					link.addEventListener('focus', function() {
						activateTaxItemInPanel(panel, item);
					});
				}
			});
		});

		menu.addEventListener('mouseleave', function() {
			if (isMobileLayout()) {
				return;
			}

			if (triggerMode !== 'hover') {
				return;
			}

			closeMenu();
		});

		// Hide all panels when clicking outside
		document.addEventListener('click', function(event) {
			menus.forEach(function(menu) {
				var isClickInside = menu.contains(event.target);
				if (!isClickInside) {
					closeMenu();
				}
			});
		});
	});
});

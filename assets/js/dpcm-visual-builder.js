(function($, React) {
	'use strict';

	if (!React) {
		return;
	}

	var createElement = React.createElement;

	function normalizeText(value, fallback) {
		return value && String(value).trim() ? value : fallback;
	}

	function buildCategoryPreview(props) {
		var label = normalizeText(props.menu_title, 'Shop Categories');
		var showIndicator = 'off' !== props.show_indicator;
		var demoItems = [
			{
				label: 'Clothing',
				children: ['T-Shirts', 'Jackets']
			},
			{
				label: 'Accessories',
				children: ['Bags', 'Belts']
			},
			{
				label: 'Sale',
				children: []
			}
		];

		return createElement(
			'nav',
			{ className: 'dpcm-menu dpcm-menu--preview' },
			createElement('span', { className: 'dpcm-menu__title' }, label),
			createElement(
				'ul',
				{ className: 'dpcm-menu__items' },
				demoItems.map(function(item, index) {
					var hasChildren = 'off' !== props.show_subcategories && item.children.length > 0;
					return createElement(
						'li',
						{
							className: 'dpcm-menu__item' + (hasChildren ? ' dpcm-menu__item--has-children is-open' : ''),
							key: item.label + '-' + index
						},
						createElement(
							'span',
							{ className: 'dpcm-menu__link' },
							item.label,
							hasChildren && showIndicator ? createElement('span', { className: 'dpcm-menu__indicator', 'aria-hidden': 'true' }) : null
						),
						hasChildren ? createElement(
							'ul',
							{ className: 'dpcm-submenu' },
							item.children.map(function(childLabel) {
								return createElement(
									'li',
									{ className: 'dpcm-submenu__item', key: item.label + '-' + childLabel },
									createElement('span', { className: 'dpcm-submenu__link' }, childLabel)
								);
							})
						) : null
					);
				})
			)
		);
	}

	class DPCMProductCategoryMenu extends React.Component {
		render() {
			return buildCategoryPreview(this.props || {});
		}
	}

	DPCMProductCategoryMenu.slug = 'dpcm_product_category_menu';

	class DPCMProductCategoryMenuItem extends React.Component {
		render() {
			var label = normalizeText(this.props.item_label, 'Custom Item');
			return createElement(
				'li',
				{ className: 'dpcm-menu__item dpcm-menu__item--custom' },
				createElement('span', { className: 'dpcm-menu__link' }, label)
			);
		}
	}

	DPCMProductCategoryMenuItem.slug = 'dpcm_product_category_menu_item';

	$(window).on('et_builder_api_ready', function(event, API) {
		API.registerModules([
			DPCMProductCategoryMenu,
			DPCMProductCategoryMenuItem
		]);
	});
})(jQuery, window.React);

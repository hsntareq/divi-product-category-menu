import { Component } from 'react';

const normalizeText = (value, fallback) => (value && String(value).trim() ? value : fallback);

class DPCMProductCategoryMenu extends Component {
	static slug = 'dpcm_product_category_menu';

	render() {
		const props = this.props || {};
		const label = normalizeText(props.menu_title, 'Shop Categories');
		const showIndicator = 'off' !== props.show_indicator;
		const triggerClass = `dpcm-menu--trigger-${props.dropdown_trigger || 'hover'}`;
		const displayClass = `dpcm-menu--display-${props.menu_display || 'block'}`;
		const widthScopeClass = `dpcm-menu--width-scope-${props.dropdown_width_scope || 'column'}`;
		const previewStyle = {
			'--dpcm-left-cat-text': props.left_cat_text_color || '#1f2937',
			'--dpcm-left-cat-bg': props.left_cat_bg_color || '#f8fafc',
			'--dpcm-left-cat-active-text': props.left_cat_active_text_color || '#ffffff',
			'--dpcm-left-cat-active-bg': props.left_cat_active_bg_color || '#0f766e',
			'--dpcm-main-btn-bg': props.main_btn_bg_color || '#e2e8f0',
			'--dpcm-main-btn-text': props.main_btn_text_color || '#111827',
			'--dpcm-main-btn-bg-active': props.main_btn_active_bg_color || '#0f766e',
			'--dpcm-main-btn-text-active': props.main_btn_active_text_color || '#ffffff',
			'--dpcm-panel-bg': props.mega_panel_bg_color || '#ffffff',
			'--dpcm-panel-radius': props.mega_panel_radius || '12px',
			'--dpcm-panel-padding': props.mega_panel_padding || '16px',
			'--dpcm-left-col-width': props.mega_left_column_width || '300px',
			'--dpcm-mega-min-height': props.mega_min_height || '280px',
			'--dpcm-left-item-size': props.left_item_font_size || '16px',
			'--dpcm-sub-item-size': props.sub_item_font_size || '15px',
		};
		const categoryTerms = [
			{
				label: 'Clothing',
				children: ['T-Shirts', 'Jackets'],
			},
			{
				label: 'Accessories',
				children: ['Bags', 'Belts'],
			},
		];
		const brandTerms = [
			{ label: 'Nike', children: [] },
			{ label: 'Adidas', children: [] },
			{ label: 'Puma', children: [] },
		];

		return (
			<nav className={`dpcm-menu dpcm-menu--preview ${widthScopeClass} ${triggerClass} ${displayClass}`} style={previewStyle}>
				<span className="dpcm-menu__title">{label}</span>
				<div className="dpcm-tax-nav">
					<div className="dpcm-tax-nav__tabs">
						<button className="dpcm-tax-nav__btn is-active" type="button">Product by Category</button>
						<button className="dpcm-tax-nav__btn" type="button">Product by Brand</button>
					</div>
				</div>

				<div className="dpcm-tax-panel is-active dpcm-tax-panel--category">
					<div className="dpcm-tax-layout">
						<ul className="dpcm-tax-list">
							{categoryTerms.map((term, index) => {
								const isActive = index === 0;

								return (
									<li className={`dpcm-tax-item dpcm-tax-item--has-children${isActive ? ' is-active' : ''}`} key={term.label}>
										<div className="dpcm-tax-item__head">
											<span className="dpcm-tax-item__link">{term.label}</span>
											{showIndicator ? <span className="dpcm-tax-item__indicator" aria-hidden="true" /> : null}
										</div>
									</li>
								);
							})}
						</ul>

						<div className="dpcm-tax-mega">
							<div className="dpcm-tax-mega__panel is-active">
								<p className="dpcm-tax-mega__title">Clothing</p>
								<ul className="dpcm-tax-mega__list">
									{categoryTerms[0].children.map((childLabel) => (
										<li className="dpcm-tax-mega__item" key={`preview-${childLabel}`}>
											<span className="dpcm-tax-mega__link">{childLabel}</span>
										</li>
									))}
								</ul>
							</div>
						</div>
					</div>
				</div>

			</nav>
		);
	}
}

export default DPCMProductCategoryMenu;

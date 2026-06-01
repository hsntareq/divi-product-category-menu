import { Component } from 'react';

class DPCMProductCategoryMenuItem extends Component {
	static slug = 'dpcm_product_category_menu_item';

	render() {
		const label = this.props.item_label && String(this.props.item_label).trim() ? this.props.item_label : 'Custom Item';

		return (
			<li className="dpcm-menu__item dpcm-menu__item--custom">
				<span className="dpcm-menu__link">{label}</span>
			</li>
		);
	}
}

export default DPCMProductCategoryMenuItem;

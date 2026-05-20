<?php
/**
 * Child Divi module for custom product category menu items.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product category menu child item module.
 */
class DPCM_Product_Category_Menu_Item extends ET_Builder_Module {
	/**
	 * Module slug.
	 *
	 * @var string
	 */
	public $slug = 'dpcm_product_category_menu_item';

	/**
	 * Visual builder support flag.
	 *
	 * @var string
	 */
	public $vb_support = 'on';

	/**
	 * Child module flag.
	 *
	 * @var string
	 */
	public $type = 'child';

	/**
	 * Configure the child module.
	 *
	 * @return void
	 */
	public function init() {
		$this->name            = esc_html__( 'Custom Menu Item', 'divi-product-category-menu' );
		$this->plural          = esc_html__( 'Custom Menu Items', 'divi-product-category-menu' );
		$this->child_title_var = 'item_label';
	}

	/**
	 * Return settings modal toggles.
	 *
	 * @return array<string, mixed>
	 */
	public function get_settings_modal_toggles() {
		return array(
			'general' => array(
				'toggles' => array(
					'main_content' => array(
						'title' => esc_html__( 'Item', 'divi-product-category-menu' ),
					),
				),
			),
		);
	}

	/**
	 * Return module fields.
	 *
	 * @return array<string, mixed>
	 */
	public function get_fields() {
		return array(
			'item_label'      => array(
				'label'           => esc_html__( 'Label', 'divi-product-category-menu' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => esc_html__( 'Custom Item', 'divi-product-category-menu' ),
				'toggle_slug'     => 'main_content',
			),
			'link_type'       => array(
				'label'           => esc_html__( 'Link Type', 'divi-product-category-menu' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'url'      => esc_html__( 'Custom URL', 'divi-product-category-menu' ),
					'category' => esc_html__( 'Product Category', 'divi-product-category-menu' ),
				),
				'default'         => 'url',
				'toggle_slug'     => 'main_content',
			),
			'item_url'        => array(
				'label'           => esc_html__( 'URL', 'divi-product-category-menu' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'show_if'         => array(
					'link_type' => 'url',
				),
				'toggle_slug'     => 'main_content',
			),
			'category_id'     => array(
				'label'           => esc_html__( 'Category ID', 'divi-product-category-menu' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Enter a WooCommerce product category ID when using a category link.', 'divi-product-category-menu' ),
				'show_if'         => array(
					'link_type' => 'category',
				),
				'toggle_slug'     => 'main_content',
			),
			'open_in_new_tab' => array(
				'label'           => esc_html__( 'Open In New Tab', 'divi-product-category-menu' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-product-category-menu' ),
					'off' => esc_html__( 'No', 'divi-product-category-menu' ),
				),
				'default'         => 'off',
				'toggle_slug'     => 'main_content',
			),
		);
	}

	/**
	 * Render child item markup.
	 *
	 * @param array<string, mixed> $attrs       Module attributes.
	 * @param string|null          $content     Child module content.
	 * @param string               $render_slug Current render slug.
	 *
	 * @return string
	 */
	public function render( $attrs, $content = null, $render_slug = '' ) {
		$label = $this->props['item_label'];
		$url   = $this->props['item_url'];
		if ( 'category' === $this->props['link_type'] ) {
			$term = get_term_by( 'id', absint( $this->props['category_id'] ), 'product_cat' );
			if ( $term && ! is_wp_error( $term ) ) {
				$term_link = get_term_link( $term );
				if ( ! is_wp_error( $term_link ) ) {
					$url = $term_link;
				}
			}
		}

		$target = 'on' === $this->props['open_in_new_tab'] ? ' target="_blank" rel="noopener noreferrer"' : '';

		return sprintf(
			'<li class="dpcm-menu__item dpcm-menu__item--custom"><a class="dpcm-menu__link" href="%1$s"%3$s>%2$s</a></li>',
			esc_url( $url ? $url : '#' ),
			esc_html( $label ),
			$target
		);
	}
}

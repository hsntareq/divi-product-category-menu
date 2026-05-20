<?php
/**
 * Parent Divi module for the product category menu.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product category menu parent module.
 */
class DPCM_Product_Category_Menu extends ET_Builder_Module {
	/**
	 * Module slug.
	 *
	 * @var string
	 */
	public $slug = 'dpcm_product_category_menu';

	/**
	 * Visual builder support flag.
	 *
	 * @var string
	 */
	public $vb_support = 'on';

	/**
	 * Configure the module.
	 *
	 * @return void
	 */
	public function init() {
		$this->name             = esc_html__( 'Product Category Menu', 'divi-product-category-menu' );
		$this->plural           = esc_html__( 'Product Category Menus', 'divi-product-category-menu' );
		$this->child_slug       = 'dpcm_product_category_menu_item';
		$this->child_item_text  = esc_html__( 'Custom Menu Item', 'divi-product-category-menu' );
		$this->main_css_element = '%%order_class%% .dpcm-menu';
	}

	/**
	 * Return advanced field configuration.
	 *
	 * @return array<string, mixed>
	 */
	public function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'menu_title'   => array(
					'label' => esc_html__( 'Menu Title', 'divi-product-category-menu' ),
					'css'   => array(
						'main' => '%%order_class%% .dpcm-menu__title',
					),
				),
				'menu_item'    => array(
					'label' => esc_html__( 'Menu Item', 'divi-product-category-menu' ),
					'css'   => array(
						'main' => '%%order_class%% .dpcm-menu__link',
					),
				),
				'submenu_item' => array(
					'label' => esc_html__( 'Submenu Item', 'divi-product-category-menu' ),
					'css'   => array(
						'main' => '%%order_class%% .dpcm-submenu__link',
					),
				),
			),
			'background'     => array(
				'css' => array(
					'main' => '%%order_class%% .dpcm-menu',
				),
			),
			'borders'        => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dpcm-menu',
							'border_styles' => '%%order_class%% .dpcm-menu',
						),
					),
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .dpcm-menu',
					'important' => 'all',
				),
			),
			'text'           => false,
			'filters'        => false,
			'link_options'   => false,
		);
	}

	/**
	 * Return settings modal toggles.
	 *
	 * @return array<string, mixed>
	 */
	public function get_settings_modal_toggles() {
		return array(
			'general'  => array(
				'toggles' => array(
					'main_content' => array(
						'title' => esc_html__( 'Content', 'divi-product-category-menu' ),
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'menu' => array(
						'title' => esc_html__( 'Menu', 'divi-product-category-menu' ),
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
			'menu_title'            => array(
				'label'           => esc_html__( 'Menu Label', 'divi-product-category-menu' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'default'         => esc_html__( 'Shop Categories', 'divi-product-category-menu' ),
				'toggle_slug'     => 'main_content',
			),
			'include_categories'    => array(
				'label'            => esc_html__( 'Include Categories', 'divi-product-category-menu' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'  => true,
					'term_name'  => 'product_cat',
					'field_name' => 'et_pb_include_dpcm_product_cat',
				),
				'tab_slug'         => 'general',
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Select top-level product categories to include. Leave empty to show all top-level categories.', 'divi-product-category-menu' ),
			),
			'hide_empty'            => array(
				'label'           => esc_html__( 'Hide Empty Categories', 'divi-product-category-menu' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-product-category-menu' ),
					'off' => esc_html__( 'No', 'divi-product-category-menu' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'show_subcategories'    => array(
				'label'           => esc_html__( 'Show Subcategories', 'divi-product-category-menu' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-product-category-menu' ),
					'off' => esc_html__( 'No', 'divi-product-category-menu' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'custom_items_position' => array(
				'label'           => esc_html__( 'Custom Item Position', 'divi-product-category-menu' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'before' => esc_html__( 'Before Categories', 'divi-product-category-menu' ),
					'after'  => esc_html__( 'After Categories', 'divi-product-category-menu' ),
				),
				'default'         => 'after',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'dropdown_trigger'      => array(
				'label'           => esc_html__( 'Dropdown Trigger', 'divi-product-category-menu' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'hover' => esc_html__( 'Hover', 'divi-product-category-menu' ),
					'click' => esc_html__( 'Click', 'divi-product-category-menu' ),
				),
				'default'         => 'hover',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'show_indicator'        => array(
				'label'           => esc_html__( 'Show Dropdown Indicator', 'divi-product-category-menu' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'divi-product-category-menu' ),
					'off' => esc_html__( 'No', 'divi-product-category-menu' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
		);
	}

	/**
	 * Render module output.
	 *
	 * @param array<string, mixed> $attrs       Module attributes.
	 * @param string|null          $content     Child module shortcodes.
	 * @param string               $render_slug Current render slug.
	 *
	 * @return string
	 */
	public function render( $attrs, $content = null, $render_slug = '' ) {
		$menu_items_html = do_shortcode( $content );
		$menu_tree       = DPCM_Category_Menu_Data::get_menu_tree(
			array(
				'include_categories' => $this->props['include_categories'],
				'hide_empty'         => $this->props['hide_empty'],
				'show_subcategories' => $this->props['show_subcategories'],
			)
		);

		wp_enqueue_style( 'dpcm-product-category-menu' );
		wp_enqueue_script( 'dpcm-product-category-menu' );

		$template_path          = DPCM_PATH . 'templates/product-category-menu.php';
		$dpcm_title             = $this->props['menu_title'];
		$dpcm_has_items         = ! empty( $menu_tree ) || ! empty( trim( $menu_items_html ) );
		$dpcm_menu_classes      = array(
			'dpcm-menu',
			'dpcm-menu--trigger-' . sanitize_html_class( $this->props['dropdown_trigger'] ),
		);
		$dpcm_menu_tree         = $menu_tree;
		$dpcm_custom_items_html = $menu_items_html;
		$dpcm_custom_position   = $this->props['custom_items_position'];
		$dpcm_show_indicator    = 'on' === $this->props['show_indicator'];
		$dpcm_menu_class_name   = implode( ' ', $dpcm_menu_classes );

		ob_start();
		include $template_path;
		return ob_get_clean();
	}
}

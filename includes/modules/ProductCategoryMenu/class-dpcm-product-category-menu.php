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
						'main' => '%%order_class%% .dpcm-tax-nav__btn, %%order_class%% .dpcm-tax-item__link',
					),
				),
				'submenu_item' => array(
					'label' => esc_html__( 'Submenu Item', 'divi-product-category-menu' ),
					'css'   => array(
						'main' => '%%order_class%% .dpcm-tax-mega__title-link, %%order_class%% .dpcm-tax-mega__link',
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
					'design_elements' => array(
						'title' => esc_html__( 'Design Elements', 'divi-product-category-menu' ),
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
				'default'         => 'off',
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
			'menu_display'          => array(
				'label'           => esc_html__( 'Menu Display', 'divi-product-category-menu' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'block'  => esc_html__( 'Block', 'divi-product-category-menu' ),
					'inline' => esc_html__( 'Inline', 'divi-product-category-menu' ),
				),
				'default'         => 'block',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'dropdown_width_scope' => array(
				'label'           => esc_html__( 'Dropdown Width Scope', 'divi-product-category-menu' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'column' => esc_html__( 'Column (.et_pb_module_inner)', 'divi-product-category-menu' ),
					'row'    => esc_html__( 'Row (.et_pb_row)', 'divi-product-category-menu' ),
				),
				'default'         => 'column',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'left_cat_text_color'   => array(
				'label'           => esc_html__( 'Left Category Text Color', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'default'         => '#1f2937',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'left_cat_bg_color'     => array(
				'label'           => esc_html__( 'Left Category Background', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'default'         => '#f8fafc',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'left_cat_active_text_color' => array(
				'label'           => esc_html__( 'Left Category Active Text', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'default'         => '#ffffff',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),
			'left_cat_active_bg_color' => array(
				'label'           => esc_html__( 'Left Category Active Background', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'configuration',
				'default'         => '#0f766e',
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
			'main_btn_bg_color'     => array(
				'label'           => esc_html__( 'Top Button Background', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'default'         => '#e2e8f0',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'main_btn_text_color'   => array(
				'label'           => esc_html__( 'Top Button Text', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'default'         => '#111827',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'main_btn_active_bg_color' => array(
				'label'           => esc_html__( 'Top Button Active Background', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'default'         => '#0f766e',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'main_btn_active_text_color' => array(
				'label'           => esc_html__( 'Top Button Active Text', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'default'         => '#ffffff',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'mega_panel_bg_color'    => array(
				'label'           => esc_html__( 'Mega Menu Background', 'divi-product-category-menu' ),
				'type'            => 'color-alpha',
				'option_category' => 'layout',
				'default'         => '#ffffff',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'mega_panel_radius'      => array(
				'label'           => esc_html__( 'Mega Menu Corner Radius', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '12px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 40,
					'step' => 1,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'mega_panel_padding'     => array(
				'label'           => esc_html__( 'Mega Menu Padding', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '16px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 0,
					'max'  => 60,
					'step' => 1,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'mega_left_column_width' => array(
				'label'           => esc_html__( 'Left Column Width', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '300px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 220,
					'max'  => 480,
					'step' => 1,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'mega_min_height'        => array(
				'label'           => esc_html__( 'Mega Menu Min Height', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default'         => '280px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 160,
					'max'  => 800,
					'step' => 5,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'left_item_font_size'    => array(
				'label'           => esc_html__( 'Left Item Font Size', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'default'         => '16px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 10,
					'max'  => 36,
					'step' => 1,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
			),
			'sub_item_font_size'     => array(
				'label'           => esc_html__( 'Sub Item Font Size', 'divi-product-category-menu' ),
				'type'            => 'range',
				'option_category' => 'font_option',
				'default'         => '15px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => 10,
					'max'  => 36,
					'step' => 1,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'design_elements',
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
		$menu_items_html     = do_shortcode( $content );
		$taxonomy_navigation = DPCM_Category_Menu_Data::get_taxonomy_navigation(
			array(
				'include_categories' => $this->props['include_categories'],
				'hide_empty'         => $this->props['hide_empty'],
				'show_subcategories' => $this->props['show_subcategories'],
			)
		);

		wp_enqueue_style( 'dpcm-product-category-menu' );
		wp_enqueue_script( 'dpcm-product-category-menu' );

		$template_path            = DPCM_PATH . 'templates/product-category-menu.php';
		$dpcm_title               = $this->props['menu_title'];
		$dpcm_has_items           = ! empty( $taxonomy_navigation ) || ! empty( trim( $menu_items_html ) );
		$dpcm_menu_classes        = array(
			'dpcm-menu',
			'dpcm-menu--trigger-' . sanitize_html_class( $this->props['dropdown_trigger'] ),
			'dpcm-menu--display-' . sanitize_html_class( $this->props['menu_display'] ? $this->props['menu_display'] : 'block' ),
			'dpcm-menu--width-scope-' . sanitize_html_class( $this->props['dropdown_width_scope'] ? $this->props['dropdown_width_scope'] : 'column' ),
		);
		$dpcm_taxonomy_navigation = $taxonomy_navigation;
		$dpcm_custom_items_html   = $menu_items_html;
		$dpcm_custom_position     = $this->props['custom_items_position'];
		$dpcm_show_indicator      = 'on' === $this->props['show_indicator'];
		$dpcm_menu_class_name     = implode( ' ', $dpcm_menu_classes );
		$dpcm_menu_inline_style   = sprintf(
			'--dpcm-left-cat-text:%1$s;--dpcm-left-cat-bg:%2$s;--dpcm-left-cat-active-text:%3$s;--dpcm-left-cat-active-bg:%4$s;--dpcm-main-btn-bg:%5$s;--dpcm-main-btn-text:%6$s;--dpcm-main-btn-bg-active:%7$s;--dpcm-main-btn-text-active:%8$s;--dpcm-panel-bg:%9$s;--dpcm-panel-radius:%10$s;--dpcm-panel-padding:%11$s;--dpcm-left-col-width:%12$s;--dpcm-mega-min-height:%13$s;--dpcm-left-item-size:%14$s;--dpcm-sub-item-size:%15$s;',
			esc_attr( $this->props['left_cat_text_color'] ? $this->props['left_cat_text_color'] : '#1f2937' ),
			esc_attr( $this->props['left_cat_bg_color'] ? $this->props['left_cat_bg_color'] : '#f8fafc' ),
			esc_attr( $this->props['left_cat_active_text_color'] ? $this->props['left_cat_active_text_color'] : '#ffffff' ),
			esc_attr( $this->props['left_cat_active_bg_color'] ? $this->props['left_cat_active_bg_color'] : '#0f766e' ),
			esc_attr( $this->props['main_btn_bg_color'] ? $this->props['main_btn_bg_color'] : '#e2e8f0' ),
			esc_attr( $this->props['main_btn_text_color'] ? $this->props['main_btn_text_color'] : '#111827' ),
			esc_attr( $this->props['main_btn_active_bg_color'] ? $this->props['main_btn_active_bg_color'] : '#0f766e' ),
			esc_attr( $this->props['main_btn_active_text_color'] ? $this->props['main_btn_active_text_color'] : '#ffffff' ),
			esc_attr( $this->props['mega_panel_bg_color'] ? $this->props['mega_panel_bg_color'] : '#ffffff' ),
			esc_attr( $this->props['mega_panel_radius'] ? $this->props['mega_panel_radius'] : '12px' ),
			esc_attr( $this->props['mega_panel_padding'] ? $this->props['mega_panel_padding'] : '16px' ),
			esc_attr( $this->props['mega_left_column_width'] ? $this->props['mega_left_column_width'] : '300px' ),
			esc_attr( $this->props['mega_min_height'] ? $this->props['mega_min_height'] : '280px' ),
			esc_attr( $this->props['left_item_font_size'] ? $this->props['left_item_font_size'] : '16px' ),
			esc_attr( $this->props['sub_item_font_size'] ? $this->props['sub_item_font_size'] : '15px' )
		);

		ob_start();
		include $template_path;
		return ob_get_clean();
	}
}

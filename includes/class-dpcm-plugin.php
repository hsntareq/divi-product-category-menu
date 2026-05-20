<?php
/**
 * Plugin bootstrap and module registration.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin controller.
 */
class DPCM_Plugin {
	/**
	 * Plugin singleton instance.
	 *
	 * @var DPCM_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Missing runtime dependencies.
	 *
	 * @var array<string, string>
	 */
	private $missing_dependencies = array();

	/**
	 * Return the plugin singleton.
	 *
	 * @return DPCM_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Register early plugin hooks.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'bootstrap' ) );
	}

	/**
	 * Bootstrap the plugin after WordPress plugins load.
	 *
	 * @return void
	 */
	public function bootstrap() {
		if ( ! $this->dependencies_available() ) {
			add_action( 'admin_notices', array( $this, 'render_dependency_notice' ) );
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		add_action( 'et_builder_ready', array( $this, 'register_modules' ) );
	}

	/**
	 * Check whether Divi and WooCommerce are available.
	 *
	 * @return bool
	 */
	private function dependencies_available() {
		$this->missing_dependencies = array();

		if ( ! defined( 'ET_BUILDER_THEME' ) && ! function_exists( 'et_builder_should_wrap_styles' ) ) {
			$this->missing_dependencies['divi'] = __( 'Divi Builder', 'divi-product-category-menu' );
		}

		if ( ! taxonomy_exists( 'product_cat' ) ) {
			$this->missing_dependencies['woocommerce'] = __( 'WooCommerce', 'divi-product-category-menu' );
		}

		return empty( $this->missing_dependencies );
	}

	/**
	 * Render an admin notice when required dependencies are missing.
	 *
	 * @return void
	 */
	public function render_dependency_notice() {
		if ( empty( $this->missing_dependencies ) || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$dependencies = implode( ', ', array_values( $this->missing_dependencies ) );
		$message      = sprintf(
			/* translators: %s: dependency list. */
			esc_html__( 'Divi Product Category Menu requires %s to be active.', 'divi-product-category-menu' ),
			esc_html( $dependencies )
		);

		echo '<div class="notice notice-warning"><p>' . esc_html( $message ) . '</p></div>';
	}

	/**
	 * Load and instantiate Divi modules.
	 *
	 * @return void
	 */
	public function register_modules() {
		if ( ! class_exists( 'ET_Builder_Module' ) ) {
			return;
		}

		require_once DPCM_PATH . 'includes/class-dpcm-category-menu-data.php';
		require_once DPCM_PATH . 'includes/modules/ProductCategoryMenu/class-dpcm-product-category-menu.php';
		require_once DPCM_PATH . 'includes/modules/ProductCategoryMenuItem/class-dpcm-product-category-menu-item.php';

		new DPCM_Product_Category_Menu();
		new DPCM_Product_Category_Menu_Item();
	}

	/**
	 * Register frontend assets.
	 *
	 * @return void
	 */
	public function register_assets() {
		wp_register_style(
			'dpcm-product-category-menu',
			DPCM_URL . 'assets/css/product-category-menu.css',
			array(),
			DPCM_VERSION
		);

		wp_register_script(
			'dpcm-product-category-menu',
			DPCM_URL . 'assets/js/product-category-menu.js',
			array(),
			DPCM_VERSION,
			true
		);

		wp_register_script(
			'dpcm-visual-builder',
			DPCM_URL . 'assets/js/dpcm-visual-builder.js',
			array( 'react', 'jquery' ),
			DPCM_VERSION,
			true
		);

		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
			wp_enqueue_script( 'dpcm-visual-builder' );
			wp_enqueue_style( 'dpcm-product-category-menu' );
		}
	}

	/**
	 * Prevent cloning.
	 *
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Prevent unserializing.
	 *
	 * @return void
	 */
	public function __wakeup() {}
}

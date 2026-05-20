<?php
/**
 * Frontend template for the product category menu module.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $dpcm_title, $dpcm_menu_tree, $dpcm_custom_items_html, $dpcm_custom_position, $dpcm_show_indicator, $dpcm_has_items, $dpcm_menu_class_name ) ) {
	return;
}

$render_category_items = static function ( $items, $show_indicator ) {
	foreach ( $items as $item ) {
		$has_children = ! empty( $item['children'] );
		?>
		<li class="dpcm-menu__item<?php echo $has_children ? ' dpcm-menu__item--has-children' : ''; ?>">
			<a class="dpcm-menu__link" href="<?php echo esc_url( $item['url'] ); ?>">
				<?php echo esc_html( $item['label'] ); ?>
				<?php if ( $has_children && $show_indicator ) : ?>
					<span class="dpcm-menu__indicator" aria-hidden="true"></span>
				<?php endif; ?>
			</a>
			<?php if ( $has_children ) : ?>
				<button class="dpcm-menu__toggle" type="button" aria-expanded="false">
					<span class="screen-reader-text"><?php esc_html_e( 'Toggle submenu', 'divi-product-category-menu' ); ?></span>
				</button>
				<ul class="dpcm-submenu">
					<?php foreach ( $item['children'] as $child ) : ?>
						<li class="dpcm-submenu__item">
							<a class="dpcm-submenu__link" href="<?php echo esc_url( $child['url'] ); ?>"><?php echo esc_html( $child['label'] ); ?></a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
		<?php
	}
};
?>
<nav class="<?php echo esc_attr( $dpcm_menu_class_name ); ?>" aria-label="<?php echo esc_attr( $dpcm_title ); ?>">
	<?php if ( '' !== trim( $dpcm_title ) ) : ?>
		<span class="dpcm-menu__title"><?php echo esc_html( $dpcm_title ); ?></span>
	<?php endif; ?>
	<ul class="dpcm-menu__items">
		<?php if ( 'before' === $dpcm_custom_position && ! empty( trim( $dpcm_custom_items_html ) ) ) : ?>
			<?php echo wp_kses_post( $dpcm_custom_items_html ); ?>
		<?php endif; ?>

		<?php if ( $dpcm_has_items ) : ?>
			<?php $render_category_items( $dpcm_menu_tree, $dpcm_show_indicator ); ?>
		<?php else : ?>
			<li class="dpcm-menu__empty"><?php esc_html_e( 'No product categories found.', 'divi-product-category-menu' ); ?></li>
		<?php endif; ?>

		<?php if ( 'after' === $dpcm_custom_position && ! empty( trim( $dpcm_custom_items_html ) ) ) : ?>
			<?php echo wp_kses_post( $dpcm_custom_items_html ); ?>
		<?php endif; ?>
	</ul>
</nav>

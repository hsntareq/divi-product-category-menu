<?php
/**
 * Frontend template for the product category menu module.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $dpcm_title, $dpcm_taxonomy_navigation, $dpcm_custom_items_html, $dpcm_custom_position, $dpcm_show_indicator, $dpcm_has_items, $dpcm_menu_class_name, $dpcm_menu_inline_style ) ) {
	return;
}
?>
<nav class="<?php echo esc_attr( $dpcm_menu_class_name ); ?>" style="<?php echo esc_attr( $dpcm_menu_inline_style ); ?>" aria-label="<?php echo esc_attr( $dpcm_title ); ?>">
	<?php if ( '' !== trim( $dpcm_title ) ) : ?>
		<span class="dpcm-menu__title"><?php echo esc_html( $dpcm_title ); ?></span>
	<?php endif; ?>
	<div class="dpcm-tax-nav">
		<?php if ( 'before' === $dpcm_custom_position && ! empty( trim( $dpcm_custom_items_html ) ) ) : ?>
			<ul class="dpcm-menu__custom-items dpcm-menu__custom-items--before dpcm-menu__custom-items--nav">
				<?php echo wp_kses_post( $dpcm_custom_items_html ); ?>
			</ul>
		<?php endif; ?>

		<div class="dpcm-tax-nav__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Taxonomy Navigation', 'divi-product-category-menu' ); ?>">
			<?php foreach ( $dpcm_taxonomy_navigation as $taxonomy_index => $taxonomy_group ) : ?>
				<?php $panel_id = 'dpcm-tax-panel-' . sanitize_html_class( $taxonomy_group['key'] ); ?>
				<button
					type="button"
					class="dpcm-tax-nav__btn"
					role="tab"
					aria-selected="false"
					aria-controls="<?php echo esc_attr( $panel_id ); ?>"
					data-dpcm-tax-target="<?php echo esc_attr( $panel_id ); ?>"
				>
					<?php echo esc_html( $taxonomy_group['label'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<?php if ( 'after' === $dpcm_custom_position && ! empty( trim( $dpcm_custom_items_html ) ) ) : ?>
			<ul class="dpcm-menu__custom-items dpcm-menu__custom-items--after dpcm-menu__custom-items--nav">
				<?php echo wp_kses_post( $dpcm_custom_items_html ); ?>
			</ul>
		<?php endif; ?>
	</div>

	<div class="dpcm-tax-panels">
	<?php if ( $dpcm_has_items ) : ?>
		<?php foreach ( $dpcm_taxonomy_navigation as $taxonomy_index => $taxonomy_group ) : ?>
			<?php
			$panel_id      = 'dpcm-tax-panel-' . sanitize_html_class( $taxonomy_group['key'] );
			$is_category   = 'product_cat' === $taxonomy_group['key'];
			$terms         = $taxonomy_group['terms'];
			$has_term_data = ! empty( $terms );
			?>
			<section class="dpcm-tax-panel<?php echo $is_category ? ' dpcm-tax-panel--category' : ' dpcm-tax-panel--brand'; ?>" id="<?php echo esc_attr( $panel_id ); ?>" role="tabpanel" hidden>
				<?php if ( $has_term_data ) : ?>
					<div class="dpcm-tax-layout">
						<ul class="dpcm-tax-list" role="list">
							<?php foreach ( $terms as $term_index => $term_item ) : ?>
								<?php
								$has_children  = ! empty( $term_item['children'] );
								$term_panel_id = $panel_id . '-term-' . absint( $term_index );
								?>
								<li class="dpcm-tax-item<?php echo $has_children ? ' dpcm-tax-item--has-children' : ''; ?>" data-dpcm-term-target="<?php echo esc_attr( $term_panel_id ); ?>">
									<div class="dpcm-tax-item__head">
										<span class="dpcm-tax-item__link"><?php echo esc_html( $term_item['label'] ); ?></span>
										<?php if ( $has_children && $dpcm_show_indicator ) : ?>
											<span class="dpcm-tax-item__indicator" aria-hidden="true"></span>
										<?php endif; ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>

						<div class="dpcm-tax-mega">
							<?php foreach ( $terms as $term_index => $term_item ) : ?>
								<?php
								$term_panel_id = $panel_id . '-term-' . absint( $term_index );
								$has_children  = ! empty( $term_item['children'] );
								?>
								<div class="dpcm-tax-mega__panel" id="<?php echo esc_attr( $term_panel_id ); ?>" hidden>
									<p class="dpcm-tax-mega__title"><a class="dpcm-tax-mega__title-link" href="<?php echo esc_url( $term_item['url'] ); ?>"><?php echo esc_html( $term_item['label'] ); ?></a></p>
									<?php if ( $has_children ) : ?>
										<ul class="dpcm-tax-mega__list">
											<?php foreach ( $term_item['children'] as $child ) : ?>
												<li class="dpcm-tax-mega__item">
													<a class="dpcm-tax-mega__link" href="<?php echo esc_url( $child['url'] ); ?>"><?php echo esc_html( $child['label'] ); ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php else : ?>
										<p class="dpcm-tax-mega__empty"><?php esc_html_e( 'No child items found.', 'divi-product-category-menu' ); ?></p>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php else : ?>
					<p class="dpcm-menu__empty"><?php esc_html_e( 'No taxonomy items found.', 'divi-product-category-menu' ); ?></p>
				<?php endif; ?>
			</section>
		<?php endforeach; ?>
	<?php else : ?>
		<p class="dpcm-menu__empty"><?php esc_html_e( 'No taxonomy items found.', 'divi-product-category-menu' ); ?></p>
	<?php endif; ?>
	</div>

</nav>

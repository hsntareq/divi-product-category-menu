<?php
/**
 * Product category menu data service.
 *
 * @package DiviProductCategoryMenu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch and normalize product category menu data.
 */
class DPCM_Category_Menu_Data {
	/**
	 * Build the top-level menu tree.
	 *
	 * @param array<string, mixed> $args Query settings.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_menu_tree( $args = array() ) {
		$defaults = array(
			'include_categories' => '',
			'hide_empty'         => 'on',
			'show_subcategories' => 'on',
		);

		$args = wp_parse_args( $args, $defaults );

		$hide_empty      = 'on' === $args['hide_empty'];
		$include_ids     = self::parse_term_ids( $args['include_categories'] );
		$top_level_terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => $hide_empty,
				'parent'     => 0,
				'include'    => $include_ids,
			)
		);

		if ( is_wp_error( $top_level_terms ) || empty( $top_level_terms ) ) {
			return array();
		}

		$menu = array();

		foreach ( $top_level_terms as $term ) {
			$children = array();

			if ( 'on' === $args['show_subcategories'] ) {
				$children = self::get_child_items( $term->term_id, $hide_empty );
			}

			$menu[] = array(
				'id'       => $term->term_id,
				'label'    => $term->name,
				'url'      => get_term_link( $term ),
				'children' => $children,
			);
		}

		return array_filter(
			$menu,
			static function ( $item ) {
				return ! is_wp_error( $item['url'] );
			}
		);
	}

	/**
	 * Parse a comma-separated term id string.
	 *
	 * @param string $value Raw field value.
	 *
	 * @return array<int, int>
	 */
	private static function parse_term_ids( $value ) {
		if ( empty( $value ) ) {
			return array();
		}

		return array_filter(
			array_map( 'absint', array_map( 'trim', explode( ',', $value ) ) )
		);
	}

	/**
	 * Get immediate child categories for a top-level term.
	 *
	 * @param int  $parent_id  Parent category id.
	 * @param bool $hide_empty Whether empty categories should be hidden.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_child_items( $parent_id, $hide_empty ) {
		$terms = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => $hide_empty,
				'parent'     => absint( $parent_id ),
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return array();
		}

		$children = array();

		foreach ( $terms as $term ) {
			$url = get_term_link( $term );
			if ( is_wp_error( $url ) ) {
				continue;
			}

			$children[] = array(
				'id'    => $term->term_id,
				'label' => $term->name,
				'url'   => $url,
			);
		}

		return $children;
	}
}

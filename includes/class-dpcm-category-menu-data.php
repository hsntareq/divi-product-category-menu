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
	 * Build taxonomy navigation data.
	 *
	 * @param array<string, mixed> $args Query settings.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_taxonomy_navigation( $args = array() ) {
		$defaults = array(
			'include_categories' => '',
			'hide_empty'         => 'off',
			'show_subcategories' => 'on',
		);

		$args = wp_parse_args( $args, $defaults );

		$taxonomies = array(
			'product_cat'   => esc_html__( 'Product by Category', 'divi-product-category-menu' ),
			'product_brand' => esc_html__( 'Product by Brand', 'divi-product-category-menu' ),
		);

		$navigation = array();

		foreach ( $taxonomies as $taxonomy => $label ) {
			if ( ! taxonomy_exists( $taxonomy ) ) {
				continue;
			}

			$terms = self::get_terms_for_taxonomy( $taxonomy, $args );
			if ( empty( $terms ) ) {
				continue;
			}

			$navigation[] = array(
				'key'          => $taxonomy,
				'label'        => $label,
				'terms'        => $terms,
				'hierarchical' => is_taxonomy_hierarchical( $taxonomy ),
			);
		}

		return $navigation;
	}

	/**
	 * Build the top-level menu tree.
	 *
	 * @param array<string, mixed> $args Query settings.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	public static function get_menu_tree( $args = array() ) {
		$terms = self::get_terms_for_taxonomy( 'product_cat', $args );

		return is_array( $terms ) ? $terms : array();
	}

	/**
	 * Get terms for a taxonomy.
	 *
	 * @param string               $taxonomy Taxonomy key.
	 * @param array<string, mixed> $args     Query settings.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_terms_for_taxonomy( $taxonomy, $args ) {
		$hide_empty      = 'on' === $args['hide_empty'];
		$is_hierarchical = is_taxonomy_hierarchical( $taxonomy );

		$query_args = array(
			'taxonomy'   => $taxonomy,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => $hide_empty,
		);

		if ( $is_hierarchical ) {
			$query_args['parent'] = 0;
		}

		if ( 'product_cat' === $taxonomy ) {
			$include_ids = self::parse_term_ids( $args['include_categories'] );
			if ( ! empty( $include_ids ) ) {
				$query_args['include'] = $include_ids;
			}
		}

		$terms = get_terms( $query_args );
		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return array();
		}

		$items = array();

		foreach ( $terms as $term ) {
			$url = get_term_link( $term );
			if ( is_wp_error( $url ) ) {
				continue;
			}

			$children = array();
			if ( 'on' === $args['show_subcategories'] && $is_hierarchical ) {
				$children = self::get_child_items( $taxonomy, $term->term_id, $hide_empty );
			}

			$items[] = array(
				'id'       => $term->term_id,
				'label'    => $term->name,
				'url'      => $url,
				'children' => $children,
			);
		}

		return $items;
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
	 * @param string $taxonomy   Taxonomy key.
	 * @param int    $parent_id  Parent term id.
	 * @param bool   $hide_empty Whether empty terms should be hidden.
	 *
	 * @return array<int, array<string, mixed>>
	 */
	private static function get_child_items( $taxonomy, $parent_id, $hide_empty ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'hide_empty' => false,
				'parent'     => absint( $parent_id ),
			)
		);

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return array();
		}

		$children = array();

		foreach ( $terms as $term ) {
			if ( $hide_empty && ! self::term_is_effectively_non_empty( $taxonomy, $term ) ) {
				continue;
			}

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

	/**
	 * Determine whether a term should be considered non-empty.
	 *
	 * A term is treated as non-empty when it has direct products, or when any
	 * descendant term has products.
	 *
	 * @param string  $taxonomy Taxonomy key.
	 * @param WP_Term $term     Taxonomy term.
	 *
	 * @return bool
	 */
	private static function term_is_effectively_non_empty( $taxonomy, $term ) {
		if ( ! empty( $term->count ) ) {
			return true;
		}

		if ( ! is_taxonomy_hierarchical( $taxonomy ) ) {
			return false;
		}

		$non_empty_descendant = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => true,
				'child_of'   => absint( $term->term_id ),
				'number'     => 1,
				'fields'     => 'ids',
			)
		);

		if ( is_wp_error( $non_empty_descendant ) ) {
			return false;
		}

		return ! empty( $non_empty_descendant );
	}
}

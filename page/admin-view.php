<?php
/**
 * Pods Shortcode list
 */
function admin_shortcode_list_view() {

	$pods = pods_api()->load_pods( 
		array( 
			'fields' => false, 
			'type' => array( 'post_type' ),
		) 
	);

	if (empty( $pods)) {		
		echo "登録された".__( 'Custom Post Type', 'pods' )."はありません !";
		return ;
	}

	$view = pods_v( 'view', 'get', 'all', true );

	$types = array(
		'post_type' => __( 'Post Type (extended)', 'pods' ),
		'taxonomy'  => __( 'Taxonomy (extended)', 'pods' ),
		'cpt'       => __( 'Custom Post Type', 'pods' ),
		'ct'        => __( 'Custom Taxonomy', 'pods' ),
		'user'      => __( 'User (extended)', 'pods' ),
		'media'     => __( 'Media (extended)', 'pods' ),
		'comment'   => __( 'Comments (extended)', 'pods' ),
		'pod'       => __( 'Advanced Content Type', 'pods' ),
		'settings'  => __( 'Custom Settings Page', 'pods' ),
	);

	$row = false;

	$pod_types_found = array();

	$fields = array(
		'label'       => array( 
			'label' => __( 'Label', 'pods' ),
			'width' => '10%',
		),
		'name'        => array( 
			'label' => __( 'Name', 'pods' ),
			'width' => '10%',
		),
		'add_edit_shortcode'   => array(
			'label' => __( 'Add / Edit Shortcode', 'pods' ),
			'width' => '20%',
		),
		'add_edit_url'   => array(
			'label' => __( 'Add / Edit Page Url', 'pods' ),
			'width' => '20%',
		),
		'list_shortcode'   => array(
			'label' => __( 'List Shortcode', 'pods' ),
			'width' => '20%',
		),
		'list_url'   => array(
			'label' => __( 'List Page Url', 'pods' ),
			'width' => '20%',
		),
	);

	$total_fields = 0;

	foreach ( $pods as $k => $pod ) {

		if ( isset( $types[ $pod['type'] ] ) ) {
			if ( in_array(
				$pod['type'], array(
					'post_type',
					'taxonomy',
				), true
			) ) {
				if ( empty( $pod['object'] ) ) {
					if ( 'post_type' === $pod['type'] ) {
						$pod['type'] = 'cpt';
					} else {
						$pod['type'] = 'ct';
					}
				}
			}

			if ( ! isset( $pod_types_found[ $pod['type'] ] ) ) {
				$pod_types_found[ $pod['type'] ] = 1;
			} else {
				$pod_types_found[ $pod['type'] ] ++;
			}

			if ( 'all' !== $view && $view !== $pod['type'] ) {
				unset( $pods[ $k ] );

				continue;
			}

			$pod['real_type'] = $pod['type'];
			$pod['type']      = $types[ $pod['type'] ];
		} elseif ( 'all' !== $view ) {
			continue;
		}//end if

		// @codingStandardsIgnoreLine
		if ( $pod['id'] == pods_v( 'id' ) && 'delete' !== pods_v( 'action' ) ) {
			$row = $pod;
		}

		$pod = array(
			'id'          => $pod['id'],
			'label'       => pods_v( 'label', $pod ),
			'name'        => pods_v( 'name', $pod ),
			'type'        => pods_v( 'type', $pod ),
			'field_count' => count( $pod['fields'] ),
			'add_edit_shortcode' => '[post-edit slug="'.pods_v( 'name', $pod ).'"]',
			'add_edit_url' => home_url().'/'.pods_v( 'name', $pod ).'-edit',
			'list_shortcode' => '[post-list slug="'.pods_v( 'name', $pod ).'"]',
			'list_url' => home_url().'/'.pods_v( 'name', $pod ).'-list',
		);

		$total_fields += $pod['field_count'];

		$pods[ $k ] = $pod;
	}//end foreach

	if ( false === $row && 0 < pods_v( 'id' ) && 'delete' !== pods_v( 'action' ) ) {
		pods_message( 'Pod not found', 'error' );

		// @codingStandardsIgnoreLine
		unset( $_GET['id'], $_GET['action'] );
	}

	$ui = array(
		'data'             => $pods,
		'row'              => $row,
		'total'            => count( $pods ),
		'total_found'      => count( $pods ) - 1,
		'items'            => 'Pods',
		'item'             => 'Pod',
		'actions_hidden' => array(
			'edit', 'duplicate', 'delete', 'add',
		),
		'fields'           => array(
			'manage' => $fields,
		),
		'search'           => false,
		'searchable'       => false,
		'sortable'         => true,
		'pagination'       => false,
	);

	if ( 1 < count( $pod_types_found ) ) {
		$ui['views']            = array( 'all' => __( 'All', 'pods' ) );
		$ui['view']             = $view;
		$ui['heading']          = array( 'views' => __( 'Type', 'pods' ) );
		$ui['filters_enhanced'] = true;

		foreach ( $pod_types_found as $pod_type => $number_found ) {
			$ui['views'][ $pod_type ] = $types[ $pod_type ];
		}
	}

	pods_ui( $ui );

}


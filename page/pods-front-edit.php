<?php

function pods_front_edit( $att, $content = null ) {

	$cpt_slug = $att['slug'];

	if(!pod_front_user_logged_in_check()){
		return;
	}

	$service_id = pod_front_is_valid_id();

	global $current_user;
	$user_id = $current_user->ID;

	if($service_id == 0){
		$mypod = pods( $cpt_slug );
	}else {
		$mypod = pods( $cpt_slug, $service_id );

		if ( $mypod->field( 'post_author' ) != $user_id ) {
			pod_front_to_404();
		}

		if (! $mypod->exists() ) {
			pod_front_to_404();
		}
	}

	/*
	* Viewの表示
	*/
	ob_start(); 

	$fields = array(
		'name'	   => array( 
			'label' => 'タイトル',
			'required' => 1,
		),
	);

	$options = get_pod_detail($cpt_slug)['options'];

	if ( $options['supports_editor'] == '1' ) {
		
		$fields['content'] = array( 
			'label' => '記事',
			'type' => 'wysiwyg',
		);
		
	}

	$pod_fields = get_pod_detail($cpt_slug)['fields'];

	$fields = array_merge($fields, $pod_fields);

	echo $mypod->form( $fields, '登録', home_url() . '/?p=X_ID_X' );
	
	return ob_get_clean();
}
add_shortcode('post-edit', 'pods_front_edit');

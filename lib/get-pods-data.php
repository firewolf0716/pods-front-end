<?php

function get_pod_detail( $name )
{
	$pod = pods_api()->load_pod( 
		array( 
			'fields' => false, 
			'type' => array( 'post_type', 'pod'), 
			'name' => $name 
		) 
	);

 	return $pod;
}

function get_pod_taxonomies($theID)
{
	$post_type  = get_post_type($theID);
	$taxonomies = get_object_taxonomies($post_type, 'objects');

	return (array) $taxonomies; 
}

function pod_front_user_logged_in_check()
{
	if (!is_user_logged_in()) 
	{
		echo "このページを表示するためにはログインが必要です。<br>";
		echo "<a href='".home_url('/usr-login')."'>こちら</a>からログインしてください。";

		return false;
	}
	return true;
}

function pod_front_is_valid_id($id = "")
{
	if(!is_admin())
	{
		if(empty($id) && isset($_GET['id'])) 
			$id = htmlspecialchars($_GET['id']);

		if( !is_numeric($id) )
			pod_front_to_404();
	}
	return $id;
}

function pod_front_to_404()
{
	?>
	<script type="text/javascript">
		window.location="<?=home_url('/404'); ?>";
	</script>
	<?php
	wp_die();
}
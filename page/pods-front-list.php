<?php

function pods_front_list( $att, $content = null ) {

	$cpt_slug = $att['slug'];
	
	if(!pod_front_user_logged_in_check()){
		return;
	}

	global $current_user;
	$user_id = $current_user->ID;

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	$args = array(
		'author' => $user_id,
		'post_type' => $cpt_slug,
		'post_status' => array('publish', 'pending', 'draft', 'private'),
		'paged' => $paged,
		'posts_per_page' => 100,
		'order_by' => 'modified',
	);

	$the_query = new WP_Query( $args );

	$pod_label = get_pod_detail( $cpt_slug )['label'];

	/*
	* Viewの表示
	*/
	ob_start();
	?>
	<div class='section padding_10'>
		<div id="infoListContent">
			<div id="infoListWrapper" class="bottom_20">
				<?php if ( $the_query->have_posts() ) : ?>
				<div class="my-service-list">
					<div class="my-service-list-header-inner">
						<div class="my-service-list-item service-name"><?= $pod_label ?></div>
						<div class="my-service-list-item modified-dt">更新日</div>
						<div class="my-service-list-item note"></div>
						<div class="my-service-list-item edit"></div>
					</div>

					<?php /* Start the Loop */ ?>
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div class="my-service-list-inner">
							<div class="my-service-list-item service-name">
								<?php
								if(get_post_status(get_the_ID())==='draft'){
									the_title( '<div class="entry-title">', '</div>' );
								}else{
									the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' );
								}
								?>
							</div>
							<div class="my-service-list-item modified-dt"><?= get_the_modified_date()  ?></div>
							<div class="my-service-list-item note">
								<?php
									if(get_post_status(get_the_ID())==='draft'){
										echo "承認されるまで表示できません";
									}
								?>
							</div>
							<div class="my-service-list-item edit">
								<?php
								if(get_post_status(get_the_ID())==='draft'){
								}else{ ?>									
									<a href="<?= home_url() . '/' . $cpt_slug . '-edit/?id=' . get_the_ID() ?>">編集</a>
								<?php } ?>
							</div>
						</div>

						<?php wp_reset_postdata(); ?>
					<?php endwhile; ?>
					<?php
					$big = 999999999; // need an unlikely integer

					echo "<div class='nav-links'>";
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'end_size' => 0,
						'mid_size' => 0,
						'prev_text' => '<span>前へ</span>',
						'next_text' => '<span>次へ</span>',
						'total' => $the_query->max_num_pages
					) );
					echo "</div>";
					?>
				</div>

				<?php else : ?>
					<div>登録された<?=$pod_label?>はありません</div>
				<?php endif; ?>

			</div>
		</div>

	</div>
<?php
	return ob_get_clean();
}
add_shortcode('post-list', 'pods_front_list');

<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Seedlet
 * @since 1.0.0
 */

// query
$the_query = new WP_Query(array(
	'post_type'			=> 'events',
	'posts_per_page'	=> -1,
    'orderby' => 'meta_value ',     
    'meta_key' => 'timestamp', 
    'order' => 'ASC',
	'meta_query'=> array(
		array(
            'key' => 'timestamp',
			'value' => date("Y-m-d H:i:s"),
			'compare' => '>=',
			'type' => 'DATE'
        ),
	),
));

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header default-max-width">
				<?php the_archive_title(); ?>
				<?php the_archive_description('<div class="archive-description">', '</div>'); ?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
				<div class="row">
					<?php
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

						$time = time();
						$today = date("Y-m-d H:i:s", $time);	
						$event_date = get_field('timestamp');
		         		$date1 = new DateTime($today);
						$date2 = new DateTime($event_date);
						$interval = $date1->diff($date2);
						echo " in " . $interval->d . " day(s) " . $interval->h . " hour(s) ". $interval->i . " minute(s) " . $interval->s . " second(s)"; 
					?>
				</div>
				<?php
				// End the loop.
			endwhile;
		endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

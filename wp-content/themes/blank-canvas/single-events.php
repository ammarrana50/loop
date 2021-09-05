<?php
/**
 * The template for displaying all single events
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Blank Canvas
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main container" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
				<div class="single-event ">
					<?php the_title( sprintf( '<h2 class="entry-title">' ), '</h2>' );
					the_content();
					?>
					<div class="event-fields">
						<div class="field">Event ID: <?php the_field('id'); ?></div>
						<div class="field">Orgranizer: <?php the_field('organizer'); ?></div>
						<div class="field">Timestamp: <?php the_field('timestamp'); ?></div>
						<div class="field">E-Mail: <?php the_field('email'); ?></div>
						<div class="field">Address: <?php the_field('address'); ?></div>
						<div class="field">Latitude: <?php the_field('latitude'); ?></div>
						<div class="field">Longitude: <?php the_field('longitude'); ?></div>
					</div>
				</div>
			<?php
			endwhile; // End of the loop.
			?>
			<a href="/loop/events">All Events</a>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

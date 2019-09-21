<?php
/**
 * The template for displaying archive pages.
 *
 * @package Beyond The Conversation
 */

get_header('events'); ?>

			<div id="primary" class="events-content-area">
				<main id="main" class="site-main" role="main">

				<?php $query_upcoming = new WP_Query( array(
					'post_type'  => 'event',
					'posts_per_page' => 10,
					'meta_query' => array (
						array(
						'key' => 'date',
						'value' => date('Y-m-d', strtotime("today")),
						'type' => 'DATE',
						'compare' => '>='
						)
					)
				) ); ?>

		<?php if ( $query_upcoming->have_posts() ) : ?>

			<header class="page-header">
				
					<h1 class="page-title">Upcoming events</h1>
				
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( $query_upcoming->have_posts() ) : $query_upcoming->the_post(); ?>

					<div class="event">
						<?php $dateTime = DateTime::createFromFormat('Y-m-d', get_post_meta($query_upcoming->post->ID, 'date', true ));?>
						<h2 class="event-date"><?php echo $dateTime->format('F j');?></h2>
						<p class="event-time"><?php echo get_post_meta($query_upcoming->post->ID, 'time', true ); ?></p>
						<p class="event-location"><?php echo get_post_meta($query_upcoming->post->ID, 'location', true ); ?></p>
						<p class="event-type"><?php echo get_post_meta($query_upcoming->post->ID, 'event_type', true ); ?></p>
						<p class="event-title"><?php echo $query_upcoming->post->post_title; ?></p>
						<div class="event-description"><?php echo $query_upcoming->post->post_content; ?></div>

						<a class="event-rsvp" href="<?php echo get_post_meta($query_upcoming->post->ID, 'rsvp', true )['url']; ?>"
						 target="<?php echo get_post_meta($query_upcoming->post->ID, 'rsvp', true )['target']; ?>">
						 <?php echo get_post_meta($query_upcoming->post->ID, 'rsvp', true )['text']; ?></a>
					</div>


			<?php endwhile; ?>


			<a href="#" id="loadMore1">Load More</a>

			<p class="meet-ups">We also host weekly meet-ups in your local area.</p>
			<a class="link-find-us" href="<?php echo get_permalink( get_page_by_path( 'find-us' ) ) ?>">See your nearest locations<i class="fas fa-arrow-right"></i></a>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		


			<?php $query_past = new WP_Query( array(
					'post_type'  => 'event',
					'posts_per_page' => 6,
					'orderby'   => 'meta_value',
        			'order' => 'DESC',
					'meta_query' => array (
						array(
							'key' => 'date',
							'value' => date('Y-m-d', strtotime("today")),
							'type' => 'DATE',
							'compare' => '<='
						)
					)
				) ); ?>

		<?php if ( $query_past->have_posts() ) : ?>

			<header class="page-header">
				
					<h1 class="page-title">Past events</h1>
				
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( $query_past->have_posts() ) : $query_past->the_post(); ?>

					<div class="past-event">
						
						<p class="event-title"><?php echo $query_past->post->post_title; ?></p>
						<div class="event-description"><?php echo $query_past->post->post_content; ?></div>
						
						<?php $image_id = get_post_meta($query_past->post->ID, 'image', true );?>
						<img class="event-image" src="<?php echo wp_get_attachment_url( $image_id ) ; ?>">

					</div>
			<?php endwhile; ?>

			<a href="#" id="loadMore2">Load More</a>


			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
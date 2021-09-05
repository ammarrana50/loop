<?php
/*
	Plugin Name: Event Manager
	Description: Import/Export Events for CPTs from JSON File using WP_CLI.
	Author: Ammar
	Version: 0.1
*/

if (!defined('WP_CLI')) {
	//Then we don't want to load the plugin
	return;
}

class LOOP_WP_CLI_COMMANDS extends WP_CLI_Command
{

	function import_events_from_json()
	{

		echo "Importing Events...\n";
		// Read the JSON file 
		$json = file_get_contents(__DIR__ . '/events.json');

		// Decode the JSON file
		$json_data = json_decode($json, true);

		// Counters
		$count_updated_posts = 0;
		$count_new_imported_posts = 0;

		// Create the new post and populate the fields
		foreach ($json_data as &$item) {
			$id = $item['id'];
			$title = $item['title'];
			$about = $item['about'];
			$organizer = $item['organizer'];
			$time_stamp = $item['timestamp'];
			$email = $item['email'];
			$address = $item['address'];
			$latitude = $item['latitude'];
			$longitude = $item['longitude'];
			$tags_array = $item['tags'];

			if (get_post_status($id)) {
				$update_post = array(
					'ID' => $id,
					'post_title' => $title,
					'post_content' => $about,
					'post_status' =>  'publish',
					'post_type' => 'events',
					'tags_input' => $tags_array,
					'meta_input' => array(
						'id' => $id,
						'organizer' => $organizer,
						'timestamp' => $time_stamp,
						'email' => $email,
						'address' => $address,
						'latitude' => $latitude,
						'longitude' => $longitude,
					),
				);
				$post_id = wp_insert_post($update_post);
				$count_updated_posts++;
			} else {
				$new_post = array(
					'import_id' => $id,
					'post_title' => $title,
					'post_content' => $about,
					'post_status' =>  'publish',
					'post_type' => 'events',
					'tags_input' => $tags_array,
					'meta_input' => array(
						'id' => $id,
						'organizer' => $organizer,
						'timestamp' => $time_stamp,
						'email' => $email,
						'address' => $address,
						'latitude' => $latitude,
						'longitude' => $longitude,
					),
				);
				$post_id = wp_insert_post($new_post);
				$count_new_imported_posts++;
			}
		}
		echo "Import Complete\n";
		echo "New Posts: " . $count_new_imported_posts;
		echo "\nUpdated Posts: " . $count_updated_posts;
		echo "\n";

		$to_email = "logging@agentur-loop.com";
		$subject = "Event Import Update";
		$body = "New Posts: " . $count_new_imported_posts . "\nUpdated Posts: " . $count_updated_posts;
		$headers = "From: sender\'s email";
		echo "Sending E-mail update...";

		if (mail($to_email, $subject, $body, $headers)) {
			echo "Email successfully sent to $to_email";
		} else {
			echo "Email sending failed...";
		}
	}

	function export_events_in_json()
	{

		$args = array(
			'post_type' => 'events',
			'posts_per_page' => -1,
			'post_status' => 'any',
			'orderby' => 'meta_value ',
			'meta_key' => 'timestamp',
			'order' => 'ASC',
		);

		$query = new WP_Query($args);
		$events = array();

		while ($query->have_posts()) : $query->the_post();
			$id = get_field('id');
			$about = get_the_content();
			$organizer = get_field('organizer');
			$time_stamp = get_field('timestamp');
			$email = get_field('email');
			$address = get_field('address');
			$latitude = get_field('latitude');
			$longitude = get_field('longitude');
			$tags_array = get_the_tags();
			$tags_name = array();
			if ($tags_array) {
				foreach ($tags_array as $tag) {
					$tags_name[] = $tag->name;
				}
			}

			$events[] = array(
				'id' => $id,
				'title' => get_the_title(),
				'about' => $about,
				'organizer' => $organizer,
				'timestamp' => $time_stamp,
				'email' => $email,
				'address' => $address,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'tags' => $tags_name,
			);

		endwhile;

		wp_reset_query();

		$data = json_encode($events);
		echo "JSON Encoding...\n";
		$upload_dir = wp_get_upload_dir();
		$file_name = 'events_export.json';
		$save_path = $upload_dir['basedir'] . '/' . $file_name;

		$f = fopen($save_path, "w");
		fwrite($f, $data);
		echo "Writing JSON...\n";
		fclose($f);
	}

	function delete_all_events() {
		$events= get_posts( array('post_type'=>'events','numberposts'=>-1) );
		echo "Deleting Events...";

		foreach ($events as $event) {
			wp_delete_post( $event->ID, true );
		}
		echo "\nAll Events Deleted.";
	}
}

WP_CLI::add_command('loop', 'LOOP_WP_CLI_COMMANDS');

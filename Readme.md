# LOOP Event Manager

## Setup

Clone this repository inside `htdocs` directory on your localhost or your server.

## Working with WP_CLI

### Pre-Req
wp_cli should be installed to execute the commands.  
SMTP server should be setup to send an email.

### Commands
Place the `events.json` file in `\wp-content\plugins\event-manager`  
Execute `wp loop import_events_in_json` to import all the events from JSON file.   
Execute `wp loop export_events_in_json` to export all the events to JSON file.   
Execute `wp loop delete_all_events` to delete all the existing events in WordPress.   

## Endpoints/URLs
Send a GET request `https://localhost/loop/wp-json/api/v1/events` to fetch all events in JSON format.
List all events in event archive: `https://localhost/loop/events/`
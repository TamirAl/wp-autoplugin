<?php
namespace WP_Autoplugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin_Generator {
	private $ai_api;

	public function __construct( $ai_api ) {
		$this->ai_api = $ai_api;
	}

	public function generate_plugin_plan( $input ) {
		$prompt = "Generate a detailed technical specification and development plan for a WordPress plugin with the following features:

$input

The plugin must be contained within a single file, including all necessary code. Do not write the actual plugin code. Your response should be a valid JSON object, with clear and concise text in each of the following sections:

plugin_name: Provide a concise name for the plugin.
design_and_architecture: Outline the overall design and architecture of the plugin, including data flow and major components.
detailed_feature_description: Provide a detailed description of each feature, explaining how it should be implemented.
user_interface: Describe the user interface elements and how users will interact with the plugin.
security_considerations: Discuss any security measures that need to be incorporated to ensure the plugin's safety.
testing_plan: Outline a plan for testing the plugin to ensure it functions correctly. There will be no test suite for the plugin, you just have to explain how the plugin works, so it can be tested correctly. The user may not be technical, so the plan should be clear and easy to follow.

Do not add any additional commentary. Make sure your response only contains a valid JSON object with the specified sections. Do not use Markdown formatting in your answer.";
		return $this->ai_api->send_prompt( $prompt, '', array( 'response_format' => array( 'type' => 'json_object' ) ) );
	}

	public function generate_plugin_code( $plan ) {
		$prompt = "Build a single-file WordPress plugin based on the specification below. Do not use Markdown formatting in your answer. Ensure the response does not contain any explanation or commentary, ONLY the complete, working code without any placeholders. \"Add X here\" comments are not allowed in the code, you need to write out the full, working code.\n\n$plan\n\nImportant: all code should be self-contained within one PHP file and follow WordPress coding standards. Use appropriate hooks, actions, and filters as necessary. Always use \"WP-Autoplugin\" for the Author of the plugin, with Author URI: https://wp-autoplugin.com. Do not add the final closing \"?>\" tag in the PHP file.";
		return $this->ai_api->send_prompt( $prompt );
	}
}
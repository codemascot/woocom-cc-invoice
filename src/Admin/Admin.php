<?php # -*- coding: utf-8 -*-

namespace TheDramatist\WooComCCInvoice\Admin;

class Admin {
	
	public function __construct() {
	
	}
	
	public function init() {
		add_action(
			'woocom-cc-invoice_plugin_activate',
			[ $this, 'activation_hook' ]
		);
		add_action(
			'admin_menu',
			[ $this, 'admin_menu' ]
		);
		add_action(
			'admin_init',
			[ $this, 'admin_init' ]
		);
	}
	
	public function activation_hook() {
		$options = get_option( 'wcis_options' );
		if ( false !== $options ) {
			return;
		}
		add_option( 'wcis_options', [
			'form_title'         => __(
				'Share Your Invoice',
				'woocom-cc-invoice'
			),
			'help_message'       => __(
				'Enter an email address to share your invoice.',
				'woocom-cc-invoice'
			),
			'button_text'        => __( 'Share Invoice', 'woocom-cc-invoice' ),
			'input_placeholder'  => __( 'Enter Email', 'woocom-cc-invoice' ),
			'success_message'    => __(
				'Success! Your invoice has been sent, send another?',
				'woocom-cc-invoice'
			),
			'email_message'      => __(
				'Invalid email address, please try again.',
				'woocom-cc-invoice'
			),
			'order_message'      => __(
				'Invalid order number, please refresh and try again.',
				'woocom-cc-invoice'
			),
			'account_message'    => __(
				'Invalid account, please make sure you are logged in and try again.',
				'woocom-cc-invoice'
			),
			'default_message'    => __(
				'Something went wrong, please refresh the page and try again.',
				'woocom-cc-invoice'
			),
			'order_received'     => 'on',
			'order_received_top' => 'on',
			'view_order'         => 'on',
		], '', false );
	}
	
	public function admin_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Invoice Sharing', 'woocom-cc-invoice' ),
			__( 'Invoice Sharing', 'woocom-cc-invoice' ),
			'edit_posts',
			'woocom-cc-invoice-settings',
			[ $this, 'admin_menu_render' ]
		);
	}
	
	/**
	 * Share Order Settings Page - Allows users to
	 * control various options for the plugin.
	 *
	 * @return void Prints HTML form
	 */
	public function admin_menu_render() { ?>
		<div class="wrap wcis_wrap">
			<h2>Invoice Sharing Settings</h2>
			<form action="options.php" method="post">
				<?php settings_fields('wcis_options'); ?>
				<?php do_settings_sections('wcis_options_page'); ?>
				<input name="Submit" type="submit" class="button button-primary button-large" value="Save Changes" />
			</form>
		</div><!-- .wrap -->
		<?php
	}
	
	/*
	*	Register WSO Admin Menu Settings
	*
	*	@return void
	*/
	public function admin_init() {
		register_setting(
			'wcis_options',
			'wcis_options',
			'wcis_validate_options'
		);
		add_settings_section(
			'wcis_settings',
			'',
			'wcis_settings_help_text',
			'wcis_options_page'
		);
		add_settings_field(
			'wcis_form_options',
			'Update Form Values',
			[ $this, 'form_options' ],
			'woocom-cc-invoice-options-page',
			'wcis_settings'
		);
		add_settings_field(
			'wcis_messages_field',
			'Update Message Values',
			'wcis_message_input',
			'wcis_options_page',
			'wcis_settings'
		);
		add_settings_field(
			'wcis_output_select_field',
			'Upate Positioning',
			'wcis_page_input',
			'wcis_options_page',
			'wcis_settings'
		);
	}
	
	/*
	*	Settings Help Text
	*
	*	@return void Prints HTML message
	*/
	function wcis_settings_help_text() {
		// echo "Help Text";
	}
	
	/*
	*	Messages Input Section - Allow the user to customize the
	* 	messages displayed throughout the plugin.
	*
	*	@return void Prints HTML form
	*/
	function form_options() {
		
		$options = get_option( 'wcis_options' );
		
		if ($options == false) {
			$options = array();
		}
		
		$defaults = array(
			'form_title'		=> 'Share Your Invoice',
			'help_message'		=> 'Enter an email address to share your invoice.',
			'button_text' 		=> 'Share Invoice',
			'input_placeholder' => 'Enter Email'
		);
		
		$options = wp_parse_args($options, $defaults);
		extract($options);
		
		?>
		<div id="wcis_form_options">
			<label for="wcis_options[form_title]">Form Title</label>
			<input type="text" name="wcis_options[form_title]" value="<?php echo $form_title ?>" />
			
			<label for="wcis_options[help_message]">Help Message</label>
			<input type="text" name="wcis_options[help_message]" value="<?php echo $help_message ?>" />
			
			<label for="wcis_options[button_text]">Button Text</label>
			<input type="text" name="wcis_options[button_text]" value="<?php echo $button_text ?>" />
			
			<label for="wcis_options[input_placeholder]">Input Placeholder</label>
			<input type="text" name="wcis_options[input_placeholder]" value="<?php echo $input_placeholder ?>" />
		</div>
		<?php
	}
	
	
	/*
	*	Messages Input Section - Allow the user to customize the messages displayed
	* 	throughout the plugin.
	*
	*	@return void Prints HTML form
	*/
	function wcis_message_input() {
		
		$options = get_option( 'wcis_options' );
		
		if ($options == false) {
			$options = array();
		}
		
		$defaults = array(
			'success_message' => 'Success! Your invoice has been sent, send another?',
			'email_message'	=> 'Invalid email address, please try again.',
			'order_message'	=> 'Invalid order number, please refresh and try again.',
			'account_message'=> 'Invalid account, please make sure you are logged in and try again.',
			'default_message'=> 'Something went wrong, please refresh the page and try again.'
		);
		
		$options = wp_parse_args($options, $defaults);
		extract($options);
		
		?>
		<div id="wcis_message_options">
			
			<label for="wcis_options[success_message]">Success Message</label>
			<input type="text" name="wcis_options[success_message]" value="<?php echo $success_message ?>" />
			
			<label for="wcis_options[email_message]">Invalid Email Message</label>
			<input type="text" name="wcis_options[email_message]" value="<?php echo $email_message ?>" />
			
			<label for="wcis_options[order_message]">Invalid Order Message</label>
			<input type="text" name="wcis_options[order_message]" value="<?php echo $order_message ?>" />
			
			<label for="wcis_options[account_message]">Invalid Account Message</label>
			<input type="text" name="wcis_options[account_message]" value="<?php echo $account_message ?>" />
			
			<label for="wcis_options[default_message]">Default Error Message</label>
			<input type="text" name="wcis_options[default_message]" value="<?php echo $default_message ?>" />
		</div>
		<?php
	}
	
	/*
	*	Page Options - Allow the user to decide which page to display
	*	the form on.
	*
	*	@return void Prints html form
	*/
	function wcis_page_input() {
		
		$options = get_option( 'wcis_options' );
		
		if ($options == false) {
			$options = array();
		}
		
		$defaults = array(
			'order_received' 		=> 'on',
			'order_received_top' 	=> 'on',
			'view_order'			=> 'on',
		);
		
		$options = wp_parse_args($options, $defaults);
		extract($options);
		
		?>
		
		<div id="wcis_page_options">
			
			<div>
				<input type="checkbox" name="wcis_options[order_received]" <?php if ( $order_received == 'on' ) echo 'checked' ?> />
				<label for="wcis_options[order_received]">Display on Order Received Page</label>
			</div>
			
			<div>
				<input type="checkbox" name="wcis_options[order_received_top]" <?php if ( $order_received_top == 'on' ) echo 'checked' ?> />
				<label for="wcis_options[order_received_top]">Top of Order Received Page? (Unchecked will display the form at the bottom)</label>
			</div>
			
			<div>
				<input type="checkbox" name="wcis_options[view_order]" <?php if ( $view_order == 'on' ) echo 'checked' ?> />
				<label for="wcis_options[view_order]">Display on View Order Page</label>
			</div>
		</div>
		
		<?php
	}
	
	/*
	*	Validation Settings
	*
	*	@param	array	$input
	*	@return	array	$input
	*/
	function wcis_validate_options( $input ) {
		
		$input['form_title'] = strip_tags( $input['form_title'] );
		$input['help_message'] = strip_tags( $input['help_message'] );
		$input['button_text'] = strip_tags( $input['button_text'] );
		$input['input_placeholder'] = strip_tags( $input['input_placeholder'] );
		$input['success_message'] = strip_tags( $input['success_message'] );
		$input['email_message'] = strip_tags( $input['email_message'] );
		$input['order_message'] = strip_tags( $input['order_message'] );
		$input['account_message'] = strip_tags( $input['account_message'] );
		$input['default_message'] = strip_tags( $input['default_message'] );
		
		if ( ! isset( $input['order_received'] ) ) {
			$input['order_received'] = '';
		}
		
		if ( ! isset( $input['order_received_top'] ) ) {
			$input['order_received_top'] = '';
		}
		
		if ( ! isset( $input['view_order'] ) ) {
			$input['view_order'] = '';
		}
		
		return $input;
	}
	
}
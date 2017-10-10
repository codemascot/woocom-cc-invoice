<?php # -*- coding: utf-8 -*-

namespace TheDramatist\WooComCCInvoice\Assets;

/**
 * Class AssetsEnqueue
 *
 * @package TheDramatist\WooComCCInvoice\Assets
 */
class AssetsEnqueue {

	/**
	 * AssetsEnqueue constructor.
	 */
	public function __construct() {

	}

	/**
	 * Enqueueing scripts and styles.
	 * @return void
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );
	}

	/**
	 * Enqueueing styles.
	 * @return void
	 */
	public function styles() {
		wp_enqueue_style(
			'woocom-cc-invoice-css',
			plugin_dir_url( __FILE__ ) . '../../assets/css/woocom-cc-invoice.css',
			null,
			'1.0.0',
			'all'
		);
	}

	/**
	 * Enqueueing scripts.
	 * @return void
	 */
	public function scripts() {
		// Registering the script.
		wp_register_script(
			'woocom-cc-invoice-js',
			plugin_dir_url( __FILE__ ) . '../../assets/js/woocom-cc-invoice.js',
			[ 'jquery' ],
			'1.0.0',
			true
		);
		// Local JS data
		$local_js_data = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
		);
		// Pass data to myscript.js on page load
		wp_localize_script(
			'woocom-cc-invoice-js',
			'WPAjaxObj',
			$local_js_data
		);
		// Enqueueing JS file.
		wp_enqueue_script( 'woocom-cc-invoice-js' );

	}
}
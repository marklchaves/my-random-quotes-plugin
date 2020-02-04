<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://caughtmyeye.dev/about
 * @since      1.0.0
 *
 * @package    My_Random_Quotes
 * @subpackage My_Random_Quotes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    My_Random_Quotes
 * @subpackage My_Random_Quotes/public
 * @author     mark <mark@marklchaves.com>
 */
class My_Random_Quotes_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in My_Random_Quotes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The My_Random_Quotes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/my-random-quotes-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in My_Random_Quotes_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The My_Random_Quotes_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/my-random-quotes-public.js', array('jquery'), $this->version, false);
	}

	/**
	 * Returns a post object of random quotes
	 *
	 * @param array $params An array of optional parameters
	 * quantity Number of quote posts to return
	 *
	 * @return object A post object
	 * 
	 * ~mlc 4 Feb 2020
	 */

	public function get_rdm_quotes($params)
	{
		$return = '';
		$args = array(
			'post_type' => 'rdm-quote',
			'posts_per_page' => $params,
			'orderby' => 'rand'
		);

		$query = new WP_Query($args);

		if (is_wp_error($query)) {
			$return = 'Oops!...No posts for you!';
		} else {
			$return = $query->posts;
		}

		return $return;
	} // get_rdm_quotes()

	/**
	 * Processes shortcode randomquote
	 *
	 * @param array $atts The attributes from the shortcode
	 *
	 *
	 * @return mixed $output Output of the buffer
	 * 
	 * ~mlc 4 Feb 2020
	 */

	public function list_quotes($atts = array())
	{
		ob_start();

		$args = shortcode_atts(
			array(
				'num-quotes' => 1,
				'quotes-title' => 'Words of Wisdom',
			),
			$atts
		);

		$items = $this->get_rdm_quotes($args['num-quotes']);
		//var_dump($items);

		// Let partials handle presentation.
		if (is_array($items) || is_object($items)) {
			include ('partials/my-random-quotes-public-display.php');
		} else {
			echo $items;
		}

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	} // get_rdm_quotes()

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 *
	 * ~mlc 4 Feb 2020
	 */

	public function register_shortcodes()
	{
		add_shortcode('randomquote', array($this, 'list_quotes'));
	} // register_shortcodes()
}

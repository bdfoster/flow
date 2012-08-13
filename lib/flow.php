<?php

ini_set('display_errors','On');
error_reporting(E_ERROR | E_PARSE);

define('ROOT', __DIR__ . '/..');

/* This function is called for each get route that you hav defined in
 * your index.php file. This function is a simple pass-through function
 * that hands off the route and callback to the register function of
 * Flow.
 */
function get($route, $callback) {
	Flow::register($route, $callback);
}

class Flow {
	private static $instance;
	public static $route_found = false;
	public $route = '';
	
	/* The Singleton Pattern allows our class to not just be a simple
	 * class, but also to be one object. This means that each time we
	 * call our class, we are accessing a single existing object. But
	 * if that object doesn't exist yet, we automatically create it
	 * here for us to use.
	 */
	 public static function get_instance() {
		 if (!isset(self::$instance)) {
			 self::$instance = new Flow();
		 }
		 return self::$instance;
	 }
	 
	 public function __construct() {
		 $this->route = $this->get_route();
	 }
	 
	 protected function get_route() {
		 parse_str($_SERVER['QUERY_STRING'], $route);
		 if ($route) {
			 return '/' . $route['request'];
		 } else {
			 return '/';
		 }
	 }
	 
	 public function set($index, $value) {
		 $this->vars[$index] = $value;
	 }
	 
	 public function render($view, $layout = "layout") {
		 $this->content = ROOT. '/views/'. $view . '.php';
		 foreach ($this->vars as $key => $value) {
			 $$key = $value;
		 }
		 
		 if (!$layout) {
			 include($this->content);
		 } else {
			 include(ROOT. '/views/' . $layout . '.php');
		 }
	 }
	 
	 /* This function has two parameters: $route and $callback. $route
	  * contains the route that we are attempting to match against the 
	  * actual route, and $callback is the function that will be 
	  * executed if the routes do indeed match. Notice that, at the
	  * start of the register function, we call for out Flow instance, 
	  * using the static::get_instance() function. This is the Singleton
	  * Pattern in action, returning the single instance of the Flow
	  * object to us. The register function then checks to see if the
	  * route that we visited through our browser matches the route that
	  * was passed into the function. If there is a match, our
	  * $route_found variable will be set to true, which will allow us
	  * to skip looking through the rest of the routes. The register
	  * function will then execute a callback function that will do the
	  * work that was defined by our route. Our Flow instance will also
	  * be passed with the callback function so that we can use it to 
	  * our advantage. If the route is not a match, we will return false
	  * so that we know the route was not a match.
	  */
	  
	 public static function register($route, $callback) {
		$flow = static::get_instance();
		 
		if ($route == $flow->route && !static::$route_found) {
			static::$route_found = true;
			echo $callback($flow);
		} else {
			return false;
		}
	}
}
	
	

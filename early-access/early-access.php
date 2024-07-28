<?php 
/*
 * Plugin Name: Early Access
 */

 

 function hello() {
	echo 'Hello World';
     die();
} 

add_action('init', 'hello');
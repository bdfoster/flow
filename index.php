<?php

include 'lib/flow.php';

get('/', function($app){
	echo "Home";
});

get('/signup', function($app){
	echo "Signup!";
});


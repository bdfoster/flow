<?php

include 'lib/flow.php';

get('/', function($app){
	$app->set('message', 'Welcome Back!');
	$app->render('home');
});

get('/signup', function($app){
	$app->render('signup');
});


<?php

return [
	'enable_register_routes' => false,
	'redirect_path' => '/home',

	'seed_users' => array(
		array(
			'name' => 'help',
			'email' => 'help@outdare.pt',
			'password' => 'help!uiop',
			'roles' => array('admin')
		)
	),

	'enable_roles' => true,

	'seed_roles' => array(
		array(
			'name' => 'admin',
			'description' => 'outdare admin',
		)
	),
];

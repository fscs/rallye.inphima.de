<?php

$config = array(
	'home/login' => array(
		array(
			'field' => 'password',
			'label' => 'Passwort',
			'rules' => 'trim|required|xss_clean'
		),
		array(
			'field' => 'username',
			'label' => 'Benutzername',
			'rules' => 'trim|required|xss_clean'
		)
	),
);

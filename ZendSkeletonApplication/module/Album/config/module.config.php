<?php
return array(
	'controllers' => array(
		'invokables' => array(
			'Album\Controller\Album' => 'Album\Controller\AlbumController',
		),
	),

	'router' => array(
		'routes' => array(
			'album' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/album[/][:action][/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',	//limit actions to start with a letter and then subsequent characters only being alphanumeric, underscore or hyphen
						'id' => '[0-9]+',						//limit the id to a number
					),
					'defaults' => array(
						'controller' => 'Album\Controller\Album',
						'action' => 'index',
					),
				),
			),
		),
	),

	'view_manager' => array(
		'template_path_stack' => array(
			'album' => __DIR__ . '/../view',
		),
	),
);
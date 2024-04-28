<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('editor', 'EditorController::index');
$routes->post('editor/saveContent', 'EditorController::saveContent');
$routes->post('editor/loadImage', 'EditorController::loadImage');


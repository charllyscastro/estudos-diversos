<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Editor de texto
$routes->get('editor', 'EditorController::index');
$routes->post('editor/saveContent', 'EditorController::saveContent');
$routes->post('editor/loadImage', 'EditorController::loadImage');


//Pdf
$routes->get('pdf', 'PdfController::index');
$routes->get('pdf-gerar', 'PdfController::pdf_gerar');

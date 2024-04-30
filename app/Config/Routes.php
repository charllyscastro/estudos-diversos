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
$routes->get('pdf-gerar-imagem', 'PdfController::pdf_gerar_imagem');
$routes->get('pdf-gerar-css-externo', 'PdfController::pdf_gerar_css_externo');
$routes->get('pdf-gerar-relatorio-bd', 'PdfController::pdf_gerar_relatorio_bd');

$routes->post('pdf-gerar-relatorio-filtro-bd', 'PdfController::pdf_gerar_relatorio_filtro_bd');


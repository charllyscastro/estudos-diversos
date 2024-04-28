<?php

function data_dma($data){

    return date_format(new DateTime($data), 'd/m/Y');
}

function data(){
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    return strftime('%d de %B de %Y', strtotime('today'));
}
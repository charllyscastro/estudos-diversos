<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EditorModel;
use Dompdf\Dompdf;

class PdfController extends BaseController
{
    public function index()
    {
        return view('Pdf/index');
    }

    // Exemplo para geração de pdf
    public function pdf_gerar()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf();
       
        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml('Gerar pdf de teste');

        //Configurar o tamanho e a orientação do documento
        //landscape - formato paisagem
        // portrait - formato retrato
        $dompdf->setPaper('A4', 'portrait');

        // Rederizar o HTML como PDF
        $dompdf->render();

        //Gerar o pdf
        $dompdf->stream();
    }

    // Exemplo para geração de pdf buscando os dados do BD gerados pelo editor trumbowyg
    public function pdf_gerar_editor_trumbowyg()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf();

        $artigo = new EditorModel();
       
        $artigos = $artigo->findAll();

        $data = ['artigo' => $artigos[0]->conteudo];
        
        // Testando o Css da tabela inserida no editor
        $viewPdf = view('Pdf/pdfview', $data );
       
        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml($viewPdf);

        //Configurar o tamanho e a orientação do documento
        //landscape - formato paisagem
        // portrait - formato retrato
        $dompdf->setPaper('A4', 'portrait');

        // Rederizar o HTML como PDF
        $dompdf->render();

        //Gerar o pdf
        $dompdf->stream();
    }


}
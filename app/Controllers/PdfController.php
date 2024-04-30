<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EditorModel;
use App\Models\UsuarioModel;
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

    // Exemplo para geração de pdf
    public function pdf_gerar_imagem()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf();

        $fileContent = file_get_contents(ROOTPATH . 'public/imagem.jpg');
        $base64Image = base64_encode($fileContent);
        $contentType = mime_content_type(ROOTPATH . 'public/imagem.jpg');

        $dados = '<h1>Gerar pdf com PHP</h1>';

        $dados .= '<img src="' . 'data:' . $contentType . ';base64,' . $base64Image . '" >';

        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml($dados);

        //Configurar o tamanho e a orientação do documento
        //landscape - formato paisagem
        // portrait - formato retrato
        $dompdf->setPaper('A4', 'portrait');

        // Rederizar o HTML como PDF
        $dompdf->render();

        //Gerar o pdf
        $dompdf->stream();
    }

    // Exemplo para geração de pdf com css externo
    public function pdf_gerar_css_externo()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf(['enable_remote' => true]);

        $fileContent = file_get_contents(ROOTPATH . 'public/imagem.jpg');
        $base64Image = base64_encode($fileContent);
        $contentType = mime_content_type(ROOTPATH . 'public/imagem.jpg');

        $cssContent = file_get_contents(ROOTPATH . 'public/css/custom.css');
        $base64Css = base64_encode($cssContent);
        $contentTypeCss = mime_content_type(ROOTPATH . 'public/css/custom.css');

        $dados = "<!DOCTYPE html>";
        $dados .= "<html lang='pt-br'>";
        $dados .= "<head>";
        $dados .= "<meta charset='UTF-8'>";
        $dados .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        $dados .= "<link rel='stylesheet' href='" . 'data:' . $contentTypeCss . ';base64,' . $base64Css . "'>";
        $dados .= "<title>Gerar pdf</title>";
        $dados .= "</head>";
        $dados .= "<body>";
        $dados .= "<h1>Gerar pdf com PHP</h1><br><br>";
        $dados .= "<img src='" . 'data:' . $contentType . ';base64,' . $base64Image . "' ><br><br>";
        $dados .= "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ";
        $dados .= "</body>";
        $dados .= "</html>";

        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml($dados);

        //Configurar o tamanho e a orientação do documento
        //landscape - formato paisagem
        // portrait - formato retrato
        $dompdf->setPaper('A4', 'portrait');

        // Rederizar o HTML como PDF
        $dompdf->render();

        //Gerar o pdf
        $dompdf->stream();
    }

    // Exemplo para geração de pdf relatorio do BD
    public function pdf_gerar_relatorio_bd()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf(['enable_remote' => true]);

        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->findAll();

        $fileContent = file_get_contents(ROOTPATH . 'public/imagem.jpg');
        $base64Image = base64_encode($fileContent);
        $contentType = mime_content_type(ROOTPATH . 'public/imagem.jpg');

        $cssContent = file_get_contents(ROOTPATH . 'public/css/custom.css');
        $base64Css = base64_encode($cssContent);
        $contentTypeCss = mime_content_type(ROOTPATH . 'public/css/custom.css');

        $dados = "<!DOCTYPE html>";
        $dados .= "<html lang='pt-br'>";
        $dados .= "<head>";
        $dados .= "<meta charset='UTF-8'>";
        $dados .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        $dados .= "<link rel='stylesheet' href='" . 'data:' . $contentTypeCss . ';base64,' . $base64Css . "'>";
        $dados .= "<title>Gerar pdf</title>";
        $dados .= "</head>";
        $dados .= "<body>";
        $dados .= "<h1>Gerar pdf com PHP - Listar usuários</h1><br><br>";


        foreach ($usuarios as $usuario) {
            $dados .= "id $usuario->id <br>";
            $dados .= "nome $usuario->nome<br>";
            $dados .= "email $usuario->email<br>";
            $dados .= "<hr>";
        }


        $dados .= "<img src='" . 'data:' . $contentType . ';base64,' . $base64Image . "' ><br><br>";
        $dados .= "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ";
        $dados .= "</body>";
        $dados .= "</html>";

        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml($dados);

        //Configurar o tamanho e a orientação do documento
        //landscape - formato paisagem
        // portrait - formato retrato
        $dompdf->setPaper('A4', 'portrait');

        // Rederizar o HTML como PDF
        $dompdf->render();

        //Gerar o pdf
        $dompdf->stream();
    }

    // Exemplo para geração de pdf relatorio com filtro do BD
    public function pdf_gerar_relatorio_filtro_bd()
    {
        // instnciamos a classe da biblioteca
        $dompdf = new Dompdf(['enable_remote' => true]);

        $usuarioModel = new UsuarioModel();

        $arrayMatch = ['nome' => $this->request->getPost('texto_pesquisar')];
        $usuarios = $usuarioModel->like($arrayMatch)->findAll();


        $fileContent = file_get_contents(ROOTPATH . 'public/imagem.jpg');
        $base64Image = base64_encode($fileContent);
        $contentType = mime_content_type(ROOTPATH . 'public/imagem.jpg');

        $cssContent = file_get_contents(ROOTPATH . 'public/css/custom.css');
        $base64Css = base64_encode($cssContent);
        $contentTypeCss = mime_content_type(ROOTPATH . 'public/css/custom.css');

        $dados = "<!DOCTYPE html>";
        $dados .= "<html lang='pt-br'>";
        $dados .= "<head>";
        $dados .= "<meta charset='UTF-8'>";
        $dados .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        $dados .= "<link rel='stylesheet' href='" . 'data:' . $contentTypeCss . ';base64,' . $base64Css . "'>";
        $dados .= "<title>Gerar pdf</title>";
        $dados .= "</head>";
        $dados .= "<body>";
        $dados .= "<h1>Gerar pdf com PHP - Listar usuários</h1><br><br>";


        foreach ($usuarios as $usuario) {
            $dados .= "id $usuario->id <br>";
            $dados .= "nome $usuario->nome<br>";
            $dados .= "email $usuario->email<br>";
            $dados .= "<hr>";
        }


        $dados .= "<img src='" . 'data:' . $contentType . ';base64,' . $base64Image . "' ><br><br>";
        $dados .= "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ";
        $dados .= "</body>";
        $dados .= "</html>";

        // instanciar o metodo loadHtml e enviar o conteudo do PDF
        $dompdf->loadHtml($dados);

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
        $viewPdf = view('Pdf/pdfview', $data);

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

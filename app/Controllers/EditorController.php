<?php

namespace App\Controllers;

use App\Models\EditorModel;

class EditorController extends BaseController
{
    public function index(): string
    {
        $artigo = new EditorModel();
        $data = [
            'artigos' => $artigo->findAll()
        ];
        return view('editor', $data);
    }

    public function saveContent()
    {
        $artigo = new EditorModel();

        $post = $this->request->getPost();

        $data = [
            'titulo' => $post['titulo'],
            'conteudo' => $post['conteudo']
        ];

        $artigo->save($data);

        return redirect()->back();
    }


    /**
     * Usando a biblioteca do Codeigniter
     */
    public function loadImage()
    {
        $post = $this->request->getFile('image');

        $new = $post->getRandomName();

        //Convertendo a imagem
        $new_name = explode('.', $new);
        $path = WRITEPATH . 'uploads/' . $new_name[0] . '.jpeg';
        \Config\Services::image()
            ->withFile($post->getTempName())
            ->fit(200, 200, 'center')
            ->convert(IMAGETYPE_JPEG)
            ->save($path);

        $retorno['success'] = true;
        $retorno['file'] = $this->carregaImagem($path); 

        // Exclui a imagem para não conter lixo dentro da pasta
        unlink( $path );
        echo json_encode($retorno);
    }



    /**
     * Usando PHP Puro
     */

    // public function loadImage()
    // {
    //     //Receber os dados da imagem

    //     $dados_imagem = $_FILES['image'];

    //     //Diretorio que será salvo a imagem
    //     $diretorio = WRITEPATH . 'uploads/';

    //     //Gerar uma chave para o nome do arquivo
    //     $chave = substr(md5(rand()), 0,16);

    //     //Pegar a extensão do arquivo
    //     $extensao = pathinfo($dados_imagem['name'], PATHINFO_EXTENSION);

    //     $nome_arquivo = $chave . "." . $extensao;

    //     $path = $diretorio . $nome_arquivo;

    //     // Carregar a imagem na pasta Writable
    //     move_uploaded_file($dados_imagem['tmp_name'], $path);

    //     $retorno['success'] = true;
    //     $retorno['file'] = $this->carregaImagem($path); 

    //     // Exclui a imagem para não conter lixo dentro da pasta
    //     unlink( $path );
    //     echo json_encode($retorno);
    // }

    private function carregaImagem($path)
    {
        $fileContent = file_get_contents($path);
        $base64Image = base64_encode($fileContent);

        $contentType = mime_content_type($path);

        // Retornar a imagem em base 64, pois não temos acesso diretamente como por exemplo na pasta public
        return 'data:' . $contentType . ';base64,' . $base64Image;
    }
}

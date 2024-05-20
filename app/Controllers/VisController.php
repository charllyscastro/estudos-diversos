<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PessoaModel;
use App\Models\PessoaVeiculoModel;
use App\Models\PessoaVinculoModel;
use App\Models\VinculoModel;
use CodeIgniter\Config\Factories;


class VisController extends BaseController
{
    private $pessoaModel;
    private $vinculoModel;
    private $pessoaVinculoModel;
    private $pessoaVeiculoModel;

    public function __construct()
    {
        $this->pessoaModel = Factories::models(PessoaModel::class);
        $this->vinculoModel = Factories::models(VinculoModel::class);
        $this->pessoaVinculoModel = Factories::models(PessoaVinculoModel::class);
        $this->pessoaVeiculoModel = Factories::models(PessoaVeiculoModel::class);
    }
    public function index()
    {

       $data = $this->busca_vinculos(1);
        
        // dd($data);
        return view('Vis/index.php', $data);
    }

    public function recupera_vinculos(){
        $pessoa_id = $this->request->getGet('pessoa_id');

        $data = $this->busca_vinculos($pessoa_id);

        return $this->response->setJSON($data);
    }

    private function busca_vinculos($pessoa_id){

        $pessoa = $this->pessoaModel->where('id', $pessoa_id)->first();

        $selected = 'pessoas.nome as pessoa_nome, vinculos.nome as vinculo_nome, pessoas_vinculos.*';

        $vinculos = $this->pessoaVinculoModel
            ->select($selected)
            ->join('pessoas', 'pessoas.id = pessoas_vinculos.pessoa_id')
            ->join('vinculos', 'vinculos.id = pessoas_vinculos.vinculo_id')
            ->where('pessoas_vinculos.pessoa_id', $pessoa_id)->findAll();

            foreach ($vinculos as $vinculo) {
                $vinculo->vinculo = $this->pessoaModel
                ->select('pessoas.nome as pessoa_vinculo_nome, pessoas.imagem as pessoa_imagem')
                ->find($vinculo->pessoa_vinculo_id);
            };

        $veiculos = $this->pessoaVeiculoModel->where('pessoa_id', $pessoa_id)->findAll();

        
        $data = [
            'vinculos' => $vinculos,
            'pessoa' => $pessoa,
            'veiculos' => $veiculos
        ];

        return $data;
    }
}

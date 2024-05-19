<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PessoaModel;
use App\Models\PessoaVeiculoModel;
use App\Models\PessoaVinculoModel;
use App\Models\VinculoModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Query;
use CodeIgniter\HTTP\ResponseInterface;

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

        $pessoa = $this->pessoaModel->where('id', 1)->first();


        $selected = 'pessoas.nome as pessoa_nome, vinculos.nome as vinculo_nome, pessoas_vinculos.*';

        $vinculos = $this->pessoaVinculoModel
            ->select($selected)
            ->join('pessoas', 'pessoas.id = pessoas_vinculos.pessoa_id')
            ->join('vinculos', 'vinculos.id = pessoas_vinculos.vinculo_id')
            ->where('pessoas_vinculos.pessoa_id', 1)->findAll();

            foreach ($vinculos as $vinculo) {
                $vinculo->vinculo = $this->pessoaModel
                ->select('pessoas.nome as pessoa_vinculo_nome, pessoas.imagem as pessoa_imagem')
                ->find($vinculo->pessoa_vinculo_id);
            };

        $veiculos = $this->pessoaVeiculoModel->where('pessoa_id', 1)->findAll();

        
        $data = [
            'vinculos' => $vinculos,
            'pessoa' => $pessoa,
            'veiculos' => $veiculos
        ];
        
        // dd($data);
        return view('Vis/index.php', $data);
    }
}

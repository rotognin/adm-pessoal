<?php

namespace Src\Controller;

use Src\Model\Contrato;

class ContratoController extends Controller
{
    /**
     * Carregar a lista de contratos e chamar a view
     */
    public static function contratos(array $post = [], array $get = [], String $mensagem = '')
    {
        $params = http_build_query(["status" => "0"]);
        $contratos = (new Contrato())->find('status = :status', $params)->fetch(true);

        parent::view('contrato.lista', ['contratos' => $contratos, 'mensagem' => $mensagem]);
    }

    /**
     * Adicionar um novo contrato
     */
    public static function novo()
    {
        criarCsrf();
        parent::view('contrato.novo', ['acao' => 'novo']);
    }

    /**
     * Alterar um contrato existente
     */
    public static function alterar(array $post, array $get)
    {
        criarCsrf();
        $contrato = (new Contrato())->findById($post['contrato_id']);
        parent::view('contrato.alterar', ['contrato' => $contrato, 'acao' => 'alterar']);
    }

    /**
     * Encerrar um contrato
     */
    public static function finalizar(array $post, array $get)
    {
        $contrato = (new Contrato())->findById($post['contrato_id']);

        $mensagem = '';

        if (!$contrato){
            $mensagem = 'Não foi possível finalizar o contrato.';
            parent::view('contrato.lista', ['mensagem' => $mensagem]);
            exit;
        }

        $contrato->data_fim = date('Y-m-d');
        $contrato->status = 2; // Finalizado

        if (!$contrato->save()){
            $mensagem = 'Não foi possível finalizar o contrato.';
            parent::view('contrato.lista', ['mensagem' => $mensagem]);
            exit;
        }

        $mensagem = 'O contrato ' . $contrato->numero . ' foi finalizado.';

        self::contratos([], [], $mensagem);
    }

    /**
     * Realizar a gravação ou atualização de um contrato
     */
    public static function gravar(array $post, array $get)
    {
        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            self::contratos();
            exit;
        }

        if ($post['acao'] == 'novo'){
            $contrato = new Contrato();
        } else {
            $contrato = (new Contrato())->findById($post['id']);
        }
        
        $contrato->numero = verificarString($post['numero']);
        $contrato->nome = verificarString($post['nome']);
        $contrato->data_inicio = $post['data_inicio'];
        $contrato->observacoes = verificarString($post['observacoes']);
        $contrato->status = $post['status'];

        $mensagem = '';

        if ($contrato->nome == ''){
            $mensagem = 'O nome deve ser preenchido.<br>';
        }

        if ($contrato->numero == ''){
            $mensagem .= 'O número do contrato deve ser preenchido.<br>';
        }

        if ($contrato->data_inicio == ''){
            $mensagem .= 'A data de início do contrato deve ser informada.<br>';
        }

        // Ver se já existe um número de contrato igual ao que foi digitado
        if ($post['acao'] == 'novo'){
            $params = http_build_query(['numero' => $contrato->numero, 'status' => '0']);
            $contExiste = (new Contrato())->find('numero = :numero AND status = :status', $params)->fetch();

            if ($contExiste){
                $mensagem .= 'Existe um contrato ativo com esse número: ' . $contrato->numero . '<br>';
            }
        }

        if ($mensagem != ''){
            $mensagem = substr($mensagem, 0, strlen($mensagem) - 4);
            parent::view('contrato.novo', ['mensagem' => $mensagem, 'contrato' => $contrato]);
            exit;
        }

        if (!$contrato->save()){
            $mensagem = 'Não foi possível gravar o contrato.';
            parent::view('contrato.novo', ['mensagem' => $mensagem]);
            exit;
        }

        self::contratos();
    }
}
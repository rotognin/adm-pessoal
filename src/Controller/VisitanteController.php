<?php

namespace Src\Controller;

use Src\Model\Visitante;
use Src\Model\Contrato;

class VisitanteController extends Controller
{
    /**
     * Lista de visitantes
     */
    public static function visitantes(array $post, array $get, string $mensagem = '')
    {
        // Carregar os visitantes e chamar a view
        $paramsArray = [];

        $contrato_id = $post['contrato_id'] ?? $get['contrato_id'];
        $paramsArray['contrato_id'] = $contrato_id;
        $busca = 'contrato_id = :contrato_id';

        $params = http_build_query($paramsArray);
        $visitantes = (new Visitante())->find($busca, $params)->fetch(true);
        $contrato = (new Contrato())->findById($contrato_id);

        parent::view('visitante.lista', ['visitantes' => $visitantes, 'contrato' => $contrato, 'mensagem' => $mensagem]);
    }

    /**
     * Novo Visitante
     */
    public static function novo(array $post, array $get)
    {
        criarCsrf();
        $contrato = (new Contrato())->findById($post['contrato_id']);
        parent::view('visitante.novo', ['contrato' => $contrato, 'acao' => 'novo']);
    }

    /**
     * Alterar um visitante existente
     */
    public static function alterar(array $post, array $get)
    {
        criarCsrf();
        $visitante = (new Visitante())->findById($post['visitante_id']);
        $visitante->senha = '';

        $contrato = (new Contrato())->findById($post['contrato_id']);
        parent::view('visitante.alterar', ['visitante' => $visitante, 'contrato' => $contrato, 'acao' => 'alterar']);
    }

    /**
     * Inativar um visitante
     */
    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 2);
    }

    /**
     * Ativar um visitante
     */
    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 0);
    }

    /**
     * Alterar o Status de um visitante
     */
    public static function alterarStatus(array $post, array $get, int $status)
    {
        $visitante = (new Visitante())->findById($post['visitante_id']);

        $mensagem = '';

        if (!$visitante){
            $mensagem = 'Não foi possível inativar o visitante.';
            self::visitantes($post, $get, $mensagem);
            exit;
        }

        $visitante->status = $status;

        if (!$visitante->save()){
            $mensagem = 'Não foi possível alterar a situação do visitante.';
            self::visitantes($post, $get, $mensagem);
            exit;
        }

        $mensagem = 'O visitante ' . $visitante->nome . ' teve a situação alterada.';

        self::visitantes($post, $get, $mensagem);
    }

    /**
     * Gravar um visitante
     */
    public static function gravar(array $post, array $get)
    {
        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            self::visitantes();
            exit;
        }

        if ($post['acao'] == 'novo'){
            $visitante = new Visitante();
        } else {
            $visitante = (new Visitante())->findById($post['id']);
        }

        $visitante->contrato_id = $post['contrato_id'];
        $visitante->email = verificarString($post['email']);
        $mensagem = '';

        if ($post['acao'] == 'novo'){
            if ($visitante->jaCadastrado()){
                $mensagem = 'Já existe um visitante com esse e-mail para este contrato.<br>';
            }
        }

        $visitante->nome = verificarString($post['nome']);
        $visitante->contato = verificarString($post['contato']);
        $visitante->status = $post['status'];
        $visitante->parentesco = verificarString($post['parentesco']);
        $visitante->observacoes = verificarString($post['observacoes']);

        if ($visitante->nome == ''){
            $mensagem = 'O nome deve ser preenchido.<br>';
        }

        if ($visitante->email == ''){
            $mensagem .= 'O e-mail deve ser preenchido.<br>';
        }

        if ($mensagem != ''){
            $contrato = (new Contrato())->findById($visitante->contrato_id);
            $mensagem = substr($mensagem, 0, strlen($mensagem) - 4);
            parent::view('visitante.novo', ['acao' => $post['acao'],'mensagem' => $mensagem, 'contrato' => $contrato, 'visitante' => $visitante]);
            exit;
        }

        if ($post['acao'] == 'novo'){
            $visitante->senha = sha1('novousuario');
            $visitante->status = 3;
            $hash = hash('sha256', $visitante->senha . rand(0, 1000));
            $visitante->hash = $hash;

            $contrato = (new Contrato())->findById($visitante->contrato_id);
        }

        if (!$visitante->save()){
            $mensagem = 'Não foi possível gravar o visitante.';
            parent::view('visitante.novo', ['mensagem' => $mensagem, 'visitante' => $visitante]);
            exit;
        }

        if ($post['acao'] == 'novo')
        {
            // Enviar um e-mail para o visitante que foi adicionado
            $mensagem = emailVisitanteCadastrado($contrato->numero, $visitante->nome, $visitante->email, $visitante->hash);
            enviarEmail($visitante->email, 'Cadastro efetuado', $mensagem);
        }

        self::visitantes($post, $get);
    }
}
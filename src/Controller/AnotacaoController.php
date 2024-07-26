<?php

namespace Src\Controller;

use Src\Model\Anotacao;

class AnotacaoController extends Controller
{
    public static function anotacoes(string $mensagem = '')
    {
        $anotacoes = (new Anotacao())->find()->fetch(true);
        parent::view('anotacao.lista', ['anotacoes' => $anotacoes, 'mensagem' => $mensagem]);
    }

    public static function novo()
    {
        criarCsrf();
        parent::view('anotacao.novo', ['acao' => 'novo']);
    }

    public static function alterar()
    {
        global $request;
        $anotacao_id = filter_var($request->post('anotacao_id'), FILTER_VALIDATE_INT);

        if (!$anotacao_id) {
            $mensagem = 'ID incorreto.';
            self::anotacoes($mensagem);
            exit;
        }

        $anotacao = (new Anotacao())->findById($anotacao_id);

        if (!$anotacao) {
            $mensagem = 'Registro não encontrado';
            self::anotacoes($mensagem);
            exit;
        }

        criarCsrf();
        parent::view('anotacao.alterar', ['anotacao' => $anotacao, 'acao' => 'alterar']);
    }

    public static function gravar()
    {
        global $request;

        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']) {
            self::anotacoes('Não permitido');
            exit;
        }

        $acao = verificarString($request->post('acao'));

        if ($acao == 'alterar') {
            $id = filter_var($request->post('id'), FILTER_VALIDATE_INT);
            if (!$id) {
                $mensagem = 'ID incorreto.';
                self::anotacoes($mensagem);
                exit;
            }

            $anotacao = (new Anotacao())->findById($id);
        } else {
            $anotacao = new Anotacao();
            $anotacao->ano_data = date('Y-m-d H:i:s');
        }

        $anotacao->ano_texto = verificarString($request->post('ano_texto'));
        $anotacao->ano_prioridade = verificarString($request->post('ano_prioridade'));
        $anotacao->ano_status = verificarString($request->post('ano_status'));

        if (!$anotacao->save()) {
            $mensagem = 'Não foi possível gravar o registro da Anotação.';
            parent::view('anotacao.' . $acao, ['anotacao' => $anotacao, 'acao' => $acao, 'mensagem' => $mensagem]);
        }

        self::anotacoes('Registro gravado.');
    }

    public static function excluir()
    {
        global $request;

        $id = filter_var($request->post('ano_id'), FILTER_VALIDATE_INT);

        if (!$id) {
            self::anotacoes('Não permitido');
            exit;
        }

        $anotacao = (new Anotacao())->findById($id);

        if ($anotacao->fail()) {
            self::anotacoes($anotacao->fail()->getMessage());
            exit;
        }

        $anotacao->destroy();

        self::anotacoes('Registro excluído.');
    }
}

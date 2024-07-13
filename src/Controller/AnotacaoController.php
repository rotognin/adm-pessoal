<?php

namespace Src\Controller;

use Src\Model\Anotacao;

class AnotacaoController extends Controller
{
    public static function anotacoes(array $post, array $get, string $mensagem = '')
    {
        $anotacoes = (new Anotacao())->find()->fetch(true);
        parent::view('anotacao.lista', ['anotacoes' => $anotacoes, 'mensagem' => $mensagem]);
    }

    public static function novo()
    {
        criarCsrf();
        parent::view('anotacao.novo', ['acao' => 'novo']);
    }

    public static function alterar(array $post, array $get)
    {
        $anotacao_id = filter_var($post['anotacao_id'], FILTER_VALIDATE_INT);

        if (!$anotacao_id) {
            $mensagem = 'ID incorreto.';
            self::anotacoes([], [], $mensagem);
            exit;
        }

        $anotacao = (new Anotacao())->findById($anotacao_id);

        if (!$anotacao) {
            $mensagem = 'Registro não encontrado';
            self::anotacoes([], [], $mensagem);
            exit;
        }

        criarCsrf();
        parent::view('anotacao.alterar', ['anotacao' => $anotacao, 'acao' => 'alterar']);
    }

    public static function gravar(array $post, array $get)
    {
        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']) {
            self::anotacoes([], [], 'Não permitido');
            exit;
        }

        $acao = verificarString($post['acao']);

        if ($acao == 'alterar') {
            $id = filter_var($post['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                $mensagem = 'ID incorreto.';
                self::anotacoes($post, $get, $mensagem);
                exit;
            }

            $anotacao = (new Anotacao())->findById($id);
        } else {
            $anotacao = new Anotacao();
            $anotacao->ano_data = date('Y-m-d H:i:s');
        }

        $anotacao->ano_texto = verificarString($post['ano_texto']);
        $anotacao->ano_prioridade = verificarString($post['ano_prioridade']);
        $anotacao->ano_status = verificarString($post['ano_status']);

        if (!$anotacao->save()) {
            $mensagem = 'Não foi possível gravar o registro da Anotação.';
            parent::view('anotacao.' . $acao, ['anotacao' => $anotacao, 'acao' => $acao, 'mensagem' => $mensagem]);
        }

        self::anotacoes([], [], 'Registro gravado.');
    }

    public static function excluir(array $post, array $get)
    {
        $id = filter_var($post['ano_id'], FILTER_VALIDATE_INT);

        if (!$id) {
            self::anotacoes([], [], 'Não permitido');
            exit;
        }

        $anotacao = (new Anotacao())->findById($id);

        if ($anotacao->fail()) {
            self::anotacoes([], [], $anotacao->fail()->getMessage());
            exit;
        }

        $anotacao->destroy();

        self::anotacoes([], [], 'Registro excluído.');
    }
}

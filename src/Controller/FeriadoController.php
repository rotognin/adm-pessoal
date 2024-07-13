<?php

namespace Src\Controller;

use Src\Model\Feriado;

class FeriadoController extends Controller
{
    public static function feriados(array $post, array $get, string $mensagem = '')
    {
        $feriados = (new Feriado())->find()->fetch(true);
        parent::view('feriado.lista', ['feriados' => $feriados, 'mensagem' => $mensagem]);
    }

    public static function novo()
    {
        criarCsrf();
        parent::view('feriado.novo', ['acao' => 'novo']);
    }

    public static function alterar(array $post, array $get)
    {
        $feriado_id = filter_var($post['feriado_id'], FILTER_VALIDATE_INT);

        if (!$feriado_id){
            $mensagem = 'ID incorreto.';
            self::feriados([], [], $mensagem);
            exit;
        }

        $feriado = (new Feriado())->findById($feriado_id);

        if (!$feriado){
            $mensagem = 'Registro não encontrado';
            self::feriados([], [], $mensagem);
            exit;
        }

        criarCsrf();
        parent::view('feriado.alterar', ['feriado' => $feriado, 'acao' => 'alterar']);
    }

    public static function gravar(array $post, array $get)
    {
        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            self::feriados([], [], 'Não permitido');
            exit;
        }

        $acao = verificarString($post['acao']);

        if ($acao == 'alterar'){
            $id = filter_var($post['id'], FILTER_VALIDATE_INT);
            if (!$id){
                $mensagem = 'ID incorreto.';
                self::feriados($post, $get, $mensagem);
                exit;
            }

            $feriado = (new Feriado())->findById($id);
        } else {
            $feriado = new Feriado();
        }

        $dia = filter_var($post['dia'], FILTER_VALIDATE_INT);
        $mes = filter_var($post['mes'], FILTER_VALIDATE_INT);
        $ano = filter_var(date('Y'), FILTER_VALIDATE_INT);
        $descricao = verificarString($post['descricao']);

        if (!$dia || !$mes){
            $mensagem = 'Verifique o Dia e o Mês';
            parent::view('feriado.' . $acao, ['feriado' => $feriado, 'acao' => 'alterar', 'mensagem' => $mensagem]);
            exit;
        }

        $feriado->dia = $dia;
        $feriado->mes = $mes;
        $feriado->descricao = $descricao;

        if (!checkdate($mes, $dia, $ano)){
            $mensagem = 'Data inválida.';
            parent::view('feriado.' . $acao, ['feriado' => $feriado, 'acao' => $acao, 'mensagem' => $mensagem]);
            exit;
        }

        if ($descricao == ''){
            $mensagem = 'É necessário informar uma descrição para o feriado';
            parent::view('feriado.' . $acao, ['feriado' => $feriado, 'acao' => $acao, 'mensagem' => $mensagem]);
            exit;
        }

        if (!$feriado->save()){
            $mensagem = 'Não foi possível gravar o registro do feriado.';
            parent::view('feriado.' . $acao, ['feriado' => $feriado, 'acao' => $acao1, 'mensagem' => $mensagem]);
        }

        self::feriados([], [], 'Registro gravado.');
    }

    public static function excluir(array $post, array $get){
        $id = filter_var($post['feriado_id'], FILTER_VALIDATE_INT);

        if (!$id){
            self::feriados([], [], 'Não permitido');
            exit;
        }

        $feriado = (new Feriado())->findById($id);
        
        if ($feriado->fail()){
            self::feriados([], [], $feriado->fail()->getMessage());
            exit;
        }

        $feriado->destroy();

        self::feriados([], [], 'Registro excluído.');
    }
}
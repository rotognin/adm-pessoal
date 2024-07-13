<?php

namespace Src\Controller;

use Src\Model\Parametro;
use Src\Model\Horario;

class ParametroController extends Controller
{
    public static function cadastro(array $post, array $get, string $mensagem = '')
    {
        criarCsrf();
        $parametro = (new Parametro())->findById(1);

        if (!$parametro){
            $parametro = new Parametro();
            $parametro->qtd_agendamentos = 2;
            $parametro->qtd_pessoas = 3;
            $parametro->horas_antes = 24;
            $parametro->horas_cancelamento = 1;
            $parametro->qtd_marcacoes = 2;
            $parametro->qtd_marcacoes_sabados = 2;
            $parametro->save();
        }

        $horarios = (new Horario())->find()->fetch(true);

        parent::view('parametro.cadastro', ['parametro' => $parametro, 'horarios' => $horarios, 'mensagem' => $mensagem]);
    }

    public static function gravar(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $parametro = (new Parametro())->findById(1);
        $parametro->qtd_agendamentos = filter_var($post['qtd_agendamentos'], FILTER_VALIDATE_INT);
        $parametro->qtd_pessoas = filter_var($post['qtd_pessoas'], FILTER_VALIDATE_INT);
        $parametro->horas_antes = filter_var($post['horas_antes'], FILTER_VALIDATE_INT);
        $parametro->horas_cancelamento = filter_var($post['horas_cancelamento'], FILTER_VALIDATE_INT);
        $parametro->qtd_marcacoes = filter_var($post['qtd_marcacoes'], FILTER_VALIDATE_INT);
        $parametro->qtd_agendamentos_sabados = filter_var($post['qtd_agendamentos_sabados'], FILTER_VALIDATE_INT);

        if (!$parametro->qtd_agendamentos){
            $mensagem = 'A quantidade de agendamentos por horário está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }

        if (!$parametro->qtd_pessoas){
            $mensagem = 'A quantidade de pessoas por visita está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }

        if (!$parametro->horas_antes){
            $mensagem = 'A quantidade de horas de antecedência está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }

        if (!$parametro->horas_cancelamento){
            $mensagem = 'A quantidade de horas para cancelamento está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }

        if (!$parametro->qtd_marcacoes){
            $mensagem = 'A quantidade de agendamentos por semana está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }

        if (!$parametro->qtd_agendamentos_sabados){
            $mensagem = 'A quantidade de agendamentos aos sábados está incorreta.';
            self::cadastro($post, $get, $mensagem);
            exit;
        }
        
        if (!$parametro->save()){
            self::cadastro($post, $get, 'Não foi possível gravar as informações...');
        } else {
            self::cadastro($post, $get, 'Informações gravadas.');
        }
    }
}
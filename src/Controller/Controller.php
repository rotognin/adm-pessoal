<?php

namespace Src\Controller;

use Src\Model\Admin;
use Src\Model\Anotacao;
use Src\Model\Visitante;
use Src\Model\Visita;
use Src\Model\DataSemana;

class Controller
{
    public static function login(array $post, array $get)
    {
        $params = http_build_query(["login" => verificarString($post['login'])]);
        $admin = (new Admin())->find('login = :login', $params)->fetch();

        if (!$admin) {
            self::view('index', ['mensagem' => 'Usuário ou senha inválidos']);
            exit;
        }

        if ($admin->senha != sha1($post['senha'])) {
            self::view('index', ['mensagem' => 'Usuário ou senha inválidos']);
            exit;
        }

        if (STATUS_ADMIN[$admin->status] == 'Inativo') {
            self::view('index', ['mensagem' => 'Usuário inativo.']);
            exit;
        }

        // Deixar logar mesmo que esteja pendente, caso a senha seja lembrada.
        /*
        if (STATUS_ADMIN[$admin->status] == 'Pendente'){
            self::view('index', ['mensagem' => 'Usuário pendente para recuperação de senha.']);
            exit;
        }
        */

        if ($admin->status == 1) {
            self::view('index', ['mensagem' => 'Usuário inativo.']);
            exit;
        }

        $_SESSION['usuId'] = $admin->id;
        $_SESSION['usuNome'] = $admin->nome;
        $_SESSION['usuNivel'] = $admin->nivel;

        self::menu($post, $get);
    }

    public static function logout()
    {
        session_unset();
        self::view('index');
    }

    public static function home()
    {
        self::view('index');
    }

    public static function menu(array $post, array $get)
    {
        /*
        $data_semana = new DataSemana();

        if (isset($post['dia']) && $post['dia'] != 'Todos'){
            $dia_filtrar = $post['dia'];
            $data_inicial = $post['dia'];
            $data_final = $post['dia'];
        } else {
            // Montar a semana e buscar as visitas apenas daquela semana
            $data_inicial = $data_semana->data_inicial->format('Y-m-d');
            $data_final = $data_semana->data_final->format('Y-m-d');
            $dia_filtrar = '';
        }

        $data_semana->montarDatas();

        $params = http_build_query(["status" => 0, 'data_inicial' => $data_inicial, 'data_final' => $data_final]);
        $visitas = (new Visita())
            ->find('status = :status AND data_visita BETWEEN :data_inicial AND :data_final', $params)
            ->order('data_visita, hora_visita')
            ->fetch(true);

        if ($visitas){
            foreach($visitas as $visita){
                $visita->anexarDados();
            }
        }

        self::view('menu', ['visitas' => $visitas, 'data_semana' => $data_semana, 'dia_filtrar' => $dia_filtrar]);
        */

        $params = http_build_query(['ano_status' => 'N']);
        $anotacoes = (new Anotacao())->find('ano = :ano_status', $params);

        self::view('menu', ['anotacoes' => $anotacoes]);
    }

    public static function view(string $view, array $array = [])
    {
        $view = str_replace('.', DS, $view);
        $arquivo = '.' . DS . 'src' . DS . 'View' . DS . $view . '.php';

        if (!file_exists($arquivo)) {
            echo '.... Arquivo não existe ... ' . $arquivo;
            die();
        }

        if (!empty($array)) {
            foreach ($array as $var => $valor) {
                $$var = $var;
                $$var = $valor;
            }
        }

        ob_start();
        require_once $arquivo;
        $pagina = ob_get_contents();
        ob_end_clean();
        echo $pagina;
    }
}

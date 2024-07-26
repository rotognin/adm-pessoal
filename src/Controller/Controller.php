<?php

namespace Src\Controller;

use Src\Model\Admin;
use Src\Model\Anotacao;

class Controller
{
    public static function login()
    {
        global $request;

        $params = http_build_query(["login" => verificarString($request->post('login'))]);
        $admin = (new Admin())->find('login = :login', $params)->fetch();

        if (!$admin) {
            self::view('index', ['mensagem' => 'Usuário ou senha inválidos']);
            exit;
        }

        if ($admin->senha != sha1($request->post('senha'))) {
            self::view('index', ['mensagem' => 'Usuário ou senha inválidos']);
            exit;
        }

        if (STATUS_ADMIN[$admin->status] == 'Inativo') {
            self::view('index', ['mensagem' => 'Usuário inativo.']);
            exit;
        }

        if ($admin->status == 1) {
            self::view('index', ['mensagem' => 'Usuário inativo.']);
            exit;
        }

        $_SESSION['usuId'] = $admin->id;
        $_SESSION['usuNome'] = $admin->nome;
        $_SESSION['usuNivel'] = $admin->nivel;

        self::menu();
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

    public static function menu()
    {
        $params = http_build_query(['ano_status' => 'N']);
        $anotacoes = (new Anotacao())->find('ano = :ano_status', $params);

        self::view('menu', ['anotacoes' => $anotacoes]);
    }

    public static function view(string $view, array $array = [])
    {
        $view = str_replace('.', '/', $view);
        $arquivo = './src/View/' . $view . '.php';

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

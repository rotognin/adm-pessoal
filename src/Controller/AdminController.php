<?php

namespace Src\Controller;

use Src\Model\Admin;

class AdminController extends Controller
{
    public static function administradores()
    {
        if (!self::nivelSuficiente(0)){
            parent::view('menu');
            Exit;
        }

        $admins = (new Admin())->find()->fetch(true);

        parent::view('admin.lista', ['admins' => $admins]);
    }

    public static function novo()
    {
        criarCsrf();
        parent::view('admin.novo', ['acao' => 'novo']);
    }

    public static function alterar(array $post, array $get)
    {
        criarCsrf();
        $admin = (new Admin())->findById($post['id']);
        $admin->senha = '';

        parent::view('admin.alterar', ['admin' => $admin, 'acao' => 'alterar']);
    }

    public static function inativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 1);
    }

    public static function ativar(array $post, array $get)
    {
        self::alterarStatus($post, $get, 0);
    }

    public static function alterarStatus(array $post, array $get, int $status)
    {
        $admin = (new Admin())->findById($post['id']);

        $mensagem = '';

        if (!$admin){
            $mensagem = 'Não foi possível inativar o usuário.';
            self::administradores($post, $get, $mensagem);
            Exit;
        }

        $admin->status = $status;

        if (!$admin->save()){
            $mensagem = 'Não foi possível alterar a situação do usuário.';
            self::administradores($post, $get, $mensagem);
            Exit;
        }

        $mensagem = 'O usuário ' . $admin->nome . ' teve a situação alterada.';

        self::administradores($post, $get, $mensagem);
    }

    /**
     * Verificar se o usuário logado tem o nível suficiente para executar
     * determinada ação
     */
    public static function nivelSuficiente(int $nivelEsperado)
    {
        $usuarioLogado = self::carregarUsuarioLogado();
        return ($usuarioLogado->nivel <= $nivelEsperado);
    }

    /**
     * Carregar o usuário logado em um objeto
     */
    public static function carregarUsuarioLogado()
    {
        return (new Admin())->findById($_SESSION['usuId']);
    }

    /**
     * Verificações e gravação do usuário
     */
    public static function gravar(array $post, array $get)
    {
        // Verificar o token
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            self::administradores();
            Exit;
        }

        if ($post['acao'] == 'novo'){
            $admin = new Admin();
        } else {
            $admin = (new Admin())->findById($post['id']);
        }

        if ($post['senha'] != ''){
            $admin->senha = sha1($post['senha']);
        }

        $admin->nome = verificarString($post['nome']);
        $admin->email = verificarString($post['email']);
        $admin->login = verificarString($post['login']);
        $admin->status = $post['status'];
        $admin->nivel = $post['nivel'];

        $mensagem = '';

        if ($admin->nome == ''){
            $mensagem = 'O nome deve ser preenchido.<br>';
        }

        if ($admin->email == ''){
            $mensagem = 'O e-mail deve ser preenchido.<br>';
        }

        if ($admin->login == ''){
            $mensagem .= 'O login deve ser preenchido.<br>';
        }

        if ($admin->senha == '' && $post['acao'] == 'novo'){
            $mensagem .= 'A senha deve ser informada para o primeiro acesso.<br>';
        }

        if ($mensagem != ''){
            $mensagem = substr($mensagem, 0, strlen($mensagem) - 4);
            parent::view('admin.novo', ['mensagem' => $mensagem, 'admin' => $admin]);
            Exit;
        }

        if (!$admin->save()){
            $mensagem = 'Não foi possível gravar o usuário.';
            parent::view('admin.novo', ['mensagem' => $mensagem, 'admin' => $admin]);
            Exit;
        }

        self::administradores($post, $get);
    }

    public static function esqueci()
    {
        criarCsrf();
        parent::view('admin.esqueci', []);
    }

    public static function enviaremail(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        // Validar as informações digitadas
        $login = verificarString($post['login']);
        $email = verificarString($post['email']);

        if ($login == '' || $email == ''){
            $mensagem = 'Favor informar o login e o e-mail.';
            parent::view('admin.esqueci', ['mensagem' => $mensagem]);
            exit;
        }

        // Ler o registro do usuário pelo login e e-mail
        $params = http_build_query(["login" => $login, "email" => $email]);
        $admin = (new Admin())->find('login = :login AND email = :email', $params)->fetch();

        if (!$admin){
            self::view('admin.esqueci', ['mensagem' => 'E-mail ou Login incorretos']);
            exit;
        }

        if (STATUS_ADMIN[$admin->status] == 'Inativo'){
            self::view('index', ['mensagem' => 'Usuário inativo.']);
            exit;
        }

        // Se estiver OK, marcar o status do usuário como "Pendente"
        $hash = hash('sha256', $admin->senha . rand(0, 1000));

        $admin->status = 2;
        $admin->hash = $hash;

        if (!$admin->save()){
            gravarLog('Não foi atualizado o admin na recuperação da senha: ' . $admin->fail()->getMessage());
            self::view('index', ['mensagem' => 'Não foi possível enviar o e-mail. Favor proceder novamente.']);
            exit;
        }

        // Enviar um e-mail para o usuário
        $emailMsg = emailRecuperarSenha($admin->nome, $admin->login, $hash);
        enviarEmail($admin->email, 'Sistema Administrativo - Redefinir a senha de acesso', $emailMsg);

        // Redirecionar o usuário para a página inicial com o aviso
        $mensagem = 'Foi enviado um e-mail com o link para redefinir sua senha.';
        self::view('index', ['mensagem' => $mensagem]);
    }

    /**
     * Verificar o link do usuário e encaminhá-lo para a redifinição da senha
     */
    public static function recuperar(array $post, array $get)
    {
        $hash = verificarString($get['hash']);
        $admin = self::localizarPeloHash($hash);
        if (!$admin){
            exit;
        }

        criarCsrf();
        parent::view('admin.redefinir', ['admin' => $admin]);
    }

    /**
     * Localizar o cadastro do usuário pelo hash informado
     */
    private static function localizarPeloHash(string $hash)
    {
        if ($hash == ''){
            parent::view('index', ['mensagem' => 'Acesso incorreto']);
            return false;
        }

        $params = http_build_query(['hash' => $hash]);
        $admin = (new Admin())->find('hash = :hash', $params)->fetch();

        if (!$admin){
            $mensagem = 'Não foi possível localizar seu cadastro.<br>Execute o processo de recuperação de senha novamente.';
            parent::view('index', ['mensagem' => $mensagem]);
            return false;
        }

        if ($admin->status != 2){
            $mensagem = 'Acesso não autorizado.<br>Execute o processo de recuperação de senha novamente.';
            parent::view('index', ['mensagem' => $mensagem]);
            return false;
        }

        return $admin;
    }

    /**
     * Verificar se está tudo OK, e redefinir a senha do usuário --- PAREI AQUI
     */
    public static function redefinir(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::logout();
            exit;
        }

        $hash = verificarString($post['hash']);
        $admin = self::localizarPeloHash($hash);
        if (!$admin){
            exit;
        }

        $admin_id = verificarString($post['admin_id']);

        if ($admin->id != $admin_id){
            parent::view('index', ['mensagem' => 'Acesso incorreto.']);
            exit;
        }

        if (verificarString($post['senha']) == ''){
            criarCsrf();
            parent::view('admin.redefinir', ['mensagem' => 'As senhas devem ser informadas.', 'admin' => $admin]);
            exit;
        }

        $senha = sha1($post['senha']);
        $senharepetida = sha1($post['senharepetida']);

        if ($senha != $senharepetida){
            criarCsrf();
            parent::view('admin.redefinir', ['mensagem' => 'As senhas devem ser idênticas.', 'admin' => $admin]);
            exit;
        }

        $admin->status = 0;
        $admin->senha = $senha;
        $admin->hash = '';

        if (!$admin->save()){
            gravarLog('Não foi atualizada a senha do usuário na redefinição: ' . $admin->fail()->getMessage());
            self::view('index', ['mensagem' => 'Não foi possível redefinir a senha. Favor proceder novamente.']);
            exit;
        }

        parent::view('index', ['mensagem' => 'A sua senha foi redefinida.<br>Você pode entrar no sistema.']);
    }
}
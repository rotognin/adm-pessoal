<?php

/**
 * Mensagens a serem utilizadas para enviar e-mails automaticamente
 */

 /**
  * E-mail a ser enviado assim que um visitante é cadastrado no sistema
  */
function emailVisitanteCadastrado(string $contrato, string $nome, string $email, string $hash)
{
    $mensagem = 'Olá <b>' . $nome . '</b>, seu cadastro foi efetuado no sistema de visitas do Lar Melhor Idade. <br> ' .
                'Acesse o link abaixo para definir a sua senha de acesso. <br><br>' .
                'Link: ' . LINK_APP . '/index?action=recuperar&control=visitante&hash=' . $hash . '<br><br><br>' .
                'Para acessar o sistema de agendamento de visitas, utilize as informações abaixo: <br>' .
                'Acesso: ' . LINK_APP . '<br>' .
                'Número do contrato: <b>' . $contrato . '</b><br>' .
                'E-mail: <b>' . $email . '</b><br><br>' .
                'Dúvidas entrar em contato pelos telefones: <b>' . FONE_ADM . '</b>' . 
                '<br><br>' .
                'Muito obrigado!' .
                '<br><br>' .
                'Lar Melhor Idade';

    return $mensagem;
}

/**
 * E-mail a ser enviado quando uma visita for cancelada na parte Administrativa
 */
function emailVisitaCancelada(string $nome, string $data, string $hora, string $dia_semana)
{
    $mensagem = 'Olá, <b>' . $nome . '</b>, viemos lhe informar que a visita que estava marcada para o dia ' . 
                $data . ' (' . $dia_semana . '), hora ' . $hora . ' foi cancelada. <br><br>' .
                'Dúvidas entrar em contato pelos telefones: <b>' . FONE_ADM . '</b>' . 
                '<br><br>' .
                'Muito obrigado!' .
                '<br><br>' .
                'Lar Melhor Idade';

    return $mensagem;
}

/**
 * E-mail com o link para recuperação de senha
 */
function emailRecuperarSenha(string $nome, string $login, string $hash)
{
    $mensagem = 'Olá, <b>' . $nome . '</b>, estamos enviando o link para recuperação da sua senha de acesso.<br>' . 
                'Por favor, acesse o link abaixo para redefinir a sua senha de acesso ao sistema administrativo.<br>' .
                'Login: <b> ' . $login . '</b> <br><br>' .
                'Link para a resuperação da senha: ' . LINK_ADM . '/index?action=recuperar&control=admin&hash=' . $hash .
                '<br><br>' .
                'Muito obrigado!' .
                '<br><br>' .
                'Lar Melhor Idade';

    return $mensagem;
}
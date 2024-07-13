<?php

/**
 * Funções auxiliares (helpers) para chamada de outras
 */

/**
 * Helper para ajudar na gravação do Log
 */
function gravarLog($mensagem)
{
    $log = new Src\Model\Log();
    $log->texto = $mensagem;
    $log->save();
}

/**
 * Helper para envio de e-mails
 */
function enviarEmail(string $destino, string $assunto, string $mensagem)
{
    $email = new Src\Model\Email();
    $email->setDestino($destino);
    $email->setAssunto($assunto);
    $email->setMensagem($mensagem);
    $email->enviar();
}
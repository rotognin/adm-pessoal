<?php

namespace Src\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email
{
    /** Propriedades configuradas */
    private string $host;   
    private string $user;
    private string $pass;
    private int $port;

    /** Propriedades a serem informadas */
    private string $destino;
    private string $assunto;
    private string $mensagem;
    private string $reply;

    public function __construct()
    {
        $this->host = EMAIL_DATA['host'];
        $this->user = EMAIL_DATA['user'];
        $this->pass = EMAIL_DATA['pass'];
        $this->port = EMAIL_DATA['port'];
        $this->reply = EMAIL_DATA['reply'];
    }

    public function setDestino(string $destino)
    {
        $this->destino = (filter_var($destino, FILTER_VALIDATE_EMAIL)) ? $destino : '';

        if ($this->destino == ''){
            gravarLog('E-mail incorreto. Não enviado para: ' . $destino);
            Exit;
        }
    }

    public function setMensagem(string $mensagem)
    {
        $this->mensagem = $mensagem;
    }

    public function setAssunto(string $assunto)
    {
        $this->assunto = $assunto;
    }

    public function enviar()
    {
        $email = new PHPMailer(true);

        try{
            //$email->SMTPDebug = SMTP::DEBUG_LOWLEVEL;
            $email->isSMTP();
            $email->Host = $this->host;
            $email->SMTPAuth = true;
            $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $email->Username = $this->user;
            $email->Password = $this->pass;
            $email->Port = $this->port;
            $email->Charset = PHPMailer::CHARSET_UTF8;
            $email->Encoding = PHPMailer::ENCODING_BASE64;

            $email->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $email->setFrom($this->user, 'Lar Melhor Idade');
            $email->addReplyTo($this->reply);
            $email->addAddress($this->destino);
            $email->isHTML(true);
            $email->Subject = $this->assunto;
            $email->Body = utf8_decode(nl2br($this->mensagem));
            $email->AltBody = strip_tags($this->mensagem);

            if (!$email->send()){
                gravarLog('E-mail não foi enviado para: ' . $this->destino . ' - assunto: ' . $this->assunto);
                gravarLog('Erro relatado: ' . $email->ErrorInfo);
            } else {
                gravarLog('E-mail enviado para: ' . $this->destino . ' - assunto: ' . $this->assunto);
            }
        } catch (Exception $exc) {
            gravarLog("Exceção ao enviar e-mail: " . $email->ErrorInfo);
        }
    }
}
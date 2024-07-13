<?php

namespace Src\Controller;

use Src\Model\Visita;
use Src\Model\Contrato;

class VisitaController extends Controller
{
    /**
     * Cancelar uma visita pela administração
     */
    public static function cancelar(array $post, array $get)
    {
        $visita = (new Visita())->findById($post['visita_id']);
        $visita->status = 2; // Cancelada
        $visita->save();

        $visita->anexarDados();
        $dia_semana = DIA[date('w', strtotime($visita->data_visita))];

        // Enviar um e-mail para o visitante dizendo que a visita foi cancelada
        $mensagem = emailVisitaCancelada($visita->visitante->nome, ajustarData($visita->data_visita), $visita->hora_visita, $dia_semana);
        enviarEmail($visita->visitante->email, 'Visita Cancelada', $mensagem);

        parent::menu($post, $get);
    }
}
<?php

namespace Src\Controller;

use Src\Model\Visita;
use Src\Model\Contrato;

class RelatorioController extends Controller
{
    /**
     * Controlador que irá exibir o relatório de visitas
     */
    public static function relatorio(array $post, array $get)
    {
        $contratos = (new Contrato())->find()->order('nome ASC')->fetch(true);
        criarCsrf();

        $datas = array(
            'data_inicio' => date('Y-m-01'),
            'data_fim' => date('Y-m-t')
        );

        parent::view('visita.filtrar', ['contratos' => $contratos, 'datas' => $datas]);
    }

    /**
     * Quando o operador filtrar as informações, essa função será chamada
     */
    public static function filtrar(array $post, array $get)
    {
        if (!isset($post['_token']) || $post['_token'] != $_SESSION['csrf']){
            parent::view('menu');
            exit;
        }

        $params = '';
        $busca = '';
        $primeiro = true;

        // Filtrar pela data
        $data_inicio = filter_var($post['data_inicio'], FILTER_SANITIZE_STRING);
        $data_fim = filter_var($post['data_fim'], FILTER_SANITIZE_STRING);

        $busca = 'data_visita BETWEEN "' . $data_inicio . '" AND "' . $data_fim . '"';

        // Filtrar pelo contrato (se foi selecionado um)
        if ($post['contrato'] <> '0'){
            $busca .= ' AND contrato_id = :contrato_id';
            $contrato_id = filter_var($post['contrato'], FILTER_VALIDATE_INT);
            $params .= 'contrato_id=' . $contrato_id;
            $primeiro = false;
        }

        // Filtrar pela situação da Visita
        if ($post['situacao'] != 'todas'){
            $situacao = array_search(ucfirst($post['situacao']), STATUS_VISITA);

            // Fazer o filtro
            $busca .= ' AND status = :status';

            if (!$primeiro){
                $params .= '&';
            }

            $params .= 'status=' . $situacao;
        }

        $visitas = (new Visita())->find($busca, $params)->fetch(true);

        if ($visitas){
            foreach($visitas as $visita){
                $visita->anexarDados();
            }
        }

        parent::view('visita.relatorio', ['visitas' => $visitas]);
    }
}
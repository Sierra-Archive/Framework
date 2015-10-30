<?php

class comercio_certificado_PropostaVisual extends comercio_certificado_Visual
{
    /**
    * Construtor
    * 
    * @name __construct
    * @access public
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 0.4.2
    */
    public function __construct() {
      parent::__construct();
    }
    static function Show_HTML(&$proposta) {
        $html = '';
        $html .= '<div class="space15"></div>';
        if (LAYOULT_IMPRIMIR!=='AJAX') {
            $html .= '<div class="row">'.
            '<div class="col-sm-8 bio">';
        } else {
            $html .= '<div class="col-sm-12 bio">';
        }
        $html .= '<h2>Dados da Proposta</h2>';
    
        if ($proposta->idcliente2!=='') {
            $html .= '<p><label style="width:150px;">Cliente</label>: '.$proposta->idcliente2.'</p>';
        }
        if ($proposta->idproduto2!=='') {
            $html .= '<p><label style="width:150px;">Produto</label>: '.$proposta->idproduto2.'</p>';
        }
        if ($proposta->num_proposta!=='') {
            $html .= '<p><label style="width:150px;">Número da Proposta</label>: '.$proposta->num_proposta.'</p>';
        }
        if ($proposta->num_contrato!=='') {
            $html .= '<p><label style="width:150px;">Número do Contrato</label>: '.$proposta->num_contrato.'</p>';
        }
        if ($proposta->num_certificado!=='') {
            $html .= '<p><label style="width:150px;">Número do Certificado</label>: '.$proposta->num_certificado.'</p>';
        }
        if ($proposta->validade!=='') {
            $html .= '<p><label style="width:150px;">Data de Validade</label>: '.$proposta->validade.'</p>';
        }
        if ($proposta->data_aceita_proposta!=='') {
            $html .= '<p><label style="width:150px;">Data de Aceitação da Proposta</label>: '.$proposta->data_aceita_proposta.'</p>';
        }
        if ($proposta->data_certificado!=='') {
            $html .= '<p><label style="width:150px;">Data de Certificação</label>: '.$proposta->data_certificado.'</p>';
        }
        if ($proposta->data_envio_contrato!='') {
            $html .= '<p><label style="width:150px;">Data da Assinatura do Contrato</label>: '.$proposta->data_envio_contrato.'</p>';
        }
        if ($proposta->data_dev_contrato!=='') {
            $html .= '<p><label style="width:150px;">Envio ao Cliente</label>: '.$proposta->data_dev_contrato.'</p>';
        }
        if ($proposta->data_envio_cert!=='') {
            $html .= '<p><label style="width:150px;">Data de Envio do Certificado</label>: '.$proposta->data_envio_cert.'</p>';
        }
        if ($proposta->data_imetro!=='') {
            $html .= '<p><label style="width:150px;">Data Imetro</label>: '.$proposta->data_imetro.'</p>';
        }
        if ($proposta->data_comissao!=='') {
            $html .= '<p><label style="width:150px;">Data da Comissão</label>: '.$proposta->data_comissao.'</p>';
        }
        if (isset($proposta->produto_valor_contrato) && $proposta->produto_valor_contrato!=='') {
            $html .= '<p><label style="width:150px;">Valor do Contrato do Produto</label>: '.$proposta->produto_valor_contrato.'</p>';
        }
        if ($proposta->produto_valor_entrada!=='') {
            $html .= '<p><label style="width:150px;">Valor de Entrada do Produto</label>: '.$proposta->produto_valor_entrada.'</p>';
        }
        if ($proposta->produto_num_parcelas!=='') {
            $html .= '<p><label style="width:150px;">Números de Parcelas do Produto</label>: '.$proposta->produto_num_parcelas.'</p>';
        }
        if ($proposta->produto_dia_faturamento!=='') {
            $html .= '<p><label style="width:150px;">Dia do Faturamento</label>: '.$proposta->produto_dia_faturamento.'</p>';
        }
        if ($proposta->valor_mensal!=='') {
            $html .= '<p><label style="width:150px;">Valor Mensal </label>: '.$proposta->valor_mensal.'</p>';
        }
        
        '<div class="space15"></div>';
        /*if ($proposta->obs!='') {
            $html .= '<h2>Observação</h2>';
            $html .= '<p>'.$proposta->obs.'</p>';
        }
        $html .= '<div class="space15"></div>';*/
        if (LAYOULT_IMPRIMIR!='AJAX') {
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
    public function Show_Perfil(&$proposta,$layoult='Unico') {
        $html = self::Show_HTML($proposta);
        
        if (SQL_MAIUSCULO) {
            $titulo = 'VISUALIZAR PROPOSTA '.$proposta->num_proposta; //mb_strtoupper( )
        } else {
            $titulo = 'Visualizar Proposta '.$proposta->num_proposta;
        }
        // FORMULA JSON OU IMPRIME HTML
        if (LAYOULT_IMPRIMIR=='AJAX') {
            $popup = array(
                'id'        => 'popup',
                'title'     => $titulo,
                /*'botoes'    => array(
                    '0'         => array(
                        'text'      => 'Fechar Janela',
                        'clique'    => '$(this).dialog(\'close\');'
                    )
                ),*/
                'html'      => $html
            );
            $this->Json_IncluiTipo('Popup',$popup);
        } else {
            $this->Blocar($html);
            if ($layoult=='Unico') {
                $this->Bloco_Unico_CriaConteudo();
            } else if ($layoult=='Maior') {
                $this->Bloco_Maior_CriaConteudo();
            } else {
                $this->Bloco_Menor_CriaConteudo();
            }
            $this->Json_Info_Update('Titulo',$titulo);
        }
    }
}
?>
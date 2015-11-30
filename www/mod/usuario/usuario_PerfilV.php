<?php

class usuario_PerfilVisual extends usuario_Visual
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
    * @version 0.4.24
    */
    public function __construct() {
      parent::__construct();
    }
    static function Show_HTML(&$usuario, $tipo='Cliente', $mensagens = false) {
        $html = '';
        if ($tipo=='cliente')                                                                                                    $tipo = "Cliente";
        if ($tipo=='Funcionrio' || $tipo=="Funcionario" || $tipo=="funcionario" || $tipo=="funcionário" || $tipo=="funcionrio")  $tipo = "Funcionário";
        if ($tipo=="Usurio" || $tipo=="Usuario" || $tipo=="usuario" || $tipo=="usuário" || $tipo=="usurio")                      $tipo = 'Usuário';
        $nome = $usuario->nome;
        
        $email = '';
        if (isset($usuario->email)) {
            $email .= $usuario->email.' ';
        }
        
        if (isset($usuario->id)) {
            $id = $usuario->id;
        } else {
            $id = '';
        }
        if (LAYOULT_IMPRIMIR!='AJAX') {
            $html .= '<div class="profile-head">'.
                        '<div class="col-sm-8">'.
                            '<h1>'.$nome.'</h1>'.
                            '<p>'.$email.'</p>'.
                        '</div>'.

                        '<div class="col-sm-4">'.
                            '<a class="btn btn-edit btn-large pull-right mtop20 lajax explicar-titulo" data-acao="" href="'.URL_PATH.'usuario/Admin/Usuarios_Edit/'.$id.'" title="Editar Usuário">Editar Usuário</a>'.
                        '</div>'.
                    '</div>';
        }
        $html .= '<div class="space15"></div>';
        if (LAYOULT_IMPRIMIR!='AJAX') {
            $html .= '<div class="row">'.
            '<div class="col-sm-8 bio">';
        } else {
            $html .= '<div class="col-sm-12 bio">';
        }
        $html .= '<h2>Dados do '.$tipo.'</h2>';
        if ($usuario->login!='')  $html .= '<p><label style="width:150px;">'.__('Login').' </label>: '.$usuario->login.'</p>';
        if ($usuario->nome!='')  $html .= '<p><label style="width:150px;">'.__('Nome Completo').' </label>: '.$usuario->nome.'</p>';
        if ($usuario->nome_contato!='')  $html .= '<p><label style="width:150px;">'.__('Nome Contato').' </label>: '.$usuario->nome_contato.'</p>';
        if ($usuario->email!='')  $html .= '<p><label style="width:150px;">'.__('Email').' </label>: '.$usuario->email.'</p>';
        if ($usuario->email2!='')  $html .= '<p><label style="width:150px;">'.__('Email Alternativo').' </label>: '.$usuario->email2.'</p>';
        if ($usuario->telefone!='')  $html .= '<p><label style="width:150px;">'.__('Telefone Fixo').' </label>: '.$usuario->telefone.'</p>';
        if ($usuario->telefone2!='')  $html .= '<p><label style="width:150px;">'.__('Telefone Fixo 2').' </label>: '.$usuario->telefone2.'</p>';
        if ($usuario->celular!='')  $html .= '<p><label style="width:150px;">'.__('Celular').' </label>: '.$usuario->celular.'</p>';
        if ($usuario->fax!='')  $html .= '<p><label style="width:150px;">'.__('Fax').' </label>: '.$usuario->fax.'</p>';
        if (isset($usuario->crm) && $usuario->crm!='')  $html .= '<p><label style="width:150px;">'.__('CRM').' </label>: '.$usuario->crm.'</p>';
        if ($usuario->cpf!='')  $html .= '<p><label style="width:150px;">'.__('CPF').' </label>: '.$usuario->cpf.'</p>';
        if ($usuario->cnpj!='')  $html .= '<p><label style="width:150px;">'.__('CNPJ').' </label>: '.$usuario->cnpj.'</p>';
        if ($usuario->cnpj_insc!='')  $html .= '<p><label style="width:150px;">'.__('Insc. Estadual / Municipal').' </label>: '.$usuario->cnpj_insc.'</p>';
        if ($usuario->razao_social!='')  $html .= '<p><label style="width:150px;">'.__('Razão Social').' </label>: '.$usuario->razao_social.'</p>';
        if ($usuario->nomefantasia!='')  $html .= '<p><label style="width:150px;">'.__('Nome Fantasia').' </label>: '.$usuario->nomefantasia.'</p>';
        if ($usuario->resp_tecnico!='')  $html .= '<p><label style="width:150px;">'.__('Responsável Técnico').' </label>: '.$usuario->resp_tecnico.'</p>';
        if ($usuario->resg_tecnico!='')  $html .= '<p><label style="width:150px;">'.__('Registro do Técnico').' </label>: '.$usuario->resg_tecnico.'</p>';
        if ($usuario->banco!='')  $html .= '<p><label style="width:150px;">'.__('banco').' </label>: '.$usuario->banco.'</p>';
        if ($usuario->agencia!='')  $html .= '<p><label style="width:150px;">'.__('Agência').' </label>: '.$usuario->agencia.'</p>';
        if ($usuario->conta!='')  $html .= '<p><label style="width:150px;">'.__('Conta').' </label>: '.$usuario->conta.'</p>';
        if ($usuario->site!='' && $usuario->site!='http://')  $html .= '<p><label style="width:150px;">'.__('Site').' </label>: '.$usuario->site.'</p>';
        if ($usuario->perfil_nascimento!=='' && $usuario->perfil_nascimento!=='//' && $usuario->perfil_nascimento!=='0000/00/00' && $usuario->perfil_nascimento!='00/00/0000')  $html .= '<p><label style="width:150px;">'.__('Nascimento').' </label>: '.$usuario->perfil_nascimento.'</p>';
        if ($usuario->cep!='')  $html .= '<p><label style="width:150px;">'.__('Cep').' </label>: '.$usuario->cep.'</p>';
        if ($usuario->pais2!='')  $html .= '<p><label style="width:150px;">'.__('País').' </label>: '.$usuario->pais2.'</p>';
        if ($usuario->estado2!='')  $html .= '<p><label style="width:150px;">'.__('Estado').' </label>: '.$usuario->estado2.'</p>';
        if ($usuario->cidade2!='')  $html .= '<p><label style="width:150px;">'.__('Cidade').' </label>: '.$usuario->cidade2.'</p>';
        if ($usuario->bairro2!='')  $html .= '<p><label style="width:150px;">'.__('Bairro').' </label>: '.$usuario->bairro2.'</p>';
        if ($usuario->endereco!='')  $html .= '<p><label style="width:150px;">'.__('Endereço').' </label>: '.$usuario->endereco.'</p>';
        if ($usuario->numero!='')  $html .= '<p><label style="width:150px;">'.__('Número').' </label>: '.$usuario->numero.'</p>';
        if ($usuario->complemento!='')  $html .= '<p><label style="width:150px;">'.__('Complemento').' </label>: '.$usuario->complemento.'</p>';
        if ($usuario->data_admissao!='')  $html .= '<p><label style="width:150px;">'.__('Data de Admissão').' </label>: '.$usuario->data_admissao.'</p>';
        if ($usuario->data_demissao!='')  $html .= '<p><label style="width:150px;">'.__('Data de Demissão').' </label>: '.$usuario->data_demissao.'</p>';
        if ($usuario->vale_transporte!=='' && $usuario->vale_transporte!=='R$0,00')  $html .= '<p><label style="width:150px;">'.__('Vale Transporte').' </label>: '.$usuario->vale_transporte.'</p>';
        if ($usuario->vale_refeicao!='' && $usuario->vale_refeicao!=='R$0,00')  $html .= '<p><label style="width:150px;">'.__('Vale Refeição').' </label>: '.$usuario->vale_refeicao.'</p>';
        if ($usuario->hora_entrada!='')  $html .= '<p><label style="width:150px;">'.__('Hora da Entrada').' </label>: '.$usuario->hora_entrada.'</p>';
        if ($usuario->hora_saida!='')  $html .= '<p><label style="width:150px;">'.__('Hora da Saida').' </label>: '.$usuario->hora_saida.'</p>';
        if ($usuario->salariobase!=='' && $usuario->salariobase!=='R$0,00')  $html .= '<p><label style="width:150px;">'.__('Salário Base').' </label>: '.$usuario->salariobase.'</p>';
        if ($usuario->tipocontrato!='')  $html .= '<p><label style="width:150px;">'.__('Tipo de Contrato').' </label>: '.$usuario->tipocontrato.'</p>';
        if ($usuario->cnh!='')  $html .= '<p><label style="width:150px;">'.__('CNH').' </label>: '.$usuario->cnh.'</p>';
        '<div class="space15"></div>';
        if ($usuario->obs!='') {
            if (\Framework\App\Sistema_Funcoes::Perm_Modulos('usuario_mensagem')) {
                $html .= '<h2>'.__('Mensagem').'</h2>';
            } else {
                $html .= '<h2>'.__('Observação').'</h2>';
            }
           $html .= '<p>'.$usuario->obs.'</p>';
        }
        $html .= '<div class="space15"></div>';
        if (LAYOULT_IMPRIMIR!='AJAX') {
            $html .= '</div>';
            if ($mensagens !== false) {
                $html .= '<div class="col-sm-4">';
                foreach ($mensagens AS &$valor) {
                    $html .= '';
                }
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
    public function Show_Perfil($tipo,&$usuario, $layoult='Unico') {
        $nome = $usuario->nome;
        $html = self::Show_HTML($usuario, $tipo);
        
        if (SQL_MAIUSCULO) {
            $titulo = 'VISUALIZAR '.$nome; //mb_strtoupper( )
        } else {
            $titulo = 'Visualizar '.$nome;
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
            $this->Json_IncluiTipo('Popup', $popup);
        } else {
            $this->Blocar($html);
            if ($layoult=='Unico') {
                $this->Bloco_Unico_CriaConteudo();
            } else if ($layoult=='Maior') {
                $this->Bloco_Maior_CriaConteudo();
            } else {
                $this->Bloco_Menor_CriaConteudo();
            }
            $this->Json_Info_Update('Titulo', $titulo);
        }
    }
}
?>
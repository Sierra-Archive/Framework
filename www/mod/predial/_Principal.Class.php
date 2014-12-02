<?php
class predial_Principal implements PrincipalInterface
{
    /**
     * Função Home para o modulo mensagem aparecer na pagina HOME
     * 
     * @name Home
     * @access public
     * @static
     * 
     * @param Class &$controle Classe Controle Atual passada por Ponteiro
     * @param Class &$modelo Modelo Passado por Ponteiro
     * @param Class &$Visual Visual Passado por Ponteiro
     *
     * @uses predial_Controle::$num_Indicados
     * 
     * @return void 
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Home(&$controle, &$modelo, &$Visual){
        self::Widgets();
        return true;
    }
    /**
     * 
     * @return boolean
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Config(){
        return false;
    }
    
    static function Relatorio($data_inicio,$data_final,$filtro=false){
        return false;
    }
    
    static function Estatistica($data_inicio,$data_final,$filtro=false){
        return false;
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public static function Widgets(){
        $Registro = &\Framework\App\Registro::getInstacia();
        $modelo = $Registro->_Modelo;
        $Visual = $Registro->_Visual;
        
        
        
        if(\Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('predial/Correio/Correios')){
            // Correios
            $where = Array(
                'data_recebido'     =>      '0000-00-00 00:00:00'
            );
            $correio = $modelo->db->Sql_Select('Predial_Bloco_Apart_Correio',$where);
            if(is_object($correio)) $correio = Array(0=>$correio);
            if($correio!==false && !empty($correio)){
                reset($correio);
                $correio_qnt = count($correio);
            }else{
                $correio_qnt = 0;
            }
            // Adiciona Widget a Pagina Inicial
            \Framework\App\Visual::Layoult_Home_Widgets_Add(
                'Correios recebidos e não entregues', 
                'predial/Correio/Correios', 
                'envelope', 
                '+'.$correio_qnt, 
                'block-yellow', 
                true, 
                260,
                false  // bloquea pra nao gastar processamento
            );
        }
        
        
        // Area de Donos de Apartamentos
        $id = \Framework\App\Acl::Usuario_GetID_Static();
        if($id!==false && $id!==0){
            // Correios
            $where = Array(
                'morador'     => $id
            );
            $apartamentos = $modelo->db->Sql_Select('Predial_Bloco_Apart',$where);
            if(is_object($apartamentos)) $apartamentos = Array(0=>$apartamentos);
            if($apartamentos!==false && !empty($apartamentos)){
                foreach ($apartamentos as $valor){
                    $apartamento = $valor->id;
                    list($titulo1,$html1) = predial_AdvertenciaControle::Personalizados($apartamento);
                    list($titulo2,$html2) = predial_CorreioControle::Personalizados($apartamento,false, 10);
                    list($titulo3,$html3) = predial_CorreioControle::Personalizados($apartamento,true);

                    // Adiciona o Conteudo
                    $Visual->Blocar($Visual->Bloco_Customizavel(Array(
                        Array(
                            'span'      =>      7,
                            'conteudo'  =>  Array(Array(
                                'div_ext'   =>      false,
                                'title_id'  =>      false,
                                'title'     =>      $titulo1,
                                'html'      =>      $html1,
                            ),),
                        ),
                        Array(
                            'span'      =>      5,
                            'conteudo'  =>  Array(Array(
                                'div_ext'   =>      false,
                                'title_id'  =>      false,
                                'title'     =>      $titulo2,
                                'html'      =>      $html2,
                            ),Array(
                                'div_ext'   =>      false,
                                'title_id'  =>      false,
                                'title'     =>      $titulo3,
                                'html'      =>      $html3,
                            ),),
                        )
                    ),false));
                    // Bota na Ultima Tabela
                    $Visual->Bloco_Unico_CriaJanela('Apartamento '.$valor->num.' - Bloco '.$valor->bloco2);
                }
            }
        }
        
        
        
        
        
        
        
        
    }
    
    
    /***********************
     * BUSCAS
     */
    static function Busca(&$controle, &$modelo, &$Visual,$busca){
        $i = 0;
        // Busca Advertencias
        $result = self::Busca_Advertencias($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Animal
        $result = self::Busca_Animais($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Apartamento
        $result = self::Busca_Apartamentos($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Bloco
        $result = self::Busca_Blocos($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Correios
        $result = self::Busca_Correios($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Informativos
        $result = self::Busca_Informativos($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        // Busca Veiculo
        $result = self::Busca_Veiculos($controle, $modelo, $Visual, $busca);
        if($result!==false){
            $i = $i + $result;
        }
        if(is_int($i) && $i>0){
            return $i;
        }else{
            return false;
        }
    }
    static function Busca_Advertencias($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'nome'                    => '%'.$busca.'%',
          'descricao'               => '%'.$busca.'%',
          'data_acontecimento'      => '%'.$busca.'%'
        ));
        $i = 0;
        $advertencias = $modelo->db->Sql_Select('Predial_Bloco_Apart_Advertencia',$where);
        if($advertencias===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Advertência" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Advertencia/Advertencias_Add">Adicionar nova Advertência</a><div class="space15"></div>');
        if(is_object($advertencias)) $advertencias = Array(0=>$advertencias);
        if($advertencias!==false && !empty($advertencias)){
            list($tabela,$i) = predial_AdvertenciaControle::Advertencias_Tabela($advertencias);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhuma Advertência na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Advertências: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Animais($controle, $modelo, $Visual, $busca){
        $where = Array(
          'nome'                    => '%'.$busca.'%'
        );
        $i = 0;
        $animais = $modelo->db->Sql_Select('Predial_Bloco_Apart_Animal',$where);
        if($animais===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Animal" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Correio/Animais_Add">Adicionar novo Animal</a><div class="space15"></div>');
        if(is_object($animais)) $animais = Array(0=>$animais);
        if($animais!==false && !empty($animais)){
            list($tabela,$i) = predial_CorreioControle::Animais_Tabela($animais);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{           
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Animal na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Animais: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Apartamentos($controle, $modelo, $Visual, $busca){
        $where = Array(
          'num'                     => '%'.$busca.'%'
        );
        $i = 0;
        $apartamentos = $modelo->db->Sql_Select('Predial_Bloco_Apart',$where);
        if($apartamentos===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Apartamento" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Apart/Aparts_Add">Adicionar novo Apartamento</a><div class="space15"></div>');
        if(is_object($apartamentos)) $apartamentos = Array(0=>$apartamentos);
        if($apartamentos!==false && !empty($apartamentos)){
            list($tabela,$i) = predial_ApartControle::Aparts_Tabela($apartamentos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{       
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Apartamento na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Apartamentos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Blocos($controle, $modelo, $Visual, $busca){
        $where = Array(
          'nome'                    => '%'.$busca.'%'
        );
        $i = 0;
        $blocos = $modelo->db->Sql_Select('Predial_Bloco',$where);
        if($blocos===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Bloco" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Bloco/Blocos_Add">Adicionar novo Bloco</a><div class="space15"></div>');
        if(is_object($blocos)) $blocos = Array(0=>$blocos);
        if($blocos!==false && !empty($blocos)){
            list($tabela,$i) = predial_BlocoControle::Blocos_Tabela($blocos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{          
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Bloco na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Blocos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }    
    static function Busca_Correios(&$controle, &$modelo, &$Visual,$busca){
        $where = Array(Array(
          //'PB.nome'                 => '%'.$busca.'%',
          //'PBA.numero'              => '%'.$busca.'%',
          'responsavel'             => '%'.$busca.'%',
          'data_entregue'           => '%'.$busca.'%',
          'data_recebido'           => '%'.$busca.'%'
        ));
        $i = 0;
        $correios = $modelo->db->Sql_Select('Predial_Bloco_Apart_Correio',$where);
        if($correios===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Correio" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Correio/Correios_Add">Adicionar novo Correio</a><div class="space15"></div>');
        if(is_object($correios)) $correios = Array(0=>$correios);
        if($correios!==false && !empty($correios)){
            list($tabela,$i) = predial_CorreioControle::Correios_Tabela($correios);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{       
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Correio na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Correios: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Informativos($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          //'PB.nome'                 => '%'.$busca.'%',
          //'PBA.numero'              => '%'.$busca.'%',
          'nome'                    => '%'.$busca.'%',
          'descricao'               => '%'.$busca.'%',
          'data_inicio'             => '%'.$busca.'%',
          'data_fim'                => '%'.$busca.'%'
        ));
        $i = 0;
        $informativos = $modelo->db->Sql_Select('Predial_Bloco_Apart_Informativo',$where);
        if($informativos===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Informativo" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Informativo/Informativos_Add">Adicionar novo Informativo</a><div class="space15"></div>');
        if(is_object($informativos)) $informativos = Array(0=>$informativos);
        if($informativos!==false && !empty($informativos)){
            list($tabela,$i) = predial_InformativoControle::Informativos_Tabela($informativos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{     
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Informativo na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Informativos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
    static function Busca_Veiculos($controle, $modelo, $Visual, $busca){
        $where = Array(Array(
          'marca'                   => '%'.$busca.'%',
          'modelo'                  => '%'.$busca.'%',
          'cor'                     => '%'.$busca.'%',
          'placa'                   => '%'.$busca.'%'
        ));
        $i = 0;
        $veiculos = $modelo->db->Sql_Select('Predial_Bloco_Apart_Veiculo',$where);
        if($veiculos===false) return false;
        // add botao
        $Visual->Blocar('<a title="Adicionar Veiculo" class="btn btn-success lajax explicar-titulo" acao="" href="'.URL_PATH.'predial/Correio/Veiculos_Add">Adicionar novo Veiculo</a><div class="space15"></div>');
        if(is_object($veiculos)) $veiculos = Array(0=>$veiculos);
        if($veiculos!==false && !empty($veiculos)){
            list($tabela,$i) = predial_CorreioControle::Veiculos_Tabela($veiculos);
            $Visual->Show_Tabela_DataTable($tabela);
        }else{      
            $Visual->Blocar('<center><b><font color="#FF0000" size="5">Nenhum Veiculo na Busca '.$busca.'</font></b></center>');
        }
        $titulo = 'Busca de Veiculos: '.$busca.' ('.$i.')';
        $Visual->Bloco_Unico_CriaJanela($titulo);
        return $i;
    }
}
?>

<?php
class Enquete_ShowControle extends Enquete_Controle
{
    public function __construct(){
        parent::__construct();
    }
    /**
    * Main
    * 
    * @name Main
    * @access public
    * 
    * @uses enquete_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function Main(){
        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','Enquetes'); 
    }
    static function Show($bloco='right',$id_min=0){
        // Verifica Permissao
        if(\Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Chave('Enquete_Show')===false) return false;
        
        $registro = &\Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        $Visual = $registro->_Visual;
        // Procura Uma enquete aleatória se nao
        $enquetes = $Modelo->db->Sql_Select('Enquete',
                Array('>id'=>$id_min),
                1/*,
                'rand()'*/
        );
        if($enquetes===false) return false;
        $titulo2 = $enquetes->nome;
        $respostas = $Modelo->db->Sql_Select('Enquete_Resposta',Array(
            'enquete'       =>  $enquetes->id),
            0
        );    
        if($respostas===false){
            return self::Show($bloco,$enquetes->id);
        }
        if(is_object($respostas)) return false;
        if(\Framework\App\Acl::Usuario_GetID_Static()==0) return false;
        $voto = $Modelo->db->Sql_Select('Enquete_Voto',Array(
            'enquete'       =>  $enquetes->id,
            'usuario'       =>  \Framework\App\Acl::Usuario_GetID_Static()
        ),1);  
        if($voto!==false){
            $retorno = self::Show($bloco,$enquetes->id);
            if($retorno===false){
                $Visual->Blocar('<span id="home_Enquete_Show">'.self::Show_Resposta($enquetes,$respostas).'</span>');
                // Mostra Conteudo
                if($bloco=='All')   $Visual->Bloco_Unico_CriaJanela($titulo2,'',0); //,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);'
                if($bloco=='right') $Visual->Bloco_Menor_CriaJanela($titulo2,'',0);
                if($bloco=='left')  $Visual->Bloco_Maior_CriaJanela($titulo2,'',0);
                return true;
            }
            return $retorno;
        }
        // Puxa Form
        $form = new \Framework\Classes\Form('Enquete_Show_Votar','Enquete/Show/Votar/'.$enquetes->id,'formajax','mini','vertical');// Add o Radio
        $form->Radio_Novo(
            '',
            'votar',
            'votar',
            '',
            '',
            '',
            '',
            false
        );
        foreach($respostas as &$valor){
            $form->Radio_Opcao($valor->nome,$valor->id,0);
        }
        // Fecha Radio
        $form->Radio_Fim();
        $formulario = $form->retorna_form('Votar');
        $Visual->Blocar('<span id="home_Enquete_Show">'.$formulario.'</span>');
        // Mostra Conteudo
        if($bloco=='All')   $Visual->Bloco_Unico_CriaJanela($titulo2,'',0); //,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);'
        if($bloco=='right') $Visual->Bloco_Menor_CriaJanela($titulo2,'',0);
        if($bloco=='left')  $Visual->Bloco_Maior_CriaJanela($titulo2,'',0);
        // Pagina Config
    }
    static function Show_Resposta(&$enquete,&$respostas){
        $registro = \Framework\App\Registro::getInstacia();
        $Modelo = $registro->_Modelo;
        
        $id = (int) $enquete->id;
        $votos = $Modelo->db->Sql_Select('Enquete_Voto',Array(
            'enquete'       =>  $id
        ));
        if(is_object($respostas)) $respostas = Array($respostas);
        if(is_object($votos)) $votos = Array($votos);
        if($votos===false){
            $total_votos = 0;
        }else{
            $total_votos = count($votos);
        }
        // Zera Votos
        $contagem_votos = Array();
        foreach($respostas as &$valor){
            $contagem_votos[$valor->id] = 0;
        }
        // Captura Cores
        list($cores_qnt,$cores)             = \Framework\App\Visual::Tema_Tipos('label');
        list($barracores_qnt,$barracores)   = \Framework\App\Visual::Tema_Tipos('progress-bar');
        $cor = 0;
        // Percorre Votos
        if(!empty($votos)){
            foreach($votos as &$valor){
                $contagem_votos[$valor->resposta] = 1+$contagem_votos[$valor->resposta];
            }
        }
        // Percorre Respostas
        $html = '<ul class="list-unstyled">';
        foreach($respostas as &$valor){
            if(!isset($contagem_votos[$valor->id]) || $total_votos==0){
                $os_votos  = 0;
                $porc = 0;
            }else{
                $os_votos = $contagem_votos[$valor->id];
                $porc = round($os_votos/$total_votos*100);
            }
            $html .= '<li>'.$valor->nome.' <strong class="label '.$cores[$cor].'"> '.$porc.'%</strong>'.
                '<div class="space10"></div>'.
                '<div class="progress">'.
                    '<div style="width: '.$porc.'%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="'.$porc.'" role="progressbar" class="progress-bar progress-bar-striped '.$barracores[$cor].'">'.
                        '<span class="sr-only">'.$porc.'%</span>'.
                    '</div>'.
                '</div>'.
            '</li>';
            ++$cor;
            if($cor==$cores_qnt) $cor=0;
        }
        $html .= '</ul>';
        return $html;
    }
    public function Votar($enquete = false){
        if($enquete===false){
            throw new \Exception('Enquete nao Especificada', 404);
        }
        $enquete = (int) $enquete;
        // Procura Uma enquete aleatória se nao
        $enquetes = $this->_Modelo->db->Sql_Select('Enquete',
                Array('id'  => $enquete),
                1
        );
        if($enquetes===false){
            throw new \Exception('Enquete nao Existe', 404);
        }
        $respostas = $this->_Modelo->db->Sql_Select('Enquete_Resposta',Array(
            'enquete'       =>  $enquete),
            0
        );    
        if($respostas===false){
            throw new \Exception('Enquete sem respostas', 404);
        }
        $voto = $this->_Modelo->db->Sql_Select('Enquete_Voto',Array(
            'enquete'       =>  $enquete,
            'usuario'       =>  \Framework\App\Acl::Usuario_GetID_Static()
        ),1);  
        if($voto!==false){
            throw new \Exception('Já votou nessa enquete', 9010);
        }
        $voto_do_malandro = (int) $_POST['votar'];
        $gravar_voto = new \Enquete_Voto_DAO();
        $gravar_voto->usuario   = $this->_Acl->Usuario_GetID();
        $gravar_voto->enquete   = $enquete;
        $gravar_voto->resposta  = $voto_do_malandro;
        $this->_Modelo->db->Sql_Inserir($gravar_voto);
        // Nao Zera Layoult
        $this->layoult_zerar = false;
        // Mostra Resposta
        $conteudo = array(
            'location'  => '#home_Enquete_Show',
            'js'        => '',
            'html'      => self::Show_Resposta($enquetes,$respostas)
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $this->_Visual->Json_Info_Update('Historico', false);
        $this->_Visual->Json_Info_Update('Titulo','Voto computado com Sucesso');
    }
}
?>

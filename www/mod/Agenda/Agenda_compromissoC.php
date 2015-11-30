<?php
class Agenda_compromissoControle extends Agenda_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function Main() {
        // CARREGA LOCALIDADES
        $compromisso = array();
        $this->_Modelo->compromisso_fullretorna($compromisso);
        $this->_Visual->Blocar(Agenda_compromissoVisual::show_compromissos($compromisso));   
        $this->_Visual->Bloco_Maior_CriaJanela('Compromissos');
        unset($compromisso); // LIMPA MEMÓRIA

        // cadastro de local
        self::compromisso_formcadastro($this->_Modelo, $this->_Visual);

        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo','compromisso');
    }
    static function anteriorescompromissos(&$modelo, &$Visual){
        // CARREGA LOCALIDADES
        $compromisso = array();
        Agenda_compromissoModelo::compromissos_retornaanteriores($modelo, $compromisso);
        $Visual->Blocar(Agenda_compromissoVisual::show_compromissosanteriores($compromisso));   
        $Visual->Bloco_Maior_CriaJanela('Conferir Compromissos Passados');
        unset($compromisso); // LIMPA MEMÓRIA
    }
    static function proximoscompromissos(&$modelo, &$Visual){
        // CARREGA LOCALIDADES
        $compromisso = array();
        Agenda_compromissoModelo::compromissos_retornaproximos($modelo, $compromisso);
        $Visual->Blocar(Agenda_compromissoVisual::show_compromissos($compromisso));   
        $Visual->Bloco_Maior_CriaJanela('Próximos Compromissos');
        unset($compromisso); // LIMPA MEMÓRIA
    }
    /***********************************
    *
    *  retorna formulario de cadastro de local
    *
    *************************************/
    static function compromisso_formcadastro(&$modelo, &$Visual, $data = false){
        global $language;
        if($data===false) $data = APP_DATA_BR;
        // CARREGA LOCALIDADES
        $selectlocais = array();
        locais_locaisModelo::local_retorna($modelo, $selectlocais);

        // CADASTRA compromisso
        $form = new \Framework\Classes\Form('adminformcompromissosend','Agenda/compromisso/compromisso_inserir/','formajax');
        $form->Input_Novo('Data Inicio','dt_inicio',$data,'text', 10,'obrigatorio', '', false,'','','Data','', false);   
        $form->Input_Novo('Hora Inicio','hr_inicio','','text', 8,'obrigatorio masc_hora');   
        $form->Input_Novo('Data Fim','dt_fim',$data,'text', 10,'obrigatorio', '', false,'','','Data','', false);    
        $form->Input_Novo('Hora Fim','hr_fim','','text', 8,'obrigatorio masc_hora');  
        $form->Input_Novo('Nome','nome','','text', 30, 'obrigatorio ');   
        $form->Input_Novo('Descricao','descricao', 255,'','text');   
        
        // COMEÇO DOS SELECT DE LOCALIDADES
        $form->Select_Novo($language['palavras']['locais'],'local','selectlocais');
        $tamanho = sizeof($selectlocais);
        for($i=0;$i<$tamanho;++$i){
            if(isset($selectlocais[$i]['nome']) && isset($selectlocais[$i]['valor'])){
                if($selectlocais[$i]['valor']==1) $select = 1; else  $select = 0;
                $form->Select_Opcao($selectlocais[$i]['nome'],$selectlocais[$i]['id'],$select);
            }
        }
        $form->Select_Fim();
        // FINAL DOS SELECT DE LOCALIDADES
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);

        $Visual->Blocar($formulario);
        $Visual->Bloco_Menor_CriaJanela('Inserir Compromisso');

        $Visual->Javascript_Executar('Sierra.Control_Layoult_Calendario(\'dt_inicio\',\''.$data.'\');Sierra.Control_Layoult_Calendario(\'dt_fim\',\''.$data.'\');');

    }
    public function compromisso($id){
        $id = (int) $id;
   
        // MOSTRA LOCAL
        $local = $this->_Modelo->local_fullretorna_unico($id);
        $this->_Visual->Blocar($this->_Visual->show_local($local));
        $this->_Visual->Bloco_Maior_CriaJanela($local['nome'].' - '.$language['palavras']['info']);

        // eventos
        $eventos = array();
        $this->_Modelo->local_retornaeventos($eventos,$id); 
        $this->_Visual->Blocar($this->_Visual->show_eventos($eventos));   
        $this->_Visual->Bloco_Maior_CriaJanela($language['titulos']['evento']);
        unset($eventos);

        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Info_Update('Titulo',$local['nome'].' - '.$language['palavras']['info']);
        $conteudo = array(
            "location" => "#main-content-left",
            "js" => $js,
            "html" =>  $this->_Visual->getjanela()
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        $conteudo = array(
            "location" => "#loadcoldir",
            "js" => "",
            "html" => ''//$this->_Visual->getjaneladir()
        );
        $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
          
    }
    public function compromisso_inserir($retorna=0){
        global $language;
        $retorna = (int) $retorna;
        $nome = \anti_injection($_POST["nome"]);
        $dt_inicio = data_hora_brasil_eua(\anti_injection($_POST["dt_inicio"].' '.$_POST["hr_inicio"]));
        $dt_fim = data_hora_brasil_eua(\anti_injection($_POST["dt_fim"].' '.$_POST["hr_fim"]));
        //data_hora_brasil_eua()
        $descricao = \anti_injection($_POST["descricao"]);
        $local = (int) $_POST["local"];

        $sucesso =  $this->_Modelo->compromisso_inserir($nome,$dt_inicio,$dt_fim,$descricao,$local);
        $compromissos = array();
        $this->_Modelo->compromisso_retorna($compromissos);
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => 'Compromisso inserido com Sucesso',
                "mgs_secundaria" => $nome.' foi add a base de dados...'
            );
            $tamanho = sizeof($compromissos);
            for($i=0;$i<$tamanho;++$i){
                if($compromissos[$i]['nome']==$nome) $ativar = 1;
                else                            $ativar = 0;
                $form .= \Framework\Classes\Form::Select_Opcao_Stat($compromissos[$i]['nome'],$compromissos[$i]['id'],$ativar);
            }
            if($retorna==1){
                $conteudo = array(
                    "location" => "#selectcompromisso",
                    "js" => "",
                    "html" => $form
                );
                $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);                     
            }
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        echo $this->_Visual->Json_Retorna();
    
    }
}
?>

<?php

namespace Framework\Classes;

class Form 
{
    private $form               ;
    private $layoult            = 'mini';
    private $_Registro          ;
    private $_Visual            ;
    // Coluna Tipo
    private $ColunaTipo         = 'horizontal';
    //
    private $selectextra        = '';
    private $selectid           = '';
    private $selectcondicao     = '';
    private $radioextra         = '';
    private $radioid            = '';
    private $radiocondicao      = '';
    private $checkboxextra      = '';
    private $checkboxid         = '';
    private $checkboxcondicao   = '';
    // SE Formulario tem bloqueio de acesso a botoes extrangeiros
    private $form_dependencia   = false;
    static  $controle_duallist      = 0;
    static  $tab_index           = 1;
    /**
    * Construtor de Formul�rio
    * 
    * @name __construct
    * @access public
    * 
    * @param string $id Atributo id do Formulario
    * @param string $endereco Atributo url do Formulario
    * @param string $class Atributo class do Formulario
    * 
    * @uses \Framework\Classes\Form::$form
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function __construct($id = 'formulario',$endereco = '', $classe='', $layoult="mini",$ColunaTipo='horizontal',$autocomplete='on') { //layoult pode ser comprimido, completo, ajax
        // Puxa Registro
        $this->_Registro = &\Framework\App\Registro::getInstacia();
        $this->_Visual     = &$this->_Registro->_Visual;
        $this->layoult = $layoult;
        // Grava Coluna Tipo
        $this->ColunaTipo = $ColunaTipo;
        // Popup SELECT
        if(isset($_GET['formselect']) && $_GET['formselect']!='' && isset($_GET['condicao']) && $_GET['condicao']!=''){
            $extra = '?formselect='.\anti_injection($_GET['formselect']).
                     '&condicao='.\anti_injection($_GET['condicao']);
            $this->form_dependencia = true;
        }else{
            $extra = '';
        }
        // Puxa Layoult
        $config = Array(
            'Tipo'      => 'Entrada',
            'Opcao'     => Array(
                'id'                => $id,
                'class'             => $classe,
                'url'               => URL_PATH,
                'end'               => $endereco.$extra,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'ColunaForm'        => $ColunaTipo,
                'AutoComplete'      => $autocomplete
            )
        );
        $this->form = $this->_Visual->renderizar_bloco('template_form',$config);
    }
    /**
     * 
     * @param type $titulo
     * @param type $col1
     * @param type $col2
     * @param string $id
     * @param type $class
     * @param type $nao_selecionado
     * @param type $selecionado
     * @param type $escondido
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function BoleanoMultiplo($titulo='',$col1 = 'Não Permitido',$col2 = 'Permitido',$id='padrao',$class='',$nao_selecionado = Array(),$selecionado = Array(), $escondido=false){
        // Aumenta o id e Add javascript no Visual
        $controle_duallist = &self::$controle_duallist;
        ++$controle_duallist;
        ++self::$tab_index;
        
        $id = $id.'[]';
        $registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = $registro->_Visual;
        $Visual->Javascript_Executar('var form_duallist'.$controle_duallist.' = $(\'.form_duallist'.$controle_duallist.'\').bootstrapDualListbox('.
            '{bootstrap2compatible: true,'.
            'nonselectedlistlabel: \''.$col1.'\','.
            'selectedlistlabel: \''.$col2.'\','.
            'preserveselectiononmove: \'moved\','.
            'moveonselect: false,'.
            'infotext: \'Mostrando {0}\','.
            'infotextfiltered: \'<span class="label label-warning">Filtrado</span> {0} de {1}\','.
            'infotextempty: \'Lista Vazia\','.
            'filterplaceholder: \'Filtro\','.
            'filtertextclear: \'mostrar tudo\'}'.
        ');');
        // Cria Formulario
        $html  = '<select tabindex="'.self::$tab_index.'" multiple="multiple" size="10" id="'.$id.'" name="'.$id.'" class="form_duallist'.$controle_duallist.'">';
        if(!empty($nao_selecionado) && is_array($nao_selecionado)){
            foreach($nao_selecionado as $indice=>&$valor){
                $html .= '<option value="'.$indice.'">'.$valor.'</option>';
            }
        }
        if(!empty($selecionado) && is_array($selecionado)){
            foreach($selecionado as $indice=>&$valor){
                $html .= '<option value="'.$indice.'" selected="selected">'.$valor.'</option>';
            }
        }
        $html .= '</select>';
        // Puxa Layoult
        $config = Array(
            'Tipo'      => 'Conteudo',
            'Opcao'     => Array(
                'id'                => $id,
                'titulo'            => $titulo,
                'html'              => $html,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @param type $titulo
     * @param type $col1
     * @param type $col2
     * @param string $id
     * @param type $class
     * @param type $nao_selecionado
     * @param type $selecionado
     * @param type $escondido
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function SelectMultiplo($titulo='',$opcoes = Array(),$id=false,$url='',$campos=false, $javascript_campos = false, $condicao=false, $escondido = false, $class='', $infonulo='Escolha uma opção'){
        //Aumenta o id e Add javascript no Visual
        ++self::$tab_index;
        if($id!==false){
            $id = \anti_injection($id);
        }
        $registro   = &\Framework\App\Registro::getInstacia();
        $Visual     = $registro->_Visual;
        // Zera VAriaveis
        $change = '';
        if($campos!==false && $javascript_campos!==false){
            // Javascript
            $js = '<script LANGUAGE="JavaScript" TYPE="text/javascript">';
            $js .= 'function Form_Change_'.$id.'(){'. 
                'var valores_usados = $("#'.$id.'").val();'.
                '$("#'.$id.'controlador > span").attr("calculado",0);'.
                'if(typeof(valores_usados)!="undefined" && valores_usados!=null){'.
                    'var length = valores_usados.length;'.
                    'for(var i = 0; i < length; i++) {'.
                    
                    
                        // Deleta Duplicados
                        // Trocado de chzn para chosen, nao sei qual bug que dava, mas acho que nao ocorre mais
                        // vou comentar
                        /*'var j = 0;'.
                        '$(\'#'.$id.'_chosen\').find(\'#'.$id.'_chzn_c_\'+valores_usados[i]).each(function(i){'.
                            '++j;'.
                            'if(j>1){'.
                                '$(this).delete();'.
                            '}'.
                        '});'.*/
                    
                    
                        // Puxa Nome, E troca calculado pra 1 caso exista
                        'var nome = $("#'.$id.' option[value="+valores_usados[i]+"]").html();'.
                        'if(nome!=\'\'){'.
                            'if($("#'.$id.'controlador_"+valores_usados[i]+"").size()!=1){'.
                                'var java_campos = "'.$javascript_campos.'";'.
                                'java_campos = java_campos.replace(/{id}/g, valores_usados[i]);'.
                                'java_campos = java_campos.replace(/{nome}/g, Sierra.Visual_Tratamento_Maiusculo_Primeira(nome,true));'.
                                '$( "#'.$id.'controlador" ).append("<span id=\"'.$id.'controlador_"+valores_usados[i]+"\" calculado=\"1\">'.
                                    '"+java_campos+"'.
                                    //'<hr>'.
                                    '</span>"'.
                                ');'.
                            '}else{'.
                                '$("#'.$id.'controlador_"+valores_usados[i]+"").attr("calculado",1);'.
                            '}'.
                        '}'.
                    '}'.
                '}'.
                '$("#'.$id.'controlador1").attr("calculado",1);$("#'.$id.'controlador > span[calculado=0]").remove();'.
                'Sierra.Control_Layoult_Recarrega_Formulario();'.
            '}</script>';
            $Visual->Blocar($js);
            $change = 'Form_Change_'.$id.'()';
        }
        // Se tiver Obrigatorio bota Asteristico
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        } 
        // Add Valor Zero
        $nenhum_selecionado = true;
        foreach($opcoes as $valor){
            if($valor['selected']===1){
                $nenhum_selecionado = false;
                continue;
            }
        }
        if($nenhum_selecionado) array_unshift($opcoes, Array('titulo'=>'','valor'=>'','selected'=>1));
        // Puxa Formulario
        $config = Array(
            'Tipo'      => 'SelectMultiplo',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'url'               => URL_PATH,
                // Entrada
                'id'                => $id,
                'titulo'            => $titulo,
                'nome'              => $id.'[]',
                'end'               => $url,
                'change'            => $change,
                'js'                => '',
                'condicao'          => $condicao,
                'escondido'         => $escondido,
                'class'             => $class,
                'infonulo'          => $infonulo,
                'Option'            => $opcoes,  
                // Outros
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html = $Visual->renderizar_bloco('template_form',$config);
        $this->form .= $html;
        return $html;
    }
    /**
     * 
     * @param type $titulo
     * @param type $value
     * @param type $selected
     * @return string
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    static function Select_Opcao_Stat($titulo,$value,$selected = 0){        
        $_Registro = &\Framework\App\Registro::getInstacia();
        $_Visual     = $_Registro->_Visual;
        $config = Array(
            'Tipo'      => 'Select_Opcao',
            'Opcao'     => Array(
                'titulo'    => $titulo,
                'valor'     => $value,
                'selected'  => $selected,
                'layoult'   => 'mini'
            )
        );
        return $_Visual->renderizar_bloco('template_form',$config);
    }
    public function Upload($titulo,$name,$value,$type = 'Imagem', $class='', $info='', $info_titulo='', $somenteleitura=false,$valida='', $escondido = false){
  
        ++self::$tab_index;
        //Começa
        $id = $name;
        // Verifica se é obrigatorio
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        } 
        // Faz Array
        $config = Array(
            'Tipo'      => 'Upload',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'id'                => $id,
                'nome'              => $name,
                'titulo'            => $titulo,
                'class'             => $class,
                'valor'             => $value,
                'tipo'              => $type,
                'info'              => $info,
                'info_titulo'       => $info_titulo,
                'somenteleitura'    => $somenteleitura,
                'valida'            => $valida,
                'form_dependencia'  => $this->form_dependencia,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form .= $html;
        return $html;
    }
    /**
     * 
     * @param string $titulo
     * @param type $name
     * @param type $value
     * @param type $type
     * @param type $class
     * @param type $info
     * @param type $somenteleitura
     * @param type $urlextra
     * @param type $change
     * @param type $valida
     * @param type $escondido
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Input_Novo($titulo,$name,$value,$type = 'text', $max_caracteres = false, $class='', $info='', $somenteleitura=false,$urlextra='',$change='',$mascara=false,$valida='', $escondido = false){
  
        ++self::$tab_index;
        //Começa
        $id = $name;
        // Verifica se é obrigatorio
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        } 
        // Trata o Change
        if($change!==false && $change!='' && is_string($change)){
            if(strpos($change, 'Local::')!==false){
                $change = str_replace(Array('Local::'), Array(''), $change);
                $change = $change;
            }else{
                $change = 'Sierra.'.$change;
            }
        }
        // Faz Array
        $config = Array(
            'Tipo'      => 'Input',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'id'                => $id,
                'nome'              => $name,
                'titulo'            => $titulo,
                'class'             => $class,
                'valor'             => $value,
                'max_caracteres'    => $max_caracteres,
                'tipo'              => $type,
                'info'              => $info,
                'somenteleitura'    => $somenteleitura,
                'layoult'           => $this->layoult,
                'urlextra'          => $urlextra,
                'change'            => $change,
                'Mascara'           => $mascara,
                'valida'            => $valida,
                'form_dependencia'  => $this->form_dependencia,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form .= $html;
        return $html;
    }
    /**
     * 
     * @param string $titulo
     * @param type $name
     * @param type $id
     * @param type $value
     * @param type $type
     * @param type $class
     * @param type $info
     * @param type $somenteleitura
     * @param type $urlextra
     * @param type $escondido
     * @return type
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function TextArea_Novo($titulo,$name,$id = '',$value = '',$type = 'text', $max_caracteres = false, $class='', $info='', $somenteleitura=false,$urlextra='', $escondido = false){
        
        ++self::$tab_index;
        // Verifica se é obrigatorio
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        }        
        //Começa
        $config = Array(
            'Tipo'      => 'TextArea',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'id'                => $id,
                'nome'              => $name,
                'titulo'            => $titulo,
                'class'             => $class,
                'valor'             => $value,
                'max_caracteres'    => $max_caracteres,
                'tipo'              => $type,
                'info'              => $info,
                'somenteleitura'    => $somenteleitura,
                'layoult'           => $this->layoult,
                'urlextra'          => $urlextra,
                'form_dependencia'  => $this->form_dependencia,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form .= $html;
        return $html;
    }
    /**
     * 
     * @param string $titulo
     * @param type $name
     * @param type $id
     * @param type $url
     * @param type $change
     * @param type $js
     * @param type $condicao
     * @param type $escondido
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Radio_Novo($titulo,$name,$id='',$url='',$change='', $js = '', $condicao=false, $escondido = false){
        // Verifica se é obrigatorio
        /*if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        }*/
        // Trata o Change
        if($change!==false && $change!='' && is_string($change)){
            if(strpos($change, 'Local::')!==false){
                $change = str_replace(Array('Local::'), Array(''), $change);
                $change = $change;
            }else{
                $change = 'Sierra.'.$change;
            }
        }
        //Começa
        $config = Array(
            'Tipo'      => 'Radio_Inicio',
            'Opcao'     => Array(
                'id'                => $id,
                'titulo'            => $titulo,
                'nome'              => $name,
                'url'               => URL_PATH,
                'end'               => $url,
                'change'            => $change,
                'js'                => $js,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $condicao,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $this->radioextra       = $url;
        $this->radiocondicao    = $condicao;
        $this->radioid          = $id;
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @param type $titulo
     * @param type $value
     * @param type $selected
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Radio_Opcao($titulo,$value,$selected = 0){
        ++self::$tab_index;
        if($this->ColunaTipo=='vertical'){
            $classextra = 'radio-block-level';
        }else{
            $classextra = 'radio';
        }
        $config = Array(
            'Tipo'      => 'Radio_Opcao',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'titulo'            => $titulo,
                'valor'             => $value,
                'selected'          => $selected,
                'id'                => $this->radioid,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'classextra'        => $classextra,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Radio_Fim(){
        $config = Array(
            'Tipo'      => 'Radio_Fim',
            'Opcao'     => Array(
                'url'               => URL_PATH,
                'layoult'           => $this->layoult,
                'id'                => $this->radioid,
                'end'               => $this->radioextra,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $this->radiocondicao,
            )
        );
        $this->radioid          = '';
        $this->radioextra       = '';
        $this->radiocondicao    = '';
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    public function Checkbox_Novo($titulo,$name,$id='',$url='',$change='', $js = '', $condicao=false, $escondido = false){
        // Verifica se é obrigatorio
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        }
        // Trata o Change
        if($change!==false && $change!='' && is_string($change)){
            if(strpos($change, 'Local::')!==false){
                $change = str_replace(Array('Local::'), Array(''), $change);
                $change = $change;
            }else{
                $change = 'Sierra.'.$change;
            }
        }
        //Começa
        $config = Array(
            'Tipo'      => 'CheckBox_Inicio',
            'Opcao'     => Array(
                'id'                => $id,
                'titulo'            => $titulo,
                'nome'              => $name,
                'url'               => URL_PATH,
                'end'               => $url,
                'change'            => $change,
                'js'                => $js,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $condicao,
                'escondido'         => $escondido,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $this->checkboxextra      = $url;
        $this->checkboxcondicao   = $condicao;
        $this->checkboxid         = $id;
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @param type $titulo
     * @param type $value
     * @param type $selected
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Checkbox_Opcao($titulo,$value,$selected = 0){
        ++self::$tab_index;
        $config = Array(
            'Tipo'      => 'Checkbox_Opcao',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'titulo'            => $titulo,
                'id'                => $this->checkboxid,
                'valor'             => $value,
                'selected'          => $selected,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Checkbox_Fim(){
        $config = Array(
            'Tipo'      => 'Checkbox_Fim',
            'Opcao'     => Array(
                'url'               => URL_PATH,
                'layoult'           => $this->layoult,
                'id'                => $this->checkboxid,
                'end'               => $this->checkboxextra,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $this->checkboxcondicao,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $this->selectid         = '';
        $this->selectextra      = '';
        $this->selectcondicao   = '';
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * Cria um NOvo Select dentro de um FOrmulario
     * @param string $titulo
     * @param type $name
     * @param type $id
     * @param type $url
     * @param type $change
     * @param type $js
     * @param type $condicao
     * @param type $escondido
     * @param type $class
     * @param type $infonulo
     * @param type $multiplo
     * @return type
     */
    public function Select_Novo($titulo,$name,$id='',$url='',$change='', $js = '', $condicao=false, $escondido = false, $class='', $infonulo='Escolha uma opção',$multiplo=false){
        ++self::$tab_index;
        // Verifica se é obrigatorio
        if(strpos($class, 'obrigatorio')!==false){
            $titulo = $titulo.'*';
        }
        // Trata o Change
        if($change!==false && $change!='' && is_string($change)){
            if(strpos($change, 'Local::')!==false){
                $change = str_replace(Array('Local::'), Array(''), $change);
                $change = $change;
            }else{
                $change = 'Sierra.'.$change;
            }
        }
        //Começa
        $config = Array(
            'Tipo'      => 'Select_Inicio',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'id'                => $id,
                'titulo'            => $titulo,
                'nome'              => $name,
                'url'               => URL_PATH,
                'end'               => $url,
                'change'            => $change,
                'js'                => $js,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $condicao,
                'escondido'         => $escondido,
                'class'             => $class,
                'infonulo'          => $infonulo,
                'multiplo'          => $multiplo,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $this->selectextra      = $url;
        $this->selectcondicao   = $condicao;
        $this->selectid         = $id;
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @param type $titulo
     * @param type $value
     * @param type $selected
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Select_Opcao($titulo,$value,$selected = 0){
        $config = Array(
            'Tipo'      => 'Select_Opcao',
            'Opcao'     => Array(
                'titulo'            => $titulo,
                'valor'             => $value,
                'selected'          => $selected,
                'layoult'           => $this->layoult,
                'form_dependencia'  => $this->form_dependencia,
            )
        );
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
     * 
     * @return boolean
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 2.0
     */
    public function Select_Fim(){
        $config = Array(
            'Tipo'      => 'Select_Fim',
            'Opcao'     => Array(
                'url'               => URL_PATH,
                'layoult'           => $this->layoult,
                'id'                => $this->selectid,
                'end'               => $this->selectextra,
                'form_dependencia'  => $this->form_dependencia,
                'condicao'          => $this->selectcondicao,
                'ColunaTipo'        => $this->ColunaTipo
            )
        );
        $this->selectid         = '';
        $this->selectextra      = '';
        $this->selectcondicao   = '';
        $html                   = $this->_Visual->renderizar_bloco('template_form',$config);
        $this->form             .= $html;
        return                  $html;
    }
    /**
    * Add Html ao Formulário Atual
    * 
    * @name addtexto
    * @access public
    * 
    * @param string $texto Html a ser add ao formulario
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function addtexto($texto){
        $this->form .= $texto;
    }
    /**
    * Retorna Formulario do Objeto
    * 
    * @name retorna_form
    * @access public
    * 
    * @param string $botao
    * 
    * @uses \Framework\Classes\Form::$form
    * 
    * @return string
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 2.0
    */
    public function retorna_form($botao=''){
        ++self::$tab_index;
        $config = Array(
            'Tipo'      => 'Final',
            'TabIndex'  => self::$tab_index,
            'Opcao'     => Array(
                'botao'     => $botao,
                'layoult'   => $this->layoult
            )
        );
        $this->form .= $this->_Visual->renderizar_bloco('template_form',$config);
        return $this->form;
    }
}
?>

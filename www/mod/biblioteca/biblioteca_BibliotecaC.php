<?php
class biblioteca_BibliotecaControle extends biblioteca_Controle
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
    * @uses biblioteca_Controle::$comercioPerfil
    * 
    * @return void
    * 
    * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
    * @version 3.1.1
    */
    public function Main(){
        \Framework\App\Sistema_Funcoes::Redirect(URL_PATH.'biblioteca/Biblioteca/Bibliotecas');
        return false;
    }
    static function Endereco_Biblioteca($true=true){
        $registro = \Framework\App\Registro::getInstacia();
        $_Controle = $registro->_Controle;
        if($true===true){
            $_Controle->Tema_Endereco(__('Biblioteca'),'biblioteca/Biblioteca/Bibliotecas');
        }else{
            $_Controle->Tema_Endereco(__('Biblioteca'));
        }
    }
    public function Download($id,$raiz=false){
        $resultado_arquivo = $this->_Modelo->db->Sql_Select('Biblioteca', Array('id'=>$id),1);
        if($resultado_arquivo===false || !is_object($resultado_arquivo)){
            throw new \Exception('Essa Arquivo não existe:'. $raiz, 404);
        }else if($resultado_arquivo->tipo==1){
            throw new \Exception('Essa Pasta não pode baixar:'. $raiz, 404);
        }
        $endereco = 'bibliotecas'.DS.strtolower($resultado_arquivo->arquivo.'.'.$resultado_arquivo->ext);
        self::Export_Download($endereco, $resultado_arquivo->nome.'.'.$resultado_arquivo->ext);
        if($raiz!==false){
            $this->Bibliotecas($raiz);
        }
    }
    static function Bibliotecas_Tabela(&$bibliotecas,$raiz=0){
        $funcao = '';
        $registro   = \Framework\App\Registro::getInstacia();
        $Controle     = &$registro->_Controle;
        $Modelo     = &$registro->_Modelo;
        $Visual     = &$registro->_Visual;
        $tabela = Array();
        $i = 0;
        if($raiz!==false && $raiz!=0){
            $resultado_pasta = $Modelo->db->Sql_Select('Biblioteca', Array('id'=>$raiz),1);
            if($resultado_pasta===false){
                throw new \Exception('Essa Pasta não existe:'. $raiz, 404);
            }
            $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" acao=""><img src="'.WEB_URL.'img'.US.'arquivos'.US.'pastavoltar.png" alt="0" /></a>';
            $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$resultado_pasta->parent.'" border="1" class="lajax" acao="">Voltar para a Pasta Anterior</a>';
            $tabela['Descrição'][$i]        = '';
            $tabela['Tamanho'][$i]          = '';
            $tabela['Criador'][$i]          = '';
            $tabela['Data'][$i]  = '';
            $tabela['Funções'][$i]          = '';
            ++$i;
        }
        if($bibliotecas!==false){
            // Percorre Bibliotecas
            if(is_object($bibliotecas)) $bibliotecas = Array(0=>$bibliotecas);
            reset($bibliotecas);
            if(!empty($bibliotecas)){
                $perm_download = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Download');
                $perm_editar = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Edit');
                $perm_del = \Framework\App\Registro::getInstacia()->_Acl->Get_Permissao_Url('biblioteca/Biblioteca/Bibliotecas_Del');

                foreach ($bibliotecas as &$valor) {
                    if($valor->tipo==1){
                        $tipo       =   'pasta';
                        $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                    }else{
                        $tipo  = \Framework\App\Sistema_Funcoes::Control_Arq_Ext($valor->ext);
                        $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($valor->arquivo).'.'.$tipo;
                        if(!file_exists($endereco)){
                            continue;
                        }
                        if(file_exists(WEB_PATH.'img'.US.'arquivos'.US.$tipo.'.png')){
                            $foto = WEB_URL.'img'.US.'arquivos'.US.$tipo.'.png';
                        }else{
                            $foto = WEB_URL.'img'.US.'arquivos'.US.'desconhecido.png';
                        }
                    }
                    
                    // Tamanho
                    $tamanho = (int) $valor->tamanho;
                    if($tamanho === 0){
                        if($valor->tipo==1){
                            $tamanho = self::Bibliotecas_AtualizaTamanho_Pai($valor);
                        }else{
                            $tamanho = filesize($endereco);
                            $Modelo->db->Sql_Update($valor);
                        }
                    }
                    
                    if($valor->tipo==1){
                        $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" acao=""><img src="'.$foto.'" alt="1" /></a>';
                        $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$valor->id.'/" border="1" class="lajax" acao="">'.$valor->nome.'</a>';
                    }else{
                        $tabela['Tipo'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK"><img src="'.$foto.'" alt="'.$tipo.'" /></a>';
                        $tabela['Nome'][$i]             = '<a href="'.URL_PATH.'biblioteca/Biblioteca/Download/'.$valor->id.'/" border="1" target="_BLANK">'.$valor->nome.'</a>';
                    }
                    $tabela['Descrição'][$i]        = $valor->obs;
                    $tabela['Tamanho'][$i]          = \Framework\App\Sistema_Funcoes::Tranf_Byte_Otimizado($tamanho);
                    $tabela['Criador'][$i]          = $valor->usuario2;
                    $tabela['Data'][$i]             = $valor->log_date_add;
                    
                    if($valor->tipo==1){
                        $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Pasta')        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                          $Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Pasta')       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,__('Deseja realmente deletar essa pasta ?')),$perm_del);
                    }else{
                        $tabela['Funções'][$i]          = $Visual->Tema_Elementos_Btn('Baixar'     ,Array(__('Download de Arquivo')   ,'biblioteca/Biblioteca/Download/'.$valor->id    ,''),$perm_download).
                                                          $Visual->Tema_Elementos_Btn('Editar'     ,Array(__('Editar Arquivo')        ,'biblioteca/Biblioteca/Bibliotecas_Edit/'.$valor->id.'/'.$raiz    ,''),$perm_editar).
                                                          $Visual->Tema_Elementos_Btn('Deletar'    ,Array(__('Deletar Arquivo')       ,'biblioteca/Biblioteca/Bibliotecas_Del/'.$valor->id.'/'.$raiz     ,__('Deseja realmente deletar esse arquivo ?')),$perm_del);
                    }
                    $funcao .= $tabela['Funções'][$i];
                    ++$i;
                }
            }
        }
        if($funcao===''){
            unset($tabela['Funções']);
        }
        // Desconta Primeiro Registro
        if($raiz!==false && $raiz!=0){
            $i = $i-1;
        }
        // Retorna List
        return Array($tabela,$i);
    }
    /**
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas($raiz = false){
        self::Endereco_Biblioteca(false);
        // Bloca o Upload
        $this->_Visual->Blocar(
            $this->_Visual->Upload_Janela(
                'biblioteca',
                'Biblioteca',
                'Bibliotecas',
                $raiz,
                '*.*',
                __('Todos os Arquivos')
            )
        );
        $this->_Visual->Bloco_Maior_CriaJanela(__('Fazer Upload de Arquivo Nessa Pasta')  );
        // Extensoes Permitidas
        $ext = $this->Upload_Ext();
        $this->_Visual->Blocar('.'.implode(', .',$ext));
        $this->_Visual->Bloco_Menor_CriaJanela(__('Extensões Permitidas')  );
        
        
        // Processa Biblioteca
        list($titulo,$html,$i) = $this->Bibliotecas_Processar($raiz);
        $this->_Visual->Blocar('<span id="biblioteca_arquivos_mostrar">'.$html.'</span>');
        $this->_Visual->Bloco_Unico_CriaJanela($titulo,'',10,Array("link"=>"biblioteca/Biblioteca/Bibliotecas_Add",'icon'=>'add','nome'=>__('Adicionar Pasta')));
        
        //Carrega Json
        $this->_Visual->Json_Info_Update('Titulo', __('Listagem de Biblíotecas'));
    }
    private function Bibliotecas_Processar($raiz = false){
        return self::Bibliotecas_Processar_Static($raiz);
    }
    private static function Bibliotecas_Processar_Static($raiz = false){
        $registro = \Framework\App\Registro::getInstacia();
        $_Modelo = $registro->_Modelo;
        $_Visual = $registro->_Visual;
        // Biblioteca
        $endereco = (string) '';
        $html     = (string) '';
        if($raiz!==false && $raiz!=='0' && $raiz!==0){
            $resultado_pasta = $_Modelo->db->Sql_Select('Biblioteca', '{sigla}id=\''.$raiz.'\'',1);
            if($resultado_pasta===false){
                throw new \Exception('Essa Pasta não existe:'. $raiz, 404);
            }else if($resultado_pasta->tipo!=1){
                throw new \Exception('Não é uma pasta:'. $raiz, 404);
            }
            // Add ao Endereço
            $enderecopai = (int) $resultado_pasta->parent;
            $endereco =    '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$enderecopai.'" border="1" class="lajax link_titulo" acao="">'.
                            $resultado_pasta->nome.'</a> / '.$endereco;
            while(is_int($enderecopai) && $enderecopai!=0){
                $resultado_pasta2 = $_Modelo->db->Sql_Select('Biblioteca', '{sigla}id=\''.$enderecopai.'\'',1);
                if($resultado_pasta2===false){
                    throw new \Exception('Pasta Pai não existe:'. $enderecopai, 404);
                }else if($resultado_pasta->tipo!=1){
                    throw new \Exception('O pai Não é uma pasta:'. $enderecopai, 404);
                }
                $enderecopai = (int) $resultado_pasta2->parent;
                $endereco =    '<a href="'.URL_PATH.'biblioteca/Biblioteca/Bibliotecas/'.$enderecopai.'" border="1" class="lajax link_titulo" acao="">'.
                                $resultado_pasta2->nome.'</a> / '.$endereco;
            }
            // Condicao de Query
            //$where = Array('parent'=>$raiz);
        }else{
            $raiz = 0;
            //$where = Array('parent'=>0);
        }
        $endereco = __('Biblíoteca').' / '.$endereco;
        $i = 0;
        // COntinua
        // add botao
        /*$_Visual->Blocar($_Visual->Tema_Elementos_Btn('Superior'     ,Array(
            Array(
                __('Adicionar Pasta'),
                'biblioteca/Biblioteca/Bibliotecas_Add/'.$raiz,
                ''
            ),
            Array(
                'Print'     => true,
                'Pdf'       => true,
                'Excel'     => true,
                'Link'      => 'biblioteca/Biblioteca/Bibliotecas/'.$raiz,
            )
        )));
        $bibliotecas = $_Modelo->db->Sql_Select('Biblioteca',$where);
        if($bibliotecas!==false && !empty($bibliotecas) || $raiz!==false){
            list($tabela,$i) = self::Bibliotecas_Tabela($bibliotecas,$raiz);
            if($export!==false){
                self::Export_Todos($export,$tabela, $titulo);
            }else{
                $html .= $_Visual->Show_Tabela_DataTable(
                    $tabela,     // Array Com a Tabela
                    '',          // style extra
                    false,        // true -> Add ao Bloco, false => Retorna html
                    false,        // Apagar primeira coluna ?
                    Array(       // Ordenacao
                        Array(
                            0,'asc'
                        )
                    )
                );
            }
            unset($tabela);
        }else{
            $html .= '<center><b><font color="#FF0000" size="5">'.__('Nenhum Arquivo/Pasta').'</font></b></center>';            
        }*/
        
        $tabela_colunas = Array();

        $tabela_colunas[] = __('Tipo');
        $tabela_colunas[] = __('Extensão');
        $tabela_colunas[] = __('Nome');
        $tabela_colunas[] = __('Descrição');
        $tabela_colunas[] = __('Tamanho');
        $tabela_colunas[] = __('Criador');
        $tabela_colunas[] = __('Data');
        $tabela_colunas[] = __('End. do Arquivo');
        $tabela_colunas[] = __('Funções');

        $html = $_Visual->Show_Tabela_DataTable_Massiva($tabela_colunas,'biblioteca/Biblioteca/Bibliotecas/'.$raiz,'',false,false);
        
        $titulo = $endereco.' (<span id="DataTable_Contador">0</span>)';
        return Array($titulo,$html,$i);
    }
    /**
     * ADD SOMENTE PASTA
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas_Add($raiz = 0){
        self::Endereco_Biblioteca();
        // Carrega Config
        $titulo1    = __('Adicionar Pasta à Biblíoteca de Arquivos');
        $titulo2    = __('Salvar Pastas');
        $formid     = 'form_Sistema_Admin_Bibliotecas';
        $formbt     = __('Salvar Pasta');
        $formlink   = 'biblioteca/Biblioteca/Bibliotecas_Add2/'.$raiz;
        $campos = Biblioteca_DAO::Get_Colunas();
        // Retira Endereço Virtual
        self::DAO_Campos_Retira($campos, 'end_virtual');
        self::DAO_Campos_Retira($campos, 'tipo');
        self::DAO_Campos_Retira($campos, 'arquivo');
        if($raiz!=='false') self::DAO_Campos_Retira($campos, 'parent');
        self::DAO_Campos_Retira($campos, 'usuario');
        self::DAO_Campos_Retira($campos, 'grupo');
        self::DAO_Campos_Retira($campos, 'ext');
        self::DAO_Campos_Retira($campos, 'tamanho');
        // Chama Formulario
        \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos);
    }
    /**
     * ADD SOMENTE PASTA
     *
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas_Add2($raiz = 0){
        $titulo     = __('Pasta Adicionada com Sucesso');
        $dao        = 'Biblioteca';
        $funcao     = '$this->Bibliotecas('.$raiz.');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Pasta cadastrada com sucesso.');
        $alterar    = Array(
            'tipo'      =>  1,
            'usuario'   =>  $this->_Acl->Usuario_GetID(),
        );
        // Se Parent for false coloca o pai
        if($raiz!=='false'){
            $alterar['parent'] = $raiz;
        }
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas_Edit($id,$raiz=0){
        self::Endereco_Biblioteca();
        // Recupera Arquivo
        $resultado = $this->_Modelo->db->Sql_Select('Biblioteca', '{sigla}id=\''.$id.'\'',1);
        if($resultado===false){
            throw new \Exception('Esse arquivo/pasta não existe:'. $raiz, 404);
        }
        // Carrega Config
        $titulo1    = 'Editar Biblíoteca (#'.$id.')';
        $titulo2    = __('Alteração de Biblíoteca');
        $formid     = 'form_Sistema_AdminC_BibliotecaEdit';
        $formbt     = __('Alterar Biblíoteca');
        $formlink   = 'biblioteca/Biblioteca/Bibliotecas_Edit2/'.$id.'/'.$raiz;
        $editar     = $resultado;
        $campos = Biblioteca_DAO::Get_Colunas();
        // SE É PASTA
        // Retira Endereço Virtual
        self::DAO_Campos_Retira($campos, 'end_virtual');
        self::DAO_Campos_Retira($campos, 'tipo');
        self::DAO_Campos_Retira($campos, 'arquivo');
        //self::DAO_Campos_Retira($campos, 'parent');
        self::DAO_Campos_Retira($campos, 'usuario');
        self::DAO_Campos_Retira($campos, 'grupo');
        self::DAO_Campos_Retira($campos, 'ext');
        self::DAO_Campos_Retira($campos, 'tamanho');
        /*if($resultado->tipo==1){
            self::DAO_Campos_Retira($campos, $campomysql);
        }*/
        $this->_Visual->Blocar(\Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,$editar,'html'));
        
        $this->Tema_Endereco($titulo1);
        $this->_Visual->Json_Info_Update('Historico', true);
        $this->_Visual->Json_Info_Update('Titulo',$titulo1);
        $this->_Visual->Bloco_Unico_CriaJanela($titulo2,'',10,'Sierra.Control_Form_Tratar($(\'#'.$formid.'\')[0]);');
        
        $extensao = Framework\App\Sistema_Funcoes::Control_Arq_Ext($resultado->ext);
        
        // Edita PDF, DOCX, ODT, RTF, HTML
        if($resultado->tipo!=1 && ($extensao==='pdf' || $extensao==='docx' || $extensao==='odt' || $extensao==='rtf' || $extensao==='html')){
            
            $writers = array(
                'docx' => 'Word2007', 
                'odt' => 'ODText', 
                'rtf' => 'RTF', 
                'html' => 'HTML', 
                'pdf' => 'PDF'
            );
            require_once CLASS_PATH . 'PhpWord'.DS.'Autoloader.php';

            date_default_timezone_set('UTC');
            /**
             * Header file
             */
            \Framework\Classes\PhpWord\Autoloader::register();
            \Framework\Classes\PhpWord\Settings::loadConfig();
            $endereco = ARQ_PATH.'bibliotecas'.DS.strtolower($resultado->arquivo.'.'.$extensao);
            $phpWord = \Framework\Classes\PhpWord\IOFactory::load($endereco, $writers[$extensao]);
            ob_start();
            $writer = \Framework\Classes\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            $writer->save('php://output');
            $saida = ob_get_contents();
            ob_end_clean();
            
            $this->_Visual->Blocar($saida);
            $this->_Visual->Bloco_Unico_CriaJanela(__('Visualizando Documento'),'',0);
        }else
        // Se for arquivo de Imagem como Gif, JPG, JPEG, PNG, TIFF
        if($resultado->tipo!=1 && ($extensao==='gif' || $extensao==='jpg' || $extensao==='jpeg' || $extensao==='png' || $extensao==='tiff')){
            $endereco = 'bibliotecas'.DS.strtolower($resultado->arquivo.'.'.$extensao);
            $this->_Visual->Blocar('<img width="100%" src="'.ARQ_URL.$endereco.'" \>');
            $this->_Visual->Bloco_Maior_CriaJanela(__('Visualizando Imagem'),'',0);
            
            // Informacoes
            $imnfo = getimagesize(ARQ_PATH.$endereco);
            $html =  '<b>'.__('Largura').'</b>: '.$imnfo[0].' px<br>';	  // largura
            $html .= '<b>'.__('Altura').'</b>: '.$imnfo[1].' px<br>';	  // altura
            //$html .= '<b>'.__('Extensão').'</b>: '.$imnfo[2].'<br>';	  // extensão
            $html .= '<b>'.__('Mime').'</b>: '.$imnfo['mime'].'<br>'; // mime-type
            
            // Caso seja JPG, JPEG ou TIFF, le os Dados EXIF
            if($extensao==='jpg' || $extensao==='jpeg' || $extensao==='tiff'){
                $exif = exif_read_data(ARQ_PATH.$endereco);
                
                //$html .= '<br><br><b>'.__('Informações do Exif').'</b><br>';
                if(isset($exif["DateTimeOriginal"])){
                    $html .= '<b>'.__('Horário da Foto').'</b>: '.$exif["DateTimeOriginal"].'<br>';
                }
                if(isset($exif["Model"])){
                    $html .= '<b>'.__('Modelo da Camera').'</b>: '.$exif["Model"].'<br>';
                }
                if(isset($exif["Make"])){
                    $html .= '<b>'.__('Fabricante da Camera').'</b>: '.$exif["Make"].'<br>';
                }
                if(isset($exif["Software"])){
                    $html .= '<b>'.__('Programa que Manipulou o Arquivo').'</b>: '.$exif["Software"].'<br>';
                }
                if(isset($exif["Flash"])){
                    $html .= '<b>'.__('Flash').'</b>: '.$exif["Flash"].'<br>';
                }
                if(isset($exif["FNumber"])){
                    $html .= '<b>'.__('Abertura Relativa da Lente').'</b>: '.$exif["FNumber"].'<br>';
                }
                if(isset($exif["ExposureTime"])){
                    $html .= '<b>'.__('Tempo para Foto').'</b>: '.$exif["ExposureTime"].'<br>';
                }
                if(isset($exif["FocalLength"])){
                    $html .= '<b>'.__('Tamanho Focal').'</b>: '.$exif["FocalLength"].'<br>';
                }
                
                // Localizacao da Foto
                if(array_key_exists('GPSLongitude', $exif) && array_key_exists('GPSLatitude', $exif)) {
                    $lng = Framework\App\Sistema_Funcoes::Get_Gps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
                    $lat = Framework\App\Sistema_Funcoes::Get_Gps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
                    $html .= '<b>'.__('Latitude da Foto').'</b>: '.$lng.'<br>';
                    $html .= '<b>'.__('Longitude da Foto').'</b>: '.$lat.'<br>';
                }else{
                    $html .= '<br><b><font color="red">'.__('Essa Foto não Possui Informações do local aonde ela foi tirada.').'</font></b>';
                }
            }
            
            $this->_Visual->Blocar($html);
            $this->_Visual->Bloco_Menor_CriaJanela(__('Informações da Imagem'),'',0);
            
            

        }
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas_Edit2($id,$raiz=0){
        $titulo     = __('Editado com Sucesso');
        $dao        = Array('Biblioteca',$id);
        $funcao     = '$this->Bibliotecas('.$raiz.');';
        $sucesso1   = __('Arquivo/Pasta Alterado com Sucesso.');
        $sucesso2   = ''.$_POST["nome"].' teve a alteração bem sucedida';
        $alterar    = Array();
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);   
    }
    /**
     * 
     * @param type $id
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 3.1.1
     */
    public function Bibliotecas_Del($id,$raiz=0){
    	$id = (int) $id;
        // Puxa biblioteca e deleta
        $biblioteca = $this->_Modelo->db->Sql_Select('Biblioteca', Array('id'=>$id));
        $sucesso =  $this->_Modelo->db->Sql_Delete($biblioteca);
        // Mensagem
    	if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => __('Deletado'),
                "mgs_secundaria" => __('Pasta/Arquivo deletado com sucesso')
            );
    	}else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => __('Erro'),
                "mgs_secundaria" => __('Erro')
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);
        
        $this->Bibliotecas($raiz);
        
        $this->_Visual->Json_Info_Update('Titulo', 'Pasta/Arquivo deletado com Sucesso');
        $this->_Visual->Json_Info_Update('Historico', false);
    }
    /**
     * 
     * @param type $id
     */
    public function Bibliotecas_Upload($parent = 0){
        $parent = (int) $parent;
        
        $dir = 'bibliotecas'.DS;
        $ext = $this->Upload($dir,false,false);
        if($ext!==false){
            $arquivo = new \Biblioteca_DAO();
            $arquivo->parent        = $parent;
            $arquivo->ext           = \Framework\App\Sistema_Funcoes::Control_Arq_Ext($ext[0]);
            $arquivo->arquivo       = $ext[1];
            $arquivo->nome          = $ext[2];
            $arquivo->tamanho       = $ext[3];
            $arquivo->tipo          = 2;
            $arquivo->usuario       = $this->_Acl->Usuario_GetID();
            $this->_Modelo->db->Sql_Inserir($arquivo);
            $this->_Visual->Json_Info_Update('Titulo', __('Upload com Sucesso'));
            $this->_Visual->Json_Info_Update('Historico', false);
            // Atualiza Parent
            if($parent!==0){
                self::Bibliotecas_AtualizaTamanho_Pai($parent);
            }
            // Tras de Volta e Atualiza via Json
            list($titulo,$html,$i) = $this->Bibliotecas_Processar($parent);
            $conteudo = array(
                'location'  => '#biblioteca_arquivos_mostrar',
                'js'        => '',
                'html'      => $html
            );
            $this->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }else{
            $this->_Visual->Json_Info_Update('Titulo', __('Erro com Upload'));
            $this->_Visual->Json_Info_Update('Historico', false);
        }
    }
    /**
     * Adicionar Biblioteca Dinamica a Item de Outro Modulo
     * @param type $motivo Identificador do Modulo
     * @param type $motivoid Identificador
     * @param type $camada Camada de Retorno
     * @param boolean $retornar Se Escreve ou retorna html
     * @return string
     */
    static function Biblioteca_Dinamica($motivo,$motivoid,$camada,$retornar=true){
        $existe = false;
        if($retornar==='false') $retornar = false;
        // Verifica se Existe Conexao, se nao tiver abre o adicionar conexao, se nao, abre a pasta!
        $registro = \Framework\App\Registro::getInstacia();
        $resultado = $registro->_Modelo->db->Sql_Select('Biblioteca_Acesso','{sigla}motivo=\''.$motivo.'\' AND {sigla}motivoid=\''.$motivoid.'\'',1);
        if(is_object($resultado)){
            $existe = true;
        }
        
        // Dependendo se Existir Cria Formulario ou Lista arquivos
        if($existe===false){
            $html = self::Biblioteca_Dinamica_Add($motivo, $motivoid, $camada);
        }else{
            /*list($titulo,$html,$i)*/$html = self::Bibliotecas_Processar_Static($resultado->biblioteca, false);
            $html = '<span id="biblioteca_arquivos_mostrar">'.$html[1].'</span>'.
                    $registro->_Visual->Upload_Janela(
                        'biblioteca',
                        'Biblioteca',
                        'Bibliotecas',
                        $resultado->biblioteca,
                        '*.*',
                        __('Todos os Arquivos')
                    );
            /*$this->_Visual->Blocar('<span id="biblioteca_arquivos_mostrar">'.$html.'</span>');
            $this->_Visual->Bloco_Unico_CriaJanela($titulo);*/
        }
        
        if($retornar===true){
            return $html;
        }else{
            $conteudo = array(
                'location'  =>  '#'.$camada,
                'js'        =>  '',
                'html'      =>  $html
            );
            $registro->_Visual->Json_IncluiTipo('Conteudo',$conteudo);
        }
    }
    static protected function Biblioteca_Dinamica_Add($motivo,$motivoid,$camada){
        // Carrega Config
        $titulo1    = __('Criar Conexão com Biblioteca');
        $titulo2    = __('Salvar Conexão');
        $formid     = 'form_Sistema_Admin_BibliotecasDinamica';
        $formbt     = __('Salvar Conexão');
        $formlink   = 'biblioteca/Biblioteca/Biblioteca_Dinamica_Add2/'.$motivo.'/'.$motivoid.'/'.$camada;
        $campos = Biblioteca_Acesso_DAO::Get_Colunas();
        // Remove Essas Colunas
        self::DAO_Campos_Retira($campos, 'motivo');
        self::DAO_Campos_Retira($campos, 'motivoid');
        // Chama Formulario
       return \Framework\App\Controle::Gerador_Formulario_Janela($titulo1,$titulo2,$formlink,$formid,$formbt,$campos,false,'html',false);
    }
    public function Biblioteca_Dinamica_Add2($motivo,$motivoid,$camada){
        $resultado = $this->_Modelo->db->Sql_Select('Biblioteca_Acesso','{sigla}motivo=\''.$motivo.'\' AND {sigla}motivoid=\''.$motivoid.'\'',1);
        if(is_object($resultado)){
            biblioteca_BibliotecaControle::Biblioteca_Dinamica($motivo,$motivoid,$camada,false);
            return true;
        }
        $titulo     = __('Conexão de Pasta Feita com Sucesso');
        $dao        = 'Biblioteca_Acesso';
        $funcao     = 'biblioteca_BibliotecaControle::Biblioteca_Dinamica(\''.$motivo.'\',\''.$motivoid.'\',\''.$camada.'\',\'false\');';
        $sucesso1   = __('Inserção bem sucedida');
        $sucesso2   = __('Conexão cadastrada com sucesso.');
        $alterar    = Array(
            'motivo'        =>  $motivo,
            'motivoid'      =>  $motivoid
        );
        $this->Gerador_Formulario_Janela2($titulo,$dao,$funcao,$sucesso1,$sucesso2,$alterar);
    }
}
?>

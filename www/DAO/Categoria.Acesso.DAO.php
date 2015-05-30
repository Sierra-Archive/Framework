<?php
final Class Categoria_Acesso_DAO extends Framework\App\Dao 
{
    protected $categoria;
    protected $mod_acc;
    protected $user_criacao;
    protected static $objetocarregado     = false;     protected static $mysql_colunas       = false;     protected static $mysql_outside       = Array();     protected static $mysql_inside        = Array(); public function __construct() {  parent::__construct(); } public static function Get_Nome(){
        return MYSQL_CAT_ACESSO;
    }
    /**
     * Fornece Permissão de Copia da tabela
     * @return string
     */
    public static function Permissao_Copia(){
        return false;
    }
    public static function Get_Sigla(){
        return 'CA';
    }
    public static function Get_LinkTable(){
        return Array(
            'C'         =>  'categoria',
            // Quando Indice = 'Array', Nao tem 3 tabela, e Resultado é outro array com nome do campo e seus valores
            'Array'   =>  Array(
                'mod_acc',
                self::Mod_Acesso_Get_Chave()
            ),
        );
    }
    public static function Get_Engine(){
        return 'InnoDB';
    }
    public static function Get_Charset(){
        return 'latin1';
    }
    public static function Get_Autoadd(){
        return 1;
    }
    public static function Get_Class(){
        return get_class() ; //return str_replace(Array('_DAO'), Array(''), get_class());
    }
    public static function Gerar_Colunas(){
        return Array(
            Array(
                'mysql_titulo'      => 'categoria',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => true,
                'mysql_estrangeira' => 'C.id|C.nome', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'mod_acc',
                'mysql_tipovar'     => 'varchar', //varchar, int, 
                'mysql_tamanho'     => 255,
                'mysql_null'        => false,
                'mysql_default'     => false,
                'mysql_primary'     => true,
                'mysql_estrangeira' => false, // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
            ),
            Array(
                'mysql_titulo'      => 'user_criacao',
                'mysql_tipovar'     => 'int', //varchar, int, 
                'mysql_tamanho'     => 11,
                'mysql_null'        => true,
                'mysql_default'     => false,
                'mysql_primary'     => false,
                'mysql_estrangeira' => 'U.id|U.nome-U.razao_social', // chave estrangeira
                'mysql_autoadd'     => false,
                'mysql_comment'     => false,
                'mysql_inside'      => false, // Funcao Executada quando o dado for inserido no banco de dados
                'mysql_outside'     => false, // Funcao Executada quando o dado for retirado no banco de dados
                'perm_copia'        => false, //permissao funcional necessaria para campo 2 todos 
            )
        );
    }
    private static function Mod_Acesso(){
        return Array(
            'Agenda|Pasta'                  => Array(                
                'nome'      =>  'Tipo de Pasta',   
                'chave_nome'=>  'Pastas',             
                'chave'     =>  'Agenda_Pasta',
             ),
            'banner'                        => Array(
                'nome'      =>  'Tipo de Banner',
                'chave_nome'=>  'Banners',
                'chave'     =>  'banner',
             ),
            'comercio|Fornecedor'           => Array(
                'nome'      =>  'Tipo de Fornecedor',
                'chave_nome'=>  'Fornecedores',
                'chave'     =>  'comercio_Fornecedor',
             ),
            'locais|local'           => Array(
                'nome'      =>  'Tipo de Locais',
                'chave_nome'=>  'Locais',
                'chave'     =>  'locais_local',
             ),
            'Engenharia|Equipamento'        => Array(                
                'nome'      =>  'Tipo de Equipamento',   
                'chave_nome'=>  'Equipamentos',             
                'chave'     =>  'Engenharia_Equipamento',
             ),
            'Enquete'                       => Array(                
                'nome'      =>  'Tipo de Enquete',   
                'chave_nome'=>  'Enquetes',             
                'chave'     =>  'Enquete',
             ),
            'Financeiro|Financa'            => Array(                
                'nome'      =>  'Tipo de Finanças',   
                'chave_nome'=>  'Finanças',             
                'chave'     =>  'Financeiro_Financa',
             ),
            // Modulos de Noticias
            'noticia'                       => Array(                
                'nome'      =>  'Tipo de Noticia',   
                'chave_nome'=>  'Noticias',             
                'chave'     =>  'noticia',
             ),
            // Modulos de Gerencia de Predios
            'predial|Advertencia'           => Array(                
                'nome'      =>  'Tipo de Advertência',  
                'chave_nome'=>  'Advertência',              
                'chave'     =>  'predial_Advertencia',
             ),
            'predial|Animal'                => Array(                
                'nome'      =>  'Tipo de Animal',  
                'chave_nome'=>  'Animais',              
                'chave'     =>  'predial_Animal',
             ),
            'predial|Correio'               => Array(                
                'nome'      =>  'Tipo de Correio',  
                'chave_nome'=>  'Correios',              
                'chave'     =>  'predial_Correio',
             ),
            'predial|Informativo'           => Array(                
                'nome'      =>  'Tipo de Informativo',  
                'chave_nome'=>  'Informátivos',              
                'chave'     =>  'predial_Informativo',
             ),
            'predial|Salao'                 => Array(                
                'nome'      =>  'Tipo de Local de Reserva',  
                'chave_nome'=>  'Locais de Reserva',              
                'chave'     =>  'predial_Salao',
             ),
            'predial|Veiculo'               => Array(                
                'nome'      =>  'Tipo de Veiculo',   
                'chave_nome'=>  'Veiculos',             
                'chave'     =>  'predial_Veiculo',
             ),
            // Modulos de Projetos
            'Desenvolvimento'               => Array(                
                'nome'      =>  'Tipo de Projeto',   
                'chave_nome'=>  'Projetos',             
                'chave'     =>  'projeto',
             ),
            'Desenvolvimento|Tarefa'        => Array(                
                'nome'      =>  'Tipo de Tarefas de Projetos',   
                'chave_nome'=>  'Tarefas de Projetos',             
                'chave'     =>  'Desenvolvimento_Tarefa',
             ),
            'Desenvolvimento|Senha'         => Array(                
                'nome'      =>  'Tipo de Senhas',   
                'chave_nome'=>  'Senhas',             
                'chave'     =>  'Desenvolvimento_Senha',
             ),
            // Modulos de Usuario
            'usuario|grupo'       => Array(                
                'nome'      =>  'Tipo de Grupo',  
                'chave_nome'=>  'Grupos',              
                'chave'     =>  'usuario_grupo',
             ),
            'usuario_veiculo|Veiculo'       => Array(                
                'nome'      =>  'Tipo de Veiculo',  
                'chave_nome'=>  'Veiculos',              
                'chave'     =>  'usuario_veiculo_Veiculo',
             ),
            'usuario_veiculo|Equipamento'   => Array(                
                'nome'      =>  'Tipo de Equipamento', 
                'chave_nome'=>  'Equipamentos',               
                'chave'     =>  'usuario_veiculo_Equipamento',
             ),
            // Modulos de Transporte
            'Transporte|Caminhao'   => Array(                
                'nome'      =>  'Tipo de Autonômo', 
                'chave_nome'=>  'Caminhões',               
                'chave'     =>  'Transporte_Caminhao',
             ),
            // Modulos de Transporte
            'Transporte|Armazem'   => Array(                
                'nome'      =>  'Tipo de Armazém', 
                'chave_nome'=>  'Armazens',               
                'chave'     =>  'Transporte_Armazem',
             ),
            // Modulos de Transporte
            'Transporte|Transportadora'   => Array(                
                'nome'      =>  'Tipo de Transportadora', 
                'chave_nome'=>  'Transportadoras',               
                'chave'     =>  'Transporte_Transportadora',
             ),
            // Modulos de Transporte
            'Transporte|Fornecedor'   => Array(                
                'nome'      =>  'Tipo de Fornecedor', 
                'chave_nome'=>  'Fornecedores',               
                'chave'     =>  'Transporte_Fornecedor',
             ),
        );
    }
    /**
     * 
     * @param type $tipo (Chave)
     * @return type
     * @throws Exception
     */
    public static function Mod_Acesso_Get($tipo=false){
        if($tipo!==false){
            $array = Array();
            // Percorre os modulos que aceitam categorias
            $percorrer = Categoria_Acesso_DAO::Mod_Acesso();
            foreach($percorrer as &$value){
                if(strtoupper($tipo)===strtoupper($value['chave'])) return $value;
            }
            throw new \Exception('Categoria de Acesso não encontrado. Tipo:'.$tipo,404);
        }else{
            $array = Array();
            // Percorre os modulos que aceitam categorias
            $percorrer = Categoria_Acesso_DAO::Mod_Acesso();
            foreach($percorrer as $indice=>&$value){
                // Verifica se é do modulo inteiro ou de um submodulo
                if(strpos($indice, '|')===false){
                    $modulo     = $indice;
                    $submodulo  = false;
                }else{
                    $indice = explode('|',$indice);
                    $modulo     = $indice[0];
                    $submodulo  = $indice[1];
                }
                // Verifica se o modulo é permitido
                if(\Framework\App\Sistema_Funcoes::Perm_Modulos($modulo,$submodulo)){
                   $array[] = $value;
                }
            }
            return $array;
        }
    }
    public static function Mod_Acesso_Get_Nome($chave){
        // Percorre os modulos que aceitam categorias
        $percorrer = self::Mod_Acesso();
        foreach($percorrer as &$value){
            if(strtoupper($chave)===strtoupper($value['chave'])){
                return $value['nome'];
            }
        }
        throw new \Exception('Categoria de Acesso não encontrado. '.$chave,404);
    }
    public static function Mod_Acesso_Get_Chave(){
        $repassar = self::Mod_Acesso_Get();
        foreach($repassar AS &$valor){
            $valor = $valor['chave'];
        }
        return $repassar;
    }
}
?>

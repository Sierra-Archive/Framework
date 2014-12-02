<?php
/**
 * #update antigo
 */
class usuario_social_personasControle extends usuario_social_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function usuario_social(){
        $usuario_social ='';

        // carrega camada de addpersona
        $this->usuario_social_carregajanelaadd();
		
        $this->_Modelo->retorna_usuario_social($usuario_social);
        $i = 0;
        $j = 0;
        $z = 0;
        if(!empty($usuario_social)){
            //usort($usuario_social, "ordenar");
            reset($usuario_social);
            foreach ($usuario_social as $indice=>&$valor) {
                if($usuario_social[$indice]['posicao']==3){
                    if($usuario_social[$indice]['id_face']!=0){
                        $impor['Face'][$i] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $impor['Face'][$i] = 'Sem foto';
                    }
                    $impor['Persona'][$i] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $impor['Sexo'][$i] = 'Masculino';
                    }else{
                        $impor['Sexo'][$i] = 'Feminino';
                    }
                    $impor['Celular'][$i] = $usuario_social[$indice]['celular'];
                    $impor['Email'][$i] = $usuario_social[$indice]['email'];
                    $impor['Nascimento'][$i] = $usuario_social[$indice]['nasc'];
                    $impor['Pontos'][$i] = $usuario_social[$indice]['pontos'];
                    ++$i;
                }elseif($usuario_social[$indice]['posicao']==0){
                    if($usuario_social[$indice]['id_face']!=0){
                        $normal['Face'][$j] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $normal['Face'][$j] = 'Sem foto';
                    }
                    $normal['Persona'][$j] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $normal['Sexo'][$j] = 'Masculino';
                    }else{
                        $normal['Sexo'][$j] = 'Feminino';
                    }
                    $normal['Celular'][$j] = $usuario_social[$indice]['celular'];
                    $normal['Email'][$j] = $usuario_social[$indice]['email'];
                    $normal['Nascimento'][$j] = $usuario_social[$indice]['nasc'];
                    $normal['Pontos'][$j] = $usuario_social[$indice]['pontos'];
                    ++$j;
                }else{
                    //if($usuario_social[$indice]['id_face']!=0){
                    //	$proibido['Face'][$z] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    //}else{
                            $proibido['Face'][$z] = 'Sem foto';
                    //}
                    $proibido['Persona'][$z] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $proibido['Sexo'][$z] = 'Masculino';
                    }else{
                        $proibido['Sexo'][$z] = 'Feminino';
                    }
                    $proibido['Celular'][$z] = $usuario_social[$indice]['celular'];
                    $proibido['Email'][$z] = $usuario_social[$indice]['email'];
                    $proibido['Nascimento'][$z] = $usuario_social[$indice]['nasc'];
                    $proibido['Pontos'][$z] = $usuario_social[$indice]['pontos'];
                    ++$z;
                }
            }
        }
        $this->_Visual->Show_Tabela_DataTable($impor);
        $this->_Visual->Bloco_Maior_CriaJanela('Importantes');

        $this->_Visual->Show_Tabela_DataTable($normal);
        $this->_Visual->Bloco_Maior_CriaJanela('Principais');

        $this->_Visual->Show_Tabela_DataTable($proibido);
        $this->_Visual->Bloco_Maior_CriaJanela('Lista Negra');

        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Start('Usuario_social');
    }
    // PAGINA DE UMA PERSONA S�
    public function love(){
        $usuario_social ='';
        $this->_Modelo->retorna_usuario_social($usuario_social);
        $i = 0;
        $j = 0;
        $z = 0;
        $y = 0;
        if(!empty($usuario_social)){
            usort($usuario_social, "ordenar");
            reset($usuario_social);
            foreach ($usuario_social as $indice=>&$valor) {
                if($usuario_social[$indice]['situacao']==4 && $usuario_social[$indice]['posicao']!=1){
                    if($usuario_social[$indice]['id_face']!=0){
                        $orgulho['Face'][$i] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $orgulho['Face'][$i] = 'Sem foto';
                    }
                    $orgulho['Persona'][$i] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $orgulho['Sexo'][$i] = 'Masculino';
                    }else{
                        $orgulho['Sexo'][$i] = 'Feminino';
                    }
                    $orgulho['Celular'][$i] = $usuario_social[$indice]['celular'];
                    $orgulho['Email'][$i] = $usuario_social[$indice]['email'];
                    $orgulho['Nascimento'][$i] = $usuario_social[$indice]['nasc'];
                    $orgulho['Pontos'][$i] = $usuario_social[$indice]['pontos'];
                    ++$i;
                }elseif($usuario_social[$indice]['situacao']==1 && $usuario_social[$indice]['posicao']!=1){
                    if($usuario_social[$indice]['id_face']!=0){
                        $pegos['Face'][$j] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $pegos['Face'][$j] = 'Sem foto';
                    }
                    $pegos['Persona'][$j] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $pegos['Sexo'][$j] = 'Masculino';
                    }else{
                        $pegos['Sexo'][$j] = 'Feminino';
                    }
                    $pegos['Celular'][$j] = $usuario_social[$indice]['celular'];
                    $pegos['Pontos'][$j] = $usuario_social[$indice]['pontos'];
                    ++$j;
                    $pegos['Email'][$j] = $usuario_social[$indice]['email'];
                    $pegos['Nascimento'][$j] = $usuario_social[$indice]['nasc'];
                }elseif($usuario_social[$indice]['situacao']==2 && $usuario_social[$indice]['posicao']!=1){
                    if($usuario_social[$indice]['id_face']!=0){
                        $queropega['Face'][$z] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $queropega['Face'][$z] = 'Sem foto';
                    }
                    $queropega['Persona'][$z] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $queropega['Sexo'][$z] = 'Masculino';
                    }else{
                        $queropega['Sexo'][$z] = 'Feminino';
                    }
                    $queropega['Celular'][$z] = $usuario_social[$indice]['celular'];
                    $queropega['Email'][$z] = $usuario_social[$indice]['email'];
                    $queropega['Nascimento'][$z] = $usuario_social[$indice]['nasc'];
                    $queropega['Pontos'][$z] = $usuario_social[$indice]['pontos'];
                    ++$z;
                }elseif($usuario_social[$indice]['situacao']==3 && $usuario_social[$y]['posicao']!=1){
                    if($usuario_social[$indice]['id_face']!=0){
                        $ultimocaso['Face'][$y] = '<a href="http://www.facebook.com/profile.php?id='.$usuario_social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$usuario_social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $ultimocaso['Face'][$y] = 'Sem foto';
                    }
                    $ultimocaso['Persona'][$y] = '<a href="'.URL_PATH.'usuario_social/Visualizar/Main/'.$usuario_social[$indice]['id'].'/">'.$usuario_social[$indice]['nome'].'</a>';
                    if($usuario_social[$indice]['fis_sexo']!=0){
                        $ultimocaso['Sexo'][$y] = 'Masculino';
                    }else{
                        $ultimocaso['Sexo'][$y] = 'Feminino';
                    }
                    $ultimocaso['Celular'][$y] = $usuario_social[$indice]['celular'];
                    $ultimocaso['Email'][$y] = $usuario_social[$indice]['email'];
                    $ultimocaso['Nascimento'][$y] = $usuario_social[$indice]['nasc'];
                    $ultimocaso['Pontos'][$y] = $usuario_social[$indice]['pontos'];
                    ++$y;
                }
            }
        }
        echo 'Quantidades'.$j;
        $this->_Visual->Show_Tabela_DataTable($pegos);
        $this->_Visual->Bloco_Maior_CriaJanela('Pegos');

        $this->_Visual->Show_Tabela_DataTable($orgulho);
        $this->_Visual->Bloco_Maior_CriaJanela('Orgulho Supremo');

        $this->_Visual->Show_Tabela_DataTable($queropega);
        $this->_Visual->Bloco_Maior_CriaJanela('Quero Gape');

        $this->_Visual->Show_Tabela_DataTable($ultimocaso);
        $this->_Visual->Bloco_Maior_CriaJanela('Ultimo Caso');

        $this->_Visual->renderizar(1,$this->calendario,$this->config_dia,$this->config_mes,$this->config_ano,$this->config_dataixi);
    }
    /***********************************
    *
    *  retorna formulario de cadastro de registro financeiro
    *
    *************************************/
    public function usuario_social_carregajanelaadd(){
        global $language;

        $formulario = $this->usuario_social_formcadastro();
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela($language['usuario_social']['cadastro']);

        $this->_Visual->Javascript_Executar(false);
        
    }
    public function usuario_social_formcadastro(){
        global $language;
        
       
        $form = new \Framework\Classes\Form('adminformusuario_socialend','usuario_social/usuario_social/usuario_social_inserir/','formajax');
        $form->Input_Novo($language['usuario_social']['form_idface'],'idface','','text', 21,'obrigatorio'); 
        $form->Input_Novo($language['usuario_social']['form_nome'],'nome','','text', 30, 'obrigatorio'); 
              
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);
        
        return $formulario;
    }
    public function usuario_social_inserir(){
        global $language;
        //data_hora_brasil_eua()
        $nome = \anti_injection($_POST["nome"]);
        $idface = (int) $_POST["idface"];
        
        $sucesso =  $this->_Modelo->usuario_social_inserir($idface, $nome);
        $this->usuario_social();
        if($sucesso===true){
            $mensagens = array(
                "tipo" => 'sucesso',
                "mgs_principal" => $language['financas']['formsucesso1'],
                "mgs_secundaria" => preg_replace(array('/{valor}/'), array($valor), $language['financas']['formsucesso2'])
            );
        }else{
            $mensagens = array(
                "tipo" => 'erro',
                "mgs_principal" => $language['mens_erro']['erro'],
                "mgs_secundaria" => $language['mens_erro']['erro']
            );
        }
        $this->_Visual->Json_IncluiTipo('Mensagens',$mensagens);    
    }public function Main(){
}
}
?>
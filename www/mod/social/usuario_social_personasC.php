<?php
/**
 * #update antigo
 */
class social_personasControle extends social_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function social(){
        $social =__('');

        // carrega camada de addpersona
        $this->social_carregajanelaadd();
		
        $this->_Modelo->retorna_social($social);
        $i = 0;
        $j = 0;
        $z = 0;
        if(!empty($social)){
            //usort($social, "ordenar");
            reset($social);
            foreach ($social as $indice=>&$valor) {
                if($social[$indice]['posicao']==3){
                    if($social[$indice]['id_face']!=0){
                        $impor['Face'][$i] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $impor['Face'][$i] = __('Sem foto');
                    }
                    $impor['Persona'][$i] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $impor['Sexo'][$i] = __('Masculino');
                    }else{
                        $impor['Sexo'][$i] = __('Feminino');
                    }
                    $impor['Celular'][$i] = $social[$indice]['celular'];
                    $impor['Email'][$i] = $social[$indice]['email'];
                    $impor['Nascimento'][$i] = $social[$indice]['nasc'];
                    $impor['Pontos'][$i] = $social[$indice]['pontos'];
                    ++$i;
                }elseif($social[$indice]['posicao']==0){
                    if($social[$indice]['id_face']!=0){
                        $normal['Face'][$j] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $normal['Face'][$j] = __('Sem foto');
                    }
                    $normal['Persona'][$j] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $normal['Sexo'][$j] = __('Masculino');
                    }else{
                        $normal['Sexo'][$j] = __('Feminino');
                    }
                    $normal['Celular'][$j] = $social[$indice]['celular'];
                    $normal['Email'][$j] = $social[$indice]['email'];
                    $normal['Nascimento'][$j] = $social[$indice]['nasc'];
                    $normal['Pontos'][$j] = $social[$indice]['pontos'];
                    ++$j;
                }else{
                    //if($social[$indice]['id_face']!=0){
                    //	$proibido['Face'][$z] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    //}else{
                            $proibido['Face'][$z] = __('Sem foto');
                    //}
                    $proibido['Persona'][$z] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $proibido['Sexo'][$z] = __('Masculino');
                    }else{
                        $proibido['Sexo'][$z] = __('Feminino');
                    }
                    $proibido['Celular'][$z] = $social[$indice]['celular'];
                    $proibido['Email'][$z] = $social[$indice]['email'];
                    $proibido['Nascimento'][$z] = $social[$indice]['nasc'];
                    $proibido['Pontos'][$z] = $social[$indice]['pontos'];
                    ++$z;
                }
            }
        }
        $this->_Visual->Show_Tabela_DataTable($impor);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Importantes'));

        $this->_Visual->Show_Tabela_DataTable($normal);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Principais'));

        $this->_Visual->Show_Tabela_DataTable($proibido);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Lista Negra'));

        // ORGANIZA E MANDA CONTEUDO
        $this->_Visual->Json_Start('Usuario_social');
    }
    // PAGINA DE UMA PERSONA S�
    public function love(){
        $social ='';
        $this->_Modelo->retorna_social($social);
        $i = 0;
        $j = 0;
        $z = 0;
        $y = 0;
        if(!empty($social)){
            usort($social, "ordenar");
            reset($social);
            foreach ($social as $indice=>&$valor) {
                if($social[$indice]['situacao']==4 && $social[$indice]['posicao']!=1){
                    if($social[$indice]['id_face']!=0){
                        $orgulho['Face'][$i] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $orgulho['Face'][$i] = __('Sem foto');
                    }
                    $orgulho['Persona'][$i] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $orgulho['Sexo'][$i] = __('Masculino');
                    }else{
                        $orgulho['Sexo'][$i] = __('Feminino');
                    }
                    $orgulho['Celular'][$i] = $social[$indice]['celular'];
                    $orgulho['Email'][$i] = $social[$indice]['email'];
                    $orgulho['Nascimento'][$i] = $social[$indice]['nasc'];
                    $orgulho['Pontos'][$i] = $social[$indice]['pontos'];
                    ++$i;
                }elseif($social[$indice]['situacao']==1 && $social[$indice]['posicao']!=1){
                    if($social[$indice]['id_face']!=0){
                        $pegos['Face'][$j] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $pegos['Face'][$j] = __('Sem foto');
                    }
                    $pegos['Persona'][$j] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $pegos['Sexo'][$j] = __('Masculino');
                    }else{
                        $pegos['Sexo'][$j] = __('Feminino');
                    }
                    $pegos['Celular'][$j] = $social[$indice]['celular'];
                    $pegos['Pontos'][$j] = $social[$indice]['pontos'];
                    ++$j;
                    $pegos['Email'][$j] = $social[$indice]['email'];
                    $pegos['Nascimento'][$j] = $social[$indice]['nasc'];
                }elseif($social[$indice]['situacao']==2 && $social[$indice]['posicao']!=1){
                    if($social[$indice]['id_face']!=0){
                        $queropega['Face'][$z] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $queropega['Face'][$z] = __('Sem foto');
                    }
                    $queropega['Persona'][$z] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $queropega['Sexo'][$z] = __('Masculino');
                    }else{
                        $queropega['Sexo'][$z] = __('Feminino');
                    }
                    $queropega['Celular'][$z] = $social[$indice]['celular'];
                    $queropega['Email'][$z] = $social[$indice]['email'];
                    $queropega['Nascimento'][$z] = $social[$indice]['nasc'];
                    $queropega['Pontos'][$z] = $social[$indice]['pontos'];
                    ++$z;
                }elseif($social[$indice]['situacao']==3 && $social[$y]['posicao']!=1){
                    if($social[$indice]['id_face']!=0){
                        $ultimocaso['Face'][$y] = '<a href="http://www.facebook.com/profile.php?id='.$social[$indice]['id_face'].'" target="_blank"><img src="http://graph.facebook.com/'.$social[$indice]['id_face'].'/picture"></a>';
                    }else{
                        $ultimocaso['Face'][$y] = __('Sem foto');
                    }
                    $ultimocaso['Persona'][$y] = '<a href="'.URL_PATH.'social/Visualizar/Main/'.$social[$indice]['id'].'/">'.$social[$indice]['nome'].'</a>';
                    if($social[$indice]['fis_sexo']!=0){
                        $ultimocaso['Sexo'][$y] = __('Masculino');
                    }else{
                        $ultimocaso['Sexo'][$y] = __('Feminino');
                    }
                    $ultimocaso['Celular'][$y] = $social[$indice]['celular'];
                    $ultimocaso['Email'][$y] = $social[$indice]['email'];
                    $ultimocaso['Nascimento'][$y] = $social[$indice]['nasc'];
                    $ultimocaso['Pontos'][$y] = $social[$indice]['pontos'];
                    ++$y;
                }
            }
        }
        echo 'Quantidades'.$j;
        $this->_Visual->Show_Tabela_DataTable($pegos);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Pegos'));

        $this->_Visual->Show_Tabela_DataTable($orgulho);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Orgulho Supremo'));

        $this->_Visual->Show_Tabela_DataTable($queropega);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Quero Gape'));

        $this->_Visual->Show_Tabela_DataTable($ultimocaso);
        $this->_Visual->Bloco_Maior_CriaJanela(__('Ultimo Caso'));

        $this->_Visual->renderizar(1,$this->calendario,$this->config_dia,$this->config_mes,$this->config_ano,$this->config_dataixi);
    }
    /***********************************
    *
    *  retorna formulario de cadastro de registro financeiro
    *
    *************************************/
    public function social_carregajanelaadd(){
        global $language;

        $formulario = $this->social_formcadastro();
        $this->_Visual->Blocar($formulario);
        $this->_Visual->Bloco_Menor_CriaJanela($language['social']['cadastro']);

        $this->_Visual->Javascript_Executar(false);
        
    }
    public function social_formcadastro(){
        global $language;
        
       
        $form = new \Framework\Classes\Form('adminformsocialend','social/social/social_inserir/','formajax');
        $form->Input_Novo($language['social']['form_idface'],'idface','','text', 21,'obrigatorio'); 
        $form->Input_Novo($language['social']['form_nome'],'nome','','text', 30, 'obrigatorio'); 
              
        $formulario = $form->retorna_form($language['formularios']['cadastrar']);
        
        return $formulario;
    }
    public function social_inserir(){
        global $language;
        //data_hora_brasil_eua()
        $nome = \anti_injection($_POST["nome"]);
        $idface = (int) $_POST["idface"];
        
        $sucesso =  $this->_Modelo->social_inserir($idface, $nome);
        $this->social();
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
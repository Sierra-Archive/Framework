<?php
class social_statControle extends social_Controle
{

    public function __construct(){
        parent::__construct();
    }
    public function mensal(){
        #Definimos o objeto para inicar a "montagem" do gr�fico
        $grafico =& new PHPlot();

        #Definimos os dados do gr�fico

        for($i=0;$i<40;$i++){
            $dados[$i] = array('Janeiro', rand());
        }

        $grafico->SetDataValues($dados);

        #Exibimos o gr�fico
        $grafico->DrawGraph();
    }
}
?>
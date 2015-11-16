<?php

class Direito_RelatorioModelo extends DireitoModelo
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
    * @version 0.4.2
    */
    public function __construct() {
        parent::__construct();
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $id
     * @return int
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Audiencia(&$resultado, $inicial=0, $final=0) {
        $i = $this->Relatorio(
            $resultado,
            $id,
            ', '.MYSQL_ADVOGADO_AUDIENCIAS.' A, ', //.MYSQL_ADVOGADO_TIPOAUDIENCIAS.' TA'
            ' && P.id=A.id_processo && A.data>=\''.$inicial.'\' && A.data<=\''.$final.'\'' //' && TA.id=A.tipo && TA.id='.$id
        );
        return $i;
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $id
     * @return INT
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Fase(&$resultado, $id = 0) {
        $i = $this->Relatorio(
            $resultado,
            $id,
            '',
            ' && TF.id='.$id
        );
        return $i;
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $id
     * @return INT
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Comarca(&$resultado, $id = 0) {
        $i = $this->Relatorio(
            $resultado,
            $id,
            '',
            ' && C.id='.$id
        );
        return $i;
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $id
     * @return INT
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Vara(&$resultado, $id = 0) {
        $i = $this->Relatorio(
            $resultado,
            $id,
            '',
            ' && V.id='.$id
        );
        return $i;
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $idvara
     * @param INT $idcomarca
     * @return INT
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_Vara_Comarca(&$resultado, $idvara = 0, $idcomarca = 0) {
        if ($idvara==0 || $idcomarca==0) $id = 0;
        else                            $id = 1;
        $i = $this->Relatorio(
            $resultado,
            $id,
            '',
            ' && C.id='.$idcomarca.' && V.id='.$idvara
        );
        return $i;
    }/**
     * 
     * @param ARRAY $resultado
     * @param INT $id
     * @return INT
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio_SemAlt(&$resultado) {
        $i = $this->Relatorio(
            $resultado,
            1,
            '',
            '',
            ' ORDER BY F.data LIMIT 90'
        );
        return $i;
    }
    /**
     *    NO FINAL TODOS OS RELATORIOS TERMINAL AQUI
     * 
     * @param ARRAY $resultado
     * @param type $FROM
     * @param type $WHERE
     * @param INT $id
     * 
     * @author Ricardo Rebello Sierra <web@ricardosierra.com.br>
     * @version 0.4.2
     */
    public function Relatorio(&$resultado, $id=0, $FROM, $WHERE, $EXTRA = '') {
        $i = 0;
        if ($id==0) {
            $sql = $this->db->query(' SELECT P.data as DATA, C.titulo AS COMARCA, V.titulo AS VARA, F.data as FASEDATA, TF.titulo AS FASE, AU.nome AS AUTOR, CO.nome AS REU
            FROM '.MYSQL_ADVOGADO_PROCESSOS.' P, '.MYSQL_ADVOGADO_COMARCA.' C, '.MYSQL_ADVOGADO_VARAS.' V, '.MYSQL_ADVOGADO_FASES.' F, '.MYSQL_ADVOGADO_TIPOFASES.' TF, '.MYSQL_ADVOGADO_AUTORES.' AU, '.MYSQL_ADVOGADO_CONTRARIA.' CO
            WHERE P.deletado!=1 AND P.id_comarca=C.id && P.id_vara=V.id && F.id_processo=P.id && TF.id=F.tipo && AU.id_processo=P.id && CO.id_processo=P.id '.$EXTRA);
        } else {
            $sql = $this->db->query(' SELECT P.data as DATA, C.titulo AS COMARCA, V.titulo AS VARA, F.data as FASEDATA, TF.titulo AS FASE, AU.nome AS AUTOR, CO.nome AS REU
            FROM '.MYSQL_ADVOGADO_PROCESSOS.' P, '.MYSQL_ADVOGADO_COMARCA.' C, '.MYSQL_ADVOGADO_VARAS.' V, '.MYSQL_ADVOGADO_FASES.' F, '.MYSQL_ADVOGADO_TIPOFASES.' TF, '.MYSQL_ADVOGADO_AUTORES.' AU, '.MYSQL_ADVOGADO_CONTRARIA.' CO'.$FROM.'
            WHERE P.deletado!=1 AND P.id_comarca=C.id && P.id_vara=V.id && F.id_processo=P.id && TF.id=F.tipo && AU.id_processo=P.id && CO.id_processo=P.id'.$WHERE.' '.$EXTRA);
        }
        while ($campo = $sql->fetch_object()) {
            $resultado[$i]['DATA']    = $campo->DATA;
            $resultado[$i]['AUTOR']   = $campo->AUTOR;
            $resultado[$i]['REU']     = $campo->REU;
            $resultado[$i]['COMARCA'] = $campo->COMARCA;
            $resultado[$i]['VARA']    = $campo->VARA;
            $resultado[$i]['FASE']    = $campo->FASE;
            $resultado[$i]['ATRASO'] = Data_CalculaDiferenca($campo->FASEDATA,APP_HORA)*24;
            
            
            ++$i;
        }
        return $i;
    }
}
?>
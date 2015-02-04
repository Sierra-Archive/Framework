<?php if($params['Tipo'] === 'Escopo') { ?>
    <table class="table"><thead><?php echo $params['Opcao']['head']; ?></thead><tbody><?php echo $params['Opcao']['body']; ?></tbody></table>
        
        
<?php }else if($params['Tipo']==='Head'){ ?>
    <tr><?php foreach($params['Opcao']['Campos'] as &$v){ ?><th><?php echo $v; ?></th><?php } ?></tr>
    
    
<?php }else if($params['Tipo']==='Body'){ ?>
    <tr><?php foreach($params['Opcao']['Campos'] as &$v){ ?><td valign="middle" class="<?php echo $v['class']; ?>"><?php echo $v['nome']; ?></td><?php } ?></tr>
    
    
<?php }else if($params['Tipo']==='Dinamica'){
        if ($params['Opcao']['Tabela']){
            $colunas = count($params['Opcao']['Tabela']);
            $contador = 0;  ?>
            <table class="table table-hover table-striped table-bordered datatable<?php if($params['Opcao']['Apagado1']){ ?> apagado1<?php } ?>" ordenar="<?php echo $params['Opcao']['aaSorting']; ?>"><thead><tr>
            <?php foreach($params['Opcao']['Tabela'] as $k=>$v){ ?>
                <th<?php if($contador>1 && $contador<($colunas-1)){ ?> class="hidden-xs"<?php } ?>><b><?php echo $k; ?></b></th>
                <?php ++$contador; ?>
            <?php } ?>
            </tr></thead><tbody>
            <?php 
            $total = count($v);
            for($cont=0;$cont<$total; ++$cont) {  
            ?>
                <tr class="odd gradeX">
                <?php $contador = 0;
                foreach($params['Opcao']['Tabela'] as $k=>$v){ ?>
                    <td style="<?php echo $params['Opcao']['Style']; ?>"<?php if($contador>1 && $contador<($colunas-1)){ ?> class="hidden-xs"<?php } ?>>
                        <?php if (!isset($params['Opcao']['Tabela'][$k][$cont])) {
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }else{
                            echo $params['Opcao']['Tabela'][$k][$cont];
                        } ?>
                    </td>
                    <?php ++$contador; ?>
                <?php } ?>
                </tr>
            <?php } ?>
            </tbody></table>
        <?php } ?>
<?php } ?>

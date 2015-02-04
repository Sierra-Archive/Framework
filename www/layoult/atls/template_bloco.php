<?php if( $params['Tipo']==='Bloco'){ ?>
    <div class="widget<?php if($params['conteudo_tipo']==='abas'){ ?> tabbable<?php } ?> <?php echo TEMA_COLOR; ?>"<?php echo $params['div_ext']; ?>>
        <div class="widget-title">
            <h4<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h4>
        </div>
        <?php if($params['conteudo']!=''){ ?>
        <div class="widget-body"<?php if(isset($params['opc_fechada']) && $params['opc_fechada']===true)  echo ' style="display: none;"'; ?>>
            <?php echo $params['conteudo']; ?>
        </div>
        <?php } ?>
    </div>
<?php }else{ ?>
    <div class="row">
    <?php foreach($params['tamanho'] as $indice=>$span){ ?>
        <div class="col-<?php echo $span; ?>">
              <?php echo $params['conteudo'][$indice];  ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
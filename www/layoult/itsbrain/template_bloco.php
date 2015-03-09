<?php if( $params['Tipo']==='Bloco'){ ?>
    <div class="widget<?php if($params['conteudo_tipo']==='abas'){ ?> rightTabs<?php } ?>"<?php echo $params['div_ext']; ?>>
        <div class="head"><h5 class="iFrames"<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h5></div>
        <?php if($params['conteudo']!=''){ ?>
        <div class="<?php if($params['conteudo_tipo']==='abas'){ ?>tabs<?php }else{ ?>body<?php } ?>">
            <?php echo $params['conteudo']; ?>
        </div>
        <?php } ?>
    </div>
<?php }else{ ?>
    <div class="fluid">
    <?php foreach($params['tamanho'] as $indice=>$span){ ?>
        <div class="col-md-<?php echo $span; ?>">
              <?php echo $params['conteudo'][$indice];  ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
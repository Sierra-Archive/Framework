<?php if( $params['Tipo']==='Bloco'){ ?>
    <?php if($params['tamanho']===8){ ?>
        <h2<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h2>
    <?php }else if($params['tamanho']===4){ ?>
        <h3<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h3>
    <?php } ?>

    <?php if($params['conteudo']!=''){ ?>
        <div class="body-con"<?php echo $params['div_ext']; ?>><?php echo $params['conteudo']; ?></div>
    <?php } ?>
<?php }else{ ?>
    <div class="row">
    <?php foreach($params['tamanho'] as $indice=>$span){ ?>
        <div class="col-<?php echo $span; ?>">
              <?php echo $params['conteudo'][$indice];  ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
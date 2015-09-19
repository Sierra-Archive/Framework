<?php if( $params['Tipo']==='Bloco'){ ?>
    <?php if($params['tamanho']===8){ ?>
        <h2<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h2>
    <?php }else if($params['tamanho']===4){ ?>
        <h3<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h3>
    <?php }

    //Botoes
    if(isset($params['Id'])){ ?>
        <span class="tools">
            <a id="<?php echo $params['Id']; ?>_max" class="fa fa-chevron-<?php if(isset($params['opc_fechada']) && $params['opc_fechada']===true) echo 'up'; else echo 'down'; ?>" href="javascript:;"></a>
            <!--<a class="fa fa-remove" href="javascript:;"></a>-->
        </span>
        <?php 
    }
    /*BOTAO EXTRA*/
    if($params['btn_extra']!==false){ ?>
        <?php if(is_array($params['btn_extra'])){ ?>
            <div class="update-btn">
                <a class="btn btn-default lajax" href="<?php echo $params['btn_extra']['link']; ?>" class="lajax" acao=""><i class="fa fa-<?php echo $params['btn_extra']['icon']; ?>"></i> <?php echo $params['btn_extra']['nome']; ?></a>
            </div>
        <?php }else{ ?>
            <div class="update-btn">
                <a class="btn btn-default" href="#" onClick="<?php echo $params['btn_extra']; ?>" class="lajax" acao=""><i class="fa fa-repeat"></i> <?php _e('Salvar'); ?></a>
            </div>
        <?php }
    } 
    
    
    if($params['conteudo']!=''){ ?>
        <div class="body-con"<?php echo $params['div_ext']; ?>><?php echo $params['conteudo']; ?></div>
    <?php } ?>
<?php }else{ ?>
    <div class="row">
    <?php foreach($params['tamanho'] as $indice=>$span){ ?>
        <div class="col-md-<?php echo $span; ?>">
              <?php echo $params['conteudo'][$indice];  ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
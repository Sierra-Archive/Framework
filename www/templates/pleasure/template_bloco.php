<?php if ( $params['Tipo']==='Bloco') { ?>
    <div class="panel<?php if ($params['conteudo_tipo']==='abas') { ?> tabbable<?php } ?> <?php echo TEMA_COLOR; ?>"<?php echo $params['div_ext']; ?>>
        <div class="panel-heading"><div class="panel-title">
            <h4<?php echo $params['titulo_ext']; ?>><?php echo $params['titulo']; ?></h4>
            <?php
            
            /*BOTAO EXTRA*/
            if ($params['btn_extra'] !== false) { ?>
                <div class="panel-buttons"><div class="btn-group portlet-handle-cancel">
                <?php if (is_array($params['btn_extra'])) { ?>
                    <div class="update-btn">
                        <a class="btn btn-default lajax" href="<?php echo $params['btn_extra']['link']; ?>" data-acao=""><i class="ion-android-<?php echo $params['btn_extra']['icon']; ?>"></i><span class="hidden-xs"> <?php echo $params['btn_extra']['nome']; ?></span></a>
                    </div>
                <?php } else { ?>
                    <div class="update-btn">
                        <a class="btn btn-default lajax" href="#" onClick="<?php echo $params['btn_extra']; ?>" data-acao=""><i class="ion-checkmark"></i><span class="hidden-xs"> <?php _e('Salvar'); ?></span></a>
                    </div>
                <?php } ?>
                </div></div><?php
            } else if (isset($params['Id'])) { ?>
                <div class="panel-action portlet-handle-cancel">
                    <a id="<?php echo $params['Id']; ?>_max" data-toggle="panel" href="javascript:;"></a>
                    <!--<a href="javascript:;" data-toggle="remove"></a>-->
                </div>
                <?php 
            } ?>
        </div></div>
        <?php if ($params['conteudo']!='') { ?>
        <div class="panel-body"<?php if (isset($params['opc_fechada']) && $params['opc_fechada'] === true)  echo ' style="display: none;"'; ?>>
            <?php echo $params['conteudo']; ?>
        </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="row">
    <?php foreach ($params['tamanho'] as $indice=>$span) { ?>
        <div class="col-md-<?php echo $span; ?>">
              <?php echo $params['conteudo'][$indice];  ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>
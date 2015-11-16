<?php if ($params['Tipo']==='Superior') { ?>
    <div class="clearfix">
        <?php if ($params['btn_add']) { ?>
            <div class="btn-group">
                <?php if ($params['btn_add']!=='#' && $params['btn_add']!=='') { ?>
                    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="lajax" data-acao="">
                <?php } ?>
                        <button class="btn btn-ripple  green" onClick="<?php echo $params['btn_add']['onclick']; ?>">
                            <?php echo $params['btn_add']['nome']; ?> <i class="ion-android-add"></i>
                        </button>
                <?php if ($params['btn_add']!=='#' && $params['btn_add']!=='') { ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (is_array($params['Ferramentas'])) { ?>
            <div class="btn-group pull-right">
                <button class="btn btn-ripple dropdown-toggle" data-toggle="dropdown"><i class="ion-gear-b"></i> Ferramentas <i class="ion-arrow-down-b"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <?php if ($params['Ferramentas']['Print']) { 
                        ?><li><a href="<?php echo URL_PATH; echo $params['Ferramentas']['Link']; ?>/Imprimir" target="_BLANK">Imprimir</a> <i class="ion-printer"></i></li>
                        <?php if ($params['Ferramentas']['Pdf'] !== FALSE && $params['Ferramentas']['Excel'] !== FALSE) { ?><li class="divider"></li><?php }
                    } ?>
                    <?php if ($params['Ferramentas']['Pdf']) { ?><li><a href="<?php echo URL_PATH; echo $params['Ferramentas']['Link']; ?>/Pdf" target="_BLANK">Abrir em PDF</a></li><?php } ?>
                    <?php if ($params['Ferramentas']['Pdf']) { ?><li><a href="<?php echo URL_PATH; echo $params['Ferramentas']['Link']; ?>/Pdf_Download">Download em PDF</a></li><?php } ?>
                    <?php if ($params['Ferramentas']['Excel']) { ?><li><a href="<?php echo URL_PATH; echo $params['Ferramentas']['Link']; ?>/Excel">Download em Excel</a></li><?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="space15"></div>
<?php } else if ($params['Tipo']=='Personalizado') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-<?php echo $params['btn_add']['cor']; ?> lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-<?php echo $params['btn_add']['icone']; ?>"></i>
    </a>

<?php } else if ($params['Tipo']==='Destaque0') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-danger lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-heart-broken"></i>
    </a>
<?php } else if ($params['Tipo']==='Destaque1') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-heart"></i>
    </a>

<?php } else if ($params['Tipo']==='Status0') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-danger lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-eye-disabled" alt="Desativado"></i>
    </a>
<?php } else if ($params['Tipo']==='Status1') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-eye" alt="Ativado"></i>
    </a>
<?php } else if ($params['Tipo']==='Email') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-primary lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-email"></i>
    </a>
<?php } else if ($params['Tipo']==='Baixar') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-inverse explicar-titulo" target="_BLANK" title="<?php echo $params['btn_add']['nome']; ?>">
        <i class="ion-code-download"></i>
    </a>
<?php } else if ($params['Tipo']==='Visualizar') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-search"></i>
    </a>
<?php } else if ($params['Tipo']==='Zoom') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-info lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="fa fa-zoom-in"></i>
    </a>
<?php } else if ($params['Tipo']==='Editar') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-warning lajax explicar-titulo" data-confirma="Deseja Realmente Editar?" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-pencil"></i>
    </a>
<?php } else if ($params['Tipo']==='Deletar') { ?>
    <a href="<?php echo URL_PATH; echo $params['btn_add']['url']; ?>" class="btn btn-floating btn-ripple btn-danger lajax explicar-titulo" data-confirma="<?php echo $params['btn_add']['onclick']; ?>" title="<?php echo $params['btn_add']['nome']; ?>" data-acao="">
        <i class="ion-trash "></i>
    </a>
<?php } ?>
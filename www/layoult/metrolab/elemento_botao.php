<?php if($params['Tipo']==='Superior'){ ?>
    <div class="clearfix">
        <?php if($params['btn_add']){ ?>
            <div class="btn-group">
                <?php if($params['btn_add']!=='#' && $params['btn_add']!==''){ ?>
                    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="lajax" acao="">
                <?php } ?>
                        <button class="btn green" onClick="<?php echo $params['btn_add']['onclick']; ?>">
                            <?php echo $params['btn_add']['nome']; ?> <i class="icon-plus"></i>
                        </button>
                <?php if($params['btn_add']!=='#' && $params['btn_add']!==''){ ?>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if(is_array($params['Ferramentas'])){ ?>
            <div class="btn-group pull-right">
                <button class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i> Ferramentas <i class="icon-angle-down"></i>
                </button>
                <ul class="dropdown-menu pull-right">
                    <?php if($params['Ferramentas']['Print']){ 
                        ?><li><a href="<?php echo URL_PATH; ?><?php echo $params['Ferramentas']['Link']; ?>/Imprimir" target="_BLANK">Imprimir</a></li>
                        <?php if($params['Ferramentas']['Pdf']!==false && $params['Ferramentas']['Excel']!==false){ ?><li class="divider"></li><?php }
                    } ?>
                    <?php if($params['Ferramentas']['Pdf']){ ?><li><a href="<?php echo URL_PATH; ?><?php echo $params['Ferramentas']['Link']; ?>/Pdf" target="_BLANK">Abrir em PDF</a></li><?php } ?>
                    <?php if($params['Ferramentas']['Pdf']){ ?><li><a href="<?php echo URL_PATH; ?><?php echo $params['Ferramentas']['Link']; ?>/Pdf_Download">Download em PDF</a></li><?php } ?>
                    <?php if($params['Ferramentas']['Excel']){ ?><li><a href="<?php echo URL_PATH; ?><?php echo $params['Ferramentas']['Link']; ?>/Excel">Download em Excel</a></li><?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
    <div class="space15"></div>
<?php }else if($params['Tipo']=='Personalizado'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-<?php echo $params['btn_add']['cor']; ?> lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-<?php echo $params['btn_add']['icone']; ?>"></i>
    </a>

<?php }else if($params['Tipo']==='Destaque0'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-danger lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-star-empty"></i>
    </a>
<?php }else if($params['Tipo']==='Destaque1'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-star"></i>
    </a>

<?php }else if($params['Tipo']==='Status0'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-danger lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-thumbs-down" alt="Dtivado"></i>
    </a>
<?php }else if($params['Tipo']==='Status1'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-thumbs-up" alt="Ativado"></i>
    </a>
<?php }else if($params['Tipo']==='Email'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-primary lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-envelope"></i>
    </a>
<?php }else if($params['Tipo']==='Baixar'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-inverse explicar-titulo" target="_BLANK" title="<?php echo $params['btn_add']['nome']; ?>">
        <i class="icon-download"></i>
    </a>
<?php }else if($params['Tipo']==='Visualizar'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-success lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-eye-open"></i>
    </a>
<?php }else if($params['Tipo']==='Zoom'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-info lajax explicar-titulo" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-zoom-in"></i>
    </a>
<?php }else if($params['Tipo']==='Editar'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-warning lajax explicar-titulo" confirma="Deseja Realmente Editar?" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-pencil"></i>
    </a>
<?php }else if($params['Tipo']==='Deletar'){ ?>
    <a href="<?php echo URL_PATH; ?><?php echo $params['btn_add']['url']; ?>" class="btn btn-danger lajax explicar-titulo" confirma="<?php echo $params['btn_add']['onclick']; ?>" title="<?php echo $params['btn_add']['nome']; ?>" acao="">
        <i class="icon-trash "></i>
    </a>
<?php } ?>
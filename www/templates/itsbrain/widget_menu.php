<ul id="menu">
    <?php foreach($params['menu']['link'] as $k=>$v){ ?>
        <li class="<?php echo $params['menu']['img'][$k]; ?>">
            <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup<?php if($params['menu']['filhos'][$k]!==false){ ?> exp<?php } if( $params['menu']['ativo'][$k]===1){ ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active<?php } ?>">
                <span><?php echo $params['menu']['nome'][$k]; ?></span>
                <?php if($params['menu']['filhos'][$k]!==false){ ?><!--<strong>{count($params.menu.filhos.$k)}</strong>--><?php } ?>
            </a>
            <?php if($params['menu']['filhos'][$k]!==false){ ?>
                <ul class="sub">
                    <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2){ ?>
                        <li<?php if($k2+1===count($params['menu']['filhos'][$k])){ ?> class="last"<?php } ?>>
                            <a data-acao="Control_Menu_SuperiorSub" href="<?php echo $v2['link']; ?>" class="lajax-mesup<?php if($v2['ativo']===1){ ?> active<?php } ?>">
                                <?php echo $v2['nome']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
    <?php } ?>
</ul>

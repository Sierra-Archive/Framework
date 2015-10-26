<ul id="sidebar-menu">
    <?php foreach ($params['menu']['link'] as $k=>$v){ ?>
        <li class="sub-menu menu_li_controle">
            <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup<?php if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active submenu-active<?php } ?>">
                <i class="fa fa-<?php echo $params['menu']['icon'][$k]; ?>"></i>
                <span><?php echo $params['menu']['nome'][$k]; ?></span>
                <?php if($params['menu']['filhos'][$k]!==false){ ?><span class="arrow"></span><?php } ?>
            </a>
            <?php if($params['menu']['filhos'][$k]!==false){ ?>
                <ul class="sub">
                    <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2){ ?>
                        <li>
                            <a data-acao="Control_Menu_SuperiorSub" href="<?php echo $v2['link']; ?>" class="lajax-mesup<?php if(isset($v2['ativo']) && $v2['ativo']===1){ ?> active<?php } ?>">
                                <i class="fa fa-<?php echo $v2['icon']; ?>"></i>
                                <span><?php echo $v2['nome']; ?></span>
                                <?php if(isset($v2['ativo']) && $v2['ativo']===2){ ?><span class="submenu-arrow"></span><?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
    <?php } ?>
</ul>
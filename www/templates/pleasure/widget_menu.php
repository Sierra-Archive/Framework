<ul>
    <?php foreach ($params['menu']['link'] as $k=>$v) { ?>
        <li class="sub-menu menu_li_controle">
            <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup"<?php if ($params['menu']['ativo'][$k]===1 || $params['menu']['ativo'][$k]===2) {  ?> data-open-after="true"<?php } ?>>
                <i class="fa fa-<?php echo $params['menu']['icon'][$k]; ?>"></i>&nbsp;<?php echo $params['menu']['nome'][$k]; ?>
            </a>
            <?php if ($params['menu']['filhos'][$k] !== FALSE) { ?>
                <ul class="child-menu">
                    <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2) { ?>
                        <li>
                            <a data-acao="Control_Menu_SuperiorSub" href="<?php echo $v2['link']; ?>" class="lajax-mesup"<?php if (isset($v2['ativo']) && $v2['ativo']===1) { ?> data-open-after="true"<?php } ?>>
                                <i class="fa fa-<?php echo $v2['icon']; ?>"></i>&nbsp;<?php echo $v2['nome']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </li>
    <?php } ?>
    <li class="sub-menu menu_li_controle"><a data-acao="Control_Menu_Superior" href="usuario/Perfil/Perfil_Edit/" class="lajax-mesup"><i class="fa fa-user"></i>&nbsp;<?php _e('Editar Perfil'); ?></a></li>
    <li class="sub-menu menu_li_controle"><a href="?logout=sair"><i class="fa fa-key"></i>&nbsp;<?php _e('Sair do Sistema'); ?></a></li>
</ul>
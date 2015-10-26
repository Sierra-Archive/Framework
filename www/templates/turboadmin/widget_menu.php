<ul id="main-menu" class="radius-top clearfix">
    <?php foreach($params['menu']['link'] as $k=>$v){ ?>
        <li>
            <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup<?php if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active submenu-active<?php } ?>">
                <img src="<?php echo $params['url']; ?>img/<?php echo $params['menu']['img'][$k]; ?>" alt="Dashboard" />
                <span>
                    <?php echo $params['menu']['nome'][$k]; ?>
                </span>
                <?php if($params['menu']['ativo'][$k]===2){ ?><span class="submenu-arrow"></span><?php } ?>
            </a>
        </li>
    <?php } ?>
</ul><!-- #main-menu .radius-top clearfix -->
<ul id="sub-menu" class="clearfix">
<?php if($params['menu']['filhos'][$k]!==false){ ?>
    <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2){ ?>
        <li><a href="<?php echo $v2['link']; ?>"<?php if($v2['ativo']===1){ ?> class="active"<?php } ?>><?php echo $v2['nome']; ?></a></li>
    <?php } ?>
<?php } ?>
</ul><!-- #sub-menu .clearfix -->
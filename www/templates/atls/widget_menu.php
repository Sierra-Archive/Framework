<nav id="smoothmenu1" class="ddsmoothmenu mainMenu">
    <ul id="nav">
        
        <?php foreach ($params['menu']['link'] as $k=>$v){ ?>
            <li class="sub-menu menu_li_controle <?php if($params['menu']['filhos'][$k]!==false){ echo ' parent';}if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active parent<?php } ?>">
                <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup<?php if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active parent<?php } ?>">
                    <?php echo $params['menu']['nome'][$k]; ?>
                </a>
                <?php if($params['menu']['filhos'][$k]!==false){ ?>
                    <ul style="width: 100px; display: none;">
                        <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2){ ?>
                            <li class="parent">
                                <a data-acao="Control_Menu_SuperiorSub" href="<?php echo $v2['link']; ?>" class="lajax-mesup<?php if(isset($v2['ativo']) && $v2['ativo']===1){ ?> active<?php } ?>">
                                    <?php echo $v2['nome']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </li>
        <?php } ?>       
    </ul>
</nav>
                
<div class="mobMenu">
    <h1>
        <span>Menu</span>
        <a class="menuBox highlight" href="javascript:void(0);">ccc</a>
        <span class="clearfix"></span>
    </h1>
    <div id="menuInnner" style="display:none;">
        <ul class="accordion">

            <?php foreach ($params['menu']['link'] as $k=>$v){ ?>
                <li class="sub-menu menu_li_controle <?php if($params['menu']['filhos'][$k]!==false){echo ' parent';}if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active parent<?php } ?>">
                    <a data-acao="Control_Menu_Superior" href="<?php echo $params['menu']['link'][$k]; ?>" class="lajax-mesup<?php if($params['menu']['ativo'][$k]===1){  ?> active<?php }else if($params['menu']['ativo'][$k]===2){ ?> active parent<?php } ?>">
                        <?php echo $params['menu']['nome'][$k]; ?>
                    </a>
                    <?php if($params['menu']['filhos'][$k]!==false){ ?>
                        <ul style="width: 100px; display: none;">
                            <?php foreach($params['menu']['filhos'][$k] as $k2=>$v2){ ?>
                                <li class="parent">
                                    <a data-acao="Control_Menu_SuperiorSub" href="<?php echo $v2['link']; ?>" class="lajax-mesup<?php if(isset($v2['ativo']) && $v2['ativo']===1){ ?> active<?php } ?>">
                                        <?php echo $v2['nome']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </li>
            <?php } ?>
            <span class="clearfix"></span>
        </ul>

     </div>     
 </div>
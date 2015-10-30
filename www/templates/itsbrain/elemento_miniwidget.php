<?php $cont=0;
foreach($params['widgets'] as $v) {
    if( isset($v['duplo']) && $v['duplo']===true) {
        $duplo=' double';
    } else {
        $duplo='';
    }
    if($cont==0) {
        echo '<div class="metro-nav">';
    } ?>
    <div class="metro-nav-block nav-<?php echo $v['cor']; echo $duplo; ?>">
        <a data-original-title="<?php echo $v['nome']; ?>" href="<?php echo $v['link']; ?>" class="lajax" data-acao="">
            <i class="fa fa-<?php echo $v['icon']; ?>"></i>
            <div class="info"><?php echo $v['numero']; ?></div>
            <div class="status"><?php echo $v['nome']; ?></div>
        </a>
    </div>
    <?php ++$cont;
    if($cont===5) { ?>
        </div>
        <?php $cont=0;
    }
}
if($cont!==0) { echo '</div>'; } ?>
<div class="space15"></div>
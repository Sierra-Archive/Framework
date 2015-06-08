<?php $cont=0;
foreach($params['widgets'] as $v){
    var_dump($v);
    if( isset($v['duplo']) && $v['duplo']===true){
        $duplo=' double';
    }else{
        $duplo='';
    }
    if($cont==0){
        echo '<ul class="nav nav-pills" role="tablist">';
    } ?>
    <li role="presentation" class="active <?php echo $v['cor']; echo $duplo; ?>">
        <a href="<?php echo $v['link']; ?>" class="lajax" acao="">
            <?php echo $v['nome']; ?> <span class="badge"><?php echo $v['numero']; ?></span>
        </a>
    </li>
    <?php ++$cont;
    if($cont===5){ ?>
        </div>
        <?php $cont=0;
    }
}
if($cont!==0) { echo '</ul>'; } ?>
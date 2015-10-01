<li><a<?php if($params['ativo']===false) { echo ' class="active"'; }
if($params['ativo']!==false) { ?> class="lajax" href="<?php echo URL_PATH.$params['endereco']; ?>" acao=""><?php }else{ echo ' href="#">'; } ?>
    <?php 
    if($params['nome']==__('Página Inicial')){
        echo '<i class="ion-home"></i>';
    }else{
        echo $params['nome'];
    }
    ?>
</a>
</li>
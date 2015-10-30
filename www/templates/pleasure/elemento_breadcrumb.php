<li><a class="<?php if($params['ativo']===false) { echo 'active '; }
if($params['ativo']!==false) { ?>lajax" href="<?php echo URL_PATH.$params['endereco']; ?>" data-acao=""><?php } else { echo '" href="#">'; } ?>
    <?php 
    if($params['nome']==__('Página Inicial')){
        echo '<i class="ion-home"></i>';
    } else {
        echo $params['nome'];
    }
    ?>
</a>
</li>
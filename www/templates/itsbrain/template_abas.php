<?php if( $params['Tipo']==='Topo') { ?>
    <li<?php if( $params['i']==0) { ?> class="active"<?php } ?>><a href="#<?php echo $params['id']; ?>"><?php echo $params['titulo']; ?></a></li>
<?php }else if($params['Tipo']==='Final') { ?>
    <div class="<?php if( $params['i']==0) { ?>active<?php } ?>" id="<?php echo $params['id']; ?>"><?php echo $params['bloco']; ?></div>
<?php }else if($params['Tipo']==='Montagem') { ?>
    <ul><?php echo $params['html1']; ?></ul><?php echo $params['html2']; ?>
<?php } ?>
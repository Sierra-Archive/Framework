<?php
$class = Array(
    'light-green' => 'green',
    'block-yellow' => 'orange',
    'block-purple' => 'purple',
    'block-red' => 'red',
    'light-brown' => 'grey',
    'block-azulescuro' => 'indigo',
    'block-azul' => 'blue',
);
?><div class="display-animation"><div class="row image-row margin-bottom-40"><?php $cont=0;
foreach($params['widgets'] as $v) {
    if ( isset($v['duplo']) && $v['duplo'] === TRUE) {
        $duplo=' double';
    } else {
        $duplo='';
    } ?>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <div class="card tile card-dashboard-info card-<?php if (isset($class[$v['cor']])) { echo $class[$v['cor']]; } else { echo $v['cor']; } echo $duplo; ?> material-animate">
            <div class="card-body">
                    <div class="card-icon"><i class="fa fa-<?php echo $v['icon']; ?>"></i></div><!--.card-icon-->
                    <h4><?php echo $v['nome']; ?></h4>
                    <p class="result"><?php echo $v['numero']; ?></p>
                    <?php /*<small><i class="fa fa-caret-up"></i> Total balance is $23,591</small><a data-original-title="<?php echo $v['nome']; ?>" href="<?php echo $v['link']; ?>" class="lajax" data-acao="">*/ ?>
            </div>
        </div>
    </div>
    <?php
} ?>
</div></div>
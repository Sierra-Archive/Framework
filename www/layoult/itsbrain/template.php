<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></title>
    <meta charset="<?php echo CONFIG_PADRAO_TECLADO; ?>">
    <link rel="icon" type="image/png" href="<?php echo ARQ_URL; ?>favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo $params['sistema']['css']; ?>
    <link href="<?php echo $params['url_css']; ?>main.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
</head>     
<body>

    <!-- Top navigation bar -->
    <div id="topNav">
        <div class="fixed">
            <div class="wrapper">
                <div class="welcome">
                <span><?php echo SISTEMA_NOME; ?></span>
                </div>
                <div class="userNav">
                    <ul>
                        <?php echo $params['template']['usuario']; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div id="header" class="wrapper">
        <div class="fix" style="line-height: 20px; height:20px;"></div>
        <!--<div class="logo"><a class="navbar-brand" href="<?php echo URL_PATH; ?>"><img src="<?php echo ARQ_URL; ?>_Sistema/logo.png" alt="<?php echo SISTEMA_NOME; ?>" style="max-width: 300px;" /></a></div>-->
        <!--<ul class="middleNav">
            <li class="iMes"><a href="#" title=""><span>Support tickets</span></a><span class="numberMiddle">9</span></li>
            <li class="iStat"><a href="#" title=""><span>Statistics</span></a></li>
            <li class="iUser"><a href="#" title=""><span>User list</span></a></li>
            <li class="iOrders"><a href="#" title=""><span>Billing panel</span></a></li>
        </ul>-->
    </div>


    <!-- Content wrapper -->
    <div class="wrapper">

            <!-- Left navigation -->
        <div class="leftNav">
            <?php echo $params['template']['menu']; ?>
            <div class="logo"><a class="navbar-brand" href="<?php echo URL_PATH; ?>"><img src="<?php echo ARQ_URL; ?>_Sistema/logo.png" alt="<?php echo SISTEMA_NOME; ?>" style="max-width: 300px;" /></a></div>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="title"><h5><span id="Framework_Titulo"><?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></span></h5></div>
            <spam id="blocounico"<?php if( $params['template']['Bloco_Unico']==''){ ?> style="display: none;"<?php } ?>>
                <?php echo $params['template']['Bloco_Unico']; ?>
            </spam>
            <div class="fluid">
                <div class="col-sm-8" id="blocomaior"<?php if( $params['template']['Bloco_Maior']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Maior']; ?>
                </div>
                <div class="col-sm-4" id="blocomenor"<?php if( $params['template']['Bloco_Menor']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Menor']; ?>
                </div>
            </div>
    </div>
    </div>

    <!-- Footer -->
    <div id="footer">
	<div class="wrapper">
            <span>Copyright &copy; 2013 <strong><?php echo SISTEMA_NOME; ?></strong> Direitos <strong><?php echo SOBRE_DIREITOS; ?></strong></span>
        </div>
    </div>
   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time -->    
    <?php echo $params['sistema']['extras']; ?>
    <script src="<?php echo $params['url_js']; ?>extra.js"></script>
    <script type="text/javascript" src="<?php echo $params['url_js']; ?>plugins/tables/colResizable.min.js"></script>
    <script type="text/javascript" src="<?php echo $params['url_js']; ?>plugins/ui/jquery.collapsible.min.js"></script>
</body></html>

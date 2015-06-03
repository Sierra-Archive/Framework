<html><head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if($params['site_titulo']==''){ echo __('Sem Titulo'); }else{ echo $params['site_titulo']; } ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CONFIG_PADRAO_TECLADO; ?>"/>

    <link rel="icon" type="image/png" href="<?php echo ARQ_URL; ?>favicon.ico"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $params['url_css']; ?>layoult.css" />
    <script type="text/javascript" src="<?php echo $params['url_js']; ?>javascript.js"></script>
    <?php echo $params['sistema']['css']; ?>
</head>
<body>
    <div id="container">
        <div id="adminbar-outer" class="radius-bottom">
            <div id="adminbar" class="radius-bottom">
                <a href="index.htm" id="logo"></a>
                <?php echo $params['template']['usuario']; ?>
            </div><!-- #adminbar -->
        </div><!-- #adminbar-outer .radius-bottom -->
        <div id="panel-outer" class="radius">
            <div id="panel" class="radius">
                <?php echo $params['template']['menu']; ?>
                <div id="content" class="clearfix">
                    <div id="side-content-right">
                        <span id="loadcoldir">
                            <?php echo $params['template']['Bloco_Menor']; ?>
                         </span>
                    </div>
                    <div id="main-content-left">
                        <?php echo $params['template']['Bloco_Maior']; ?>
                    </div><!-- #main-content-left -->
                </div><!-- #content -->
                <div id="footer" class="radius-bottom">
                    Copyright &copy; 2011, <strong><?php echo SISTEMA_NOME; ?></strong> Direitos <strong><?php echo SOBRE_DIREITOS; ?></strong>
                </div><!-- #footer .radius-bottom -->
            </div>
        </div>
    </div><!-- #container -->
    <?php echo $params['sistema']['extras']; ?>
   <script src="<?php echo $params['url_js']; ?>extra.js"></script>
</body></html>
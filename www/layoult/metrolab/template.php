<!DOCTYPE html>
<!--[if IE 8]> <html lang="pt-br" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="pt-br" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <title><?php echo SISTEMA_NOME; ?> - <?php if($params['site_titulo']==''){ echo 'Sem Titulo'; }else{ echo $params['site_titulo']; } ?></title>
    <meta charset="<?php echo CONFIG_PADRAO_TECLADO; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo $params['sistema']['css']; ?>
    <link href="<?php echo $params['url_css']; ?>style.css" rel="stylesheet" />
    <link href="<?php echo $params['url_css']; ?>style-responsive.css" rel="stylesheet" />
    <link href="<?php echo $params['url_css']; ?>style-<?php if(TEMA_COLOR==''){ echo 'blue'; }else{ echo TEMA_COLOR; }?>.css" rel="stylesheet" id="style_color" />
</head>     
       
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <!--BEGIN SIDEBAR TOGGLE-->
            <div class="sidebar-toggle-box hidden-xs">
                <div class="glyphicon-reorder"></div>
            </div>
            <!--END SIDEBAR TOGGLE-->

            <!-- BEGIN TOP NAVIGATION BAR -->
            <a class="navbar-brand" href="<?php echo URL_PATH; ?>">
                <img src="<?php echo ARQ_URL; ?>_Sistema/logo.png" alt="<?php echo SISTEMA_NOME; ?>" style="max-height: 40px;">
            </a>
            <!-- BEGIN LOGO -->

            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->

            <button id="menuresponsivo_trocar" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
        </div>
        <!-- END  NOTIFICATION -->
        <div class="navbar-header navbar-right">
            <ul class="nav pull-right top-menu navbar-nav">
                <!-- BEGIN SUPPORT  -->
                <li class="dropdown mtop5"><a class="dropdown-toggle element lajax" acao="" data-placement="bottom" data-toggle="tooltip" href="<?php echo SISTEMA_URL.SISTEMA_DIR; ?>usuario/Admin/Usuarios_Add/cliente" data-original-title="Novo Cliente"><i class="glyphicon-user"></i></a></li>                            <!-- END SUPPORT -->
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo SISTEMA_URL.SISTEMA_DIR; ?>web/img/icons/clientes.png" width="30" height="30">
                        <span class="username">ADMINISTRADOR</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                    <?php if(isset($params['widgets']['Superior'])){ 
                         $total=count($params['widgets']['Superior']); 
                         for($cont=0;$cont<$total; ++$cont) {  
                             echo $params['widgets']['Superior'][$cont];
                         } ?>
                         <!-- END SUPPORT -->
                         <!-- BEGIN USER LOGIN DROPDOWN -->
                         <?php echo $params['template']['usuario']; 
                    }?>
                    </ul>
                </li>                        
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
       <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->         

    <!-- BEGIN CONTAINER -->
    <!-- BEGIN SIDEBAR -->
    <div class="sidebar sidebar-scroll">
        <div id="sidebar" class="nav nav-sidebar">
            <?php /*<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <div class="navbar-inverse">
                <form class="navbar-search visible-xs">
                    <input type="text" class="search-query" placeholder="Buscar" />
                </form>
            </div>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
            <!-- BEGIN SIDEBAR MENU --> */
                echo $params['template']['menu']; ?>
            <!-- END SIDEBAR MENU -->
        </div>
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->  
    <div id="main-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row">
                <div class="col-sm-12">
                    <!-- END THEME CUSTOMIZER-->
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                      <span id="Framework_Titulo"><?php if($params['site_titulo']==''){ echo 'Sem Titulo'; }else{ echo $params['site_titulo']; } ?></span>
                    </h3>
                    <?php 
                    if(isset($params['widgets']) && isset($params['widgets']['Navegacao_Endereco'])){
                        echo '<ul class="breadcrumb">'.
                             $params['widgets']['Navegacao_Endereco'].
                             '</ul>'; 
                    }
                    ?>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row">
                <div class="col-sm-12" id="blocounico"<?php if( $params['template']['Bloco_Unico']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Unico']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8" id="blocomaior"<?php if( $params['template']['Bloco_Maior']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Maior']; ?>
                </div>
                <div class="col-sm-4" id="blocomenor"<?php if( $params['template']['Bloco_Menor']==''){ ?> style="display: none;"<?php } ?>>
                    <?php echo $params['template']['Bloco_Menor']; ?>
                </div>
            </div>
            <!-- END PAGE CONTENT-->         
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->

   <!-- BEGIN FOOTER -->
   <div id="footer">
       Copyright &copy; 2013 <strong><?php echo SISTEMA_NOME; ?></strong> Direitos <strong><?php echo SOBRE_DIREITOS; ?></strong>
   </div>
   <!-- END FOOTER -->  
    
   <!-- BEGIN JAVASCRIPTS -->
   <!-- Load javascripts at bottom, this will reduce page load time --> 
    <script type="text/javascript">console.time('Sistema');</script>   
    <?php echo $params['sistema']['extras']; ?>
    <script src="<?php echo $params['url_js']; ?>extra.js"></script>
    
    
    <script src="<?php echo $params['url_js']; ?>jquery.nicescroll.js" type="text/javascript"></script>

    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="<?php echo $params['url_js']; ?>excanvas.js"></script>
    <script src="<?php echo $params['url_js']; ?>respond.js"></script>
    <![endif]-->
    <!--common script for all pages-->
    <script src="<?php echo $params['url_js']; ?>common-scripts.js"></script>
    <script type="text/javascript">console.timeEnd('Sistema');</script>
</body></html>

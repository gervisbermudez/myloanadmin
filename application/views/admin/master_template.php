<?php $user = $this->session->userdata('user');?><?php echo doctype('html5'); ?><html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('sitename'); ?> | <?php echo $title ?></title>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="MyLoanAdmin">
    <meta name="apple-mobile-web-app-title" content="MyLoanAdmin">
    <meta name="theme-color" content="#3c8dbc">
    <meta name="msapplication-navbutton-color" content="#3c8dbc">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="57x57" href="<?=base_url(IMGPATH);?>favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=base_url(IMGPATH);?>favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url(IMGPATH);?>favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url(IMGPATH);?>favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url(IMGPATH);?>favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=base_url(IMGPATH);?>favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=base_url(IMGPATH);?>favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=base_url(IMGPATH);?>favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url(IMGPATH);?>favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=base_url(IMGPATH);?>favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=base_url(IMGPATH);?>favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=base_url(IMGPATH);?>favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url(IMGPATH);?>favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=base_url(PUBLICPATH);?>manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=base_url(IMGPATH);?>favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#3c8dbc">
    <style></style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <?=link_tag(CSSPATH . 'AdminLTE.min.css?v=' . SITEVERSION);?><?php if (isset($head_includes)) {foreach ($head_includes as $value) {echo $value;}}?>
    <!--[if lt IE 9]><script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <link rel="stylesheet" crossorigin rel="preconnect"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

</html>

<body class="hold-transition skin-blue-light sidebar-mini">
    <div class="wrapper">
        <header class="main-header"><a href="<?php echo base_url(); ?>" class="logo"><span
                    class="logo-mini"><b>AD</b></span> <span
                    class="logo-lg"><b><?php echo $this->config->item('sitename'); ?></b></span></a>
            <nav class="navbar navbar-static-top"><a href="#" class="sidebar-toggle" data-toggle="push-menu"
                    role="button"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
                        class="icon-bar"></span> <span class="icon-bar"></span></a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown notifications-menu"><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span
                                    class="label label-warning notificationscount"></span></a>
                            <ul class="dropdown-menu">
                                <li class="header">Tienes <span class="notificationscount"></span> notificaciones</li>
                                <li>
                                    <ul class="menu">
                                        <li id="notifications"></li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="<?php echo base_url('admin/notificaciones'); ?>">View
                                        all</a></li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu"><a href="#" class="dropdown-toggle"
                                data-toggle="dropdown"><?php if (is_file(IMGPROFILEPATH . $user['avatar'])): ?><img
                                    class="user-image" src="<?php echo base_url(IMGPROFILEPATH . $user['avatar']); ?>"
                                    alt="Avatar"><?php endif?> <span
                                    class="hidden-xs"><?php echo $user['username']; ?></span></a>
                            <ul class="dropdown-menu">
                                <li class="user-header"><?php if (is_file(IMGPROFILEPATH . $user['avatar'])): ?><img
                                        class="img-circle"
                                        src="<?php echo base_url(IMGPROFILEPATH . $user['avatar']); ?>"
                                        alt="Avatar"><?php endif?><p><?php echo $user['username']; ?><small>Registrado:
                                            <?php echo time_to_string($user['date_created']->format('d M Y')); ?></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left"> <a
                                            href="<?php echo base_url('admin/user/view/' . $user['id']); ?>"
                                            class="btn btn-default btn-flat"><i class="fa fa-user"></i> Perfil</a></div>
                                    <div class="pull-right"><a href="<?php echo base_url('admin/login'); ?>"
                                            class="btn btn-default btn-flat"><i class="fa fa-fw fa-sign-in"></i>
                                            Salir</a></div>
                                </li>
                            </ul>
                        </li>
                        <?php /*<li> <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> </li>*/?>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar"><a href="<?php echo base_url('admin/user/view/' . $user['id']); ?>">
                    <div class="user-panel">
                        <div class="pull-left image"><?php if (is_file(IMGPROFILEPATH . $user['avatar'])): ?><img
                                class="img-circle" src="<?php echo base_url(IMGPROFILEPATH . $user['avatar']); ?>"
                                alt="Avatar"><?php endif?></div>
                        <div class="pull-left info">
                            <p><?php echo $user['username']; ?></p><i class="fa fa-circle text-success"></i> Online
                        </div>
                    </div>
                </a><?php /*<form action="#" method="get" class="sidebar-form"> <div class="input-group"> <input type="text" name="q" class="form-control" placeholder="Search..."> <span class="input-group-btn"> <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i> </button> </span> </div> </form>*/?>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="treeview"><a href="#"><i class="fa fa-users"></i> <span>Cobradores</span> <span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url('admin/user'); ?>"><i class="fa fa-circle-o"></i> Todos</a>
                            </li><?php if ($user['create_any_user']): ?><li><a
                                    href="<?php echo base_url('admin/user/add'); ?>"><i class="fa fa-plus-circle"></i>
                                    Nuevo</a></li><?php endif;?>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url('admin/user/calendar'); ?>"><i class="fa fa-calendar"></i>
                            <span>Calendario</span></a></li>
                    <li class="treeview"><a href="#"><i class="fa fa-user"></i> <span>Clientes</span> <span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url('admin/prestamo/clientes'); ?>"><i
                                        class="fa fa-circle-o"></i> Ver Clientes</a></li>
                            <li><a href="<?php echo base_url('admin/prestamo/clientes/nuevo'); ?>"><i
                                        class="fa fa-plus-circle"></i> Nuevo</a></li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="fa fa-money"></i> <span>Prestamos</span> <span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url('admin/prestamo'); ?>"><i class="fa fa-circle-o"></i> Ver
                                    prestamos</a></li>
                            <li><a href="<?php echo base_url('admin/prestamo/nuevo'); ?>"><i
                                        class="fa fa-plus-circle"></i>Nuevo</a></li>
                        </ul>
                    </li>
                    <li class="treeview"><a href="#"><i class="fa fa-file-text-o"></i> <span>Reportes</span> <span
                                class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url('admin/reportes'); ?>"><i class="fa fa-circle-o"></i>
                                    Reportes de prestamos</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
        </aside><?php if (isset($pagecontent)) {echo $pagecontent;}?><footer class="main-footer">
            <div class="pull-right hidden-xs"><b>Version</b> <?=SITEVERSION?></div><strong> Copyright &copy; 2018
                -<?=date('Y')?> <a
                    href="<?php echo base_url(); ?>"><?php echo $this->config->item('sitename'); ?></a>.</strong> All
            rights reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class="control-sidebar-menu">
                        <li><a href="javascript:void(0)"><i class="menu-icon fa fa-birthday-cake bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)"><i class="menu-icon fa fa-user bg-yellow"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                                    <p>New phone +1(800)555-1234</p>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)"><i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                                    <p>nora@example.com</p>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)"><i class="menu-icon fa fa-file-code-o bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                                    <p>Execution time 5 seconds</p>
                                </div>
                            </a></li>
                    </ul>
                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class="control-sidebar-menu">
                        <li><a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">Custom Template Design <span
                                        class="label label-danger pull-right">70%</span></h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width:70%"></div>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">Update Resume <span
                                        class="label label-success pull-right">95%</span></h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-success" style="width:95%"></div>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">Laravel Integration <span
                                        class="label label-warning pull-right">50%</span></h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-warning" style="width:50%"></div>
                                </div>
                            </a></li>
                        <li><a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">Back End Framework <span
                                        class="label label-primary pull-right">68%</span></h4>
                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-primary" style="width:68%"></div>
                                </div>
                            </a></li>
                    </ul>
                </div>
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>
                        <div class="form-group"><label class="control-sidebar-subheading">Report panel usage <input
                                    type="checkbox" class="pull-right" checked></label>
                            <p>Some information about this general settings option</p>
                        </div>
                        <div class="form-group"><label class="control-sidebar-subheading">Allow mail redirect <input
                                    type="checkbox" class="pull-right" checked></label>
                            <p>Other sets of options are available</p>
                        </div>
                        <div class="form-group"><label class="control-sidebar-subheading">Expose author name in posts
                                <input type="checkbox" class="pull-right" checked></label>
                            <p>Allow the user to show his name in blog posts</p>
                        </div>
                        <h3 class="control-sidebar-heading">Chat Settings</h3>
                        <div class="form-group"><label class="control-sidebar-subheading">Show me as online <input
                                    type="checkbox" class="pull-right" checked></label></div>
                        <div class="form-group"><label class="control-sidebar-subheading">Turn off notifications <input
                                    type="checkbox" class="pull-right"></label></div>
                        <div class="form-group"><label class="control-sidebar-subheading">Delete chat history <a
                                    href="javascript:void(0)" class="text-red pull-right"><i
                                        class="fa fa-trash-o"></i></a></label></div>
                    </form>
                </div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
    <div class="alert-zone"></div>
    <script>const JSPATH = '<?=JSPATH?>';
        const CSSPATH = '<?=CSSPATH?>';
        const FONTSPATH = '<?=FONTSPATH?>';
        const BASEURL = '<?=base_url()?>';</script>
    <script src="<?php echo base_url() . JSPATH . 'jquery/dist/jquery.min.js?v=' . SITEVERSION; ?>"></script>
    <script src="<?php echo base_url() . JSPATH . 'bootstrap/dist/js/bootstrap.min.js?v=' . SITEVERSION; ?>"></script>
    <?php if (isset($footer_includes)) {foreach ($footer_includes as $key => $value) {echo $value;}}?>
    <script src="<?php echo base_url() . JSPATH . 'app.min.js?v=' . SITEVERSION; ?>"></script>
    <?php if ($this->config->item('enable_googletagmanager')): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127304899-1"></script>
    <script>window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-127304899-1');</script>
    <?php endif;?>
</body>
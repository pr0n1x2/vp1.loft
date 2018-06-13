<?php

require('../bd.php');
require('includes/functions.php');

$page = 'details';
$order = getOrderDetails();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Детали заказа №<?= $order['id'] ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php
        include('header.php');
        ?>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php
        include('navbar.php');
        ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Детали заказа №<?= $order['id'] ?></h4> </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white"><?= $order['name'] ?></h4>
                                        <h5 class="text-white"><?= $order['phone'] ?></h5> </div>
                                </div>
                            </div>
                            <div class="user-btm-box">
                                <div class="col-md-12 col-sm-12 text-center">
                                    <p class="text-purple"><i class="ti-facebook"></i></p>
                                    <h1>Всего заказов: <?= $order['order_count'] ?></h1> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material">
                                <div class="form-group">
                                    <label class="col-md-12">Имя клиента</label>
                                    <div class="col-md-12">
                                        <p><?= $order['name'] ?></p> </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Телефон</label>
                                    <div class="col-md-12">
                                        <p><?= $order['phone'] ?></p> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <p><?= $order['email'] ?></p> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Заказ</label>
                                    <div class="col-md-12">
                                        <p>DarkBeefBurger за 500 рублей, 1 шт.</p> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Улица</label>
                                    <div class="col-md-12">
                                        <p><?= $order['street'] . ', ' . $order['home'] ?></p> </div>
                                </div>
                                <?php
                                if (!empty($order['part'])) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12">Корпус</label>
                                        <div class="col-md-12">
                                            <p><?= $order['part'] ?></p></div>
                                    </div>
                                    <?php
                                }

                                if (!empty($order['appt'])) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12">Квартира</label>
                                        <div class="col-md-12">
                                            <p><?= $order['appt'] ?></p></div>
                                    </div>
                                    <?php
                                }

                                if (!empty($order['floor'])) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12">Этаж</label>
                                        <div class="col-md-12">
                                            <p><?= $order['floor'] ?></p></div>
                                    </div>
                                    <?php
                                }

                                if (!empty($order['comment'])) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12">Комментарий</label>
                                        <div class="col-md-12">
                                            <p><?= nl2br(strip_tags($order['comment'])) ?></p></div>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label class="col-md-12">Оплата</label>
                                    <div class="col-md-12">
                                        <p><?= $order['payment'] ?></p> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Перезванивать?</label>
                                    <div class="col-md-12">
                                        <p><?= $order['is_callback'] == 1 ? 'Перезвонить' : 'Не перезванивать' ?></p> </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <?php
            include('footer.php');
            ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav slimscrollsidebar">
        <div class="sidebar-head">
            <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
        </div>
        <ul class="nav" id="side-menu">
            <li style="padding: 70px 0 0;">
                <a href="/admin/" class="waves-effect <?= $page == 'users' ? 'active' : '' ?>"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Пользователи</a>
            </li>
            <li>
                <a href="/admin/orders.php" class="waves-effect <?= $page == 'orders' ? 'active' : '' ?>"><i class="fa fa-table fa-fw" aria-hidden="true"></i>Заказы</a>
            </li>
        </ul>
    </div>
</div>
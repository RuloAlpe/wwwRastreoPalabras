<?php
use \yii\helpers\Url;
?>
<div class="site-menubar">
    <div class="site-menubar-body">
    <div>
        <div>
        <ul class="site-menu">
            <?php
            if (\Yii::$app->user->can('admin')) {
            ?>
                <li class="site-menu-category">Super admin</li>
                <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Usuarios</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/super-admin/index">
                            <span class="site-menu-title">Lista de usuarios</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/v2.html">
                            <span class="site-menu-title">Roles</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/ecommerce.html">
                            <span class="site-menu-title">Permisos</span>
                        </a>
                        </li>
                    </ul>
                </li>
            <?php    
            }
            ?>


            <li class="site-menu-category">General</li>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                    <span class="site-menu-title">Dashboard</span>
                    <div class="site-menu-badge">
                    <span class="badge badge-success">3</span>
                    </div>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                    <a class="animsition-link" href="../index.html">
                        <span class="site-menu-title">Dashboard v1</span>
                    </a>
                    </li>
                    <li class="site-menu-item">
                    <a class="animsition-link" href="../dashboard/v2.html">
                        <span class="site-menu-title">Dashboard v2</span>
                    </a>
                    </li>
                    <li class="site-menu-item">
                    <a class="animsition-link" href="../dashboard/ecommerce.html">
                        <span class="site-menu-title">Ecommerce</span>
                    </a>
                    </li>
                    <li class="site-menu-item">
                    <a class="animsition-link" href="../dashboard/analytics.html">
                        <span class="site-menu-title">Analytics</span>
                    </a>
                    </li>
                    <li class="site-menu-item">
                    <a class="animsition-link" href="../dashboard/team.html">
                        <span class="site-menu-title">Team</span>
                    </a>
                    </li>
                </ul>
            </li>
            <li class="site-menu-item has-sub">
            <a href="javascript:void(0)">
                <i class="site-menu-icon wb-layout" aria-hidden="true"></i>
                <span class="site-menu-title">Layouts</span>
                <span class="site-menu-arrow"></span>
            </a>
            <ul class="site-menu-sub">
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/menu-collapsed.html">
                    <span class="site-menu-title">Menu Collapsed</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/menu-collapsed-alt.html">
                    <span class="site-menu-title">Menu Collapsed Alt</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/menu-expended.html">
                    <span class="site-menu-title">Menu Expended</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/grids.html">
                    <span class="site-menu-title">Grid Scaffolding</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/layout-grid.html">
                    <span class="site-menu-title">Layout Grid</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/headers.html">
                    <span class="site-menu-title">Different Headers</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/panel-transition.html">
                    <span class="site-menu-title">Panel Transition</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/boxed.html">
                    <span class="site-menu-title">Boxed Layout</span>
                </a>
                </li>
                <li class="site-menu-item">
                <a class="animsition-link" href="../layouts/two-columns.html">
                    <span class="site-menu-title">Two Columns</span>
                </a>
                </li>
               
               
            </ul>
            </li>
        </ul>
        <div class="site-menubar-section">
            <h5>
            Milestone
            <span class="pull-right">30%</span>
            </h5>
            <div class="progress progress-xs">
            <div class="progress-bar active" style="width: 30%;" role="progressbar"></div>
            </div>
            <h5>
            Release
            <span class="pull-right">60%</span>
            </h5>
            <div class="progress progress-xs">
            <div class="progress-bar progress-bar-warning" style="width: 60%;" role="progressbar"></div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <div class="site-menubar-footer">
    <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
    data-original-title="Settings">
        <span class="icon wb-settings" aria-hidden="true"></span>
    </a>
    <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
        <span class="icon wb-eye-close" aria-hidden="true"></span>
    </a>
    <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
        <span class="icon wb-power" aria-hidden="true"></span>
    </a>
    </div>
</div>
<div class="site-gridmenu">
    <div>
    <div>
        <ul>
        <li>
            <a href="../apps/mailbox/mailbox.html">
            <i class="icon wb-envelope"></i>
            <span>Mailbox</span>
            </a>
        </li>
        <li>
            <a href="../apps/mailbox/mailbox.html">
            <i class="icon wb-envelope"></i>
            <span>Mailbox</span>
            </a>
        </li>
        <li>
            <a href="../apps/calendar/calendar.html">
            <i class="icon wb-calendar"></i>
            <span>Calendar</span>
            </a>
        </li>
        <li>
            <a href="../apps/contacts/contacts.html">
            <i class="icon wb-user"></i>
            <span>Contacts</span>
            </a>
        </li>
        <li>
            <a href="../apps/media/overview.html">
            <i class="icon wb-camera"></i>
            <span>Media</span>
            </a>
        </li>
        <li>
            <a href="../apps/documents/categories.html">
            <i class="icon wb-order"></i>
            <span>Documents</span>
            </a>
        </li>
        <li>
            <a href="../apps/projects/projects.html">
            <i class="icon wb-image"></i>
            <span>Project</span>
            </a>
        </li>
        <li>
            <a href="../apps/forum/forum.html">
            <i class="icon wb-chat-group"></i>
            <span>Forum</span>
            </a>
        </li>
        <li>
            <a href="../index.html">
            <i class="icon wb-dashboard"></i>
            <span>Dashboard</span>
            </a>
        </li>
        </ul>
    </div>
    </div>
</div>
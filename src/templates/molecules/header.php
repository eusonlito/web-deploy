<header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only"><?= __('Toggle navigation'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="<?= route('/'); ?>" class="navbar-brand <?= (strpos($ROUTE, 'index-') === 0) ? 'active' : ''; ?>"><?= __('Web Deploy'); ?></a>
        </div>

        <nav id="bs-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (in_array('git', $MODULES, true)) { ?>
                <li <?= (strpos($ROUTE, 'git-') === 0) ? 'class="active"' : ''; ?>>
                    <a href="<?= route('/git'); ?>"><?= __('GIT'); ?></a>
                </li>
                <?php } if (in_array('ftp', $MODULES, true)) { ?>
                <li <?= (strpos($ROUTE, 'ftp-') === 0) ? 'class="active"' : ''; ?>>
                    <a href="<?= route('/ftp'); ?>"><?= __('FTP'); ?></a>
                </li>
                <?php } if (in_array('rsync', $MODULES, true)) { ?>
                <li <?= (strpos($ROUTE, 'rsync-') === 0) ? 'class="active"' : ''; ?>>
                    <a href="<?= route('/rsync'); ?>"><?= __('RSYNC'); ?></a>
                </li>
                <?php } if (in_array('admin', $MODULES, true)) { ?>
                <li <?= (strpos($ROUTE, 'admin-') === 0) ? 'class="active"' : ''; ?>>
                    <a href="<?= route('/admin'); ?>"><?= __('Admin'); ?></a>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

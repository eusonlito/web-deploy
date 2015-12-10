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
                <li <?= (strpos($ROUTE, 'git-') === 0) ? 'class="active"' : ''; ?>><a href="<?= route('/git'); ?>"><?= __('GIT'); ?></a></li>
                <li <?= (strpos($ROUTE, 'composer-') === 0) ? 'class="active"' : ''; ?>><a href="<?= route('/composer'); ?>"><?= __('Composer'); ?></a></li>
                <li <?= (strpos($ROUTE, 'admin-') === 0) ? 'class="active"' : ''; ?>><a href="<?= route('/admin'); ?>"><?= __('Admin'); ?></a></li>
            </ul>
        </nav>
    </div>
</header>

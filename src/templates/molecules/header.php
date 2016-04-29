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
                <?php
                foreach ($MODULES as $module) {
                    echo '<li '.((strpos($ROUTE, $module.'-') === 0) ? 'class="active"' : '').'>'
                        .'<a href="'.route('/'.$module).'">'.$module.'</a>'
                        .'</li>';
                }
                ?>
            </ul>
        </nav>
    </div>
</header>

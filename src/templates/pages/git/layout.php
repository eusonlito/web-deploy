<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('Git'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <ul class="nav nav-tabs" role="tablist">
            <li <?= ($ROUTE === 'git-index') ? 'class="active"' : ''; ?>><a href="<?= route('/git'); ?>"><?= __('Status'); ?></a></li>
            <li <?= ($ROUTE === 'git-update') ? 'class="active"' : ''; ?>><a href="<?= route('/git/update'); ?>"><?= __('Update'); ?></a></li>
            <li <?= ($ROUTE === 'git-log') ? 'class="active"' : ''; ?>><a href="<?= route('/git/log'); ?>"><?= __('Log'); ?></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active">
                <?php template()->show('content'); ?>
            </div>
        </div>
    </div>
</div>
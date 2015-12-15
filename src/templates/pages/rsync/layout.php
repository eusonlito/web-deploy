<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('Rsync'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <ul class="nav nav-tabs" role="tablist">
            <li <?= ($ROUTE === 'rsync-index') ? 'class="active"' : ''; ?>><a href="<?= route('/rsync'); ?>"><?= __('Status'); ?></a></li>
            <li <?= ($ROUTE === 'rsync-update') ? 'class="active"' : ''; ?>><a href="<?= route('/rsync/update'); ?>"><?= __('Update'); ?></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php template()->show('content'); ?>
            </div>
        </div>
    </div>
</div>
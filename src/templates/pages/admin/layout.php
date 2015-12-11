<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('Admin'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <ul class="nav nav-tabs" role="tablist">
            <li <?= ($ROUTE === 'admin-index') ? 'class="active"' : ''; ?>><a href="<?= route('/admin'); ?>"><?= __('Status'); ?></a></li>
            <li <?= ($ROUTE === 'admin-update') ? 'class="active"' : ''; ?>><a href="<?= route('/admin/update'); ?>"><?= __('Update'); ?></a></li>
            <li <?= ($ROUTE === 'admin-log') ? 'class="active"' : ''; ?>><a href="<?= route('/admin/log'); ?>"><?= __('Log'); ?></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php template()->show('content'); ?>
            </div>
        </div>
    </div>
</div>
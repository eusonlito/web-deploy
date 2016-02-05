<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('MySQL'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <ul class="nav nav-tabs" role="tablist">
            <li <?= ($ROUTE === 'mysql-index') ? 'class="active"' : ''; ?>><a href="<?= route('/mysql'); ?>"><?= __('Status'); ?></a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active">
                <?php template()->show('content'); ?>
            </div>
        </div>
    </div>
</div>
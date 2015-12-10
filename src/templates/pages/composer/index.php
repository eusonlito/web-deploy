<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('Composer'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <form method="post">
            <h1 class="page-header">
                <?= __('Update Composer packages'); ?>

                <button type="submit" name="processor" value="composer-install" class="btn btn-default pull-right">
                    <?= __('Composer UPDATE'); ?>
                </button>
            </h1>

            <?= isset($processor['composer-install']) ? shellResponse($processor['composer-install']) : ''; ?>
        </form>
    </div>
</div>

<div class="bs-docs-header" id="content" tabindex="-1">
    <div class="container">
        <h1><?= __('Home'); ?></h1>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="bs-docs-section">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Who I am'); ?></h3>
            </div>

            <div class="panel-body">
                <?= shellResponse($whoami); ?>
            </div>
        </div>
    </div>
</div>
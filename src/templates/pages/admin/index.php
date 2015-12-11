<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Base Path'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($path); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Current Branch'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($branch); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Last commit'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($commit); ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Project status'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($status); ?>
    </div>
</div>

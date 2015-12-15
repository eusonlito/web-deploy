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
        <h3 class="panel-title"><?= __('Who I am'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($whoami); ?>
    </div>
</div>

<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Connection'); ?>

                <button type="submit" name="processor" value="rsync-test" class="btn btn-success pull-right xxs-block">
                    <?= __('Test'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <ul>
                <li><strong><?= __('Host') ?>:</strong> <?= $config['host']; ?></li>
                <li><strong><?= __('User') ?>:</strong> <?= $config['user']; ?></li>
                <li><strong><?= __('Port') ?>:</strong> <?= $config['port']; ?></li>
                <li><strong><?= __('Remote Path') ?>:</strong> <?= $config['remote_path']; ?></li>
            </ul>

            <?= isset($processor['rsync-test']) ? shellResponse($processor['rsync-test']) : ''; ?>
        </div>
    </div>
</form>

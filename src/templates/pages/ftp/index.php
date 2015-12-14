<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Base Path'); ?></h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($path); ?>
    </div>
</div>

<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Connection'); ?>

                <button type="submit" name="processor" value="ftp-test" class="btn btn-success pull-right xxs-block">
                    <?= __('Test'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <ul>
                <li><strong><?= __('Host') ?>:</strong> <?= $config['host']; ?></li>
                <li><strong><?= __('User') ?>:</strong> <?= $config['user']; ?></li>
                <li><strong><?= __('Port') ?>:</strong> <?= $config['port']; ?></li>
                <li><strong><?= __('Timeout') ?>:</strong> <?= $config['timeout']; ?></li>
            </ul>

            <?= isset($processor['ftp-test']) ? shellResponse($processor['ftp-test']) : ''; ?>
        </div>
    </div>
</form>
<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Connection'); ?>

                <button type="submit" name="processor" value="mysql-test" class="btn btn-success pull-right xxs-block">
                    <?= __('Test'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <ul>
                <li><strong><?= __('Host') ?>:</strong> <?= $config['host']; ?></li>
                <li><strong><?= __('User') ?>:</strong> <?= $config['user']; ?></li>
                <li><strong><?= __('Port') ?>:</strong> <?= $config['port']; ?></li>
            </ul>

            <?= isset($processor['mysql-test']) ? shellResponse($processor['mysql-test']) : ''; ?>
        </div>
    </div>
</form>
<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Connection %s', __('local')); ?>

                <button type="submit" name="processor" value="mysql-test-local" class="btn btn-success pull-right xxs-block">
                    <?= __('Test'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <ul>
                <li><strong><?= __('Host') ?>:</strong> <?= $local['host']; ?></li>
                <li><strong><?= __('Database') ?>:</strong> <?= $local['database']; ?></li>
                <li><strong><?= __('User') ?>:</strong> <?= $local['user']; ?></li>
                <li><strong><?= __('Port') ?>:</strong> <?= $local['port']; ?></li>
            </ul>

            <?= isset($processor['mysql-test-local']) ? shellResponse($processor['mysql-test-local']) : ''; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Connection %s', __('remote')); ?>

                <button type="submit" name="processor" value="mysql-test-remote" class="btn btn-success pull-right xxs-block">
                    <?= __('Test'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <ul>
                <li><strong><?= __('Host') ?>:</strong> <?= $remote['host']; ?></li>
                <li><strong><?= __('Database') ?>:</strong> <?= $remote['database']; ?></li>
                <li><strong><?= __('User') ?>:</strong> <?= $remote['user']; ?></li>
                <li><strong><?= __('Port') ?>:</strong> <?= $remote['port']; ?></li>
            </ul>

            <?= isset($processor['mysql-test-remote']) ? shellResponse($processor['mysql-test-remote']) : ''; ?>
        </div>
    </div>
</form>
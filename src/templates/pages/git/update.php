<form method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Update code to last version'); ?>

                <button type="submit" name="processor" value="git-pull" class="btn btn-success pull-right xxs-block">
                    <?= __('Git PULL'); ?>
                </button>
            </h3>
        </div>

        <?php if (isset($processor['git-pull'])) { ?>
        <div class="panel-body">
            <?= shellResponse($processor['git-pull']); ?>
        </div>
        <?php } ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Update Composer packages'); ?>

                <button type="submit" name="processor" value="composer-install" class="btn btn-success pull-right xxs-block">
                    <?= __('Composer UPDATE'); ?>
                </button>
            </h3>
        </div>

        <?php if (isset($processor['composer-install'])) { ?>
        <div class="panel-body">
            <?= shellResponse($processor['composer-install']); ?>
        </div>
        <?php } ?>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Reset code changes'); ?>

                <button type="submit" name="processor" value="git-reset" class="btn btn-danger pull-right xxs-block">
                    <?= __('Git RESET'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <p><?= __('If you have some custom code change, this action will reset all changes to last commit version.'); ?></p>
            <p><?= __('Check <strong>Project status</strong> section into <strong>Status</strong> tab to check which files will be restored.'); ?></p>
            <p><?= __(' Only files that are currently into git repository will be restored.'); ?></p>

            <?= isset($processor['git-reset']) ? shellResponse($processor['git-reset']) : ''; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= __('Revert code changes to previous commit'); ?>
            </h3>
        </div>

        <div class="panel-body">
            <div class="input-group form-group">
                <select name="commit-hash" class="form-control">
                    <?php foreach ($log as $line) { ?>
                    <option value="<?= $line['hash']; ?>"><?= $line['hash'].' - '.$line['message']; ?></option>
                    <?php } ?>
                </select>

                <span class="input-group-btn">
                    <button type="submit" name="processor" value="git-revert" class="btn btn-warning">
                        <?= __('Git REVERT'); ?>
                    </button>
                </span>
            </div>

            <?= isset($processor['git-revert']) ? shellResponse($processor['git-revert']) : ''; ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?= __('Branch change'); ?>
            </h3>
        </div>

        <div class="panel-body">
            <div class="input-group form-group">
                <select name="branch-name" class="form-control">
                    <?php foreach ($branches as $line) { ?>
                    <option value="<?= $line['name']; ?>" <?= $line['current'] ? 'selected' : ''; ?>><?= $line['name']; ?></option>
                    <?php } ?>
                </select>

                <span class="input-group-btn">
                    <button type="submit" name="processor" value="git-branch" class="btn btn-warning">
                        <?= __('Git BRANCH'); ?>
                    </button>
                </span>
            </div>

            <?= isset($processor['git-branch']) ? shellResponse($processor['git-branch']) : ''; ?>
        </div>
    </div>
</form>
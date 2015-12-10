<form method="post">
    <h1 class="page-header">
        <?= __('Update code to last version'); ?>

        <button type="submit" name="processor" value="git-pull" class="btn btn-default pull-right">
            <?= __('Git PULL'); ?>
        </button>
    </h1>

    <?= isset($processor['git-pull']) ? shellResponse($processor['git-pull']) : ''; ?>

    <h1 class="page-header">
        <?= __('Reset code changes'); ?>

        <button type="submit" name="processor" value="git-reset" class="btn btn-danger pull-right">
            <?= __('Git RESET'); ?>
        </button>
    </h1>

    <p><?= __('If you have some custom code change, this action will reset all changes to last commit version.'); ?></p>
    <p><?= __('Check <strong>Project status</strong> section into <strong>Status</strong> tab to check which files will be restored.'); ?></p>
    <p><?= __(' Only files that are currently into git repository will be restored.'); ?></p>

    <?= isset($processor['git-reset']) ? shellResponse($processor['git-reset']) : ''; ?>

    <h1 class="page-header">
        <?= __('Revert code changes to previous commit'); ?>
    </h1>

    <div class="input-group form-group">
        <select name="commit-hash" class="form-control">
            <?php foreach ($log as $line) { ?>
            <option value="<?= $line['hash']; ?>"><?= $line['hash'].' - '.$line['message']; ?></option>
            <?php } ?>
        </select>

        <span class="input-group-btn">
            <button type="submit" name="processor" value="git-revert" class="btn btn-default pull-right">
                <?= __('Git REVERT'); ?>
            </button>
        </span>
    </div>

    <?= isset($processor['git-revert']) ? shellResponse($processor['git-revert']) : ''; ?>

    <h1 class="page-header">
        <?= __('Branch change'); ?>
    </h1>

    <div class="input-group form-group">
        <select name="branch-name" class="form-control">
            <?php foreach ($branches as $line) { ?>
            <option value="<?= $line['name']; ?>" <?= $line['current'] ? 'selected' : ''; ?>><?= $line['name']; ?></option>
            <?php } ?>
        </select>

        <span class="input-group-btn">
            <button type="submit" name="processor" value="git-branch" class="btn btn-default pull-right">
                <?= __('Git BRANCH'); ?>
            </button>
        </span>
    </div>

    <?= isset($processor['git-branch']) ? shellResponse($processor['git-branch']) : ''; ?>
</form>
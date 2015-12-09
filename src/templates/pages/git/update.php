<form method="post">
    <h1 class="page-header">
        <?= __('Update GIT info'); ?>

        <button type="submit" name="processor" value="git-fetch" class="btn btn-default pull-right">
            <?= __('Git FETCH'); ?>
        </button>
    </h1>

    <?= isset($processor['git-fetch']) ? shellResponse($processor['git-fetch']) : ''; ?>

    <h1 class="page-header">
        <?= __('Update code to last version'); ?>

        <button type="submit" name="processor" value="git-pull" class="btn btn-default pull-right">
            <?= __('Git PULL'); ?>
        </button>
    </h1>

    <?= isset($processor['git-pull']) ? shellResponse($processor['git-pull']) : ''; ?>

    <h1 class="page-header">
        <?= __('Stash source code changes'); ?>

        <button type="submit" name="processor" value="git-stash" class="btn btn-default pull-right">
            <?= __('Git STASH'); ?>
        </button>
    </h1>

    <?= isset($processor['git-stash']) ? shellResponse($processor['git-stash']) : ''; ?>

    <h1 class="page-header">
        <?= __('Update code previous commit'); ?>
    </h1>

    <div class="input-group">
        <select name="commit-hash" class="form-control">
            <?php foreach ($log as $line) { ?>
            <option value="<?= $line['hash']; ?>"><?= $line['hash'].' - '.$line['message']; ?></option>
            <?php } ?>
        </select>

        <span class="input-group-btn">
            <button type="submit" name="processor" value="git-checkout" class="btn btn-default pull-right">
                <?= __('Git CHECKOUT'); ?>
            </button>
        </span>
    </div>

    <?= isset($processor['git-checkout']) ? shellResponse($processor['git-checkout']) : ''; ?>
</form>
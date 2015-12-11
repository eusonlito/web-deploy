<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Log for last %s commits', $last); ?></h3>
    </div>

    <div class="panel-body">
        <form class="form-group">
            <input type="number" name="last" value="<?= $last; ?>" placeholder="<?= __('Get log for last N commits'); ?>" class="form-control input-block" />
        </form>

        <?= shellResponse($log); ?>
    </div>
</div>

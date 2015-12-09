<h1 class="page-header">
    <?= __('Log for last %s commits', $last); ?>
</h1>

<form class="form-group">
    <input type="number" name="last" value="<?= $last; ?>" placeholder="<?= __('Get log for last N commits'); ?>" class="form-control input-block" />
</form>

<?= shellResponse($log); ?>

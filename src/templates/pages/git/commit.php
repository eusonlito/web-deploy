<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title with-button">
            <?= __('Log commit for %s', $hash); ?>

            <a href="<?= getenv('HTTP_REFERER') ?: route('/git'); ?>" class="btn btn-default pull-right xxs-block">
                <?= __('Back'); ?>
            </a>
        </h3>
    </div>

    <div class="panel-body">
        <?= shellResponse($log); ?>
    </div>
</div>

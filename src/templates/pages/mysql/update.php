<form method="post" data-loading>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title with-button">
                <?= __('Compare Database Schemas'); ?>

                <span class="badge"><?= $local['host'].'/'.$local['database']; ?></span>
                &lt;&gt;
                <span class="badge"><?= $remote['host'].'/'.$remote['database']; ?></span>

                <button type="submit" name="compare" value="true" class="btn btn-success pull-right xxs-block">
                    <?= __('Compare'); ?>
                </button>
            </h3>
        </div>

        <div class="panel-body">
            <?= isset($processor['mysql-update']) ? shellResponse($processor['mysql-update']) : ''; ?>

            <?php
            if ($diff !== null) {
                if (empty($diff)) {
                    echo shellResponse([
                        'success' => __('No database differences')
                    ]);
                } elseif (is_array($diff)) {
                    echo shellResponse($diff);
                } else {
                ?>

                <div class="form-group">
                    <textarea name="sql" rows="<?= substr_count($diff, "\n"); ?>" class="form-control"><?= htmlentities($diff); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" name="processor" value="mysql-update" class="btn-success form-control">
                        <?= __('Apply changes to remote database'); ?>
                    </button>
                </div>

                <?php
                }
            }
            ?>
        </div>
    </div>
</form>
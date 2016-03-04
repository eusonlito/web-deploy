<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Looking for files newer than N days'); ?></h3>
    </div>

    <div class="panel-body">
        <form method="post" class="form-group" data-loading>
            <div class="input-group form-group">
                <input type="number" name="days" value="<?= $days; ?>" placeholder="<?= __('Looking for files newer than N days'); ?>" class="form-control" />

                <span class="input-group-btn">
                    <button type="submit" name="find" value="true" class="btn btn-default">
                        <?= __('Find'); ?>
                    </button>
                </span>
            </div>

            <?php if (isset($processor['ftp-upload'])) { ?>

            <?php if (isset($processor['ftp-upload']['error'])) { ?>

            <pre class="bg-danger"><?= $processor['ftp-upload']['error']; ?></pre>

            <?php } else { ?>

            <?php foreach ($processor['ftp-upload']['success'] as $row) { ?>

            <pre class="bg-<?= $row['status'] ? 'success' : 'danger'; ?>"><strong><?= $row['cmd']; ?>:</strong> <?= $row['arguments']; ?></pre>

            <?php } ?>

            <?php } ?>

            <?php } ?>

            <?php if (input('find') === 'true') { ?>

            <?php if (empty($files)) { ?>

            <div class="alert alert-success"><?= __('There are not modified files in last %s days', $days); ?></div>

            <?php } else { ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox" data-checkall=".table" checked /></th>
                        <th><?= __('Name'); ?></th>
                        <th><?= __('Date'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($files as $file) { ?>
                    <tr>
                        <td><input type="checkbox" id="file-<?= $file['code']; ?>" name="files[]" value="<?= $file['code']; ?>" checked /></td>
                        <td><label for="file-<?= $file['code']; ?>"><?= $file['name']; ?></label></td>
                        <td><?= date('Y-m-d H:i:s', $file['date']); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th><input type="checkbox" data-checkall=".table" checked /></th>
                        <th><?= __('Name'); ?></th>
                        <th><?= __('Date'); ?></th>
                    </tr>
                </tfoot>
            </table>

            <button type="submit" name="processor" value="ftp-upload" class="btn-success form-control">
                <?= __('Upload to %s', $config['host']); ?>
            </button>

            <?php } ?>

            <?php } ?>
        </form>
    </div>
</div>

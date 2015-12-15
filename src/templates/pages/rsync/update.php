<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Looking for changed files'); ?></h3>
    </div>

    <div class="panel-body">
        <form method="post">
            <div class="form-group">
                <button type="submit" name="find" value="true" class="btn btn-default form-control">
                    <?= __('Find changes in %s folder', $config['remote_path']); ?>
                </button>
            </div>

            <?php if (isset($processor['rsync-upload'])) { ?>

            <?= shellResponse($processor['rsync-upload']); ?>

            <?php } ?>

            <?php if (input('find') === 'true') { ?>

            <?php if (empty($files)) { ?>

            <div class="alert alert-success"><?= __('There are not modified files'); ?></div>

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

            <button type="submit" name="processor" value="rsync-upload" class="btn-success form-control">
                <?= __('Upload to %s', $config['host']); ?>
            </button>

            <?php } ?>

            <?php } ?>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('SQL Update Log'); ?></h3>
    </div>

    <div class="panel-body">
        <form>
            <div class="input-group form-group">
                <select name="file" class="form-control" required>
                    <option value=""><?= __('Select a file to view SQL code'); ?></option>

                    <?php foreach ($files as $row) { ?>
                    <option value="<?= $row; ?>" <?= ($row === $file) ? 'selected' : ''; ?>><?= $row; ?></option>
                    <?php } ?>
                </select>

                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success">
                        <?= __('Load'); ?>
                    </button>
                </span>
            </div>
        </form>

        <?= $response ? shellResponse($response) : ''; ?>
    </div>
</div>

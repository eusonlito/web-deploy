<h1 class="page-header">
    <?= __('Base Path'); ?>
</h1>

<pre class="bg-success"><?= $path; ?></pre>

<h1 class="page-header">
    <?= __('Current Branch'); ?>
</h1>

<?= shellResponse($branch); ?>

<h1 class="page-header">
    <?= __('Last commit'); ?>
</h1>

<?= shellResponse($commit); ?>

<h1 class="page-header">
    <?= __('Project status'); ?>
</h1>

<?= shellResponse($status); ?>

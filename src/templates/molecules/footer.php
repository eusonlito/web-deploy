<div id="loading">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>

<footer class="bs-docs-footer" role="contentinfo">
    <div class="container">
        <ul class="bs-docs-footer-links pull-right">
            <li><?= __('%s seconds', round(microtime(true) - WD_TIME, 4)); ?></li>
            <li><?= __('%s MiB', round(memory_get_peak_usage(true) / 1024 / 1024, 4)); ?></li>
            <li><?= __('%s files', count(get_included_files())); ?></li>
        </ul>

        <ul class="bs-docs-footer-links">
            <li><a href="https://github.com/eusonlito/web-deploy">GitHub</a></li>
            <li><?= __('Code licensed <a rel="license" href="https://github.com/eusonlito/web-deploy/blob/master/LICENSE" target="_blank">MIT</a>'); ?></li>
        </ul>
    </div>
</footer>

<?= packer()->js(array(
    'https://code.jquery.com/jquery-2.2.0.min.js',
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
    '/js/custom.js'
)); ?>

<footer class="bs-docs-footer" role="contentinfo">
    <div class="container">
        <ul class="bs-docs-footer-links pull-right">
            <li><?= __('%s seconds', round(microtime(true) - WD_TIME, 4)); ?></li>
            <li><?= __('%s MiB', round(memory_get_peak_usage(true) / 1024 / 1024, 4)); ?></li>
        </ul>

        <ul class="bs-docs-footer-links">
            <li><a href="https://github.com/eusonlito/web-deploy">GitHub</a></li>
        </ul>

        <p>Code licensed <a rel="license" href="https://github.com/twbs/bootstrap/blob/master/LICENSE" target="_blank">MIT</a>, docs <a rel="license" href="https://creativecommons.org/licenses/by/3.0/" target="_blank">CC BY 3.0</a>.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

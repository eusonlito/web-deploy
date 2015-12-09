<!DOCTYPE HTML>
<html lang="es">
    <head>
        <?php template()->show('molecules.head'); ?>
    </head>

    <body class="body-<?= str_replace('.', '-', $ROUTE); ?>">
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <?php template()->show('molecules.header'); ?>
        <?php template()->show('body'); ?>

        <?php template()->show('molecules.footer'); ?>
    </body>
</html>

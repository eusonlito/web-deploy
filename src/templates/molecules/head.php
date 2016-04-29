<meta charset="utf-8">

<title><?= meta()->meta('title'); ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?= packer()->css([
    'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
    'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',
    '/src/templates/assets/css/bootstrap-docs.min.css',
    '/src/templates/assets/css/custom.css'
], '/storage/assets/css/styles.css'); ?>

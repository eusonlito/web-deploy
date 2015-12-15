<html>
    <head>
        <style>
            html {
                text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                font-size: 1.2em;
            }

            body {
                background-color:#f7f7f7;
                color: #646464;
                font-family: Tahoma, sans-serif;
                font-size: 1em;
            }

            div {
                display:block;
            }

            h1 {
                margin-top: 0;
                color: #333;
                font-size: 1.6em;
                font-weight: normal;
                line-height: 1.25em;
                margin-bottom: 16px;
            }

            a {
                text-decoration: none;
            }

            .text-button {
                user-select: none;
                -webkit-user-select: none;
                background: rgb(76, 142, 250);
                border: 0;
                border-radius: 2px;
                box-sizing: border-box;
                color: #fff;
                cursor: pointer;
                font-size: .875em;
                margin: 0;
                padding: 10px 24px;
                transition: box-shadow 200ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            .text-button:hover {
                box-shadow: 0 1px 2px rgb(0, 1, 1);
            }

            .error-code {
                color: #777;
                font-size: .86667em;
                margin: 0;
                opacity: .5;
            }

            .interstitial-wrapper {
                box-sizing: border-box;
                font-size: 1em;
                margin: 100px auto 0;
                max-width: 600px;
            }

            .offline .interstitial-wrapper {
                color: #2b2b2b;
                font-size: 1em;
                line-height: 1.55;
                margin: 0 auto;
                max-width: 600px;
                padding-top: 100px;
            }

            .nav-wrapper {
                margin: 40px 0;
            }

            .pull-right {
                float: right;
            }

            @media (max-width: 640px), (max-height: 640px) {
                h1 {
                    margin: 0 0 15px;
                }
            }
        </style>
    </head>

    <body class="offline">
        <div class="interstitial-wrapper">
            <div id="main-content">
                <div id="main-message">
                    <p class="error-code"><?= $code; ?></p>
                    <h1><?= $message; ?></h1>
                    <p><?= __('%s line %s', $file, $line); ?></p>
                </div>
            </div>

            <div class="nav-wrapper">
                <a href="javascript: window.reload();" class="text-button blue-button"><?= __('Reload'); ?></a>
                <a href="javascript: history.back();" class="text-button blue-button"><?= __('Back'); ?></a>
            </div>

            <div class="details">
                <?php foreach ($trace as $line) { ?>
                <p class="error-code"><?= __('%s line %s', $line['file'], $line['line']); ?></p>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
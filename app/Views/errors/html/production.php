<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>

<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>

        <h2>Error Details:</h2>
        <pre>
            <?php
            // Check if there's an exception passed and display its details
            if (isset($exception)) {
                echo "Message: " . $exception->getMessage() . "\n";
                echo "Stack trace:\n";
                echo $exception->getTraceAsString();
            } else {
                echo "No error details available.";
            }
            ?>
        </pre>

    </div>

</body>

</html>
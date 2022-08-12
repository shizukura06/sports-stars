<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= $title ?? 'Player Profiles' ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
        <link href="static/styles.css" rel="stylesheet" />
        <link href="static/ui.css" rel="stylesheet" />

        <script>
            var is_allblacks = <?= $is_allblacks ?>;
            window.jQuery || document.write('<link href="include/jq/jquery-ui.css" rel="stylesheet"> ' +
                '<script src="include/jq/jq_simp.js"><\/script>' +
                '<script src="include/jq/jquery-ui.js"><\/script> ');
        </script>
        <script src="static/scripts.js"></script>
    </head>
    <body>

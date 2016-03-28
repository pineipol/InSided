<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>InSided - ImageThread</title>
        <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    </head>
    <body>
        <header id="header_outer_container">
            <div id="header_inner_container">
                <?php require_once ROOT_DIR . $config['application']['viewsDir'] . '/partials/header.php' ?>
            </div>
        </header>
        <div id="middle_outer_container">
            <div id="inner_container">
                <?php require_once ROOT_DIR . $config['application']['viewsDir'] . '/posts/reply-box.php' ?>
                <?= $content ?>                
            </div>    
        </div>
    </body>
</html>
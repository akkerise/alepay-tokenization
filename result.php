<?php
require('Lib/Alepay.php');
require 'config.php';
require 'Lib/ConnectDB/Database.php';


$encryptKey = $config['encryptKey'];
if (isset($_REQUEST['data']) && isset($_REQUEST['checksum'])) {
    $utils = new AlepayUtils();
    $result = $utils->decryptCallbackData($_REQUEST['data'], $encryptKey);
    $objdata = json_decode($result);
    $alepay = new Alepay($config);
    $obj_data = $alepay->getTransactionInfo($objdata->data);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <title>Show Data</title>
    <style>
        #titleData {
            color: darkblue;
        }
    </style>
</head>
<body>
<div id="container">
    <div class="row">
        <div class="col s3"></div>
        <div class="col s6 center">
            <h3>Kết quả</h3>
            <ul class="collection col-md-8">
                <li class="collection-item">
                    <?php if (isset($obj_data)) {
                        foreach ($obj_data as $k => $v) { ?>
                            <div>
                                <h6 id="titleData"><?php echo $k ?></h6>
                                <p><?php echo $v ?></p>
                            </div>
                        <?php }} ?>
                </li>
                <li>
                    <div>
                        <a href="<?php echo URL_DEMO ?>">BACK TO HOME PAGE</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

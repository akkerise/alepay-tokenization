<?php
/**
 * Created by PhpStorm.
 * User: akke
 * Date: 6/11/17
 * Time: 10:54 PM
 */
require('config.php');
require('Lib/ConnectDB/Database.php');

$db = new Database();

//$res = $db->insert('todo', [
//    'title' => md5(rand(1, 1000)),
//    'status' => 1,
//    'created_at' => 'NOW()'
//]);

//$sql = "UPDATE todo SET title=:title, status=:status WHERE id=:_id";
//$sql = "DELETE FROM todo WHERE id = 3";
//$res = $db->delete('todo',
//    [
//        'id' => '',
//        'status' => 1,
//        'title' => 'clgt',
//        'created_at' => NULL,
//    ]
//);


//if ($res === true) {
//    echo "Delete success";
//} else {
//    echo $res;
//}
?>
<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Nhập Thông Tin</title>
    <style type="text/css">
        .require {
            color: red;
        }

        .form-group.col-sm-5 {
            margin: 5px;
        }
    </style>
</head>
<body>
<?php
require_once 'config.php';
?>
<div id="container" class="container">
    <div class="col-sm-5">
        <div class="col-sm-12">
            <h2 id="titleItem">Điện thoại iphone 6 16GB</h2><br>
            <img src="http://multimedia.bbycastatic.ca/multimedia/products/500x500/105/10528/10528315.jpg" width="250"
                 alt="Iporn 6"><br>
            <p><b>16.000.000₫ (Còn hàng) / 1 Chiếc</b></p><br>
            <table class="table">
                <tbody>
                <tr>
                    <td>Màn hình</td>
                    <td>LED-backlit IPS LCD, 7.9 inch</td>
                </tr>
                <tr>
                    <td>Hệ điều hành</td>
                    <td>iOS 8</td>
                </tr>
                <tr>
                    <td>Vi xử lí CPU</td>
                    <td>Dual - Core, 1 GHz</td>
                </tr>
                <tr>
                    <td>RAM</td>
                    <td>512 MB</td>
                </tr>
                <tr>
                    <td>Bộ nhớ trong</td>
                    <td>64 GB, 32 GB, 16 GB</td>
                </tr>
                <tr>
                    <td>Camera</td>
                    <td>5 MP(2592 x 1944 pixels)</td>
                </tr>
                <tr>
                    <td>Kết nối</td>
                    <td>Không 3G, Wifi chuẩn 802.11 a/b/g/n</td>
                </tr>
                <tr>
                    <td>Đàm thoại</td>
                    <td>Face Time</td>
                </tr>
                <tr>
                    <td>Dung lượng pin</td>
                    <td>4490mAh(16.3Wh)</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-7">
        <h2>Thanh Toán Bằng Tokenization</h2>
        <form class="form-" role="form" method="POST" id="formSubmit"
              action="<?= URL_DEMO ?>process.php?action=sendTokenizationPayment">
            <div class="row"></div>
            <div class="col-sm-12" id="alert"></div>
            <div class="form-group col-sm-5">
                <p>&nbsp;</p>
                <button id="sendInstallment" type="button" class="btn btn-info btn-lg">
                    CHECK OUT WITH TOKENIZATION
                </button>
            </div>
        </form>
    </div>

</div>
<!--    Start sendOrderToAlepayInstallment    -->

<div id="sendOrderToAlepayInstallment" class="modal fade" role="dialog">
    <iframe id="frame" scrolling="no" style="overflow: hidden;height: 100%;width: 100%;border: none;"></iframe>
</div><!-- /.row -->


<!--    End sendOrderToAlepayInstallment    -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var iporn = 16000000;
    $('#amount').val(iporn.toLocaleString('vi'));
    $('#totalItem').on('keyup', function () {
        if (typeof $('#amount').val() != 'undefined') {
            $('#amount').val((parseInt(iporn) * parseInt($('#totalItem').val())).toLocaleString('vi'));
        }
    });
    $('#sendInstallment').on('click', function () {
        $('#alert').html('Đang tải...');
        $.ajax({
            type: "POST",
            url: $("#formSubmit").prop('action'),
            data: $("#formSubmit").serialize(), // serializes the form's elements.
            success: function (data) {
                console.log(data.error);
                if (data.error != 'OK') {
                    $('#alert').html('<div class="alert alert-danger">' + data.message + '</div>');
                    return false;
                } else {
                    $('#frame').prop('src', data.data);
                    $('#sendOrderToAlepayInstallment').modal('show');
                    $('#alert').html('');
                }

            }
        });
    });
    $('#frame').on('load', function () {
        this.style.height = this.contentDocument.body.scrollHeight + 'px';
    });
</script>
</body>
</html>


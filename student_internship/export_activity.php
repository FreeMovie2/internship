<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }
    $sql_activity = $conn->prepare("SELECT * FROM activity WHERE s_id = ? ");
    $sql_activity->bind_param("i", $_SESSION['s_id']);
    $sql_activity->execute();
    $result_activity = $sql_activity->get_result();
    $count = 0;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Sarabun:300,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/font-th-sarabun-new@1.0.0/css/th-sarabun-new.min.css" rel="stylesheet">
    <title>:: ระบบรับสมัครนักเรียนออนไลน์ โรงเรียนยุพราชวิทยาลัย จังหวัดเชียงใหม่ ::</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font-size: 15px;
        font-family: 'THSarabunNew', sans-serif;
    }

    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-print-color-adjust: exact;
    }

    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding-top: 1.0cm;
        padding-left: 1.0cm;
        padding-right: 1.0cm;
        padding-bottom: 1.0cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .subpage {
        height: 256mm;
        padding: 14px;
    }

    li.lh2 {
        line-height: 25px;
        padding: 0 0 2px 0;
    }

    p,
    span {
        margin: 0;
        padding: 0;
    }

    ul {
        padding: 0 0 10px 0;
    }

    .head-topic {
        color: #000;
        font-size: 14px;
        line-height: 24px;
        text-align: left;
    }


    td,
    th {
        border: 1px solid #000;
        padding: 4px;
    }

    input.MyButton {
        font-family: 'Sarabun', sans-serif;
        width: 140px;
        padding: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        background: #3366cc;
        color: #fff;
        border: 1px solid #3366cc;
        -moz-box-shadow: 6px 6px 5px #999;
        -webkit-box-shadow: 6px 6px 5px #999;
        box-shadow: 6px 6px 5px #999;
    }

    input.MyButton2 {
        font-family: 'Sarabun', sans-serif;
        width: 140px;
        padding: 4px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        background: #ff9933;
        color: #fff;
        border: 1px solid #ff9933;
        -moz-box-shadow: 6px 6px 5px #999;
        -webkit-box-shadow: 6px 6px 5px #999;
        box-shadow: 6px 6px 5px #999;
    }

    input.MyButton:hover {
        color: #ffff00;
    }

    input.MyButton2:hover {
        color: #ffff00;
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }

        .MyButton,
        .MyButton * {
            display: none !important;
        }

        .MyButton2,
        .MyButton2 * {
            display: none !important;
        }
    }
    </style>
</head>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์" onclick="window.print();" />
    </form>
    <?php while($feth_activity = $result_activity->fetch_assoc()){   ?>
    <div class="page">
        <div class="subpage">
            <?php
                 $count++;
                //  $sql = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
                //  $sql->bind_param("s", $_SESSION["s_id"]);
                //  $sql->execute();
                //  $result = $sql->get_result();
                //  $fetch_company = $result->fetch_assoc();
                 $checker = explode(",", $feth_activity['a_purpose']);
                 $list_arr = [
                     "เสริมสร้างบุคลิกและความรับผิดชอบต่อสังคม",
                     "เสริมสร้างสุขภาพ/กีฬา/นันทนาการ",
                     "พัฒนาคุณธรรมและจริยธรรม",
                     "ส่งเสริมศาสนา/ศิลปะ/วัฒนธรรม",
                     "อนุรักษ์สิ่งแวดล้อม",
                     "พัฒนามาตรฐานวิชาชีพและจรรยาบรรณวิชาชีพ",
                     "ส่งเสริมความคิดสร้างสรรค์",
                     "ส่งเสริมการเรียนรู้แบบบูรณาการ",
                     "พัฒนาความรู้ความสามารถทางวิชาการ",
                     "พัฒนาผู้เรียนให้มีมาตรฐานสู่สากล"
                 ];                      
            ?>
            <p class="text-center fw-bold">แบบรายงานการเข้าร่วมกิจกรรมในสถานประกอบการ</p>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <p><b>กิจกรรมที่</b> <?php echo $count; ?></p>
                        <p><b>1. ลักษณะของกิจกรรม</b></p>
                        <div class="row" style="margin-left: 10px;">

                            <div class="col-6">
                                <?php
                                    for($i=0; $i < count($checker); $i++) {
                                        if ($i % 2 == 0) {
                                ?>
                                <?php if($checker[$i] !== "-"){ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-square" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                        <path
                                            d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }else{ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }?>
                                <?php }?>
                                <?php } ?>

                            </div>
                            <div class="col-6">
                                <?php
                                    for($i=0; $i < count($checker); $i++) {
                                        if ($i % 2 !== 0) {
                                ?>
                                <?php if($checker[$i] !== "-"){ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-square" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                        <path
                                            d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }else{ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }?>
                                <?php }?>
                                <?php } ?>
                            </div>

                        </div>
                        <p><b>2. ชื่อกิจกรรม</b> <?php echo $feth_activity['a_name']; ?></p>
                        <p><b>3. วัน/เวลา/สถานที่</b> <?php echo $feth_activity['a_date']; ?> (<?php echo $feth_activity['a_place']; ?>)</p>
                        <p><b>4. บทบาทและการมีส่วนร่วม</b> <?php echo $feth_activity['a_detail']; ?></p>
                        <p class="text-center">
                            <img src="uploaded/activity_img/<?php echo $feth_activity['a_img']; ?>" class="mt-3 mb-3 img-fluid w-75">
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">ลงชื่อ...................................ผู้เรียนเจ้าของผลงาน</p>
                        <p class="text-center">
                            (<?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?>)</p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">ลงชื่อ...................................ครูฝึก</p>
                        <p class="text-center">(............................................................)</p>
                        <p class="text-center">ผู้รับรอง</p>
                    </div>

                    <div class="col-2">

                    </div>

                    <div class="col-8 mt-5">
                        <p class="text-center">ลงชื่อ...................................ครูประจำวิชา/ครูนิเทศ</p>
                        <p class="text-center">(............................................................)</p>
                    </div>

                    <div class="col-2">

                    </div>
                </div>
            </div>




        </div>
    </div>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>


</body>

</html>
<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Sarabun:300,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-th-sarabun-new@1.0.0/css/th-sarabun-new.min.css" rel="stylesheet">
    <title>:: ระบบรับสมัครนักเรียนออนไลน์ โรงเรียนยุพราชวิทยาลัย จังหวัดเชียงใหม่ ::</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 13px;
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
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px !important;
        }

        td, th {
            border: 1px solid #000;
          
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
        <input class="MyButton2" type="button" value="พิมพ์แบบประเมิน" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <h3 class="text-center" style="font-weight: bold;text-align:center">แบบประเมินการฝึกอาชีพ</h3>
            <p>ชื่อสถานประกอบการ <?php echo $fetch_company["c_name"]; ?></p>
            <p>ชื่อ-สกุล ผู้ฝึกอาชีพ <?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?> 
            รหัสนักศึกษา <?php echo $_SESSION["s_student_id"]; ?> 
            แผนกวิชา <?php echo $_SESSION["s_major"]; ?>
            </p>
            <br/>
            <table style="margin-top: 5px;">
                <tr style="text-align:center">
                    <th>คุณลักษณะ</th>
                    <th>คะแนนเต็ม</th>
                    <th>คะแนนที่ได้</th>
                </tr>
                <tr>
                    <td>&nbsp;1. &nbsp;มีความรู้เกี่ยวกับงานในหน้าที่</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;2.  &nbsp;มีความตั้งใจแสวงหาความรู้และเรียนรู้งาน</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความขยันอดทน</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความคิดริเริ่ม</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;3.  &nbsp;มีทักษะในการใช้ภาษาเพื่อการศึกษา</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;4.  &nbsp;มีทักษะในการทำงาน การใช้วัสดุและเครื่องมืออุปกรณ์ในการวิชาชีพ</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;5.  &nbsp;ปฏิบัติงานได้อย่างมีระบบและคุณภาพ</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;6.  &nbsp;มีความสามารถในการปรับตัวและปัญหา</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;7.  &nbsp;มีความกระตือรือร้น ตรงต่อเวลา และซื่อสัตย์</td>
                    <td style="text-align: center;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;8.  &nbsp;มีความเอาใจใส่และรับผิดชอบงาน</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;9.  &nbsp;มีการแต่งกาย กิริยา วาจาสุภาพเรียบร้อย</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;10.  &nbsp;มีมนุษย์สัมพันธ์และมีความรอบรู้ทันต่อเหตุการณ์</td>
                    <td style="text-align: center;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- รอบรู้ทันต่อเหตุการณ์ในยุคปัจจุบัน</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td  style="text-align: center;"><b>รวมคะแนน</b></td>
                    <td style="text-align: center;">60</td>
                    <td></td>
                </tr>
                
            </table>
            <br/>
            <p>ข้อเสนอแนะ
                ..............................................................................................................................................................................................<br/>
                ....................................................................................................................................................................................................................<br/>
                ....................................................................................................................................................................................................................<br/>
                ....................................................................................................................................................................................................................<br/>
               

            </p>
            <p><b>ผลการประเมิน  &nbsp;&nbsp;▢ ผ่าน &nbsp;&nbsp;▢ ไม่ผ่าน</b></p>
            <br/>
            <p style="text-align: right;">ลงชื่อ..............................................ครูฝึก</p>
            <p style="text-align: right;">(........................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p style="text-align: right;">ตำแหน่ง.......................................................</p>
            <br/>
            <br/>
        
          
            <small><b>หมายเหตุ</b> : ประทับตราสถานประกอบการไว้ใต้ผลการประเมินพร้อมลงลายมือชื่อกำกับ (ถ้ามี)<br/>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           &nbsp;: ผู้ที่จะผ่านการประเมินผลการฝึกอาชีพ จะต้องได้ค่าคะแนนรวมไม่ต่ำกว่าร้อยละ 70 (42 คะแนน)</small>
        </div>
    </div>
    


</body>

</html>
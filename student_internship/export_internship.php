<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }
    $sql = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql->bind_param("s", $_SESSION["s_id"]);
    $sql->execute();
    $result = $sql->get_result();
    $fetch_company = $result->fetch_assoc();

    $subject_rows = [];
    $sql_subjects = $conn->prepare("SELECT subject_code, subject_name FROM student_internship_subjects WHERE s_id = ? ORDER BY id ASC");
    if ($sql_subjects) {
        $sql_subjects->bind_param("s", $_SESSION["s_id"]);
        $sql_subjects->execute();
        $result_subjects = $sql_subjects->get_result();
        while ($subject = $result_subjects->fetch_assoc()) {
            $subject_rows[] = $subject;
        }
    }

    // แบบประเมินสมรรถนะการฝึกงานในสถานประกอบการ (รายวิชา) ตามไฟล์ docs/แบบประเมินสมรรถนะการฝึกงานในสถานประกอบการ.pdf
    $competency_forms = [
        '17-40104-2111' => [
            'name_th' => 'การซ่อมบำรุงมอเตอร์ไฟฟ้าและระบบขับ',
            'name_en' => 'Drive System and Motor Maintenance',
            'description' => 'รายวิชานี้กำหนดสมรรถนะด้านการประยุกต์ความรู้ในการซ่อมบำรุงอุปกรณ์และมอเตอร์ การปฏิบัติงานเกี่ยวกับระบบขับเคลื่อนเครื่องกลไฟฟ้า การคิดอย่างเป็นระบบ และการประยุกต์ใช้ความรู้เพื่อแก้ปัญหาและพัฒนางาน รวมถึงงานด้านความปลอดภัย การตรวจสอบและบำรุงรักษา การรื้อถอน/ติดตั้ง การเคลื่อนย้าย การบำรุงรักษาเชิงพยากรณ์ และงานที่เกี่ยวข้องกับ Stator และ Rotor',
            'items' => [
                'ความรู้ความเข้าใจเกี่ยวกับงานไฟฟ้าและงานซ่อมบำรุง เข้าใจหลักการอุปกรณ์เครื่องจักร หรือระบบที่เกี่ยวข้องกับงานที่ได้รับมอบหมาย',
                'การตรวจสอบและประเมินสภาพอุปกรณ์ สามารถสังเกต ตรวจสอบ วัด หรือประเมินสภาพการทำงานของอุปกรณ์/ระบบที่เกี่ยวข้องได้',
                'การใช้เครื่องมือและอุปกรณ์ในการปฏิบัติงาน เลือกและใช้เครื่องมือ เครื่องมือวัด หรืออุปกรณ์ที่เกี่ยวข้องได้อย่างเหมาะสม',
                'การปฏิบัติงานตามขั้นตอนและความปลอดภัย ปฏิบัติตามขั้นตอน กฎระเบียบ และหลักความปลอดภัยของสถานประกอบการ',
                'ทักษะการบำรุงรักษาและดูแลอุปกรณ์ สามารถปฏิบัติงานตรวจสอบ ดูแล บำรุงรักษา ติดตั้ง หรือสนับสนุนงานที่เกี่ยวข้องตามที่ได้รับมอบหมาย',
                'การวิเคราะห์และแก้ไขปัญหาในการทำงาน สามารถวิเคราะห์ปัญหา หาสาเหตุ และเสนอหรือดำเนินการแก้ไขปัญหาอย่างเหมาะสม',
                'การประยุกต์ใช้ความรู้กับงานจริง สามารถเชื่อมโยงความรู้ด้านไฟฟ้า มอเตอร์ ระบบขับเคลื่อน หรืองานเทคนิคที่เกี่ยวข้องกับงานในสถานประกอบการ',
                'คุณภาพและความรับผิดชอบต่อผลงาน ปฏิบัติงานได้ถูกต้อง รอบคอบ รับผิดชอบ และคำนึงถึงคุณภาพของงาน',
                'การเรียนรู้ การสื่อสาร และการทำงานร่วมกับผู้อื่น รับฟังคำแนะนำ สื่อสารกับผู้ควบคุมงานและเพื่อนร่วมงาน และสามารถเรียนรู้งานใหม่ได้',
                'การพัฒนาตนเองและการแก้ปัญหาอย่างเป็นระบบ แสดงความใฝ่เรียนรู้ คิดอย่างเป็นระบบ และสามารถนำประสบการณ์จากการทำงานมาปรับปรุงหรือพัฒนาการทำงานของตนเอง',
            ],
        ],
        '17-40104-3001' => [
            'name_th' => 'โปรแกรมคอมพิวเตอร์ในการควบคุมระบบเทคโนโลยีไฟฟ้า',
            'name_en' => 'Computer Programming for Electrical System Control',
            'description' => 'รายวิชานี้กำหนดสมรรถนะรายวิชานี้เน้นการประยุกต์ใช้ความรู้ด้านการเขียนโปรแกรมไมโครคอนโทรลเลอร์และโปรแกรมสำหรับงานควบคุม การเลือกใช้โปรแกรม การพัฒนาตนเอง และการแก้ปัญหาที่ซับซ้อน ส่วนคำอธิบายรายวิชาครอบคลุมไมโครคอนโทรลเลอร์ การเขียนโปรแกรม ระบบควบคุม การเชื่อมต่อ Input/Output การพัฒนาระบบหรือผลิตภัณฑ์ไฟฟ้า ตลอดจนการทดสอบและแก้ปัญหา',
            'items' => [
                'ความรู้ความเข้าใจเกี่ยวกับระบบควบคุมและเทคโนโลยีไฟฟ้า เข้าใจหลักการทำงานของอุปกรณ์ระบบควบคุม หรือเทคโนโลยีที่เกี่ยวข้องกับงานที่ได้รับมอบหมาย',
                'การเลือกใช้โปรแกรมและเทคโนโลยีที่เกี่ยวข้อง สามารถเลือกใช้โปรแกรม ซอฟต์แวร์ เครื่องมือ หรือเทคโนโลยีดิจิทัลที่เหมาะสมกับการปฏิบัติงาน',
                'การปฏิบัติงานเกี่ยวกับระบบควบคุม สามารถปฏิบัติหรือสนับสนุนงานด้านการควบคุม ระบบอัตโนมัติ โปรแกรม หรือระบบเทคโนโลยีไฟฟ้าที่เกี่ยวข้องได้',
                'การเชื่อมโยงอุปกรณ์และองค์ประกอบของระบบ เข้าใจและสามารถตรวจสอบการทำงานร่วมกันของอุปกรณ์ Input/Output อุปกรณ์ควบคุม หรือส่วนประกอบที่เกี่ยวข้อง',
                'การทดสอบและตรวจสอบการทำงาน สามารถตรวจสอบ ทดสอบ สังเกตผล และประเมินการทำงานของระบบหรืออุปกรณ์ตามงานที่ได้รับมอบหมาย',
                'การวิเคราะห์และแก้ไขปัญหา สามารถวิเคราะห์ปัญหา หาสาเหตุ และเสนอหรือดำเนินการแก้ไขปัญหาของระบบหรือการปฏิบัติงานอย่างเป็นขั้นตอน',
                'การประยุกต์ใช้ความรู้กับงานจริง สามารถนำความรู้ด้านโปรแกรม ระบบควบคุม หรือเทคโนโลยีไฟฟ้ามาประยุกต์ใช้หรือสนับสนุนงานในสถานประกอบการ',
                'คุณภาพและความรับผิดชอบต่อผลงาน ปฏิบัติงานอย่างถูกต้อง รอบคอบ เป็นระบบ รับผิดชอบ และคำนึงถึงคุณภาพของงาน',
                'การเรียนรู้ การสื่อสาร และการทำงานร่วมกับผู้อื่น สามารถเรียนรู้งานใหม่ รับฟังคำแนะนำ สื่อสาร และทำงานร่วมกับผู้ควบคุมงานและเพื่อนร่วมงานได้',
                'การพัฒนาตนเองและการปรับตัวทางเทคโนโลยี มีความใฝ่เรียนรู้ สามารถเรียนรู้โปรแกรม เครื่องมือ หรือเทคโนโลยีใหม่ และนำความรู้หรือประสบการณ์มาพัฒนาการทำงานของตนเอง',
            ],
        ],
    ];

    $score_levels = [5, 4, 3, 2, 1];

    $evaluation_pages = [];
    foreach ($subject_rows as $subject) {
        $code = trim($subject['subject_code'] ?? '');
        if (isset($competency_forms[$code])) {
            $evaluation_pages[] = array_merge(['code' => $code], $competency_forms[$code]);
        }
    }
    $use_legacy_form = empty($evaluation_pages);

    $student_fullname = ($_SESSION["s_prefix"] ?? '') . ($_SESSION["s_name"] ?? '') . ' ' . ($_SESSION["s_surname"] ?? '');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Sarabun:300,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-th-sarabun-new@1.0.0/css/th-sarabun-new.min.css" rel="stylesheet">
    <title>ระบบบันทึกการฝึกอาชีพ วิทยาลัยเทคนิคฉะเชิงเทรา</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'THSarabunNew', sans-serif;
            font-size: 16px;
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
            padding: 4px;
        }

        table.score-table th,
        table.score-table td.score-cell {
            text-align: center;
            width: 34px;
        }
        hr {
            border: none;
            border-top: 2px dotted #000;
            color: #fff;
            background-color: #fff;
            height: 10px;
           
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
            font-size: 16px;
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
    <?php if ($use_legacy_form): ?>
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center">แบบประเมินผลการฝึกอาชีพ</h5>
            <p><b>ชื่อสถานประกอบการ</b> <?php echo $fetch_company["c_name"]; ?></p>
            <p><b>ชื่อ-สกุล ผู้ฝึกอาชีพ</b> <?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?> 
            <b>รหัสนักศึกษา</b> <?php echo $_SESSION["s_student_id"]; ?> 
            <b>แผนกวิชา</b>  <?php echo $_SESSION["s_major"]; ?> 
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
              
               

            </p>
            <hr>
            <hr>
            <hr>
            <hr>
            <hr>

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
    <?php else: ?>
        <?php foreach ($evaluation_pages as $form): ?>
        <div class="page">
            <div class="subpage">
                <h3 class="text-center" style="font-weight: bold;text-align:center">แบบประเมินสมรรถนะการฝึกงานในสถานประกอบการ</h3>
                <p style="text-align:center">รายวิชา <?php echo $form['code']; ?> <?php echo $form['name_th']; ?></p>
                <p style="text-align:center">(<?php echo $form['name_en']; ?>)</p>
                <br/>
                <p>ชื่อสถานประกอบการ <?php echo $fetch_company["c_name"] ?? ''; ?></p>
                <p>ชื่อ-สกุล ผู้ฝึกอาชีพ <?php echo $student_fullname; ?>
                รหัสนักศึกษา <?php echo $_SESSION["s_student_id"]; ?>
                แผนกวิชา <?php echo $_SESSION["s_major"]; ?>
                </p>
                <br/>
                <p><?php echo $form['description']; ?></p>
                <table class="score-table" style="margin-top: 5px;">
                    <tr style="text-align:center">
                        <th style="width:34px;">ข้อ</th>
                        <th>รายการประเมินสมรรถนะ</th>
                        <?php foreach ($score_levels as $level): ?>
                        <th><?php echo $level; ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($form['items'] as $index => $item): ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $index + 1; ?></td>
                        <td><?php echo $item; ?></td>
                        <?php foreach ($score_levels as $level): ?>
                        <td class="score-cell"></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="text-align:center;"><b>รวมคะแนน</b></td>
                        <td colspan="<?php echo count($score_levels); ?>"></td>
                    </tr>
                </table>
                <br/>
                <p><b>เกณฑ์การให้คะแนน</b></p>
                <p>ระดับ 5 = 10 คะแนน — ดีเยี่ยม ปฏิบัติได้ถูกต้องครบถ้วนด้วยตนเอง มีความคล่องตัว สามารถประยุกต์ใช้ความรู้และแก้ปัญหาได้เหมาะสม</p>
                <p>ระดับ 4 = 8 คะแนน — ดีมาก ปฏิบัติได้ถูกต้องด้วยตนเองเป็นส่วนใหญ่ ต้องการคำแนะนำเพียงเล็กน้อย</p>
                <p>ระดับ 3 = 6 คะแนน — ดี ปฏิบัติงานได้ตามที่ได้รับมอบหมาย แต่ยังต้องได้รับคำแนะนำหรือตรวจสอบเป็นบางครั้ง</p>
                <p>ระดับ 2 = 4 คะแนน — พอใช้ ปฏิบัติงานได้บางส่วน ต้องได้รับคำแนะนำหรือความช่วยเหลือค่อนข้างมาก</p>
                <p>ระดับ 1 = 2 คะแนน — ควรพัฒนา ยังไม่สามารถปฏิบัติงานได้ตามที่คาดหวัง ต้องได้รับการแนะนำและกำกับอย่างใกล้ชิด</p>
                <br/>
                <p>ชื่อ - นามสกุล <?php echo $student_fullname; ?> &nbsp;&nbsp;&nbsp; เลขประจำตัวนักศึกษา <?php echo $_SESSION["s_student_id"]; ?></p>
                <br/>
                <p><b>จุดเด่นของนักศึกษา</b></p>
                <p>...........................................................................................................................................................................................</p>
                <br/>
                <p><b>สิ่งที่ควรพัฒนา</b></p>
                <p>.............................................................................................................................................................................................</p>
                <br/>
                <p><b>ข้อเสนอแนะจากสถานประกอบการ</b></p>
                <p>............................................................................................................................................................................................</p>
                <br/>
                <br/>
                <p style="text-align: right;">ลงชื่อ………………………………………………… ผู้ประเมิน</p>
                <p style="text-align: right;">ตำแหน่ง…………………………………................................</p>
                <p style="text-align: right;">ชื่อสถานประกอบการ……………………………………………………................................</p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>


</body>

</html>
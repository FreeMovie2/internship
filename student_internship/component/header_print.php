<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="assets/img/logo.png">
    <link href="https://fonts.googleapis.com/css?family=Sarabun:300,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/font-th-sarabun-new@1.0.0/css/th-sarabun-new.min.css" rel="stylesheet">
    <title>ระบบบันทึกการฝึกอาชีพ วิทยาลัยเทคนิคฉะเชิงเทรา</title>
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


        td, th {
            border: 1px solid #000;
            padding: 4px;
        }

        input.MyButton {
            font-family: 'Sarabun', sans-serif;
            width: 140px;
            padding: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
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

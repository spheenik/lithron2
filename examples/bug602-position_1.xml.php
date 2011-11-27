<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm
        }
        wrapper {
            display: block;
            margin-top: 2cm;
            margin-right: 3cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
            background-color: cmyk(0,0,0,20);
            width: 10cm;
            height: 10cm;
            position: relative;
        }

        div.d1 {
            position: absolute;
            top:2cm; left:4cm;
            width:2cm; height:2cm;
            background-color: maroon;
        }
        div.d2 {
            position: relative;
            top:3cm; left:1cm;
            width:2cm; height:2cm;
            background-color: aqua;
        }
        div.d3 {
            position: absolute;
            top:-1cm; left:0cm;
            width:2cm; height:2cm;
            background-color: #42c;
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <div class="d1">DIV 1</div>

                <div class="d2">DIV 2</div>

                <div class="d3">DIV 3</div>
            </wrapper>
        </page>
    </file>



</lithron>
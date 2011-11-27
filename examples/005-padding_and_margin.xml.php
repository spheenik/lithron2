<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm
        }
        .test1
        {
            margin: 1cm 2cm 3cm 4cm;
            padding: 1cm 2cm 3cm 4cm;
            background-color: cmyk(20%,0,0,0);
        }
        .test2
        {
            margin: 1cm;
            padding: 5mm;
            background-color: cmyk(0,20%,0,0);
        }
        .test3a
        {
            margin: 1cm;
            padding: 5mm;
            background-color: cmyk(0,0,20%,0);
        }
        .test3b
        {
            margin: 1cm;
            padding: 2cm;
            background-color: cmyk(0,0,0,20%);
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="test1">A dummy text for rendering tests, do not read, please!
                I mean this serious, really ;)</div>
            <div class="test2">A dummy text for rendering tests, do not read, please!
                I mean this serious, really ;)</div>
            <div class="test3a">
                <div class="test3b">A dummy text for rendering tests, do not read, please!
                    I mean this serious, really ;)</div>
            </div>
        </page>
    </file>



</lithron>
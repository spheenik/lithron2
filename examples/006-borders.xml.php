<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm
        }
        .test1
        {
            width: 5cm;
            height: 5cm;

            background-color: cmyk(20%,0,0,0);

            padding: 2cm;
            margin: 1cm;
            
            border-stroke-mode: single;
            border-style: solid;
            border-width: 0.2cm;
            border-stroke-width: 0.2cm;
            border-stroke-color: cmyk(100%,0,0,0);
            border-stroke-pattern: "50 10";
            border-stroke-pattern: "20 20";
        }
        .test2
        {
            margin: 1cm;
            padding: 1cm;

            background-color: cmyk(0,20%,0,0);

            border-stroke-mode: single;
            border-style: solid;
            border-width: 2cm;
            border-stroke-width: 2cm;
            border-stroke-color: cmyk(0,50%,0,0);
            border-stroke-join: "1";
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="test1">2cm padding, 1cm margin, 0.2cm borders</div>
            <div class="test2">A dummy text for rendering tests, do not read, please!
            I mean this serious, really ;)</div>
        </page>
    </file>



</lithron>
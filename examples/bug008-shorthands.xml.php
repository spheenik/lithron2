<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm
        }
        .shorthands
        {
            margin: 1cm;
            padding: 1cm;
            background-color: cmyk(0,0,50%,0);
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="shorthands">
                margin, padding: 1cm<br/>
                shorthands, in style definition: OK
            </div>
            <div style="margin:2cm;padding:1cm;background-color:cmyk(0,0,50%,0);" >
                margin: 2cm, padding: 1cm<br/>
                shorthands, attributes in tag: BUG (no more)
            </div>
        </page>
    </file>



</lithron>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron style="image-resolution:web;">
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
        }

        img
        {
            width: 5cm;
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Images Low Resolution</h1>
                <h2>JPG image</h2>
                <img src="<?php echo dirname(__FILE__)."/media/test1.jpg" ?>" />
                <h2>CMYK-TIFF</h2>
                <img src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
            </wrapper>
        </page>
    </file>



</lithron>
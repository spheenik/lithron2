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
        }

        img
        {
            width: 3cm;
            height: 3cm;
            background-color: cmyk(0,0,0,10%);
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Image Mode Meet</h1>
                <h2>meet</h2>
                <img style="image-fitmethod:meet;"
                    src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                <h2>meet, image-position:50 50</h2>
                <img style="height:7cm;image-fitmethod:meet;image-position:50 50;"
                    src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                <h2>meet, image-position:50 50</h2>
                <img style="width:10cm;image-fitmethod:meet;image-position:50 50;"
                    src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                <h2>meet, image-position:100 100</h2>
                <img style="width:10cm;image-fitmethod:meet;image-position:100 100;"
                    src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
            </wrapper>
        </page>
    </file>



</lithron>
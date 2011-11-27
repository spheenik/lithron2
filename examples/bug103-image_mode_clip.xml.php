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
            background-color:cmyk(0, 0, 0, 15%);
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Image Modes</h1>
                <h2>clip</h2>
                <img style="image-fitmethod:clip;"
                    src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
                <h2>clip, scale 0.1</h2>
                <img
                    style="image-fitmethod:clip;image-scale:0.1;"
                    src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
                <h2>clip, scale 0.1, position: center / center</h2>
                <img
                    style="image-fitmethod:clip;image-scale:0.1;image-position:center center;"
                    src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
                <h2>clip, scale 0.1, position: -40 / 50</h2>
                <img
                    style="image-fitmethod:clip;image-scale:0.1;image-position:-40 50;"
                    src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
            </wrapper>
        </page>
    </file>



</lithron>
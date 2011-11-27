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

        img {
            height: 1.7em;
            width: 1.7em;
            image-fitmethod: meet;
            background-color: #1230;
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Image Test</h1>
                some text before
                <img style="display:block;padding:1em;" src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                xy <img style="display:inline;" src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                 ssssome text after <img style="display:inline;" src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                <h1>Block in inline Test</h1>
                <span style="font-weight:bold;color:maroon;">
                    some text
                    <img style="display:block;" src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                    some text
                </span>

            </wrapper>
        </page>
    </file>

</lithron>
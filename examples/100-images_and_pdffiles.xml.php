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
            height: 6cm;
            width: 6cm;
            image-fitmethod: meet;
            image-position: center center;
            background-color: cmyk(100%, 0, 0, 0);
        }

	</style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
	<page class="A4">
            <wrapper>
            <h1>Images &amp; PDF-Files</h1>
            <h2>JPG-image</h2>
            AA<img src="<?php echo dirname(__FILE__)."/media/test1.jpg" ?>" />BB
            <h2>CMYK-TIFF</h2>
            <img src="<?php echo dirname(__FILE__)."/media/test1.tif" ?>" />
            <h2>PDF-file</h2>
            <img src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
            </wrapper>
        </page>
    </file>
	
</lithron>
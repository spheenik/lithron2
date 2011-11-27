<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
	<style>
        wrapper{
            padding-top: 3cm;
            padding-left: 2cm;
            display: block;
        }
	</style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
		<page>
            <wrapper>
                <img style="display:block" src="<?php echo dirname(__FILE__)."/media/test1.jpg" ?>" />
                <img src="<?php echo dirname(__FILE__)."/media/test1.pdf" ?>" />
                <p>Bild und PDF-Datei an falscher Koordinatenposition und nicht im Block-Modus</p>
            </wrapper>
        </page>
	</file>


	
</lithron>
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
        
        image
        {
            width: 5cm;
            xxx: none;
        }

	</style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
		<page class="A4">
            <wrapper>
            <h1>Log Errors</h1>
            <image src="xxx" />
            </wrapper>
        </page>
	</file>


	
</lithron>
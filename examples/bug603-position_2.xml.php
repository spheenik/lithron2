<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
<style>
page.A4 {
	height: 297mm;
	width: 210mm;
}

div.wrapper {
	width: 15cm;
	height: 15cm;
	left: 1cm;
	top: 1cm;
	position: absolute;
	background-color: cmyk(0, 0, 0, 10%);
}

div.square-cyan {
	width: 3cm;
	height: 3cm;
	background-color: cmyk(50%, 0, 0, 0);
}

div.square-magenta {
	width: 3cm;
	height: 3cm;
	background-color: cmyk(0, 50%, 0, 0);
}

div.square-yellow {
	width: 3cm;
	height: 3cm;
	background-color: cmyk(0, 0, 50%, 0);
}

div.square-gray {
	width: 3cm;
	height: 3cm;
	background-color: cmyk(0, 0, 0, 50%);
}
</style>
<file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
<page class="A4">
<div class="wrapper">
	<div class="square-cyan"
		style="position: absolute; left: 5cm; top: 5cm">
		<div class="square-yellow" style="position: absolute; left: 1cm; top: 1cm" />
	</div>

	<div class="square-magenta" style="position: relative; margin-left: 4cm; top: 3cm">
		<div class="square-yellow" style="position: relative; margin-top: 1cm" />
		<div class="square-gray" style="position: absolute; top: 1cm" />
	</div>
</div>

<!-- Bug (no more): Absolute Elemente werden absolut zum nächsthöheren
                ABSOLUTEN Element positioniert, nicht zum RELATIVEN wie in HTML. -->
</page> </file> </lithron>

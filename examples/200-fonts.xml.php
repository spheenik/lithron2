<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <font font-family="bitstream-sans">
        <weight id="400">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/Vera" ?></style>
            <style id="italic"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraIt" ?></style>
        </weight>
        <weight id="700">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraBd" ?></style>
            <style id="italic"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraBI" ?></style>
        </weight>
        <embedding/>
    </font>

    <font font-family="bitstream-mono">
        <weight id="400">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraMono" ?></style>
            <style id="italic"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraMoIt" ?></style>
        </weight>
        <weight id="700">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraMoBd" ?></style>
            <style id="italic"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraMoBI" ?></style>
        </weight>
        <embedding/>
    </font>

    <font font-family="bitstream-serif">
        <weight id="400">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraSe" ?></style>
        </weight>
        <weight id="700">
            <style id="normal"><?php echo dirname(__FILE__)."/media/ttf-bitstream-vera-1.10/VeraSeBd" ?></style>
        </weight>
        <embedding/>
    </font>

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
        
        sans
        {
            font-family: bitstream-sans;
            margin-top: 1cm;
            margin-bottom: 0.5cm;
            display: block;
        }
        serif
        {
            font-family: "bitstream-serif";
            margin-top: 1cm;
            margin-bottom: 0.5cm;
            display: block;
        }
        mono
        {
            font-family: "bitstream-mono";
            margin-top: 1cm;
            margin-bottom: 0.5cm;
            display: block;
        }

	</style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
	<page class="A4">
            <wrapper>
            <i>Hello</i>
            <h1>Fonts</h1>
            <h2>sans</h2>
            <div><sans style="font-size:24pt">24pt Bitstream<br/> Sans Serif Normal</sans></div>
            <div><sans style="font-size:18pt"><b>18pt Bitstream Sans Serif Bold</b></sans></div>
            <div><sans style="font-size:14pt"><i>14pt Bitstream Sans Serif Italic</i></sans></div>
            <div><sans style="font-size:10pt"><strong><em>10pt Bitstream Sans Serif Bolditalic</em></strong></sans></div>

            <h2>serif</h2>
            <div><serif style="font-size:30pt">30pt Serif Bitstream Normal</serif></div>
            <div><serif style="font-size:15pt"><b>15pt Serif Bitstream Bold</b></serif></div>

            <h2>mono</h2>
            <div><mono style="font-size:16pt">16pt Bitstream Monospaced Normal</mono></div>
            <div><mono style="font-size:10pt"><b>10pt Bitstream Monospaced Bold</b></mono></div>
            <div><mono style="font-size:8pt"><i>8pt Bitstream Monospaced Italic</i></mono></div>
            <div><mono style="font-size:6pt"><strong><em>6pt Bitstream Monospaced Bolditalic</em></strong></mono></div>
            </wrapper>
        </page>
    </file>


	
</lithron>
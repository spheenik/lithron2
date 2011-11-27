<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            background-color: cmyk(0,0,0,5%);
            width: 20cm;
        }
        .wrapper
        {
            font-size: 12pt;
        }
        pre {
            width: 10cm;
            background-color: white;
            padding: 1cm;
            margin: 1cm;
            text-decoration: underline;
        }
        pre:first-child {
            background-color: red;
        }
        b:first-child {
            text-decoration: line-through;
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="wrapper">
<?php
    $ws = array("normal", "pre", "nowrap", "pre-wrap", "pre-line");
    foreach($ws as $w) {
?>
<pre style="white-space:<?php echo $w; ?>"><?php echo strtoupper($w); ?>:
This is
  a
 test.
Congue lectorum modo     <b>iusto magna duis.</b> Duis    <b>elit</b> in mazim!
Elit littera nisl ut est facit. Fiant seacula iis?</pre>
<?php } ?>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/>
            </div>
        </page>
    </file>


</lithron>
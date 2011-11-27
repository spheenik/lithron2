<?php echo'<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php
    $cols = explode(",", "#42c,aqua,black,blue,fuchsia,gray,green,lime,maroon,navy,olive,orange,purple,red,silver,teal,white,yellow");
?>

<lithron>
    <style>
        page.A4 {
            width: 90mm;
            padding: 1em;
            font-size: 8pt;
        }

        div {
            padding: 1em;
            width:auto;
            text-align: center;
        }

<?php
    foreach ($cols as $col) {
        if (strpos($col, "#") !== 0)
            echo "#$col { background-color: $col; }\n";
    }

?>

    </style>
    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
<?php

    foreach ($cols as $col) {
        if (strpos($col, "#") !== 0)
            echo "<div id=\"$col\">$col</div>\n";
        else
            echo "<div style=\"background-color:$col\">$col</div>\n";
    }

?>
        </page>
    </file>
</lithron>
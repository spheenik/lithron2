<?php header("Content-Type: text/html; charset=utf-8"); ?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" media="all" />
    </head>
    <body>
        <h1><a href="?">lithron test box</a></h1>

        <?php
        if (!class_exists("PDFlib"))
        {
            echo "<h2>Error</h2><p>PHP <a href='http://pdflib.com'>PDFlib</a> extension is not installed!";
            exit;
        }
        if (!is_writable("output"))
        {
            echo "<h2>Error</h2><p>Folder 'output' does not exist and/or is not writable!";
            exit;
        }
        echo "<h2>Examples</h2>";
        $dir = dirname(__FILE__)."/examples";
        $examples = scandir($dir);
        foreach($examples AS $example)
        {
            if ( (!is_numeric(substr($example,0,3))) && (substr($example,0,3) != "bug")) continue;
            $trans = array(".xml.php" => "", "_" => " ", "-"=> ": ", "bug" => "bug ");
            echo "<a href='render.php?file=examples/$example'>".ucwords(strtr($example,$trans))."</a><br/>";
        }
        echo "<h2>Help, Howto and Docs</h2>";
        echo "<a href='http://wiki.lithron.de'>lithron wiki</a><br/><a href='docs/manual'>souce-code docs (alpha)</a>";
        echo "<br/><br/><small>Powered by <a href='http://lithron.de'>lithron</a> from <a href='http://diemeisterei.de'>diemeisterei, Stuttgart</a></small>";
        ?>
    </body>

</html>


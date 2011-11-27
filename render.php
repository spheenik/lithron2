<?php 
    header("Content-Type: text/html; charset=utf-8");

    function tformat($t) {
        if ($t > 1.0) {
            $f = 1.0;
            $e = "s";
        } else if ($t > 0.001) {
            $f = 1000.0;
            $e = "ms";
        } else {
            $f = 1000000.0;
            $e = "&micro;s";
        }
        return sprintf("%.02f&nbsp;$e", $t*$f);

    }

?> 
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css" media="all" />
    </head>
    <body>
        <h1><a href="index.php">lithron test box</a></h1>

        <?php
        require_once("lithron/Lithron.php");

        // check file
        $file = realpath($_REQUEST['file']);
        if (!is_file($file) || !strstr($file, dirname(__FILE__).DIRECTORY_SEPARATOR."examples")){
            exit("Requested $file is not in example directory!");
        }

        // using php as a template engine ;) Greetings to Jens
        ob_start();
        include($file);
        $xml = ob_get_clean();

        // invoke lithron rendering process
        $L = Lithron::loadSource($xml);
        $jobRecorder = $L->work();

        $files = $jobRecorder->getFiles();
        foreach ($files as $file)
        {
            // download links
            echo '<h2>Download</h2>';
            echo '<div id="DownloadPanel">';
            echo '<a target="_blank" href="'.$file["URL"].'">'.$file["name"]." (".filesize($file["absoluteFile"])." bytes)".'</a>';

            // preview
            echo "<h2>Preview</h2>";
            echo '<div id="PreviewPanel"><iframe src="'.$file["URL"].'" width="100%" height="600"></iframe></div>';
        }

        // timing
        echo "<h2>Timing</h2>";
        echo "<div class='LogPanel'>";
        $timers = $jobRecorder->getLogger()->getTimers();
        echo "<table class='LithronLogTable'>";
        echo '<thead><tr><td>Timer</td><td>Elapsed</td></tr></thead>';
        foreach($timers as $timer) {
            echo "<tr><td>".$timer[0]."</td><td align='right'>".tformat($timer[1])."</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // log
        echo "<h2>Log</h2>";
        echo "<div class='LogPanel'>";
        $msgs = $jobRecorder->getLogger()->getMessages();
        echo "<table class='LithronLogTable'>";
        echo '<thead><tr><td>Level</td><td>Message</td></tr></thead>';
        foreach($msgs as $msg) {
            echo "<tr><td class='level".$msg[0]."'>".$msg[0]."</td><td>".$msg[1]."</td></tr>";
        }
        echo "</table>";
        echo "</div>";


if (isset($_GET["LITHRON_DEBUG"])) {
        $layoutDump = $jobRecorder->getLayoutDump();
        $commandDump = $jobRecorder->getCommandDump();

        //source
        echo "<h2>Source</h2>";
        echo "<div class='DebugPanel'>";
        $trans = array("<" => "&lt;", ">" => "&gt;");
        echo wordwrap(strtr($L->getCleanedXML(), $trans),120);
        echo "</div>";

        // debug
        foreach($files as $key => $file) {
            echo "<h2>Layout for ".$file["name"]."</h2>";
            echo "<div class='DebugPanel'>".str_replace("&amp;#x", "&#x", implode("<br/>", $layoutDump[$key]))."</div>";
            echo "<h2>Commands for ".$file["name"]."</h2>";
            echo "<div class='DebugPanel'>".implode("<br/>", $commandDump[$key])."</div>";
        }
}

        // credits
        echo "<br/><br/><small>Powered by <a href='http://lithron.de'>lithron</a> from <a href='http://diemeisterei.de'>diemeisterei, Stuttgart</a></small>";
        ?>
    </body>
</html>


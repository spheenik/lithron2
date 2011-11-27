<?php echo'<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php require_once("DemoHelper.php") ?>

<lithron>
    <?php include("style.xml"); ?>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm;
        }

        div.header
        {
            position: fixed;
            text-align: center;
            background-color: cmyk(50%,0,0,0);
            width: 210mm;
        }
        div.footer
        {
            position: fixed;
            text-align: center;
            background-color: cmyk(25%,0,0,0);
            width: 210mm;
            bottom: 0mm;
        }
        pagenum
        {
            content: pagenum;
        }

        sink.content{
            width: 8cm;
            height: 22.5cm;
            background-color: cmyk(0,0,0,25%);
            position: absolute;
            top: 2cm;
        }
        sink.left{
            margin-left: 2cm;
        }
        sink.right{
            margin-left: 11cm;
        }

        div.intro{
            background-color: cmyk(0,0,50%,0);
            padding-top: 0.5cm;
            padding-left: 0.5cm;
            padding-bottom: 0.5cm;
            padding-right: 0.5cm;
        }
        div.text{
            background-color: cmyk(0,0,25%,0);
            padding-top: 0.5cm;
            padding-left: 0.5cm;
            padding-bottom: 0.5cm;
            padding-right: 0.5cm;
        }
        repeater.modulo {
            display: repeater;
            modulo: 4;
            modulo-mode: different;
        }

    </style>
    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <repeater well-id="contentwell">
            <page class="A4">
                <div class="header">Page <pagenum/></div>
                <sink well-id="contentwell" class="content left" />
                <sink well-id="contentwell" class="content right" />
                <div class="footer">lithron</div>
            </page>
        </repeater>
        <!-- Fills up additional pages. Pagecount: 4,8,12,16,... -->
        <repeater class="modulo" modulo-result="0">
            <page class="A4">
                <div class="header">Page <pagenum/> Modulo 0</div>
            </page>
        </repeater>
        <repeater class="modulo" modulo-result="1">
            <page class="A4">
                <div class="header">Page <pagenum/> Modulo 1</div>
            </page>
        </repeater>
        <repeater class="modulo" modulo-result="2">
            <page class="A4">
                <div class="header">Page <pagenum/> Modulo 2</div>
            </page>
        </repeater>
        <repeater class="modulo" modulo-result="3">
            <page class="A4">
                <div class="header">Page <pagenum/> Modulo 3</div>
            </page>
        </repeater>
    </file>
    <well well-id="contentwell">
        <?php foreach(DemoHelper::getArray(15) AS $i => $data): ?>
        <div class="intro" breakable="no">
            <h2>No.<?php echo $i ?></h2>
            <image height="1cm" src="<?php echo dirname(__FILE__) ?>/media/test1.pdf" />
            <strong><?php echo DemoHelper::getBlindText(rand(1,3)*50); ?></strong>
        </div>
        <div class="text" margin-bottom="1cm">
            <?php echo DemoHelper::getBlindText(rand(1,15)*100); ?>
        </div>
        <?php endforeach; ?>
    </well>

</lithron>
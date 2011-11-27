<?php echo'<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php require_once("DemoHelper.php") ?>

<lithron>
    <?php include("style.xml"); ?>
    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Mirum commodo option</h1>
                <?php foreach(DemoHelper::getArray(3) AS $data): ?>
                <p><?php echo DemoHelper::getBlindText(250); ?></p>
                <img style="height:3cm;width:5cm;" src="<?php echo dirname(__FILE__) ?>/media/test1.jpg" />
                <p><?php echo DemoHelper::getBlindText(250); ?></p>
                <?php endforeach; ?>
            </wrapper>
        </page>
    </file>
</lithron>
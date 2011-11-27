<?php echo'<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php require_once("DemoHelper.php") ?>

<lithron>
    <?php include("style.xml"); ?>
    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <well well-id="contentwell">
                <?php foreach(DemoHelper::getArray(3) AS $data): ?>
                <h1>Mirum commodo option</h1>
                <p>
                    <image height="1cm" src="<?php echo dirname(__FILE__) ?>/media/test1.jpg" />
                    <?php echo DemoHelper::getBlindText(250); ?>
                </p>
                <?php endforeach; ?>
        </well>

        <repeater well-id="contentwell">
        <page class="A4">
            <wrapper>
                <sink well-id="contentwell" height="10cm" width="10cm" />
            </wrapper>
        </page>
        </repeater>
	</file>
</lithron>
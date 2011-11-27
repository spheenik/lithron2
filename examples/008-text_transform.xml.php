<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
        }
        .wrapper
        {
            background-color: cmyk(0,0,0,5%);
            padding: 1cm;
            font-size: 15pt;
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="wrapper">
                <span style="text-transform:uppercase_sz">&gt;&nbsp;&nbsp;uppercase_ß uppercase_ß uppercase_ß uppercase_ß<br/></span>
                <span style="text-transform:uppercase">&gt;&nbsp;&nbsp;uppercase_ß uppercase_ß uppercase_ß uppercase_ß<br/></span>
                <span style="text-transform:lowercase">&gt;&nbsp;&nbsp;LOWERCASE LOWERCASE LOWERCASE LOWERCASE <br/></span>
                <span style="text-transform:capitalize">&gt;&nbsp;&nbsp;capitalize capitalize capitalize capitalize <br/></span>
                <br/><br/><br/><br/><br/><br/><br/><br/><br/>
            </div>
        </page>
    </file>


</lithron>
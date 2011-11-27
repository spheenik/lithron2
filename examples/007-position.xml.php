<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page.A4 {
            height: 297mm;
            width: 210mm
        }
        .wrapper
        {
            background-color: cmyk(0,0,0,5%);
            padding: 1cm;
        }
        .absolute1
        {
            position: absolute;
            background-color: cmyk(50%,0,0,0);
            right: 1cm;
            top: 0cm;
            width: 5cm;
            height: 3cm;
            padding: 0.25cm;
        }
        .absolute2
        {
            position: absolute;
            background-color: cmyk(25%,0,0,0);
            right: 0.5cm;
            bottom: 0.5cm;
            width: 3cm;
            height: 1.5cm;
            padding: 0.25cm;
        }
        .relative
        {
            position: relative;
            width: 10cm;
            background-color: cmyk(0,0,20%,0);
            bottom: -5em;
            left: 4cm;
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <div class="wrapper">
                Lorem ipsum ...
                <div class="relative">
                    <div class="absolute1">
                        1cm top, absolute
                        <div class="absolute2">
                            0.5cm bottom right, absolute
                        </div>
                    </div>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                    relative relative relative relative <br/>
                </div>
                Lorem ipsum ...
            </div>
        </page>
    </file>



</lithron>
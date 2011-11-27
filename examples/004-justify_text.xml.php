<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
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
            text-align: justify;
        }
    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <h1>Headlines, Paragraphs &amp; Lists</h1>
                <p>
                    Congue lectorum modo iusto magna duis. Duis elit in mazim nulla elit. Consequat liber sollemnes commodo sed typi.
                    Elit littera nisl ut est facit. Fiant seacula iis est wisi quarta. Quod vero quis feugiat praesent zzril.
                Duis modo dolore augue claritas claritas.</p>
                <h2>Headline 2</h2>
                <p>
                    Congue lectorum modo iusto magna duis. Duis elit in mazim nulla elit. Consequat liber sollemnes commodo sed typi.
                    Elit littera nisl ut est facit. Fiant seacula iis est wisi quarta. Quod vero quis feugiat praesent zzril.
                Duis modo dolore augue claritas claritas.</p>
                <h3>Headline 3</h3>
                <p>
                    Congue lectorum modo iusto magna duis. Duis elit in mazim nulla elit. Consequat liber sollemnes commodo sed typi.
                    Elit littera nisl ut est facit. Fiant seacula iis est wisi quarta. Quod vero quis feugiat praesent zzril.
                Duis modo dolore augue claritas claritas.</p>
                <h4>Headline 4</h4>
                <p>
                    Congue lectorum modo iusto magna duis. Duis elit in mazim nulla elit. Consequat liber sollemnes commodo sed typi.
                    Elit littera nisl ut est facit. Fiant seacula iis est wisi quarta. Quod vero quis feugiat praesent zzril.
                Duis modo dolore augue claritas claritas.</p>
                <h5>Headline 5</h5>
                <p>
                    Congue lectorum modo iusto magna duis. Duis elit in mazim nulla elit. Consequat liber sollemnes commodo sed typi.
                    Elit littera nisl ut est facit. Fiant seacula iis est wisi quarta. Quod vero quis feugiat praesent zzril.
                Duis modo dolore augue claritas claritas.</p>
                <p>
                    <ul>
                        <li>Possim fiant dolore mutationem nihil lius.</li>
                        <li>Dynamicus in sit lius doming vel. Per ut ut parum feugiat Investigationes. Seacula nobis quinta eleifend tation eleifend. Quod qui mirum in placerat diam.</li>
                        <li>euismod feugait tincidunt.</li>
                    </ul>
                </p>

            </wrapper>
        </page>
    </file>



</lithron>
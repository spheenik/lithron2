<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <style>
        page {
            width: 400pt;
            height: 400pt;
            font-size:25.8pt;
            line-height: 200%;
            padding: 1em;
            font-family: helvetica;
        }
        hr {
            height: 1pt;
            background-color: black;
        }

#ex1 .outer { color: red }
#ex1 .inner { color: blue }

#ex2 .outer { position: relative; top: -15pt; color: red }
#ex2 .inner { position: relative; top: 15pt; color: blue }

#ex3 .outer {
    position: absolute;
    display: block;
    top: 200pt; left: 200pt;
    width: 200px;
    color: red;
}
#ex3 .inner { color: blue }

#ex4 .outer {
  position: relative;
  color: red
}
#ex4 .inner {
  position: absolute;
  display: block;
  top: 200px; left: -50px;
  height: 130px; width: 130px;
  color: blue;
  background-color: silver;
}

#ex5 .outer {
  color: red
}
#ex5 .inner {
  position: absolute;
  display: block;
  top: 200px; left: -50px;
  height: 130px; width: 130px;
  color: blue;
  background-color: silver;
}

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page id="ex1">Beginning of body contents.
            <span class="outer"> Start of outer contents.
                <span class="inner"> Inner contents.</span>
                End of outer contents.</span>
            End of body contents.
        </page>
        <page id="ex2">Beginning of body contents.
            <span class="outer"> Start of outer contents.
                <span class="inner"> Inner contents.</span>
                End of outer contents.</span>
            End of body contents.
        </page>
        <page id="ex3">Beginning of body contents.
            <span class="outer"> Start of outer contents.
                <span class="inner"> Inner contents.</span>
                End of outer contents.</span>
            End of body contents.
        </page>
        <page id="ex4">Beginning of body contents.
            <span class="outer"> Start of outer contents.
                <span class="inner"> Inner contents.</span>
                End of outer contents.</span>
            End of body contents.
        </page>
        <page id="ex5">Beginning of body contents.
            <span class="outer"> Start of outer contents.
                <span class="inner"> Inner contents.</span>
                End of outer contents.</span>
            End of body contents.
        </page>
    </file>



</lithron>
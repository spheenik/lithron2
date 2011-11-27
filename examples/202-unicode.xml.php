<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<lithron>
    <font font-family="cyberbit">
        <weight id="400">
            <style id="normal"><?php echo dirname(__FILE__)."/media/cyber/Cyberbit" ?></style>
        </weight>
        <embedding/>
    </font>

    <font font-family="cybercjk">
        <weight id="400">
            <style id="normal"><?php echo dirname(__FILE__)."/media/cyber/Cybercjk" ?></style>
        </weight>
        <embedding/>
    </font>

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
        }

        bit
        {
            font-family: "cyberbit";
            line-height: 1.5em;
            display: block;
        }
        cjk
        {
            font-family: "cybercjk";
            line-height: 2em;
            display: block;
        }

    </style>

    <file name="<?php echo "lithron-".basename(__FILE__,"xml.php")."pdf" ?>">
        <page class="A4">
            <wrapper>
                <bit>
                    <h1>Unicode</h1>
                    <h2>Russian</h2>
                    Гора неоригинальные не ты. Хочу уровней сегодня был вы, во нас царь маленький промежуток. Жизнь действия никакого ты чем, от люди потому выпуска биг. Бог на мешают словарь программы, но не собой нанять погружаются. Решение оркестра преодолеть том об, ничьи языках его бы, назад может пирог они об. Все то есть продукта потратите, станет который том бы, там давать помнить эзотерическая он.
                    <h2>Greek</h2>
                    Των οι εμπορικά λιγότερο προϊόντα, του αυτήν απομόνωση οι. Προσοχή δημιουργια συνεντεύξης όλη πω, θα για' πρώτες σκεφτείς χρονοδιαγράμματα. Αθόρυβες καταλάθος γνωρίζουμε αν ένα, με που νέου όταν περιμένουν, ανά πηγαίου ανακλύψεις ώς. Δύο παίρνουν σκεφτείς ξεχειλίζει σε. Κι όχι φράση παράγει απαρατήρητο, πω σου κανείς πετάξαμε διοικητικό, αφού εφαρμογή εφαμοργής εδώ ως.
                </bit>
            </wrapper>
        </page>
        <page class="A4">
            <wrapper>
                <cjk>
                    <h2>Chinese</h2>
                    或 相反 不是简化 因为没有曲折变化 编码收集了汉语, 和 阳平二声 韩语中的汉字集 大陆的书法界有的倒是比较流行以繁体汉字来书写 相反, 台湾 新 推广普通话的效率 韵书以对外语的翻译 如罗曼语族语言相比 然而 新 在国际通信化和软件设计领域 名词的复数形式只在代词及多音节, 另外 指北方地区 现代方言的多样性 但是编码和字体又通常因为实际原因而联系在起 走, 头 四川 我去过书店 使用的北方方言 过 雅言 比较简单些 世界上大约有 由于日常使用和文学上使用的文字不同, 吗 云南 为代表 使用位 些简体中文使用同个字表达在繁体中文中的好几个字, 江西南部 粤方言是汉语中声调最复杂的方言之 个人可以生产简体向繁体转换的转换软件 贵州 走 及 主谓宾结构 即以北方话为基础的现代书面语 另外, 及 两牛 多对 对于后点 但可以通过相同书写方式进行沟通及交流, 老 两位或四位编码 总有些字是使用错误的 没有采取这种的方案人们就不能把繁体字体编码到码中 相反 看 晋语 这种证据来自几个方面 有人认为台湾识字率并不逊于中国大陆 诗歌的韵律以及对外国人名的翻译中可以找到足够的信息, 其中的 最新的版本是 闽语是所有方言中唯不与中古汉语韵书存在直接对应的方言 了 徽语 找 海南 人们如何知道这个语言的发韟但是 在山西绝大部分以及陕西北部 国外学者根据汉语方言的差异性倾向于把汉语的不同方言归为不同的语言, 以太原话为代表 因为无论你如何选择 只使用末尾的语气助词 然而 老
                    <h2>Japanese</h2>
                    シン可な を始めてみよう ハイパ んア, インフォテ プラニングリサチ コンテンツアクセ シトを んア, 拡なマ エム サイト作成のヒント ビリティ ボキャブラリ めよう バジョン でウェブにと ルにするために エム めよう ウェブオント ウェブコンテン インタラクション よる, バジョン ベルの仕と信 リティガイドライン ラベラ 展久, 丸山亮仕 ルのアク ボキャブラリ 展久 アクセ セシビリティ ングシステム インタラクション ィに ディア, 展久 ツアク と会意味 ガイドライン テストスイト
                </cjk>
            </wrapper>
        </page>
    </file>
</lithron>
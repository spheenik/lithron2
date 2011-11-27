<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSSLayout
 *
 * @author short
 */
class CSSLayout {

    public static $frameProps = array(
        0 => array(
            CSS::_MARGIN_TOP,
            CSS::_BORDER_TOP_WIDTH,
            CSS::_PADDING_TOP,
            CSS::_TOP,
        ),
        1 => array(
            CSS::_MARGIN_RIGHT,
            CSS::_BORDER_RIGHT_WIDTH,
            CSS::_PADDING_RIGHT,
            CSS::_RIGHT,
        ),
        2 => array(
            CSS::_MARGIN_BOTTOM,
            CSS::_BORDER_BOTTOM_WIDTH,
            CSS::_PADDING_BOTTOM,
            CSS::_BOTTOM,
        ),
        3 => array(
            CSS::_MARGIN_LEFT,
            CSS::_BORDER_LEFT_WIDTH,
            CSS::_PADDING_LEFT,
            CSS::_LEFT,
        ),
    );

    public static function calcFrame($frame, $which) {
        preg_match("/^(M?)(B?)(P?)(X?)(T|R|B|L|H|V)$/", $which, $matches);
        //var_dump($which, $matches);
        switch ($matches[5]) {
            case "T": $indices = array(0); break;
            case "R": $indices = array(1); break;
            case "B": $indices = array(2); break;
            case "L": $indices = array(3); break;
            case "H": $indices = array(1, 3); break;
            case "V": $indices = array(0, 2); break;
        }
        $subindices = array();
        for ($i = 1; $i <= 4; $i++)
            if ($matches[$i]) $subindices[] = $i - 1;
        $sum = 0.0;
        foreach($indices as $i)
            foreach($subindices as $s)
                $sum += $frame[self::$frameProps[$i][$s]];
        return $sum;
    }

    private static function calcMargin($margin, $parentExtent) {
        if ($margin === CSS::_AUTO)
            return null;
        else if ($margin instanceof CSSNumber)
            if ($parentExtent !== null)
                return $margin->value * $parentExtent / 100.0;
            else
                return null;
        else
            return $margin;
    }

    private static function calcExtent($extent, $parentExtent) {
        if ($extent === CSS::_AUTO)
            return null;
        else if ($extent instanceof CSSNumber)
            if ($parentExtent !== null)
                return $extent->value * $parentExtent / 100.0;
            else
                return null;
        else
            return $extent;
    }

    private static function calcPos($pos, $parentExtent) {
        if ($pos === CSS::_AUTO)
            return null;
        else if ($pos instanceof CSSNumber)
            if ($parentExtent !== null)
                return $pos->value * $parentExtent / 100.0;
            else
                return null;
        else
            return $pos;
    }

    private static function calcMax($extent, $maxExtent, $parentExtent, $parentMaxExtent, $frameExtent) {
        if ($maxExtent !== CSS::_NONE)
            return $maxExtent;
        if ($parentExtent === null)
            $parentExtent = Vector::INFINITY;
        if ($parentMaxExtent === null)
            $parentMaxExtent = Vector::INFINITY;
        $maxExtent = min($parentExtent-$frameExtent, $parentMaxExtent-$frameExtent);
        return max($extent, $maxExtent);
    }

    private static function calcRelative($pos, $extent1, $extent2, $which) {
        if ($pos === CSS::_STATIC)
            return null;
        if ($extent1 === CSS::_AUTO && $extent2 === CSS::_AUTO)
            return 0.0;
        else if ($extent1 === CSS::_AUTO)
            return $which == 0 ? -$extent2 : $extent2;
        else if ($extent2 === CSS::_AUTO)
            return $which == 0 ? $extent1 : -$extent1;
        else
            return $which == 0 ? $extent1 : -$extent1;
    }

    public static function frame($overrides = array()) {
        $result = array(
          CSS::_DISPLAY => CSS::_INLINE,
          CSS::_POSITION => CSS::_STATIC,
          CSS::_Z_INDEX => 2.0,

          CSS::_LEFT => null,
          CSS::_MARGIN_LEFT => 0.0,
          CSS::_BORDER_LEFT_WIDTH => 0.0,
          CSS::_PADDING_LEFT => 0.0,
          CSS::_MIN_WIDTH => 0.0,
          CSS::_WIDTH => null,
          CSS::_MAX_WIDTH => null,
          CSS::_PADDING_RIGHT => 0.0,
          CSS::_BORDER_RIGHT_WIDTH => 0.0,
          CSS::_MARGIN_RIGHT => 0.0,
          CSS::_RIGHT => null,

          CSS::_TOP => null,
          CSS::_MARGIN_TOP => 0.0,
          CSS::_BORDER_TOP_WIDTH => 0.0,
          CSS::_PADDING_TOP => 0.0,
          CSS::_MIN_HEIGHT => 0.0,
          CSS::_HEIGHT => null,
          CSS::_MAX_HEIGHT => null,
          CSS::_PADDING_BOTTOM => 0.0,
          CSS::_BORDER_BOTTOM_WIDTH => 0.0,
          CSS::_MARGIN_BOTTOM => 0.0,
          CSS::_BOTTOM => null,
        );

        foreach($overrides as $prop => $val)
            $result[$prop] = $val;

        return $result;
    }

    public static function initialInlineFrame(Attributes $a) {
        $result = self::frame();
        $result[CSS::_DISPLAY] = CSS::_INLINE;
        $result[CSS::_POSITION] = $a[CSS::_POSITION];
        $result[CSS::_LEFT] = self::calcRelative($a[CSS::_POSITION], $a[CSS::_LEFT], $a[CSS::_RIGHT], 0);
        $result[CSS::_RIGHT] = self::calcRelative($a[CSS::_POSITION], $a[CSS::_LEFT], $a[CSS::_RIGHT], 1);
        $result[CSS::_TOP] = self::calcRelative($a[CSS::_POSITION], $a[CSS::_TOP], $a[CSS::_BOTTOM], 0);
        $result[CSS::_BOTTOM] = self::calcRelative($a[CSS::_POSITION], $a[CSS::_TOP], $a[CSS::_BOTTOM], 1);
        return $result;
}

    public static function initialStaticBlockFrame(Attributes $a, PrimitiveBox $parent) {
        $w = self::calcExtent($a[CSS::_WIDTH], $parent[CSS::_WIDTH]);
        $h = self::calcExtent($a[CSS::_HEIGHT], $parent[CSS::_HEIGHT]);

        $frame = array(
          CSS::_DISPLAY => CSS::_BLOCK,
          CSS::_POSITION => $a[CSS::_POSITION],
          CSS::_Z_INDEX => 0.0,

          CSS::_LEFT => self::calcRelative($a[CSS::_POSITION], $a[CSS::_LEFT], $a[CSS::_RIGHT], 0),
          CSS::_MARGIN_LEFT => self::calcMargin($a[CSS::_MARGIN_LEFT], $parent[CSS::_WIDTH]),
          CSS::_BORDER_LEFT_WIDTH => $a[CSS::_BORDER_LEFT_STYLE] != CSS::_NONE ? $a[CSS::_BORDER_LEFT_WIDTH] : 0.0,
          CSS::_PADDING_LEFT => $a[CSS::_PADDING_LEFT],
          CSS::_MIN_WIDTH => $a[CSS::_MIN_WIDTH],
          CSS::_WIDTH => $w,
          CSS::_PADDING_RIGHT => $a[CSS::_PADDING_RIGHT],
          CSS::_BORDER_RIGHT_WIDTH => $a[CSS::_BORDER_RIGHT_STYLE] != CSS::_NONE ? $a[CSS::_BORDER_RIGHT_WIDTH] : 0.0,
          CSS::_MARGIN_RIGHT => self::calcMargin($a[CSS::_MARGIN_RIGHT], $parent[CSS::_WIDTH]),
          CSS::_RIGHT => self::calcRelative($a[CSS::_POSITION], $a[CSS::_LEFT], $a[CSS::_RIGHT], 1),

          CSS::_TOP => self::calcRelative($a[CSS::_POSITION], $a[CSS::_TOP], $a[CSS::_BOTTOM], 0),
          CSS::_MARGIN_TOP => self::calcMargin($a[CSS::_MARGIN_TOP], $parent[CSS::_HEIGHT]),
          CSS::_BORDER_TOP_WIDTH => $a[CSS::_BORDER_TOP_STYLE] != CSS::_NONE ? $a[CSS::_BORDER_TOP_WIDTH] : 0.0,
          CSS::_PADDING_TOP => $a[CSS::_PADDING_TOP],
          CSS::_MIN_HEIGHT => $a[CSS::_MIN_HEIGHT],
          CSS::_HEIGHT => $h,
          CSS::_PADDING_BOTTOM => $a[CSS::_PADDING_BOTTOM],
          CSS::_BORDER_BOTTOM_WIDTH => $a[CSS::_BORDER_BOTTOM_STYLE] != CSS::_NONE ? $a[CSS::_BORDER_BOTTOM_WIDTH] : 0.0,
          CSS::_MARGIN_BOTTOM => self::calcMargin($a[CSS::_MARGIN_BOTTOM], $parent[CSS::_HEIGHT]),
          CSS::_BOTTOM => self::calcRelative($a[CSS::_POSITION], $a[CSS::_TOP], $a[CSS::_BOTTOM], 1),
        );
        $frame[CSS::_MAX_WIDTH] = self::calcMax($w, $a[CSS::_MAX_WIDTH], $parent[CSS::_WIDTH], $parent[CSS::_MAX_WIDTH], self::calcFrame($frame, "MBPH"));
        $frame[CSS::_MAX_HEIGHT] = self::calcMax($h, $a[CSS::_MAX_HEIGHT], $parent[CSS::_HEIGHT], $parent[CSS::_MAX_HEIGHT], self::calcFrame($frame, "MBPV"));
        return $frame;
    }

    public static function initialAbsoluteBlockFrame(Attributes $a, PrimitiveBox $parent) {
        $frame = self::initialStaticBlockFrame($a, $parent);

    // z-indices:
    // neg-inf
    // blocks:0
    // floats:1
    // inline:2
    // positioned mit auto oder z-index 0
    // inf
        $z = $a[CSS::_Z_INDEX];
        if ($z === CSS::_AUTO)
            $z = 3.0;
        else
            $z = $z >= 0.0 ? $z + 3.0 : $z;

        $frame[CSS::_Z_INDEX] = $z;
        $frame[CSS::_POSITION] = CSS::_ABSOLUTE;
        $frame[CSS::_TOP] = self::calcPos($a[CSS::_TOP], $parent[CSS::_HEIGHT]);
        $frame[CSS::_RIGHT] = self::calcPos($a[CSS::_RIGHT], $parent[CSS::_WIDTH]);
        $frame[CSS::_BOTTOM] = self::calcPos($a[CSS::_BOTTOM], $parent[CSS::_HEIGHT]);
        $frame[CSS::_LEFT] = self::calcPos($a[CSS::_LEFT], $parent[CSS::_WIDTH]);
        return $frame;
    }

    public static function finalizeStaticBlockFrame(PrimitiveBox $frame, PrimitiveBox $parent = null) {
        $parentW = $parent !== null ? $parent[CSS::_WIDTH] : null;

        if ($frame[CSS::_WIDTH] !== null) {
            if ($parentW !== null) {
                $over = $parentW - $frame[CSS::_WIDTH] - CSSLayout::calcFrame($frame, "MBPH");
                $c = 0;
                if ($frame[CSS::_MARGIN_LEFT] === null) $c++;
                if ($frame[CSS::_MARGIN_RIGHT] === null) $c++;
                if ($frame[CSS::_MARGIN_LEFT] === null) $frame[CSS::_MARGIN_LEFT] = $over/$c;
                if ($frame[CSS::_MARGIN_RIGHT] === null) $frame[CSS::_MARGIN_RIGHT] = $over/$c;
            }
        } else if ($frame[CSS::_WIDTH] === null) {
            if ($parentW !== null) {
                $frame[CSS::_WIDTH] = $parentW - CSSLayout::calcFrame($frame, "MBPH");
            } else {
                $frame[CSS::_WIDTH] = $frame[CSS::_MIN_WIDTH];
                foreach($frame->children as $child) {
                    $c = $child[CSS::_LEFT] + $child[CSS::_WIDTH] + CSSLayout::calcFrame($child, "MBPH");
                    if ($frame[CSS::_WIDTH] < $c) $frame[CSS::_WIDTH] = $c;
                }
            }
        }
        if ($parentW !== null)
            $frame[CSS::_MARGIN_RIGHT] = $parentW - $frame[CSS::_WIDTH] - $frame[CSS::_MARGIN_LEFT] - CSSLayout::calcFrame($frame, "BPH");

        if ($frame[CSS::_HEIGHT] === null) {
            $frame[CSS::_HEIGHT] = $frame[CSS::_MIN_HEIGHT];
            foreach($frame->children as $child) {
                $c = $child[CSS::_TOP] + $child[CSS::_HEIGHT] + CSSLayout::calcFrame($child, "MBPV");
                if ($frame[CSS::_HEIGHT] < $c) $frame[CSS::_HEIGHT] = $c;
            }
        }
    }


    public static function finalizeAbsoluteBlockFrame(PrimitiveBox $frame, PrimitiveBox $parent = null) {
        $parentW = $parent !== null ? $parent[CSS::_WIDTH] : null;
        $parentH = $parent !== null ? $parent[CSS::_HEIGHT] : null;

        $ac = 0;
        if ($frame[CSS::_LEFT] === null) $ac |= 1;
        if ($frame[CSS::_WIDTH] === null) $ac |= 2;
        if ($frame[CSS::_RIGHT] === null) $ac |= 4;

        if ($ac == 7 || $ac == 5) {
            $frame[CSS::_LEFT] = 0.0; // static
            $ac &= ~1;
        } else if ($ac == 0) {
            if ($parentW !== null) {
                $over = $parentW - $frame[CSS::_WIDTH] - CSSLayout::calcFrame($frame, "MBPXH");
                $c = 0;
                if ($frame[CSS::_MARGIN_LEFT] === null) $c++;
                if ($frame[CSS::_MARGIN_RIGHT] === null) $c++;
                if ($frame[CSS::_MARGIN_LEFT] === null) $frame[CSS::_MARGIN_LEFT] = $over/$c;
                if ($frame[CSS::_MARGIN_RIGHT] === null) $frame[CSS::_MARGIN_RIGHT] = $over/$c;
            }
        }
        if ($ac & 2 && $ac != 2) {
            $frame[CSS::_WIDTH] = $frame[CSS::_MIN_WIDTH];
            foreach($frame->children as $child) {
                $c = $child[CSS::_LEFT] + $child[CSS::_WIDTH] + CSSLayout::calcFrame($child, "MBPH");
                if ($frame[CSS::_WIDTH] < $c) $frame[CSS::_WIDTH] = $c;
            }
            $ac &= ~2;
        }
        $base = $parentW - CSSLayout::calcFrame($frame, "MBPH");
        if ($ac == 1) $frame[CSS::_LEFT] = $base - $frame[CSS::_WIDTH] - $frame[CSS::_RIGHT];
        if ($ac == 2) $frame[CSS::_WIDTH] = $base - $frame[CSS::_LEFT] - $frame[CSS::_RIGHT];
        if ($ac == 4) $frame[CSS::_RIGHT] = $base - $frame[CSS::_LEFT] - $frame[CSS::_WIDTH];




        $ac = 0;
        if ($frame[CSS::_TOP] === null) $ac |= 1;
        if ($frame[CSS::_HEIGHT] === null) $ac |= 2;
        if ($frame[CSS::_BOTTOM] === null) $ac |= 4;

        if ($ac == 7 || $ac == 5) {
            $frame[CSS::_TOP] = 0.0; // static
            $ac &= ~1;
        } else if ($ac == 0) {
        }
        if ($ac & 2 && $ac != 2) {
            $frame[CSS::_HEIGHT] = $frame[CSS::_MIN_HEIGHT];
            foreach($frame->children as $child) {
                $c = $child[CSS::_TOP] + $child[CSS::_HEIGHT] + CSSLayout::calcFrame($child, "MBPV");
                if ($frame[CSS::_HEIGHT] < $c) $frame[CSS::_HEIGHT] = $c;
            }
            $ac &= ~2;
        }
        $base = $parentH - CSSLayout::calcFrame($frame, "MBPV");
        if ($ac == 1) $frame[CSS::_TOP] = $base - $frame[CSS::_HEIGHT] - $frame[CSS::_BOTTOM];
        if ($ac == 2) $frame[CSS::_HEIGHT] = $base - $frame[CSS::_TOP] - $frame[CSS::_BOTTOM];
        if ($ac == 4) $frame[CSS::_BOTTOM] = $base - $frame[CSS::_TOP] - $frame[CSS::_HEIGHT];


    }



    public static function dumpFrame($frame) {
        foreach ($frame as $prop => $value) {
            echo CSS::toString($prop).":".CSS::toString($value)."<br/>";
        }
    }


}
?>

<?php
array_shift($argv);
$file = $argv[0];

$string = file_get_contents($file);
$array = explode("\n", $string);
$numberOfLines = array_shift($array);
$arrayCopy = [];

foreach ($array as $key => $value) {
    $array[$key] = str_split($value);
    foreach ($array[$key] as $k => $arrayElem) {
        if ($arrayElem === ".") {
            $arrayCopy[$key][$k] = 1;
        } else {
            $arrayCopy[$key][$k] = 0;
        }
    }
}

$lineLength = count($array[0]);

function getValueAtPos($matrix, $x, $y)
{
    if ($x < 0 || $y < 0)
        return 0;
    return $matrix[$y][$x];
}

$squareLen = 0;
$xSquare = 0;
$ySquare = 0;

// ===========================================================================================================================

for ($y = 0; $y < $numberOfLines; $y++) {
    for ($x = 0; $x < $lineLength; $x++) {
        if ($arrayCopy[$y][$x] === 1) {
            $arrayCopy[$y][$x] = min(getValueAtPos($arrayCopy, $x - 1, $y), getValueAtPos($arrayCopy, $x, $y - 1), getValueAtPos($arrayCopy, $x - 1, $y - 1)) + 1;
            if ($arrayCopy[$y][$x] > $squareLen) {
                $squareLen = $arrayCopy[$y][$x];
                $xSquare = $x;
                $ySquare = $y;
            }
        } else {
            $arrayCopy[$y][$x] = 0;
        }
    }
}

// ===========================================================================================================================

for ($y = $ySquare; $y > $ySquare - $squareLen; $y--) {
    for ($x = $xSquare; $x > $xSquare - $squareLen; $x--) {
        $array[$y][$x] = "x";
    }
}

$result = "";

for ($i = 0; $i < $numberOfLines; $i++) {
    for ($j = 0; $j < $lineLength; $j++) {
        $result .= $array[$i][$j];
    }
    $result .= "\n";
}

echo $result;
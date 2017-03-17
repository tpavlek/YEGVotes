<?php

namespace Depotwarehouse\YEGVotes\Model;

class SpeakerParser
{

    public $shouldMatchByNumber = false;
    private $text;

    public function __construct($motion_description)
    {
        $motion_description = str_replace(chr(194), '', $motion_description);
        $motion_description = str_replace(chr(160), '', $motion_description);
        $withNewLines = str_ireplace([ '<br>', '<br />', '<br/>', '<p>', '</p>', '</li>' ], "\n", $motion_description);
        $withNewLines = str_ireplace('<li>', PHP_EOL . " 1. ", $withNewLines);
        $withNewLines = str_replace(chr(194), '', $withNewLines);
        $withNewLines = str_replace('&nbsp;', ' ', $withNewLines);
        $withNewLines = str_replace('&amp;', '&', $withNewLines);

        $this->text = $withNewLines;

        if (preg_match('/(?<!\.)\d\. /', $withNewLines, $matches) === 1) {
            $this->shouldMatchByNumber = true;
        }
    }


    public function parse()
    {
        $lines = explode(PHP_EOL, strip_tags($this->text));

        // Sometimes there's junk at the end of a single-line speaker list. We'll make it a single line list.
        if (count($lines) > 1 && ends_with(trim($this->text), [ 'Title:', 'Action:', 'Department:' ])) {
            $this->text = str_replace('Title:', '', $lines[0]);
            $lines = [ $this->text ];
        }

        if (count($lines) == 1 && !$this->shouldMatchByNumber) {
            $lines = preg_split('/(?=([A-Za-z]\. ))/', $this->text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            $lines = collect($lines)->filter(function($value, $key) {
                return $key % 2 == 0;
            })->all();
        }

        if (count($lines) == 1 && $this->shouldMatchByNumber) {
            // We've already removed the number from the split result, so just match regular.
            $lines = preg_split('/(?=( \d\. ))/', $this->text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            $lines = collect($lines)->filter(function($value, $key) {
                return $key % 2 == 0;
            })->all();
        }

        $speakers = [];

        foreach ($lines as $line) {

            $line = trim($line);

            if ($this->shouldMatchByNumber) {
                // If it starts with a number and a period, there's probably a name after it

                if (preg_match('/^\d\. /', $line) === 1) {
                    preg_match('/(?<=\d\. )[[:print:]’].*?((?=\d\.)|$)/', $line, $matches);

                    $speakers[] = trim($matches[0]);

                    continue;
                }
            } else {
                if (preg_match('/^(([A-Za-z]\.)|(-)|(•)) /', $line) == 1) {
                    // The line might start with a dash (to signal a list) so we trim away the dash and spaces.
                    $line = trim($line, " \t\n\r\0\x0B-•");

                    $speakers[]= strip_tags($line);
                }
            }

        }

        return $speakers;
    }


}

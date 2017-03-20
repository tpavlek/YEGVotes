<?php

namespace Depotwarehouse\YEGVotes\Model;

class PublicHearingSpeakerParser
{

    private $blocks;

    public function __construct($motion_description)
    {
        $blocks = preg_split('/(Item [\d\.]+ and )?(Bylaw|Bylaws) \d{5}.*\n/', $motion_description);

        // We don't need the preamble about calling for persons to speak
        unset($blocks[0]);

        $blocks = collect($blocks)
            ->reject(function($block) {
                return starts_with($block, 'There were no persons');
            })
            ->flatMap(function ($block) {
                return explode(PHP_EOL, $block);
            })
            ->reject(function ($block) {
                return empty($block);
            })
            ->map(function ($block) {
                return str_ireplace([ 'in favour:', 'opposed:' ], '', $block);
            });

        $this->blocks = $blocks;
    }

    /**
     * @return array
     */
    public function parse()
    {
        return $this->blocks->flatMap(function ($block) {
            $block = str_ireplace('(to answer questions only).', '(to answer questions only)', $block);
            return collect(explode(';', $block))->reject(function ($block) { return empty(trim($block)); });
        })
            ->map(function ($block) {
                return trim(preg_replace('/^and/', '', trim($block)));
            })
            ->reject(function ($block) { return empty(trim($block)); })
            ->map(function ($block) {
                if (ends_with($block, '.') && ! ends_with($block, 'Ltd.')) {
                    return substr($block, 0, strlen($block) - 1);
                }

                return $block;
            })
            ->all();
    }

}

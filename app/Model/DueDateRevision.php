<?php

namespace App\Model;

use Carbon\Carbon;

class DueDateRevision
{

    const DATE_REGEX = '/(?<=\<p\>).*?(?=<\/p>)/';
    private $item;


    public function __construct(AgendaItem $item)
    {
        $this->item = $item;
    }

    public function revisedDueDate()
    {
        $date_text = $this->item->motions->first(function (Motion $motion) {
            return $motion->isRevisedDueDate();
        });

        return $this->extractDate($date_text);
    }

    public function extractDate($text)
    {
        preg_match_all(self::DATE_REGEX, strtolower($text), $matches);

        $extracted_date = strip_tags(collect($matches)->flatten()->last());


        if (str_contains($extracted_date, [ 'quarter', 'spring', 'summer', 'fall', 'winter', 'to be determined', 'tbd', 'svcs.'])) {
            return new NullDate($extracted_date);
        }

        $replace_texts = [ '&nbsp;', 'by', 'city council', 'first item of business', 'exec. committee', 'due date'];

        foreach ($replace_texts as $replace) {
            $extracted_date = str_replace($replace, '', $extracted_date);
        }

        if (str_contains($extracted_date, '/')) {
            $slash_position = strpos($extracted_date, '/');
            $extracted_date = substr($extracted_date, 0, $slash_position - 1) . substr($extracted_date, $slash_position + 1);
        }

        return (new Carbon($extracted_date));
    }

}

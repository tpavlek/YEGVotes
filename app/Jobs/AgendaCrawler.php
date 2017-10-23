<?php

namespace App\Jobs;

use Goutte\Client;

class AgendaCrawler
{

    public function crawl($meeting_id)
    {
        $client = new Client();

        $crawler = $client->request('GET', "http://sirepub.edmonton.ca/sirepub/mtgviewer.aspx?meetid=$meeting_id&doctype=AGENDA");

        return $crawler->text();

        $result = [];
        $crawler->filter('td')->each(function ($td) use ($result) {
            $result[] = $td->text();
        });

        dd($result);
    }
}

<?php

namespace Depotwarehouse\YEGVotes\Commands;

use Depotwarehouse\YEGVotes\Model\Election\Youtube;
use League\Url\Url;

class CreateYoutubeCommand implements CreatesPostable
{


    public function handle($content, array $candidate_ids)
    {
        $url = Url::createFromUrl($content);

        $video_id = $url->getQuery()['v'];

        $yModel = new Youtube();

        $youtube = $yModel->create([
            'content' => $video_id
        ]);

        $youtube->candidates()->sync($candidate_ids);
    }
}

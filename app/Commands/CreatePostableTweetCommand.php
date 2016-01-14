<?php

namespace Depotwarehouse\YEGVotes\Commands;

use Depotwarehouse\YEGVotes\Model\Election\Tweet;

class CreatePostableTweetCommand implements CreatesPostable
{

    public function handle($tweet_url, array $candidate_ids)
    {
        $json = file_get_contents("https://api.twitter.com/1/statuses/oembed.json?url={$tweet_url}");

        $result = json_decode($json, true);

        $tweetModel = new Tweet();

        $tweet = $tweetModel->create([
            'content' => $result['html']
        ]);

        $tweet->candidates()->sync($candidate_ids);
    }

}

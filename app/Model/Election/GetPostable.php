<?php

namespace Depotwarehouse\YEGVotes\Model\Election;

use Illuminate\Support\Collection;

class GetPostable
{

    public function getApproved()
    {
        $tweetModel = new Tweet();
        $fbModel = new FacebookPost();
        $ytModel = new Youtube();
        $arbitraryModel = new ArbitraryPostable();

        /** @var \Illuminate\Support\Collection $tweets */
        $tweets = $tweetModel->approved();
        $fbPosts = $fbModel->approved();
        $videos = $ytModel->approved();
        $arbitrary = $arbitraryModel->approved();

        return $this->sort($tweets, $fbPosts, $videos, $arbitrary);
    }

    public function getUnapproved()
    {
        $tweetModel = new Tweet();
        $fbModel = new FacebookPost();
        $ytModel = new Youtube();
        $arbitraryModel = new ArbitraryPostable();

        /** @var \Illuminate\Support\Collection $tweets */
        $tweets = $tweetModel->unapproved();
        $fbPosts = $fbModel->unapproved();
        $videos = $ytModel->unapproved();
        $arbitrary = $arbitraryModel->unapproved();

        return $this->sort($tweets, $fbPosts, $videos, $arbitrary);
    }

    public function sort(Collection ...$collections)
    {
        $newCollection = new Collection();

        foreach ($collections as $collection) {
            $newCollection = $newCollection->merge($collection->values());
        }

        return $newCollection->sortByDesc(function (PostableContent $content) {
            return $content->updated_at->timestamp;
        });
    }

}

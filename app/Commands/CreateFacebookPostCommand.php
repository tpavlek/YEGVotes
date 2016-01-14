<?php

namespace Depotwarehouse\YEGVotes\Commands;

use Depotwarehouse\YEGVotes\Model\Election\FacebookPost;

class CreateFacebookPostCommand implements CreatesPostable
{

    public function handle($content, array $candidate_ids)
    {
        $fb = new FacebookPost();

        $post = $fb->create([
            'content' => $content
        ]);

        $post->candidates()->sync($candidate_ids);
    }
}

<?php

namespace Depotwarehouse\YEGVotes\Commands;

use Depotwarehouse\YEGVotes\Model\Election\ArbitraryPostable;

class CreateAribitraryPostableCommand implements CreatesPostable
{

    public function handle($content, array $candidate_ids)
    {
        $arbitraryModel = new ArbitraryPostable();

        $new = $arbitraryModel->create([
            'content' => $content
        ]);

        $new->candidates()->sync($candidate_ids);
    }
}

<?php

namespace Depotwarehouse\YEGVotes\Commands;

interface CreatesPostable
{

    public function handle($content, array $candidate_ids);

}

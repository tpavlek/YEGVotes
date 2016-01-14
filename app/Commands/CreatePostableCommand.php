<?php

namespace Depotwarehouse\YEGVotes\Commands;

use Depotwarehouse\Toolbox\DataManagement\Validation\ValidationException;
use Illuminate\Auth\Guard;
use Illuminate\Support\MessageBag;

class CreatePostableCommand
{

    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($postable_type, $content, array $candidates)
    {
        $map = [
            'tweet' => new CreatePostableTweetCommand(),
            'facebook' => new CreateFacebookPostCommand(),
            'youtube' => new CreateYoutubeCommand(),
            'other' => new CreateAribitraryPostableCommand()
        ];

        if (!array_key_exists($postable_type, $map)) {
            throw ValidationException::fromMessageBag(new MessageBag([ 'errors' => 'Do not know how to create an update of that type' ]), [ 'type' => $postable_type ]);
        }

        /** @var CreatesPostable $command */
        $command = $map[$postable_type];

        return $command->handle($content, $candidates);
    }

}

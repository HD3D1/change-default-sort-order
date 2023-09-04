<?php

namespace hd3d\ChangeDefaultSortOrder;

use Flarum\Extend;
use Flarum\Api\Controller\ListDiscussionsController;
use Flarum\Api\Event\WillGetData;
use Flarum\Discussion\DiscussionListState;

class ChangeDefaultSortOrder extends Extend
{
    public function listen()
    {
        $this->register(
            new Extend\Compat(function (Dispatcher $events) {
                $events->listen(WillGetData::class, function (WillGetData $event) {

                    if ($event->isController(ListDiscussionsController::class) && $event->getRoute()->getName() === 'search') {
                        $state = $event->getContainer()->get('flarum.discussion.list_state');

                        if (!$state->defaultSort) {
                            $state->defaultSort = ['-lastPostedAt'=>'desc'];
                        }
                    }
                });
            })
        );
    }
}
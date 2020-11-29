<?php

use Slim\App;

return function (App $app) {
    // Home Action
    $app->get('/', \App\Action\HomeAction::class);

    // App Actions
    $app->post('/channel/create',  \App\Action\ChannelCreateAction::class)->setName('channelCreate');
    $app->post('/channel/join',  \App\Action\ChannelJoinAction::class)->setName('channelJoin');
};
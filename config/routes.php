<?php

use Slim\App;

return function (App $app) {
    // Home Action
    $app->get('/', \App\Action\HomeAction::class);

    // App Actions
    $app->post('/channel/create', \App\Action\ChannelCreateAction::class)->setName('channelCreate');
    $app->post('/channel/get', \App\Action\ChannelGetAction::class)->setName('channelGet');
    $app->post('/channel/delete', \App\Action\ChannelDeleteAction::class)->setName('channelDelete');
    $app->post('/message/send', \App\Action\MessageSendAction::class)->setName('messageSend');
};
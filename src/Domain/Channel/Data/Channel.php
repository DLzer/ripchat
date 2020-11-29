<?php

namespace App\Domain\Channel\Data;

final class Channel
{
    /**
     * The channels nice name
     *
     * @var string $channelName
     */
    public $channelName;
    /**
     * The channels unique hash identifier
     *
     * @var string $channelHash
     */
    public $channelHash;
    /**
     * The channels create time in epoch
     *
     * @var int $channelCreateTime
     */
    public $createdTime;
}
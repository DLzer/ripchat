<?php

namespace App\Domain\Channel\Data;

final class Channel
{
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
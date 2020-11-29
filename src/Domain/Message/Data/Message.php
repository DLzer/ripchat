<?php

namespace App\Domain\Message\Data;

final class Channel
{
    /**
     * The message's unique hash identifier
     *
     * @var string $messageHash
     */
    public $messageHash;
    /**
     * Message Body
     *
     * @var string $messageBody
     */
    public $messageBody;
    /**
     * The message's created time in epoch
     *
     * @var int $channelCreateTime
     */
    public $createdTime;
}
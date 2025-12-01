<?php

declare(strict_types=1);

namespace App\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class JsonMessageSerializer implements SerializerInterface
{
    public function encode(Envelope $envelope): array
    {
        $message = $envelope->getMessage();

        return [
            'body' => json_encode($message, JSON_THROW_ON_ERROR),
            'headers' => [
                'type' => get_class($message),
            ],
        ];
    }

    public function decode(array $encodedEnvelope): Envelope
    {
        $type = $encodedEnvelope['headers']['type'] ?? null;

        if (!$type || !class_exists($type)) {
            throw new \RuntimeException('Unknown message type');
        }

        $data = json_decode($encodedEnvelope['body'], true, 512, JSON_THROW_ON_ERROR);

        $message = new $type(...$data);

        return new Envelope($message);
    }
}

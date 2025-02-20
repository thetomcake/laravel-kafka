<?php

namespace Junges\Kafka\Tests\Message\Serializers;

use JsonException;
use Junges\Kafka\Contracts\KafkaProducerMessage;
use Junges\Kafka\Message\Serializers\JsonSerializer;
use Junges\Kafka\Tests\LaravelKafkaTestCase as TestCase;

class JsonEncoderTest extends TestCase
{
    public function testSerialize()
    {
        $message = $this->getMockForAbstractClass(KafkaProducerMessage::class);
        $message->expects($this->once())->method('getBody')->willReturn(['name' => 'foo']);
        $message->expects($this->once())->method('withBody')->with('{"name":"foo"}')->willReturn($message);

        $encoder = $this->getMockForAbstractClass(JsonSerializer::class);

        $this->assertSame($message, $encoder->serialize($message));
    }

    public function testSerializeThrowsException(): void
    {
        $message = $this->getMockForAbstractClass(KafkaProducerMessage::class);
        $message->expects($this->once())->method('getBody')->willReturn(chr(255));

        $encoder = $this->getMockForAbstractClass(JsonSerializer::class);

        $this->expectException(JsonException::class);

        $encoder->serialize($message);
    }
}

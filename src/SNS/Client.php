<?php


namespace Mvjacobs\SnsSqsPubSub\SNS;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use Aws\Result;

class Client
{
    /** @var SnsClient */
    private $client;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = SnsClient::factory([
            'version' => '2010-03-31',
            'region' => config('sns-sqs-sub-pub.sns.region'),
            'credentials' => new Credentials(
                config('sns-sqs-sub-pub.sns.key'),
                config('sns-sqs-sub-pub.sns.secret')
            ),
            'endpoint' =>
                // when using aws sns locally (eg. localstack: 'http://localhost:4566')
                config('sns-sqs-sub-pub.sns.endpoint', null)
        ]);
    }

    /**
     * @param string $topicArn
     * @param string $message
     * @return Result
     */
    public function publish(string $topicArn, string $message)
    {
        return $this->client->publish([
            "Message" => $message,
            "TopicArn" => $topicArn,
        ]);
    }
}

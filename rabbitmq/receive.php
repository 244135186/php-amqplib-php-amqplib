<?php
require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'password'); // 根据需要修改
$channel = $connection->channel();

$channel->queue_declare('test_queue', false, false, false, false, false, []);

$callback = function ($msg) {
    echo " [x] Received '{$msg->body}'\n";
};

$channel->basic_consume('test_queue', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();

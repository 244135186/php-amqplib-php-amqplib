<?php
require 'vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 使用 AMQPStreamConnection
$connection = new AMQPStreamConnection('localhost', 5672, 'user', 'password');
$channel = $connection->channel();
$channel->queue_declare('my_queue', false, true, false, false, false, []);
$data = 'Hello, RabbitMQ!';
$msg = new AMQPMessage($data);
$channel->basic_publish($msg, '', 'my_queue');

echo " [x] Sent '$data'\n";

$channel->close();
$connection->close();

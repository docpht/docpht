<?php
use geertw\IpAnonymizer\IpAnonymizer;

require 'vendor/autoload.php';

$ipAnonymizer = new IpAnonymizer();

var_dump($ipAnonymizer->anonymize('127.0.0.1'));
// returns 127.0.0.0

var_dump($ipAnonymizer->anonymize('192.168.178.123'));
// returns 192.168.178.0

var_dump($ipAnonymizer->anonymize('8.8.8.8'));
// returns 8.8.8.0

var_dump($ipAnonymizer->anonymize('::1'));
// returns ::

var_dump($ipAnonymizer->anonymize('::127.0.0.1'));
// returns ::

var_dump($ipAnonymizer->anonymize('2a03:2880:2110:df07:face:b00c::1'));
// returns 2a03:2880:2110:df07::

var_dump($ipAnonymizer->anonymize('2610:28:3090:3001:dead:beef:cafe:fed3'));
// returns 2610:28:3090:3001::

// Use a custom mask:
$ipAnonymizer->ipv4NetMask = "255.255.0.0";
var_dump($ipAnonymizer->anonymize('192.168.178.123'));
// returns 192.168.0.0

// You can use this class also in a static way:
var_dump(IpAnonymizer::anonymizeIp('192.168.178.123'));
// returns 192.168.178.0

var_dump(IpAnonymizer::anonymizeIp('2610:28:3090:3001:dead:beef:cafe:fed3'));
// returns 2610:28:3090:3001::

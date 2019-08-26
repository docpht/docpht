[![Latest Stable Version](https://img.shields.io/packagist/v/geertw/ip-anonymizer.svg)](https://packagist.org/packages/geertw/ip-anonymizer)
[![Total Downloads](https://img.shields.io/packagist/dt/geertw/ip-anonymizer.svg)](https://packagist.org/packages/geertw/ip-anonymizer)
[![License](https://img.shields.io/packagist/l/geertw/ip-anonymizer.svg)](https://packagist.org/packages/geertw/ip-anonymizer)

# IP address anonymizer for PHP

This is a library for PHP to anonymize IP addresses. This makes it easier to respect user privacy, and it makes it more
difficult to identify an end user by his IP address. Anonymizing IP addresses can be useful for a lot of cases where the
exact IP address is not important or even undesired, for example in a statistical analysis.

This library supports both IPv4 and IPv6 addresses. Addresses are anonymized to their network ID.

The default settings anonymize an IP address to a /24 subnet (IPv4) or a /64 subnet (IPv6), but these can be customized.

For instance, the IPv4 address `192.168.178.123` is anonymized by default to `192.168.178.0`.

The IPv6 address `2a03:2880:2110:df07:face:b00c::1` is anonymized by default to `2610:28:3090:3001::`.

## Example

```php
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
```

## License

This library is licensed under the MIT License. See the LICENSE file for the full license.

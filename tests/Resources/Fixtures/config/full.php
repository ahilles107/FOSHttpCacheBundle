<?php

/*
 * This file is part of the FOSHttpCacheBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$container->loadFromExtension('fos_http_cache', [
    'cache_control' => [
        'defaults' => [
            'overwrite' => true,
        ],
        'rules' => [
            [
                'match' => [
                    'path' => '/abc',
                    'host' => 'fos',
                    'methods' => ['GET', 'POST'],
                    'ips' => ['1.2.3.4', '1.1.1.1'],
                    'attributes' => ['_controller' => 'fos.user_bundle.*'],
                    'additional_cacheable_status' => [100, 500],
                ],
                'headers' => [
                    'overwrite' => false,
                    'cache_control' => [
                        'max_age' => 1,
                        's_maxage' => 2,
                        'public' => true,
                        'must_revalidate' => true,
                        'proxy_revalidate' => false,
                        'no_transform' => true,
                        'no_cache' => false,
                        'stale_if_error' => 3,
                        'stale_while_revalidate' => 4,
                    ],
                    'etag' => true,
                    'last_modified' => '-1 hour',
                    'reverse_proxy_ttl' => 42,
                    'vary' => ['Cookie', 'Authorization'],
                ],
            ],
        ],
    ],
    'proxy_client' => [
        'varnish' => [
            'http' => [
                'servers' => ['22.22.22.22'],
                'base_url' => '/test',
                'http_client' => 'acme.guzzle.varnish',
            ],
        ],
    ],

    'cache_manager' => [
        'enabled' => true,
        'custom_proxy_client' => 'acme.proxy_client',
    ],
    'tags' => [
        'header' => 'FOS-Tags',
        'expression_language' => 'acme.expression_language',
        'rules' => [
            [
                'match' => [
                    'path' => '/def',
                    'host' => 'friends',
                    'methods' => ['PUT', 'DELETE'],
                    'ips' => '99.99.99.99',
                    'attributes' => [
                        '_foo' => 'bar',
                    ],
                    'additional_cacheable_status' => [501, 502],
                ],
                'tags' => ['a', 'b'],
                'tag_expressions' => ['"a"', '"b"'],
            ],
        ],
    ],
    'invalidation' => [
        'enabled' => 'auto',
        'expression_language' => 'acme.expression_language',
        'rules' => [
            [
                'match' => [
                    'path' => '/hij',
                    'host' => 'symfony',
                    'methods' => ['PATCH'],
                    'ips' => ['42.42.42.42'],
                    'attributes' => [
                        '_format' => 'json',
                    ],
                    'additional_cacheable_status' => [404, 403],
                ],
                'routes' => [
                    'invalidate_route1' => [
                        'ignore_extra_params' => false,
                    ],
                ],
            ],
        ],
    ],
    'user_context' => [
        'enabled' => true,
        'match' => [
            'matcher_service' => 'fos_http_cache.user_context.request_matcher',
            'accept' => 'application/vnd.fos.user-context-hash',
            'method' => 'GET',
        ],
        'hash_cache_ttl' => 300,
        'always_vary_on_context_hash' => true,
        'user_identifier_headers' => ['Cookie', 'Authorization'],
        'user_hash_header' => 'FOS-User-Context-Hash',
        'role_provider' => true,
    ],
    'flash_message' => [
        'enabled' => true,
        'name' => 'flashtest',
        'path' => '/x',
        'host' => 'y',
        'secure' => true,
    ],
    'debug' => [
        'header' => 'FOS-Cache-Debug',
    ],
]);

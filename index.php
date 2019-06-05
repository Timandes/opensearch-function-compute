<?php
/*
   Copyright 2019 Timandes White

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
*/

use RingCentral\Psr7\Response;
use OpenSearch\Client\OpenSearchClient;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

function handler($request, $context): Response
{
    $requestURI = $request->getAttribute('requestURI');

    $query = parse_url($requestURI, PHP_URL_QUERY);

    $params = [];
    parse_str($query, $params);

    $client = new OpenSearchClient($GLOBALS['gsAccessKey'],
        $GLOBALS['gsAccessKeySecret'],
        $GLOBALS['gsAPIEndpoint'],
        $GLOBALS['gaClientOptions']);
    $uri = '/v3/openapi/apps/' . $GLOBALS['gsAppName'] . '/search';
    $response = $client->request($uri, $params, '', 'GET');

    return new Response(
        200,
        [],
        $response->result
    );
}

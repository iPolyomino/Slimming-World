<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

require_once 'bmi_status.php';

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $file = '../public/index.html';
        $response->getBody()->write(file_get_contents($file));
        return $response;
    });

    $app->post('/bmi', function (Request $request, Response $response) {
        $contents = $request->getBody()->getContents();
        $personalData = json_decode($contents, true);
        $height = $personalData['height'] / 100;
        $weight = $personalData['weight'];
        $bmi = $weight / $height ** 2;
        $responseData = array('bmi' => $bmi, 'status' => bmi_status($bmi));
        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};

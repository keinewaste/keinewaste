<?php


use Silex\Application;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

date_default_timezone_set('Europe/Berlin');

$diContainer = require(__DIR__ . '/../src/di.php');


$cors = [
    'Access-Control-Allow-Origin'      => '*',
    'Access-Control-Allow-Methods'     => 'GET, PUT, DELETE, OPTIONS, POST',
    'Access-Control-Allow-Headers'     => 'Content-Type, Authorization',
    'Access-Control-Allow-Credentials' => 'true'
];

/**
 * @var \KeineWaste\Application\Base $app
 */
$app = $diContainer->get('App');

/**
 * @var \Psr\Log\LoggerInterface $logger
 */
$logger = $diContainer->get('Logger');


$controllerExceptionHandler = function (\Exception $e) use ($logger, $app) {
    $requestData = !empty($app['request']) ? (string)$app['request'] : null;
    $data        = [];
    if ($e instanceof HttpException) {
        $status  = $e->getStatusCode();
        $message = $e->getMessage();
        if (empty($message)) {
            $message = isset(JsonResponse::$statusTexts[$status]) ? JsonResponse::$statusTexts[$status] : 'An error has occurred';
        }
        if (isset($e->getPrevious()->details)) {
            $data['details'] = $e->getPrevious()->details;
        }
        $logger->warning('Http exception', array('exception' => $e, 'request' => $requestData));
    } else {
        $status  = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $message = JsonResponse::$statusTexts[$status];
        $logger->error('Controller threw an Exception', array('exception' => $e, 'request' => $requestData));
    }
    $data = array_merge(
        $data, [
            'code'    => $status,
            'message' => $message
        ]
    );

    return new JsonResponse(
        $data,
        $status,
        array('X-Status-Code' => $status)
    );
};

$app->error(
    $controllerExceptionHandler
);

$app->before(
    function (\Symfony\Component\HttpFoundation\Request $request, \KeineWaste\Application\Application $app) use ($cors) {
        if ($request->getMethod() == 'OPTIONS') {
            $response = new \Symfony\Component\HttpFoundation\Response();
            $response->headers->add($cors);
            return $response
                ->setStatusCode(200);
        }
    }, Application::EARLY_EVENT
);

$app->after(
    function (\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\HttpFoundation\Response $response) use ($cors) {
        $response->headers->add($cors);
        return $response;
    }
);


$globalExceptionHandler = ExceptionHandler::register($app['debug']);
$globalExceptionHandler->setHandler(
    function (\Exception $e) use ($logger) {
        $logger->emergency('An error has occurred', array('exception' => $e));
        $message = 'Internal Server Error';
        ob_end_clean();
        header('Content-Type: application/json');
        header("Status: 500 $message");
        echo json_encode(array('message' => $message));
    }
);


$app->run();

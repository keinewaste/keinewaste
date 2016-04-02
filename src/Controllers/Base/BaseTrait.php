<?php

namespace KeineWaste\Controllers\Base;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use KeineWaste\Config\General as GeneralConfig;

trait BaseTrait
{
    /**
     * @var JsonResponse
     */
    protected $response;

    /**
     * @var GeneralConfig
     */
    protected $config;


    /**
     * Set Response
     *
     * @param JsonResponse $response Response
     *
     * @return void
     */
    public function setResponse(JsonResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Get Response
     *
     * @return JsonResponse
     */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * Set Config
     *
     * @param GeneralConfig $config Config
     *
     * @return void
     */
    public function setConfig(GeneralConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Get Config
     *
     * @return Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * Finish handling and return response with error message
     *
     * @param int         $httpStatusCode HTTP status code
     * @param \Exception  $exception      Exception
     * @param int|null    $errorCode      Error code
     * @param int|null    $appDomain      App domain
     * @param string|null $locale         Locale
     *
     * @throws HttpException
     *
     * @return void
     */
    protected function triggerError($httpStatusCode, $exception = null, $errorCode = null, $appDomain = null, $locale = null)
    {
        $message = $this->getExceptionTranslation($errorCode, $appDomain, $locale);
        throw new HttpException($httpStatusCode, $message, $exception, [], $errorCode);
    }

    /**
     * Returns translated exception
     *
     * @param string $errorCode Error code
     * @param string $appDomain App domain
     * @param string $locale    Locale
     *
     * @return string|null
     */
    protected function getExceptionTranslation($errorCode, $appDomain, $locale)
    {
        $message = 'Exception: ' . $errorCode;
        return $message;
    }
}
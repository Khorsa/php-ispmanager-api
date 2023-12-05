<?php

namespace Khorsa\IspManagerApi;

abstract class IspFunctionsAbstract
{
    private ?IspAccessData $ispAccessData = null;

    public function __construct(
        private readonly IspConnection $ispConnection,
    ) {
    }

    public function setAccessData(IspAccessData $ispAccessData): void
    {
        $this->ispAccessData = $ispAccessData;
    }

    /**
     * @throws IspException
     */
    protected function executeByParameters(string $function, array $parameters = []): array
    {
        $link = $this->formLink($function, $parameters);
        $response = $this->ispConnection->call($link);

        return $this->decodeResponse($function, $response);
    }

    private function decodeResponse(string $function, string $response): array
    {
        $decoded = json_decode($response, true);

        if (!is_array($decoded)) {
            throw new IspException('Parse error: '.$response);
        }

        if (isset($decoded['doc']['error']['detail']['$'])) {
            $message = $decoded['doc']['error']['detail']['$'];
            try {
                foreach ($decoded['doc']['error']['param'] as $param) {
                    $message = str_replace('__'.$param['$name'].'__', $param['$'], $message);
                }
            } catch (\Exception $exception) {
                throw new IspException('Parse error: ('.$exception->getMessage().')'.trim($response));
            }
            throw new IspException("Execution $function error: ".trim($message));
        }

        return $decoded;
    }

    protected function formLink(string $command, array $parameters): string
    {
        if (null === $this->ispAccessData) {
            throw new IspException('Need to set AccessData');
        }
        $link = $this->ispAccessData->getSiteUrl()."?out=sjson&authinfo={$this->ispAccessData->login}:{$this->ispAccessData->password}";
        $link .= '&func='.$command;
        foreach ($parameters as $key => $value) {
            $link .= "&$key=$value";
        }

        return $link;
    }

    protected function getKeyLoginLink(string $user, string $key): string
    {
        if (null === $this->ispAccessData) {
            throw new IspException('Need to set AccessData');
        }

        return $this->ispAccessData->getSiteUrl()."?func=auth&username=$user&key=$key&checkcookie=no";
    }
}

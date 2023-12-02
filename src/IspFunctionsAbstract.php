<?php

namespace IspManagerApi;

abstract class IspFunctionsAbstract
{
    public function __construct(
        private readonly IspAccessData $ispAccessData,
        private readonly IspConnection $ispConnection,
    ) {
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
                throw new IspException('Parse error: '.trim($response));
            }
            throw new IspException("Execution {$function} error: ".trim($message));
        }

        return $decoded;
    }

    protected function formLink(string $command, array $parameters): string
    {
        $link = $this->ispAccessData->getSiteUrl()."?out=sjson&authinfo={$this->ispAccessData->login}:{$this->ispAccessData->password}";
        $link .= '&func='.$command;
        foreach ($parameters as $key => $value) {
            $link .= "&$key=$value";
        }

        return $link;
    }

    protected function getKeyLoginLink(string $user, string $key): string
    {
        return $this->ispAccessData->getSiteUrl()."?func=auth&username={$user}&key={$key}&checkcookie=no";
    }
}

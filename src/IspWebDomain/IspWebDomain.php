<?php

namespace IspManagerApi\IspWebDomain;

use IspManagerApi\IspException;
use IspManagerApi\IspFunctionsAbstract;

class IspWebDomain extends IspFunctionsAbstract
{
    /**
     * @return IspWebDomainDto[]
     *
     * @throws IspException
     */
    public function list(): array
    {
        $result = $this->executeByParameters('webdomain');

        $data = [];
        foreach ($result['doc']['elem'] as $elem) {
            $database = null;
            if (isset($elem['database']['$']) && 'Notused' !== $elem['database']['$']) {
                $database = $elem['database']['$'];
            }
            $data[] = new IspWebDomainDto(
                (int) $elem['id']['$'],
                $elem['name']['$'] ?? '',
                ($elem['active']['$'] ?? '') === 'on',
                $elem['ipaddr']['$'] ?? 'unknown',
                $database,
                $elem['docroot']['$'] ?? '',
                $elem['handler']['$'] ?? '',
                $elem['owner']['$'] ?? 'unknown',
                $elem['php_mode']['$'] ?? '',
                $elem['php']['$'] ?? '',
                $elem['php_version']['$'] ?? '',
                ($elem['secure']['$'] ?? '') === 'on',
            );
        }

        return $data;
    }
}

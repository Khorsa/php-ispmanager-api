<?php

namespace IspManagerApi\IspUser;

use IspManagerApi\IspException;
use IspManagerApi\IspFunctionsAbstract;

class IspUser extends IspFunctionsAbstract
{
    /**
     * Return list of IspManager users.
     *
     * @return IspUserDto[]
     *
     * @throws IspException
     */
    public function list(): array
    {
        $result = $this->executeByParameters('user');

        $data = [];
        foreach ($result['doc']['elem'] as $elem) {
            $data[] = new IspUserDto(
                $elem['name']['$'],
                ($elem['active']['$'] ?? '') === 'on',
                $elem['fullname']['$'] ?? '',
                $elem['quota_total']['$'] ?? null,
                (int) ($elem['quota_used']['$'] ?? 0),
            );
        }

        return $data;
    }

    /**
     * Suspend user with $userName.
     *
     * @throws IspException
     */
    public function suspend(string $userName): void
    {
        $result = $this->executeByParameters('user.suspend', ['elid' => $userName]);
        if (!isset($result['doc']['ok'])) {
            throw new IspException('ISP User suspend error, '.$userName);
        }
    }

    /**
     * Resume user with $userName.
     *
     * @throws IspException
     */
    public function resume(string $userName): void
    {
        $result = $this->executeByParameters('user.resume', ['elid' => $userName]);
        if (!isset($result['doc']['ok'])) {
            throw new IspException('ISP User resume error, '.$userName);
        }
    }

    /**
     * @throws IspException
     */
    public function getRedirectLink(string $user): string
    {
        $key = md5(uniqid('', true));

        $result = $this->executeByParameters('session.newkey', ['key' => $key]);

        if (!isset($result['doc']['ok'])) {
            throw new IspException('ISP RedirectLink error '.$user);
        }

        return $this->getKeyLoginLink($user, $key);
    }
}

# php-ispmanager-api
API для ISPManager 6

_В разработке, текущая версия - 0.3.0 (05.12.2023)_

## Текущий список реализованных функций:

- user.suspend - отключить пользователя - IspUser::suspend($username)
- user.resume - включить пользователя - IspUser::resume($username)
- user.delete - удалить пользователя - IspUser::delete($username)
- webdomain - получить список веб-доменов - IspWebDomain::list($username)

## Использование
````
class Manage()
{
    public function __construct(
        private readonly IspUser $ispUser,
    ){
        $this->ispUser->setAccessData(new IspAccessData(
            'https',
            'fake-site.com',
            1500,
            'login',
            'password',
        ));
    }

    public function turnOff(string $username): void
    {
        try {
            $this->ispUser->suspend($username);
        } catch(IspException $ex) {
            print $ex->getMessage();
        }
    }
}
````



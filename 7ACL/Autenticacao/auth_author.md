# ALC é composta principalmente por dois elementos: autenticação e autorização.

No Laravel authentication é um componente que instalamos e está pronto, out of box.

A autorização é mais complexa, com vários componentes e tem como principais elementos o Gate e o Policy. Através de gates se implementa roles e permissions.

A autenticação filtra quem entra/loga no aplicativo.

Os que conseguiram entrar pela autenticação serão verificados pela autorização, que checa quem tem permissão para acesssar cada seção do aplicativo e quem não tem.

Authentication - https://laravel.com/docs/8.x/authentication

Authorization - https://laravel.com/docs/8.x/authorization


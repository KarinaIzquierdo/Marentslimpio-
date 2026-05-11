<?php

use Illuminate\Support\Str;

return [
/*
|--------------------------------------------------------------------------
| Controlador de Sesión Predeterminado
|--------------------------------------------------------------------------
|
| Esta opción determina el controlador de sesión predeterminado que se utiliza
| para las solicitudes entrantes. Laravel admite una variedad de opciones de
| almacenamiento para persistir los datos de sesión. El almacenamiento en base
| de datos es una excelente opción por defecto.
|
| Soportados: "file", "cookie", "database", "memcached",
|             "redis", "dynamodb", "array"
|
*/

    'driver' => env('SESSION_DRIVER', 'database'),

   /*
|--------------------------------------------------------------------------
| Duración de la Sesión
|--------------------------------------------------------------------------
|
| Aquí puedes especificar el número de minutos que deseas que la sesión
| permanezca inactiva antes de expirar. Si quieres que expire inmediatamente
| al cerrar el navegador, puedes indicarlo mediante la opción de configuración
| expire_on_close.
|
*/

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
|--------------------------------------------------------------------------
| Encriptación de la Sesión
|--------------------------------------------------------------------------
|
| Esta opción te permite especificar fácilmente que todos los datos de tu
| sesión deben ser encriptados antes de ser almacenados. Toda la encriptación
| es realizada automáticamente por Laravel y puedes usar la sesión de forma normal.
|
*/

    'encrypt' => env('SESSION_ENCRYPT', false),

   /*
|--------------------------------------------------------------------------
| Ubicación de los Archivos de Sesión
|--------------------------------------------------------------------------
|
| Cuando se utiliza el controlador de sesión "file", los archivos de sesión
| se almacenan en el disco. La ubicación de almacenamiento predeterminada se
| define aquí; sin embargo, puedes indicar otra ubicación donde deban guardarse.
|
*/

    'files' => storage_path('framework/sessions'),

    /*
|--------------------------------------------------------------------------
| Conexión de Base de Datos de la Sesión
|--------------------------------------------------------------------------
|
| Cuando se utilizan los controladores de sesión "database" o "redis",
| puedes especificar una conexión que se usará para gestionar estas sesiones.
| Esta debe corresponder a una conexión definida en las opciones de
| configuración de tu base de datos.
|
*/

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table to
    | be used to store sessions. Of course, a sensible default is defined
    | for you; however, you're welcome to change this to another table.
    |
    */

    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using one of the framework's cache driven session backends, you may
    | define the cache store which should be used to store the session data
    | between requests. This must match one of your defined cache stores.
    |
    | Affects: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the session cookie that is created by
    | the framework. Typically, you should not need to change this value
    | since doing so does not grant a meaningful security improvement.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application, but you're free to change this when necessary.
    |
    */

    'path' => env('SESSION_PATH', '/'),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | This value determines the domain and subdomains the session cookie is
    | available to. By default, the cookie will be available to the root
    | domain without subdomains. Typically, this shouldn't be changed.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By setting this option to true, session cookies will only be sent back
    | to the server if the browser has a HTTPS connection. This will keep
    | the cookie from being sent to you when it can't be done securely.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol. It's unlikely you should disable this option.
    |
    */

    'http_only' => env('SESSION_HTTP_ONLY', true),

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" to permit secure cross-site requests.
    |
    | See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will tie the cookie to the top-level site for
    | a cross-site context. Partitioned cookies are accepted by the browser
    | when flagged "secure" and the Same-Site attribute is set to "none".
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Serialization
    |--------------------------------------------------------------------------
    |
    | This value controls the serialization strategy for session data, which
    | is JSON by default. Setting this to "php" allows the storage of PHP
    | objects in the session but can make an application vulnerable to
    | "gadget chain" serialization attacks if the APP_KEY is leaked.
    |
    | Supported: "json", "php"
    |
    */

    'serialization' => 'json',

];

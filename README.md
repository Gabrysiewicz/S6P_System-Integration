<table align='center'>
  <tr> <td colspan='3'> <img width="884px" > </td> </tr>
  <tr> <td colspan="3" align='center'> <img src='https://github.com/Gabrysiewicz/Programowanie-aplikacji-w-chmurze-obliczeniowe/blob/main/logo_politechniki_lubelskiej.jpg' width="400px" height="400px"></td> </tr>
  <tr> <td> Kamil Gabrysiewicz </td> <td> Index: 95400 </td> <td> Group: 6.3 </td> </tr>  
  <tr> <td> Jakub Dudek </td> <td> Index: 95391 </td> <td> Group: 6.3 </td> </tr>  
  <tr> <td> Session 6 </td> <td colspan='2' align='center'> System Integration </td> </tr>  
</table>

# Statistical Data Summary on Games on Steam and Epic Games Store Platforms

## Project:
- carried out in two-person groups
- must be implemented using technologies presented in the script
- must be presented to the instructor and submitted by the penultimate class at the latest
- integrated data stored in files or a database must be relevant to the project topic
- a graphical interface is required, allowing actions to be performed and data to be presented
- Below is the scoring for individual implemented functionalities

### In the project:
- [X] export/import from XML file – 5 pts
- [X] export/import from JSON/YAML file – 5 pts
- [X] export/import from a database – 5 pts
- [X] use of ORM for database access – 5 pts
- [X] use of SOAP services – 5 pts
- [X] use of REST services – 5 pts
- [X] use of Docker containers – 5 pts
- [X] use of authentication and authorization mechanisms with JWT tokens – 5 pts
- [X] use of isolation levels in the database – 5 pts

# Required tech
Web App:
- Laravel 10
- Composer 2.5.8
- PHP 8.2.4

Client Soap:
- .NET 6

# Installation guide
1. Unpack project

2. Go to the project directory:
```
cd Project/project
```

3. Install Composer dependencies:
```
composer install
```

4.Copy the content of `.env.example` to `.env`:
```
cp .env.example .env
```

5. Generate App key:
```
php artisan key:generate
```

5.5. Generate secret key
```
php artisan jwt:secret
```

6. Install and configure the Sail tool, which will allow you to run Docker containers (you should select MySQL [0]):
```
php artisan sail:install
```

7. Clear the application's cached data before starting the containers
```
php artisan optimize:clear
```

8. Run the app:
```
./vendor/bin/sail up -d
```

9. Clear already existing migrations
```
./vendor/bin/sail artisan migrate:fresh
```

9.5 It may be necessary to change permissions
```
chmod 777 -R *
```

10. Closing the application (inside the project directory)
```
./vendor/bin/sail down
```
# Description
The project presents a summary of data on games from the Steam and Epic Games Store platforms. It allows users to register, log in, import/export data, and display it on a web page.

Data for the project is located in the `datasets` directory.  
You need to import one of the files:  
- `games.csv`  
- `games.json`  
- `games.xml`  

To enable import/export, you must create an account via `Create an account` in the login section.  

The application runs on port `8000`, so the project address is `localhost:8000`.

# XML 
Importing `.xml` files is only possible if the file has the following structure:

As a single element
```
<game>
    <name>Example Game 1</name>
    <developers>
        <developer>Example Developer</developer>
    </developers>
    <publishers>
        <publisher>Example Publisher</publisher>
    </publishers>
    <genres>
        <genre>Action</genre>
        <genre>Adventure</genre>
    </genres>
    <steam>
        <release_date>2023-06-01</release_date>
        <price>19.99</price>
    </steam>
    <epic>
        <release_date>2023-06-15</release_date>
        <price>14.99</price>
    </epic>   
</game>
```

As an array of elements
```
<games>
    <game>
        <name>Example Game 1</name>
        <developers>
            <developer>Example Developer</developer>
        </developers>
        <publishers>
            <publisher>Example Publisher</publisher>
        </publishers>
        <genres>
            <genre>Action</genre>
            <genre>Adventure</genre>
        </genres>
        <steam>
            <release_date>2023-06-01</release_date>
            <price>19.99</price>
        </steam>
        <epic>
            <release_date>2023-06-15</release_date>
            <price>14.99</price>
        </epic>
    </game>
    <game>
        <name>Example Game 2</name>
        <developers>
            <developer>Example Developer</developer>
        </developers>
        <publishers>
            <publisher>Example Publisher</publisher>
            <publisher>Example Publisher 2</publisher>
        </publishers>
        <genres>
            <genre>Action</genre>
            <genre>Adventure</genre>
        </genres>
        <steam>
            <release_date>2023-06-01</release_date>
            <price>19.99</price>
        </steam>
        <epic>
            <release_date>2023-06-15</release_date>
            <price>14.99</price>
        </epic>
    </game>
</games>
```

# JSON
A `.json` file must have the following keys: `name`, `developer`, `publisher`, `genre`, `steam: price`, `release_date`, `epic: price`, `release_date`.  
For the keys `developer`, `publisher`, and `genre`, multiple values can be provided by placing them in an array `[" ", " "]`.  

Importing `.json` files is only possible if the file has the following structure:

As a single object
```
{
    "name": "Test1",
    "developer": "Developer1",
    "publisher": "Publisher1",
    "genre": ["Action"],
    "steam": {
        "price": "14.99",
        "release_date": "06.06.2023"
    },
    "epic": {
        "price": "19.99",
        "release_date": "31.09.2008"
    }
}
```

As an array of objects
```
[
    {
        "name": "Test1",
        "developer": "Developer1",
        "publisher": "Publisher1",
        "genre": "Action",
        "steam": {
            "price": "19.99",
            "release_date": "06.06.2023"
        },
        "epic": {
            "price": "14.99",
            "release_date": "31.09.2008"
        }
    },
    {
        "name": "Test2"
        "developer": ["Developer2", "Developer3"],
        "publisher": ["Publisher2", "Publisher3"],
        "genre": "Adventure",
        "steam": {
            "price": "29.99",
            "release_date": "06.06.2023"
        },
        "epic": {
            "price": "24.99",
            "release_date": "29.09.2023"
        }
    }
]
```

# DB
Importing `.csv` files is only possible if the file has the following structure:

```
name;developer;publisher;genre;release_date_steam;price_steam;release_date_epic;price_epic
Test1;Developer1;Publisher1;Action;31.09.2008;19.99;29.09.2008;14,99
Test2;"Developer2;Developer3";"Publisher2;Publisher3";"Adventure;Indie";31.09.2008;29.99;29.09.2008;24,99
```

The first row must contain column headers.  
Columns must be separated by the ";" character.  
For the columns `developer`, `publisher`, and `genre`, multiple values can be provided by separating them with the ";" character.

Diagram ERD

<img src="https://github.com/Gabrysiewicz/S6P_Integracja_systemow/blob/main/images/erd.png" >

Relationships
- One-to-one:
    - `game` and `steam` – a game can have Steam-specific information in the `steam` table
    - `game` and `epic` – a game can have Epic Games-specific information in the `epic` table
- One-to-many:
    - `user` and `game` – one user can add many games, but one game is added by a single user
- Many-to-many:
    - `game` and `genre` – a game can belong to multiple genres, and a genre can be assigned to multiple games
    - `developer` and `game` – a developer can have multiple games, and a game can be created by multiple developers
    - `publisher` and `game` – a publisher can have multiple games, and a game can be published by multiple publishers

Starting the MySQL console in the container
```
docker exec -it [ container-id / container-tag ] mysql -u sail -h mysql -D laravel -p
```

Changing the role to `admin` for the user with ID `3`
```
UPDATE user SET role = "admin" WHERE id = 3;
```

# ORM
ORM is implemented via Laravel's Eloquent
```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

# SOAP
The SOAP server is created along with the WSDL file using the NuSOAP library
```
composer require econea/nusoap
```

Creating a route in the `routes/api.php` file to receive the WSDL file, along with a function to fetch the game name based on the provided ID from the client side
```
Route::any('soap', function() {
    $server = new \nusoap_server();

    $server->configureWSDL('GameService', false, url('api/soap'));

    $server->soap_defencoding = 'UTF-8';
    $server->decode_utf8 = FALSE;

    function GetGameName($gameId)
    {
        $game = Game::find($gameId);

        // Sprawdź, czy gra o podanym id istnieje
        if (!$game) {
            return null;
        }
        
        $gameName = $game->name;

        return $gameName;
    }

    // Dodanie funkcji do SOAP
    $server->register('GetGameName',
        array('id' => 'xsd:string'),
        array('result' => 'xsd:string'),
    );

    $rawPostData = file_get_contents("php://input");
    return response($server->service($rawPostData), 200, array('Content-Type' => 'text/xml; charset=UTF-8'));
});
```

It is important to modify the lines responsible for WSDL file encoding in the configuration file `/vendor/econea/nusoap/src/nusoap.php`.  
This is required to connect to the service from the client side.

Before the change
```
var $soap_defencoding = 'ISO-8859-1';
//var $soap_defencoding = 'UTF-8';

$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>';
```

After change:
```
//var $soap_defencoding = 'ISO-8859-1';
var $soap_defencoding = 'UTF-8';

$xml = '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?>';
```
The SOAP client was created using the WCF Web Service tool available in Visual Studio, which allows connecting a .NET project to a web service.  
This tool generates all the code and references after providing the service address.

The main program code that retrieves the game name based on the provided ID:
```
private async Task GetNameAsync(string id)
{
    GameServicePortTypeClient client = new GameServicePortTypeClient();
    GetGameNameResponse response = await client.GetGameNameAsync(id);
    if (response.result == null)
    {
        wynikLabel.Text = "Nazwa gry: Brak gry o podanym id";
    }
    else
    {
        wynikLabel.Text = $"Nazwa gry: {response.result}";
    }
}
```

The appearance of the application is created using Windows Forms

<img src="https://github.com/Gabrysiewicz/S6P_Integracja_systemow/blob/main/images/soapclient.png" >

# REST
The REST API is implemented using JWT. In Laravel, to start implementing the API, you need to create the appropriate controller using the corresponding model:
```
sail artisan make:controller ApiController --resource --model=Game
```

The above command will create a controller (`make:controller`) named `ApiController`,  
based on the `Game` model (`--model=Game`), and by default will declare the necessary functions:  
- `index`  
- `create`  
- `store`  
- `show`  
- `edit`  
- `update`  
- `destroy`  

In the `routes/api.php` file, we need to declare the routes for our API:

```
// Route::resource('games', ApiController::class );

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', [UserController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::get('games', [ApiController::class, 'index']);
    Route::post('games', [ApiController::class, 'store']);
    Route::get('games/{game}', [ApiController::class, 'show']);
    Route::put('games/{game}', [ApiController::class, 'update']);
    Route::delete('games/{game}', [ApiController::class, 'destroy']);
});
```
*The commented line allows very simplified access to all functions (`index`, `edit`, `delete`, etc.)*

Access to the API is by default via the route `localhost/api`, e.g., (POST) `localhost/api/login`  
with the login and password provided in the body to obtain a JWT token.

API routing can be configured in `Providers/RouteServiceProvider.php` in the `boot()` function:
```
public function boot(): void
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
    });

    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));


        Route::middleware('web')
            ->group(base_path('routes/web.php'));

    });
}
```

Index view for a client with the `user` role
```
{
    "status": 1,
    "data": [
        {
            "id": 193,
            "name": "New Game",
            "user_id": 3,
            "created_at": "2023-06-07T23:04:56.000000Z",
            "updated_at": "2023-06-07T23:04:56.000000Z"
        },
    [...]
    ]
}
```

Index view for a client with the `admin` role
```
{
"status": 1,
    "data": [
        {
            "id": 193,
            "name": "New Game",
            "user_id": 3,
            "created_at": "2023-06-07T23:04:56.000000Z",
            "updated_at": "2023-06-07T23:04:56.000000Z",
            "developers": [
                {
                    "id": 2,
                    "name": "Hidden Path Entertainment",
                    "pivot": {
                        "game_id": 193,
                        "developer_id": 2
                    }
                },
                {
                    "id": 1,
                    "name": "id Software",
                    "pivot": {
                        "game_id": 193,
                        "developer_id": 1
                    }
                }
            ],
            "publishers": [
                {
                    "id": 3,
                    "name": "Warner Bros. Interactive Entertainment",
                    "pivot": {
                        "game_id": 193,
                        "publisher_id": 3
                    }
                }
            ],
            "user": {
                "id": 3,
                "email": "admin@wp.pl",
                "role": "admin",
                "created_at": "2023-06-07T22:47:39.000000Z",
                "updated_at": "2023-06-07T22:47:39.000000Z"
            },
            "steam": {
                "id": 193,
                "price": "9.99",
                "release_date": "2023-06-06",
                "game_id": 193,
                "created_at": null,
                "updated_at": null
            },
            "epic": {
                "id": 193,
                "price": "9.99",
                "release_date": "2023-06-06",
                "game_id": 193,
                "created_at": null,
                "updated_at": null
            },
            "genres": [
                {
                    "id": 4,
                    "name": "Adventure",
                    "pivot": {
                        "game_id": 193,
                        "genre_id": 4
                    }
                },
                {
                    "id": 5,
                    "name": "Casual",
                    "pivot": {
                        "game_id": 193,
                        "genre_id": 5
                    }
                }
            ]
        },
    [...]
    ]
}
```

*The admin has access to all data, while a user sees only the game name, the ID of the user who added the game, and the creation and modification dates.*

# Docker
Containerization in the Laravel framework is implemented via Sail. For this, Sail must be installed in the existing project:
```
composer require laravel/sail --dev
```

Next, Sail will generate `docker-compose` and `.env` files:
```
php artisan sail:install
```

The generated `docker-compose.yml` contains 2 containers:  
- `laravel.test` with Laravel and Composer installed, inside which the project will also reside  
- a database container with a MySQL database
```
version: '3'
services:
    laravel.test:
        build:
            context: ./vendor/laravel/sail/runtimes/8.2
            dockerfile: Dockerfile
            args:
                WWWGROUP: '${WWWGROUP}'
        image: sail-8.2/app
        extra_hosts:
            - 'host.docker.internal:host-gateway'
        ports:
            - '${APP_PORT:-80}:80'
            - '${VITE_PORT:-5173}:${VITE_PORT:-5173}'
        environment:
            WWWUSER: '${WWWUSER}'
            LARAVEL_SAIL: 1
            XDEBUG_MODE: '${SAIL_XDEBUG_MODE:-off}'
            XDEBUG_CONFIG: '${SAIL_XDEBUG_CONFIG:-client_host=host.docker.internal}'
            IGNITION_LOCAL_SITES_PATH: '${PWD}'
        volumes:
            - '.:/var/www/html'
        networks:
            - sail
        depends_on:
            - mysql
    mysql:
        image: 'mysql/mysql-server:8.0'
        ports:
            - '${FORWARD_DB_PORT:-3306}:3306'
        environment:
            MYSQL_ROOT_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ROOT_HOST: '%'
            MYSQL_DATABASE: '${DB_DATABASE}'
            MYSQL_USER: '${DB_USERNAME}'
            MYSQL_PASSWORD: '${DB_PASSWORD}'
            MYSQL_ALLOW_EMPTY_PASSWORD: 1
        volumes:
            - 'sail-mysql:/var/lib/mysql'
            - './vendor/laravel/sail/database/mysql/create-testing-database.sh:/docker-entrypoint-initdb.d/10-create-testing-database.sh'
        networks:
            - sail
        healthcheck:
            test:
                - CMD
                - mysqladmin
                - ping
                - '-p${DB_PASSWORD}'
            retries: 3
            timeout: 5s
networks:
    sail:
        driver: bridge
volumes:
    sail-mysql:
        driver: local
```

# JWT
JWT will be used for logging into both the application and the API:

Adding the appropriate package
```
composer require tymon/jwt-auth
```

Configuration of config/auth.php
```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

Next, you need to create a controller to handle authorization
```
sail artisan make:controller AuthController
```

`Http/Controllers/AuthController.php`
```
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // API request
        if ($request->expectsJson()) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token], 201);
        }else{
            // WEB request
            Auth::login($user);
            $token = JWTAuth::fromUser($user);
            session(['jwt_token' => $token]);
            return redirect('/');
        }
        
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            // API request
            if ($request->expectsJson()) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            // WEB request
            return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        // API request
        if ($request->expectsJson()) {
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token]);
        }else{
            // WEB request
            session(['jwt_token' => $token]);
            return redirect('/');
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();

        // API request
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Logout successful']);
        }

        // WEB request
        session()->forget('jwt_token');
        return redirect('/');
    }

    public function getAuthenticatedUser(Request $request)
    {
        // Retrieve the user from the session or token
        $user = $request->expectsJson() ? JWTAuth::parseToken()->authenticate() : Auth::user();

        // API request
        if ($request->expectsJson()) {
            return response()->json(compact('user'));
        }

        // WEB request
        return view('profile', compact('user'));
    }
}
```
As seen in the code, the controller handles registration, login, logout, and retrieving information about the currently logged-in user.  
Since JWT is used for both web login and API access, the `return` statements had to be handled accordingly.  
For the API, a JSON `response` is returned, while for the web, a view or redirect is returned.  

Importantly, `$request->expectsJson()` in the code refers to the `Accept` header with the value `application/json` in tools like Postman, not the `Expect` header.  

If this has not been done, a SecretKey must be generated. It will be automatically added to the `.env` file.
```
php artisan jwt:secret
```

Output
```
jwt-auth secret [cvVG7cV8RTY6KtpodfatKMweRhBTL7lVtMSNfYRWuNNjmOuGBUZVIFBvdnGwXJoJ] set successfully.
```

Generating the `config/jwt.php` file that stores JWT information and configuration:
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Creating Middleware to handle JWT
```
php artisan make:middleware JwtMiddleware
```

### `Http/Middleware/JwtMiddleware.php`
```
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
    }
}
```

Inside `Models/User.php`, a function must be added to retrieve tokens from the User
```
public function getJWTIdentifier()
{
    return $this->getKey();
}
public function getJWTCustomClaims()
{
    return [];
}
```

Since non-default middleware is used in `routes/api.php`
```
Route::group(['middleware' => 'jwt.auth'], function () {
    [...]
})
```

Inside `Http/Kernel.php`, we need to add an alias for this middleware
```
protected $middlewareAliases = [
        [...],
        'jwt.auth' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
]
```

# ISOLATION
In Laravel, only one isolation level can be used for databases at a time.  

To use isolation, we need to configure `config/database.php`
REPETABLE READ:
```
'mysql' => [
    [...]
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ',
    ]) : [],
],        
```
READ COMMITTED:
```
'mysql' => [
    [...]
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED',
    ]) : [],
],
```

To apply the changes in `config`, the following command must be used
```
sail artisan config:cache
```

## Using Isolation Levels for the API
REPEATABLE READ:
```
public function index()
{
    $user = Auth::user();

    DB::beginTransaction();

    sleep(15);
        
    $games = Game::latest()->get();

    if ($user->isAdmin()) {
        $games = Game::with(['developers', 'publishers', 'user', 'steam', 'epic', 'genres'])
            ->latest()
            ->lockForUpdate()
            ->get();
    }

    // Commit the transaction
    DB::commit();

    return [
        "status" => 1,
        "data" => $games
    ];
}
```
*When retrieving data via the API `/localhost/api/games`, a transaction is created using the REPEATABLE READ mechanism. To correctly use this transaction, `lockForUpdate()` must be applied. In the case of READ COMMITTED, it is sufficient to remove this intermediate function.*

READ COMMITTED:
```
public function index()
{
    $user = Auth::user();

    DB::beginTransaction();

    sleep(15);
        
    $games = Game::latest()->get();

    if ($user->isAdmin()) {
        $games = Game::with(['developers', 'publishers', 'user', 'steam', 'epic', 'genres'])
            ->latest()
            ->get();
    }
    
    // Commit the transaction
    DB::commit();

    return [
        "status" => 1,
        "data" => $games
    ];
}
```

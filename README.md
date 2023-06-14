<table align='center'>
  <tr> <td colspan='3'> <img width="884px" > </td> </tr>
  <tr> <td colspan="3" align='center'> <img src='https://github.com/Gabrysiewicz/Programowanie-aplikacji-w-chmurze-obliczeniowe/blob/main/logo_politechniki_lubelskiej.jpg' width="400px" height="400px"></td> </tr>
  <tr> <td> Kamil Gabrysiewicz </td> <td> Index: 95400 </td> <td> Grupa: 6.3 </td> </tr>  
  <tr> <td> Jakub Dudek </td> <td> Index: 95391 </td> <td> Grupa: 6.3 </td> </tr>  
  <tr> <td> Semestr 6 </td> <td colspan='2' align='center'> Integracja systemów </td> </tr>  
</table>

# Zestawienie danych statystycznych dotyczących gier na platformach Steam i Epic Games Store

## Projekt:
- realizowany w grupach dwuosobowych
- należy wykonać w technologiach przedstawionych w skrypcie
- należy zaprezentować prowadzącemu i przesłać w terminie do przedostatnich zajęć włącznie
- integrowane dane przechowywane w plikach lub bazie danych muszą być zgodne z tematyką projektu
- wymagany jest interfejs graficzny pozwalający na wykonywanie akcji oraz prezentację danych
- Poniżej przedstawiono punktację za poszczególne realizowane funkcjonalności

### W projekcie:
- [X] eksport/import z pliku XML – 5 pkt
- [X] eksport/import z pliku JSON/YAML – 5 pkt
- [X] eksport/import z bazy danych – 5 pkt
- [X] wykorzystanie ORM w celu dostępu do bazy danych – 5 pkt
- [X] wykorzystanie usług typu SOAP – 5 pkt
- [X] wykorzystanie usług typu REST – 5 pkt
- [X] wykorzystanie kontenerów Docker – 5 pkt
- [X] wykorzystanie mechanizmów uwierzytelnienia i autoryzacji przy użyciu tokenów JWT – 5 pkt
- [X] wykorzystanie poziomów izolacji w bazie danych – 5 pkt

# Wymagane technologie
Aplikacja web:
Laravel 10
Composer 2.5.8
PHP 8.2.4

Client Soap:
.NET 6

# Instrukcja instalacji
1. Rozpakuj projekt

2. Przejdź do katalogu projektu:
```
cd Project/project
```

3. Zainstaluj zależności Composer:
```
composer install
```

4. Skopiuj zawartość pliku `.env.example` do pliku `.env`:
```
cp .env.example .env
```

5. Wygeneruj klucz aplikacji:
```
php artisan key:generate
```

5.5. Wygeneruj Secret key
```
php artisan jwt:secret
```

6. Zainstaluj i skonfiguruj narzędzie Sail, które umożliwi uruchomienie kontenerów Dockera (należy wybrać mysql [0]):
```
php artisan sail:install
```

7. Wyczyść zbuforowane dane aplikacji, przed uruchomieniem kontenerów:
```
php artisan optimize:clear
```

8. Należy uruchomić aplikację:
```
./vendor/bin/sail up -d
```

9. Wyczyść już istniejące migracje
```
./vendor/bin/sail artisan migrate:fresh
```

10. Wygeneruj Secret Key (JWT)
```
./vendor/bin/sail artisan key:generate
```
10.5 Moze okazać się potrzeba zmiana uprawnień
```
chmod 777 .env
```

# Opis
Projekt przedstawia zestawienie danych o grach na platformach Steam i Epic Games Store. Umożliwia użytkownikom rejestracje, logowanie, import/export danych oraz wyświetlanie ich na stronie internetowej

Dane do projektu znajdują się w katalogu datasets. 
Należy zaimportować jeden z plików:
- games.csv,
- games.json,
- games.xml

Aby import/export był możliwy należy utworzyć konto. `Create an account` w sekcji login

Aplikacja działa na porcie `8000` więc adresem projektu jest `localhost:8000`
# XML 
Import plików .xml jest możliwy tylko gdy plik ma następującą strukturę:

W postaci pojedyńczego elementu
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

W postaci tablicy elementów
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
Plik .json musi mieć następujące klucze: name, developer, publisher, genre, steam: price, release_date, epic: price, release_date<br>
W przypadku kluczy developer, publisher i genre, można podać wiele wartości, umieszczając je w tablicy [" "," "]<br>
Import plików .json jest możliwy tylko gdy plik ma następującą strukturę:

W postaci pojedyńczego obiektu
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

W postaci tablicy obiektów
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
Import plików .csv jest możliwy tylko gdy plik ma następującą strukturę:

```
name;developer;publisher;genre;release_date_steam;price_steam;release_date_epic;price_epic
Test1;Developer1;Publisher1;Action;31.09.2008;19.99;29.09.2008;14,99
Test2;"Developer2;Developer3";"Publisher2;Publisher3";"Adventure;Indie";31.09.2008;29.99;29.09.2008;24,99
```

Pierwszy wiersz musi zawierać nagłówki kolumn <br>
Kolumny muszą być oddzielone znakiem ";" <br>
W przypadku kolumn developer, publisher i genre, można podać wiele danych, oddzielając je znakiem ";" <br>

Diagram ERD

<img src="https://github.com/Gabrysiewicz/S6P_Integracja_systemow/blob/main/images/erd.png" >

Relacje
- jeden do jednego:
    - game i steam - jedna gra może mieć informacje specyficzne dla platformy Steam w tabeli steam
    - game i epic - jedna gra może mieć informacje specyficzne dla platformy Epic Games w tabeli epic
- jeden do wielu:
    - user i game - jeden użytkownik może dodać wiele gier, ale jedna gra jest dodana przez jednego użytkownika
- wiele do wielu:
    - game i genre - jedna gra może należeć do wielu różnych gatunków, a jeden gatunek może być przypisany do wielu różnych gier
    - developer i game - jeden deweloper może mieć wiele gier, a jedna gra może być stworzona przez wielu deweloperów
    - publisher i game - jeden wydawca może mieć wiele gier, a jedna gra może być wydana przez wielu wydawców

Uruchomienie konsoli mysql w kontenerze
```
docker exec -it [ container-id / container-tag ] mysql -u sail -h mysql -D laravel -p
```

Zmiana roli na `admin` dla usera o id `3`
```
UPDATE user SET role = "admin" WHERE id = 3;
```

# ORM
ORM jest realizowany za pośrednictwen Laravel'owego Eloquent
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
Soap server jest tworzony razem z plikiem wsdl poprzez biblioteke NuSOAP
```
composer require econea/nusoap
```

Tworzenie routa w pliku `routes/api.php` w celu odbierania pliku wsdl, wraz z funkcją do pobierania nazwy gry na podstawie podanego id od strony clienta
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

Ważne jest aby w pliku konfiguracyjnym /vendor/econea/nusoap/src/nusoap.php zmienić linie odpowiedzialne za encoding pliku wsdl.
Jest to wymagane aby połączyć się z usługą ze strony clienta.

Przed zmianą
```
var $soap_defencoding = 'ISO-8859-1';
//var $soap_defencoding = 'UTF-8';

$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>';
```

Po zmianie:
```
//var $soap_defencoding = 'ISO-8859-1';
var $soap_defencoding = 'UTF-8';

$xml = '<?xml version="1.0" encoding="' . $this->soap_defencoding . '"?>';
```

Soap client został stworzony za pomocą narzędzia WCF Web Service, dostępnego w Visual Studio, które umożliwia łączenie projektu .NET z usługą internetową.
To narzędzie generuje cały kod oraz referencje po podaniu adresu do usługi.

Główny kod programu pobierający nazwę gry na podstawie podanego id:
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

Wygląd aplikacji stworzony za pomocą Windows Forms

<img src="https://github.com/Gabrysiewicz/S6P_Integracja_systemow/blob/main/images/soapclient.png" >

# REST
REST API jest realizowane z wykorzystaniem JWT. W Laravel'u do wstępnej implementacji API należy utworzyć odpowiedni kontroler wykorzystujący
odpowiadający nam model:
```
sail artisan make:controller ApiController --resource --model=Game
```

Powyższe polecenie utworzy kontroler (`make:controller`) o nazwie `ApiController`, 
bazujący na modelu Game (`--model=Game`), dodatkowo domyślnie zadeklaruje niezbędne funkcje:
- index
- create
- store
- show
- edit
- update
- destroy

W pliku `routes/api.php` musimy zadeklarować routy dla naszego api:

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
*Zakomentowana linia pozwala na bardzo uproszczony dostęp do wszystkich funkcji (index, edit, delete, itd...)*

Dostęp do api domyślnie odbywa się poprzez trasę `localhost/api` np (POST) `localhost/api/login` 
z loginem i hasłem umieszczonym wewnątrz body w celu pobrania tokenu JWT

Routing związany z api można konfigurować w `Providers/RouteServiceProvider.php` w funkcji `boot()`:
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

Widok Index dla klienta o roli `user`
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

Widok Index dla klienta o roli `admin`
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

*Admin posiada dostęp do wszelkich danych podczas gry user widzi zaledwie nazwę gry, id user który tę grę dodał, oraz daty dodania oraz modyfikacji*

# Docker
Konteneryzacja we frameworku Laravel jest realizowana za pośrednictwem sail. W tym celu do już istniejącego projektu należy doinstalować sail:
```
composer require laravel/sail --dev
```

Następnie za pośrednictwem sail zostanie wygenerowany `docker-compose`, oraz `.env`:
```
php artisan sail:install
```

Wygenerowany docker-compose.yml zawiera 2 kontenery, laravel.test z zainstalowanym laravelem i composerem 
wewnątrz którego będzie również znajdował się projekt, oraz kontener bazodanowy z bazą mysql:
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
Do logowania się do aplikacji jak i API zostanie zastosowana metoda JWT:

Dodanie odpowiedniego pakietu
```
composer require tymon/jwt-auth
```

Konfiguracja config/auth.php
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

Następnie należy utworzyć kontroler do obsługi autoryzacji
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
Jak widać w kodzie, kontroler obsługuje rejestracje, logowanie, wylogowywanie oraz pobranie informacji o aktualnie zalogowanym użytkowniku.
Ponieważ JWT zostało wykorzystane zarówno do logowania na stronie (WEB) jak i w API, musiały zostać odpowiednio obsłużone `returny`.
Dla API zwracany jest `response` z json, a dla `WEB` widok lub redirect
Co ważne `$request->expectsJson()` w kodzie odnosi się do klucza `Accept` i wartości `application/json` w programach typu Postman a nie do klucza `Expect`

Jeżeli się tego nie zrobiło, należy wygenerować SecretKey. Automatycznie zostanie dodany do .env
```
php artisan jwt:secret
```

Output
```
jwt-auth secret [cvVG7cV8RTY6KtpodfatKMweRhBTL7lVtMSNfYRWuNNjmOuGBUZVIFBvdnGwXJoJ] set successfully.
```

Wygenerowanie pliku `config/jwt.php` przechowującego informacje i konfigurację JWT:
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Utworzenie Middleware do obsługi JWT
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

Wewnątrz `Models/User.php` należy dodać funkcję do pobierania tokenów od User
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

Ponieważ w `routes/api.php` korzystamy z non-default middleware
```
Route::group(['middleware' => 'jwt.auth'], function () {
    [...]
})
```

Wewnątrz `Http/Kernel.php` musimy dodać alias do tego middleware
```
protected $middlewareAliases = [
        [...],
        'jwt.auth' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
]
```

# ISOLATION
W Laravelu dla bazydanych jest możliwy tylko 1 tryb izolacji na raz.

Aby wykorzystać izolacje musimy skonfigurować `config/database.php`
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

Aby zmiana `config` działała należy użyć polecenia
```
sail artisan config:cache
```

## Wykorzystanie poziomów izolacji dla API
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
*Podczas pobierania danych za pośrednictwem api /localhost/api/games jest tworzona transakcja z wykorzystanie mechanizmu REPEATABLE READ. Aby poprawnie wykorzystać tę transakcję należy zastosować lockForUpdate(). Z kolei w przypadku READ COMMITTED wystarczy usunąć tę funkcję pośredniczącą.*

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

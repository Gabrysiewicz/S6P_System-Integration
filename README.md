# Zestawienie danych statystycznych dotyczących gier na platformach Steam i Epic Games Store

## Projekt:
- realizowany w grupach dwuosobowych
- należy wykonać w technologiach przedstawionych w skrypcie
- należy zaprezentować prowadzącemu i przesłać w terminie do przedostatnich zajęć włącznie
- integrowane dane przechowywane w plikach lub bazie danych muszą być zgodne z tematyką projektu
- wymagany jest interfejs graficzny pozwalający na wykonywanie akcji oraz prezentację danych
- Poniżej przedstawiono punktację za poszczególne realizowane funkcjonalności

### W projekcie:
- [ ] eksport/import z pliku XML – 5 pkt
- [ ] eksport/import z pliku JSON/YAML – 5 pkt
- [ ] eksport/import z bazy danych – 5 pkt
- [X] wykorzystanie ORM w celu dostępu do bazy danych – 5 pkt
- [ ] wykorzystanie usług typu SOAP – 5 pkt
- [ ] wykorzystanie usług typu REST – 5 pkt
- [X] wykorzystanie kontenerów Docker – 5 pkt
- [ ] wykorzystanie mechanizmów uwierzytelnienia i autoryzacji przy użyciu tokenów JWT – 5 pkt
- [ ] wykorzystanie poziomów izolacji w bazie danych – 5 pkt

## Instrukcja instalacji
1. Sklonuj projekt z repozytorium Git:
```
git clone https://github.com/Gabrysiewicz/S6P_Integracja_systemow.git
```

2. Przejdź do katalogu projektu:
```
cd S6P_Integracja_systemow/project
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

6. Zainstaluj i skonfiguruj narzędzie Sail, które umożliwi uruchomienie kontenerów Dockera:
```
php artisan sail:install
```

7. Wyczyść zbuforowane dane aplikacji, przed uruchomieniem kontenerów:
```
php artisan optimize:clear
```

8. Wyczyść już istniejące migracje
```
./vendor/bin/sail artisan migrate:fresh
```

9. Uruchom kontenery Dockera przy użyciu polecenia:
```
./vendor/bin/sail up
```

## ORM
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

## Docker

Konteneryzacja we frameworku Laravel jest realizowana za pośrednictwem sail. W tym celu do już istniejącego projektu należy doinstalować sail:
```
composer require laravel/sail --dev
```

Następnie za pośrednictwem sail zostanie wygenerowany docker-compose wykorzystujący .env:
```
php artisan sail:install
```

Wygenerowany docker-compose.yml zawiera 2 kontenery, laravel.test z zainstalowanym laravelem i composerem wewnątrz którego będzie również znajdował się projekt,
oraz kontener bazodanowy z mysql:
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

## JWT
Do logowania się do aplikacji zostanie zastosowana metoda autoryzacji JWT:

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

Następnie należy dodać kontroler do obsługi autoryzacji
```
sail artisan make:controller AuthController
```
```
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
```

Należy wygenerować SecretKey. Automatycznie zostanie dodany do .env
```
php artisan jwt:secret
```

Output
```
jwt-auth secret [cvVG7cV8RTY6KtpodfatKMweRhBTL7lVtMSNfYRWuNNjmOuGBUZVIFBvdnGwXJoJ] set successfully.
```

Wygenerowanie pliku jwt.php przechowującego informacje i konfikurację JWT:
```
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

Przykład zawartości jwt.php. Jak widać wartości są pobierane ze zmiennych w .env
```
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Secret
    |--------------------------------------------------------------------------
    |
    | Don't forget to set this in your .env file, as it will be used to sign
    | your tokens. A helper command is provided for this:
    | `php artisan jwt:secret`
    |
    | Note: This will be used for Symmetric algorithms only (HMAC),
    | since RSA and ECDSA use a private/public key combo (See below).
    |
    */

    'secret' => env('JWT_SECRET'),
```

Przykład autoryzacji dla użytkownika
```
use Tymon\JWTAuth\Facades\JWTAuth;

// Generate a token for the user
$token = JWTAuth::fromUser($user);
```

Routing z wykorzystaniem autoryzacji
```
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
```

Widok dla nieautoryzowanego użytkownika
<img src="https://github.com/Gabrysiewicz/S6P_Integracja_systemow/blob/main/images/autoryzacja.jpg" >

## Baza danych
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

## Import/Export CSV
Import plików .csv jest możliwy tylko gdy plik ma następującą strukturę:

```
name;developer;publisher;genre;release_date_steam;price_steam;release_date_epic;price_epic
Test1;Developer1;Publisher1;Action;31.09.2008;19.99;29.09.2008;14,99
Test2;"Developer2;Developer3";"Publisher2;Publisher3";"Adventure;Indie";31.09.2008;29.99;29.09.2008;24,99
```

Pierwszy wiersz musi zawierać nagłówki kolumn <br>
Kolumny muszą być oddzielone znakiem ";" <br>
W przypadku kolumn developer, publisher i genre, można podać wiele danych, oddzielając je znakiem ";" <br>

## Import/Export JSON
Plik .json musi mieć następujące klucze: name, developer, publisher, genre, steam: price, release_date, epic: price, release_date
W przypadku kluczy developer, publisher i genre, można podać wiele wartości, umieszczając je w tablicy [" "," "]
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

## Import/Export XML
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

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Steam • Epic Games Store </title>

        <!-- Styles -->
        <style>
            html, body{
                margin: 0;
                padding: 0;
                height: 100%;
                min-height: 100%;
            }
            nav{
                display: flex;
                flex-direction: row;

                background-color: black;
                color: white;
                width: 100%;
            }
            nav h1{
                flex-basis: 75%;
                color: white;
                font-size: 125% !important;
                transition: 1s ease-in-out;
                text-align: center;
            }
            nav #control-section{
                flex-basis: 25%;
                display: flex;
                justify-content: space-around;
                box-shadow: inset 2px 0 1px white;
            }
            #control-section input{
                border: 0;
                background-color: black;
                color: white;
                font-size: 125%;
                transition: 1s ease-in-out;
            }
            #control-section input:hover, nav h1:hover{
                color: red !important;
                font-size: 150% !important;
                cursor: pointer;
            }
            #control-section input:not(:hover), nav h1:not(:hover){
                font-size: initial;
            }
            table{
                width: 100%;
                text-align: center;

                /* box-shadow: 0 0 1px 1px black; */
            }
            thead{
                background: black;
                color: white;
            }
            tbody tr:nth-child(2n){
                background-color: rgba(0, 0, 0, 0.200);
                color:rgb(68, 68, 68);
            }
        </style>
    </head>
    <body>
        <nav>
            <h1 onclick="redirectTo('')">
                Steam • Epic Games Store 
            </h1>  
            <section id="control-section">
                <input type="button" value="Export" id='export-button' name='export-button' onclick="redirectTo('export')">
                <input type="button" value="Import" id='import-button' name='import-button' onclick="redirectTo('import')">   
                @if(auth()->check())
                <input type="button" value="Profile" id='profile-button' name='profile-button' onclick="redirectTo('user')">
                @else
                <input type="button" value="Login" id='login-button' name='login-button' onclick="redirectTo('login')">
                @endif
            </section>
        </nav>
        <table>
            <thead>
                <tr> 
                    <th>Game</th>
                    <th>Developer</th>
                    <th>Publisher</th>
                    <th>Genre</th>
                    <th>Steam Release Date</th> 
                    <th>Steam Price</th>
                    <th>Epic Release Date</th> 
                    <th>Epic Price</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($games as $game)
                    <tr> 
                        <td>{{ $game->name }}</td>
                        <td>
                            @foreach($game->developers as $developer)
                                {{ $developer->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($game->publishers as $publisher)
                                {{ $publisher->name }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($game->genres as $genre)
                                {{ $genre->name }}<br>
                            @endforeach
                        </td>
                        <td>     
                            {{ $game->steam->release_date }}                          
                        </td>
                        <td>
                            {{ $game->steam->price }}       
                        </td>
                        <td>
                            {{ $game->epic->release_date }}       
                        </td>
                        <td>
                            {{ $game->epic->price }}       
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            let redirectTo = (dest) => {
                window.location.href = `/${dest}`;
            }
        </script>
    </body>
</html>

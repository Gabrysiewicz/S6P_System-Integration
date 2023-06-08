<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Export</title>

        <!-- Styles -->
        <style>
            html, body{
                margin: 0;
                padding: 0;
                height: 100%;
                min-height: 100%;
            }
            body{
                display: flex;
                flex-direction: column;
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
            
            main{
                display: flex;
                justify-content: space-around;
                align-items: center;

                height: 100%;
                width: 100%;
                box-shadow: inset 0 0 1px 1px red;
            }
            article{
                /* box-shadow: inset 0 5px 5px blue; */
            }
            article input{
                width: 250px;
                height: 250px;
                font-size: 300%;
                background-color: black;
                color: white;
                border: 0;
                border-radius: 50px;
                transition: 1s ease-in-out;
            }
            article input:hover{
                color: red;
                box-shadow: 0 0 5px 5px red;
                cursor: pointer;
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
        <main>
            <article id='as-csv'>
                <form action="/export-csv" method="POST">
                    @csrf
                    <input type='submit' id='import-as-csv' name='import-as-csv' value='csv'>
                </form>
            </article>
            <article id='as-xml'>
                <form action="/export-xml" method="POST">
                    @csrf
                    <input type='submit' id='import-as-xml' name='import-as-xml' value='xml'>
                </form>        
            </article>
            <article id='as-json'>
                <form action="/export-json" method="POST">
                    @csrf
                    <input type='submit' id='import-as-json' name='import-as-json' value='json'>
                </form>
            </article>
        </main>
        <script>
            let redirectTo = (dest) => {
                window.location.href = `/${dest}`;
            }
        </script>
    </body>
</html>

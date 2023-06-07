<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>User Dashboard</title>

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
                justify-content: center;
                align-items: center;

                height: 100%;

                box-shadow: inset 0 0 1px 1px red;
            }
            form{
                display: flex;
                flex-direction: column;

                width: 33%;
                padding: 2.5%;
                background-color: black;
                color: white;
                border-radius: 25px;
                /* box-shadow: 0 0 5px 7px yellow; */
            }
            form * {
                margin: 15px 0;
            }
            form input[type="email"],[type="password"]{
                width:100%;
                font-size: 120%;
                text-align: center;
                border-radius: 25px;
                /* border: 1px solid white; */
                box-shadow: 1px 1px 5px 1px white;
            }
            form div {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                flex-wrap: wrap;
            }
            form a {
                text-decoration: none;
                color:white;
                font-size: 120%;
            }
            form input[type="submit"]{
                width:33%;
                font-size: 120%;
                align-self: center;
                border-radius: 25px;
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
        <form action="/logout" method="POST"> 
            @csrf
            <input type="submit" id="logout_button" name="logout_button" value="Logout">
        </form>
        </main>
        <script>
            let redirectTo = (dest) => {
                window.location.href = `/${dest}`;
            }
        </script>
    </body>
</html>

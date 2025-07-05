<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        @vite('resources/css/app.css')
    </head>
    <style>
        *{
          box-sizing: border-box;
        }
        html, body{
          padding: 0;
          margin: 0;
          image-rendering: pixelated
        }
        body{
          display: flex;
          flex-direction: column;
          height: 92.5svh;
          overflow-x: hidden
        }
    </style>
    <body>
      <div id="app"></div>
      @vite('resources/js/app.js')
    </body>
</html>

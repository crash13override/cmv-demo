<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Code My Views To-do Demo by Luca Basile</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="/css/app.css" rel="stylesheet">

    </head>
    <body>
        <div id="app" class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <h1 class="title">CMV To-do Demo</h1>

                    <todo-list :todos="cmv.todos"></todo-list>

                    <todo-form-inline :todos="cmv.todos" :people="cmv.people"></todo-form-inline>

                    <todo-form-csv :todos="cmv.todos" :people="cmv.people"></todo-form-csv>

                    <todo-form-excel :todos="cmv.todos" :people="cmv.people"></todo-form-excel>

                </div>
            </div>
        </div>


        <script>
            window.Laravel = {};
            Laravel.csrfToken = '{!! csrf_token() !!}';

            window.cmv = {};
            cmv.people = {!! json_encode($people) !!};
            cmv.todos = {!! json_encode($todos) !!};
        </script>

        <script src="/js/app.js"></script>

    </body>
</html>

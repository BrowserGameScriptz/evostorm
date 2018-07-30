<!DOCTYPE html>
<html lang="en" ng-app="evostormApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The Evostorm</title>

    <meta name="description" content="Browser based game">
    <meta name="author" content="Damian Winiarski">

    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>

<div class="container-fluid">
    @yield('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">
                Footer
            </h3>
        </div>
    </div>
</div>

<script src="js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="js/angular.min.js"></script>
<script type="text/javascript" src="js/angular-route.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bonsai-0.4.1.min.js"></script>
<script type="text/javascript" src="app/app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <h1 class="text-center">{{$title}}</h1>
    <div class="form-container">
        <form class="form-horizontal" action="{{$route}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Имя категории</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name"  name="name" value="{{$cat['name']}}">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-4 control-label">Описание Категории</label>
                <div class="col-sm-8">
                    <textarea  class="form-control" id="description"  name="description" value="{{$cat['description']}}"></textarea>
                    <input type="hidden"  name="id" value="{{$cat['id']}}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">{{$btn}}</button>
                    <br><br>
                    @if(Session::has('message'))
                        <div class="mail">
                            {{Session::get('message')}}
                        </div>
                        <br><br>
                    @endif
                    <a href="/admin/category">Назад</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
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
                <label for="header" class="col-sm-4 control-label">Заголовок</label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="header"  name="header" value="">{{$news['header']}}</textarea>
                    <input type="hidden" class="form-control"   name="old_name"
                           value="{{ $news['header']? $news['header'] : 'old_name' }}">
                </div>
            </div>

            <div class="form-group">
                <label for="content" class="col-sm-4 control-label">Тело</label>
                <div class="col-sm-8 ">
                    <textarea class="form-control news-content" id="description" name="content" rows="5">{{$news['content']}}</textarea>
                    <input type="hidden"  name="id" value="{{$news['id']}}">
                </div>
            </div>
            <div class="form-group">
                <label for="file" class="col-sm-4 control-label">Изображение</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control-file" id="file"  name="file" value="{}">
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" >{{$btn}}</button>
                    <br><br>
                    @foreach ($errors->all() as $error)
                        <div class="error">{{ $error }}</div>
                        <br>
                    @endforeach
                    @if(Session::has('message'))
                        <div class="mail">
                            {{Session::get('message')}}
                        </div>
                        <br><br>
                    @endif
                    <a href="/admin/news">Назад</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
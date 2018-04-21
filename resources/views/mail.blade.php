@extends('layouts.admin')

@section('content')
      <div class="form-container">
        <form class="form-horizontal" action="/admin/changeMail" method="post" enctype="multipart/form-data">
            @csrf
           <div class="form-group">
            <label for="mail" class="col-sm-4 control-label">Cменить адресс уведомления</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="mail"  name="mail" value="{{$mail}}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Сменить</button>
              <br><br>
                @if(Session::has('message'))
                    <div class="mail">
                        {{Session::get('message')}}
                    </div>
                    <br><br>
                @endif

              <a href="/">На Главную</a>
            </div>
          </div>

</form>
</div>
@endsection
@extends('layout')

@section('style')

@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-xs-9">
      <div id="messages" class="" style="height: 400px;border: 1px black solid;">
        <p class="lead">welcome!</p>
      </div>
      <textarea id="message" class="form-control" style="max-width: 100%;height: 100px;margin: 10px 0 0 0;border: 1px red solid;" placeholder="Text input"></textarea>
      <button id="say" class="btn btn-primary pull-right" style="margin: -43px 10px 0 0;">sent</button>
    </div>
    <div class="col-xs-3">
      <div id="custom" style="width: 100%;height: 300px;border: 1px green solid;"></div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  var es = new EventSource('/flush');
  es.addEventListener('message', function(e) {
    var d = JSON.parse(e.data);
    var time = new Date(parseInt(d.timestamp) * 1000).toLocaleString();
    var $p = $('<p></p>').html('<p>'+d.name+': '+d.message+' <small>@'+time+' by '+d.id+'</small></p>');

    $('#messages').append($p);
  }, false);

  $('#say').click(function() {
    $.post('/say', {
      'message':$('#message').val(),
      '_token':'{{csrf_token()}}'
    }, function(data, textStatus) {
    });

    $('#message').val('');
  });
</script>
@endsection

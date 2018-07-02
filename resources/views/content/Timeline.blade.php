@extends('layout')

@section('head')
  <style>
  .time {
    margin-top: 10px;
    background-color: #fff;
    padding: 5px;
    border-radius: 3px;
  }
  .time2 {
    margin-top: 10px;
    background-color: #fff;
    padding: 5px;
    border-radius: 3px;
    margin-left: 15px;
  }
  .time3 {
    margin-top: 10px;
    background-color: #fff;
    padding: 5px;
    border-radius: 3px;
    margin-left: 30px;
  }
  </style>
@endsection

@section('heading')
  Timeline
@endsection

@section('content')
  <div id="time-container">
    @foreach((array) $result as $item)
    @php $date = date('d-m-Y, H:i:s', strtotime($item->updated_at)); @endphp
    <div class="time">
      <span>{{ $item->content }} •••• </span>
      <span style="color:red"> {{ $date }}</span>
    </div>
    @endforeach
  </div>
@endsection

@section('script')
  <script>
    $('.time').each(function() {
      let text = $(this).children().text();
      let split = text.substr(0, text.indexOf(' '));
      if (split == 'IPS') $(this).addClass('time2');
      if (split == 'nilai') $(this).addClass('time3');
    });

    $.fn.wrapInTag = function(opts) {
  
    var tag = opts.tag || 'strong',
        words = opts.words || [],
        regex = RegExp(words.join('|'), 'g'),
        replacement = '<'+ tag +'>$&</'+ tag +'>';
    
    return this.html(function() {
      return $(this).text().replace(regex, replacement);
    });
  };

  $('#time-container span').wrapInTag({
    tag: 'strong',
    words: ['Manajemen Informatika', 'Komputerisasi Akuntansi', 'general', 'I',
      'II', 'Akselerasi I', 'III', 'IV', 'Akselerasi II']
  });
  </script>
@endsection
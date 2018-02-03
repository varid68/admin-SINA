$(function () {
  let width = 10;
  let interval = null;
  
  $('.glyphicon').click(function () {
    let san = $('input[name="password"]');
    san.attr('type') == 'password' ? san.attr('type', 'text') : san.attr('type', 'password');
  });

  function intervalLoading () {
    interval = setInterval(function () {
      $('.progress-bar').css('width', width + '%');
      width = width < 100 ? width + 10 : 10;
      console.log(width);
    }, 1000);
  }

  function onSuccess(data) {
    if (data != 'Wrong Password') {
      $('#select select').prop('disabled', false);
      $.each(data.matkul, function (index, value) {
        let val = {
          id: value.id_matkul,
          semester: value.semester,
        }
        let json = JSON.stringify(val);
        $('select')
          .append($("<option></option>")
            .attr("value", json)
            .text(value.mata_kuliah));
      });
    } else alert('Kombinasi username & password salah!');

    clearInterval(interval);
    $('#loading').css('visibility', 'hidden');
  }
  
  $('.btn-submit').click(function(e) {
    $('#loading').css('visibility', 'visible');
    intervalLoading();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });
    e.preventDefault();
    var formData = {
      username: $('input[name="username"]').val(),
      password: $('input[name="password"]').val(),
    }
    
    if (formData.username != '' && formData.password != '') {
      $.ajax({
        type: 'POST',
        url: '/login',
        data: formData,
        success: function (data) {
          onSuccess(data);
        },
        error: function (err) {
          alert(err);
        }
      });
    }
  });

  $("select").change(function () {
    window.location = '/login/' + $(this).val();
    $('#loading').css('visibility', 'visible');
    intervalLoading();
  });
});
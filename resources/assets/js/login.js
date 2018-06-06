$(function () {
  let width = 10;
  let interval = null;

  $('body').ripples({
    resolution: 512,
    dropRadius: 20,
    perturbance: 0.01,
  });

  $('.glyphicon').click(function () {
    let san = $('input[name="password"]');
    san.attr('type') == 'password' ? san.attr('type', 'text') : san.attr('type', 'password');
  });

  function intervalLoading() {
    interval = setInterval(function () {
      $('.progress-bar').css('width', width + '%');
      width = width < 100 ? width + 10 : 10;
    }, 1000);
  }

  function removeAllOption() {
    $('#select select')
      .find('option')
      .remove()
      .end()
      .append('<option value="w" disabled>- Pilih matkul -</option>')
      .val('w')
      ;
  }

  function onSuccess(data) {
    const object = `{"id":"admin","semester":"none","mata_kuliah":"none"}`;

    if (data != 'Wrong Password') {
      if (data.auth.nama == 'admin') window.location = '/login/' + object;
      else {
        removeAllOption();
        const removeDuplicate = data.matkul.filter((thing, index, self) =>
          index === self.findIndex((e) => (
            e.id_matkul === thing.id_matkul
          ))
        );
        $('#select select').prop('disabled', false);
        $.each(removeDuplicate, function (index, value) {
          let val = {
            id: value.id_matkul,
            semester: value.semester,
            mata_kuliah: value.mata_kuliah,
          }
          let json = JSON.stringify(val);
          $('select')
            .append($("<option></option>")
              .attr("value", json)
              .text(value.mata_kuliah));
        });
      }
      $('#myModal').modal('show');
      $('#myModal').delay(2000).fadeOut(450);
      setTimeout(() => {
        $('#myModal').modal('hide');
      }, 2500);
    } else alert('Kombinasi username & password salah!');

    clearInterval(interval);
    $('#loading').css('visibility', 'hidden');
  }

  $('.btn-submit').click(function (e) {
    const username = $('.username').val();
    const password = $('.password').val();

    if (username == '' || password == '') return false;

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
  });
});
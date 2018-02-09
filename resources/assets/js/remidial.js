$(function () {
  let toggle = false;
  let absensi = 0;
  let tugas = 0;
  let uts = 0;
  let uas = 0;
  let finalScoreHtml = null;

  function getGrade(nilai) {
    let grade = null;

    if (nilai <= 100 && nilai >= 92) grade = 'A';
    else if (nilai <= 91 && nilai >= 84) grade = 'A-';
    else if (nilai <= 83 && nilai >= 75) grade = 'B+';
    else if (nilai <= 74 && nilai >= 67) grade = 'B';
    else if (nilai <= 66 && nilai >= 59) grade = 'B-';
    else if (nilai <= 58 && nilai >= 50) grade = 'C+';
    else if (nilai <= 49 && nilai >= 42) grade = 'C';
    else if (nilai <= 41 && nilai >= 34) grade = 'C';
    else if (nilai <= 33 && nilai >= 25) grade = 'D+';
    else if (nilai <= 24) grade = 'D';
    else grade = '!!';

    return grade;
  }

  function calculateScore(thisObject) {
    let finalScore = Math.round(absensi + tugas + uts + uas);
    let grade = getGrade(finalScore);
    let hasil = `${finalScore} (${grade})`;
    thisObject.parents('tr').find('.final-score').val(finalScore);
    thisObject.parent().siblings('.nilai_akhir').text(hasil);
  }

  $('#btn-modal-download').click(function () {
    window.location = '/remidial-pdf';
  });

  $('.btn-info').click(function () {
    $('.absensi, .tugas, .uts, .uas').siblings().show();
    $('.absensi, .tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    if (toggle) {
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').hide();
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').siblings().show();
      $(this).show();
      $(this).siblings('.on-edit').hide();
      finalScoreHtml = null;
      toggle = false;
    } else {
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').show();
      $(this).parents('tr').find('.absensi, .tugas, .uts, .uas').siblings().hide();
      $(this).hide();
      $(this).siblings('.on-edit').show();
      $(this).parents('tr').find('.absensi').focus();
      finalScoreHtml = $(this).parent().siblings('.nilai_akhir').html();
      toggle = true;
    }
  });

  $('.dismiss').click(function () {
    $('.absensi, .tugas, .uts, .uas').siblings().show();
    $('.absensi, .tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    const absensi = $(this).parents('tr').find('.absensi').data('absensi');
    const tugas = $(this).parents('tr').find('.tugas').data('tugas');
    const uts = $(this).parents('tr').find('.uts').data('uts');
    const uas = $(this).parents('tr').find('.uas').data('uas');
    const finalScore = $(this).parents('tr').find('.final-score').data('final');
    $(this).parents('tr').find('.absensi').val(absensi);
    $(this).parents('tr').find('.tugas').val(tugas);
    $(this).parents('tr').find('.uts').val(uts);
    $(this).parents('tr').find('.uas').val(uas);
    $(this).parents('tr').find('.final-score').val(finalScore);
    $(this).parents('tr').find('.nilai_akhir').html(finalScoreHtml);
    toggle = false;
  });

  $('.absensi').keyup(function (e) {
    absensi = ((e.target.value / 14) * 10 / 100) * 100;
    calculateScore($(this));
  });

  $('.tugas').keyup(function (e) {
    tugas = parseInt(20 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('.uts').keyup(function (e) {
    uts = parseInt(30 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('.uas').keyup(function (e) {
    uas = parseInt(40 / 100 * e.target.value);
    calculateScore($(this));
  });

  $('input').keypress(function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      input = $("input[type=number]");
      i = input.index(this);
      if (input[i + 1] != null) {
        next = input[i + 1];
        next.focus();
        next.select();
        return false;
      } else {
        input[0].focus();
        next.select();
        return false;
      }
    }
  });

});
$(function () {
  let toggle = false;
  let tugas = 0;
  let uts = 0;
  let uas = 0;
  let finalScoreHtml = null;

  function getGrade(nilai) {
    let grade = null;

    if (nilai <= 100 && nilai >= 85) grade = 'A';
    else if (nilai <= 84 && nilai >= 80) grade = 'A-';
    else if (nilai <= 79 && nilai >= 75) grade = 'B+';
    else if (nilai <= 74 && nilai >= 70) grade = 'B';
    else if (nilai <= 69 && nilai >= 65) grade = 'B-';
    else if (nilai <= 64 && nilai >= 60) grade = 'C+';
    else if (nilai <= 59 && nilai >= 55) grade = 'C';
    else if (nilai <= 54 && nilai >= 50) grade = 'C-';
    else if (nilai <= 50 && nilai >= 40) grade = 'D';
    else if (nilai <= 39) grade = 'E';
    else grade = '!!'

    return grade;
  }

  function calculateScore(thisObject) {
    let finalScore = Math.round(tugas + uts + uas);
    let grade = getGrade(finalScore);
    let hasil = `${finalScore} (${grade})`;
    thisObject.parents('tr').find('.final-score').val(finalScore);
    thisObject.parent().siblings('.nilai_akhir').text(hasil);
  }

  $('#btn-modal-download').click(function () {
    window.location = '/remidial-pdf';
  });

  $('.btn-info').click(function () {
    $('.tugas, .uts, .uas').siblings().show();
    $('.tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    if (toggle) {
      $(this).parents('tr').find('.tugas, .uts, .uas').hide();
      $(this).parents('tr').find('.tugas, .uts, .uas').siblings().show();
      $(this).show();
      $(this).siblings('.on-edit').hide();
      finalScoreHtml = null;
      toggle = false;
    } else {
      $(this).parents('tr').find('.tugas, .uts, .uas').show();
      $(this).parents('tr').find('.tugas, .uts, .uas').siblings().hide();
      $(this).hide();
      $(this).siblings('.on-edit').show();
      finalScoreHtml = $(this).parent().siblings('.nilai_akhir').html();
      toggle = true;
    }
  });

  $('.dismiss').click(function () {
    $('.tugas, .uts, .uas').siblings().show();
    $('.tugas, .uts, .uas').hide();
    $('.on-edit').hide();
    $('.btn-info').show();

    const tugas = $(this).parents('tr').find('.tugas').data('tugas');
    const uts = $(this).parents('tr').find('.uts').data('uts');
    const uas = $(this).parents('tr').find('.uas').data('uas');
    const finalScore = $(this).parents('tr').find('.final-score').data('final');
    $(this).parents('tr').find('.tugas').val(tugas);
    $(this).parents('tr').find('.uts').val(uts);
    $(this).parents('tr').find('.uas').val(uas);
    $(this).parents('tr').find('.final-score').val(finalScore);
    $(this).parents('tr').find('.nilai_akhir').html(finalScoreHtml);
    toggle = false;
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
    uas = parseInt(50 / 100 * e.target.value);
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
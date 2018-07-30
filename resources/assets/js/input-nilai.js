$(function () {
  let tugas = 0;
  let uts = 0;
  let hasilAkhir = [];

  (function focusOnInit() {
    $('input').eq(1).focus();
  }());

  // membuat array kosong untuk menghitung nilai akhir
  (function createEmptyArray() {
    let length = $('tr').length - 1;
    for (var i = 0; i < length; i++) {
      hasilAkhir.push([...Array(4)].map((u, i) => null));
    }
  }());

  // menghitung nilai tugas 30%
  $('.tugas').keyup(function (e) {
    tugas = parseInt(20 / 100 * e.target.value);
    const indexElem = $('.tugas').index(this);
    hasilAkhir[indexElem][0] = tugas;
  });

  //menghitung nilai uts 30%
  $('.uts').keyup(function (e) {
    uts = parseInt(30 / 100 * e.target.value);
    const indexElem = $('.uts').index(this);
    hasilAkhir[indexElem][1] = uts;
  });

  // menghitung nilai uas 40%
  $('.uas').keyup(function (e) {
    uas = parseInt(50 / 100 * e.target.value);
    const indexElem = $('.uas').index(this);
    const i = hasilAkhir[indexElem][0] + hasilAkhir[indexElem][1] + uas;
    if (e.target.value != '') gradeNilai(i, indexElem);
  });

  // memberikan warna merah nilai jika di bawah standart < 60
  function gradeNilai(nilai, indexElem) {
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

    $('input.nilai-akhir[type="hidden"]').eq(indexElem).val(nilai);
    const selector = $('td.grade').eq(indexElem).html(nilai + '&nbsp&nbsp&nbsp' + grade);
    nilai < 59 ? selector.css('color', 'red') : selector.css('color', 'black');
  }

  // pindah textbox saat enter
  $('input').keypress(function (e) {
    if (e.keyCode == 13) {
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

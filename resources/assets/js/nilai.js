$(function () {
  let tugas = 0;
  let absensi = 0;
  let uts = 0;
  let hasilAkhir = [];
  
  (function focusOnInit() {
    $('input').eq(1).focus();
  }());

  (function addClassActive() {
    const split = location.href.split('/');
    const page = split.length > 4 ? split[4] : 1;
    $('ul.pagination').find('li a').each(function () {
      let parents = $(this).parents('li');
      $(this).text() == page ? parents.addClass('active') : parents.removeClass('active');
    });
  }());

  // membuat array kosong untuk menghitung nilai akhir
  (function createEmptyArray() {
    let length = $('tr').length - 1;
    for (var i = 0; i < length; i++) {
      hasilAkhir.push([...Array(4)].map((u, i) => null));
    }
  }());

  // menghitung nilai absensi 
  $('.absensi').keyup(function (e) {
    let Hasil = ((e.target.value / 14) * 10 / 100) * 100;
    absensi = parseInt(Hasil.toFixed(2));
    var indexElem = $('.absensi').index(this);
    hasilAkhir[indexElem][0] = absensi;
  });


  // menghitung nilai tugas 30%
  $('.tugas').keyup(function (e) {
    tugas = parseInt(20 / 100 * e.target.value);
    var indexElem = $('.tugas').index(this);
    hasilAkhir[indexElem][1] = tugas;
  });


  //menghitung nilai uts 30%
  $('.uts').keyup(function (e) {
    uts = parseInt(30 / 100 * e.target.value);
    var indexElem = $('.uts').index(this);
    hasilAkhir[indexElem][2] = uts;
  });

  // menghitung nilai uas 40%
  $('.uas').keyup(function (e) {
    uas = parseInt(40 / 100 * e.target.value);
    var indexElem = $('.uas').index(this);
    var i = hasilAkhir[indexElem][0] + hasilAkhir[indexElem][1] + hasilAkhir[indexElem][2] + uas;
    if (e.target.value != '') gradeNilai(i, indexElem);
  });

  // memberikan warna merah nilai jika di bawah standart < 60
  function gradeNilai(nilai, indexElem) {
    let grade = null;

    if (nilai <= 100 && nilai >= 92) {
      grade = 'A';
    } else if (nilai <= 91 && nilai >= 84) {
      grade = 'A-';      
    } else if (nilai <= 83 && nilai >= 75) {
      grade = 'B+';
    } else if (nilai <= 74 && nilai >= 67) {
      grade = 'B';
    } else if (nilai <= 66 && nilai >= 59) {
      grade = 'B-';      
    } else if (nilai <= 58 && nilai >= 50) {
      grade = 'C+';      
    } else if (nilai <= 49 && nilai >= 42) {
      grade = 'C';      
    } else if (nilai <= 41 && nilai >= 34) {
      grade = 'C';      
    } else if (nilai <= 33 && nilai >= 25) {
      grade = 'D+';      
    } else if (nilai <= 24) {
      grade = 'D';
    } else {
      grade = '!!'
    }

    $('input.nilai-akhir[type="hidden"]').eq(indexElem).val(nilai);
    var $selector = $('td.grade').eq(indexElem).html(nilai + '&nbsp&nbsp&nbsp' + grade);
    nilai < 59 ? $selector.css('color', 'red') : $selector.css('color', 'black');
  }

  // pindah textbox saat enter
  $('input').keypress(function (e) {
    if (e.keyCode == 13) {
      input = $("input[type=text]");
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

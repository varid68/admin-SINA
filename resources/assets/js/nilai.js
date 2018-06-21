let _absensi = 0;
let _tugas = 0;
let _uts = 0;
let _uas = 0;
let _nilai_akhir = 0;

$('#btn-modal-download').click(function () {
  window.location = '/nilai-pdf';
});

$('a[href="#myModal"]').click(function () {
  $selector = $(this).parent().siblings();
  const nim = $selector.eq(1).text();
  const nama = $(this).text();
  const absensi = $(this).parent().siblings().eq(3).text();
  const tugas = $(this).parent().siblings().eq(4).text();
  const uts = $(this).parent().siblings().eq(5).text();
  const uas = $(this).parent().siblings().eq(6).text();
  const nilaiAkhir = $(this).parent().siblings().eq(7).text();
  const split = nilaiAkhir.split(' ');

  $('#myModal').find('.nim').text(`: ${nim}`);
  $('#myModal').find('.nama').text(`: ${nama}`);
  $('#myModal').find('.absensi').val(absensi);
  $('#myModal').find('.tugas').val(tugas);
  $('#myModal').find('.uts').val(uts);
  $('#myModal').find('.uas').val(uas);
  $('#myModal').find('.nim2').val(nim);
  $('#myModal').find('.nilai-akhir').val(split[0]);
  $('#myModal').find('.skala-nilai').text(nilaiAkhir);
  _absensi = parseInt((absensi / 14) * 10 / 100 * 100);
  _tugas = parseInt(20 / 100 * tugas);
  _uts = parseInt(30 / 100 * uts);
  _uas = parseInt(40 / 100 * uas);
  _nilai_akhir = split[0];
});

$('.absensi').keyup(function (e) {
  _absensi = parseInt((e.target.value / 14) * 10 / 100) * 100;
  calculate();
});

$('.tugas').keyup(function (e) {
  _tugas = parseInt(20 / 100 * e.target.value);
  calculate();
});

$('.uts').keyup(function (e) {
  _uts = parseInt(30 / 100 * e.target.value);
  calculate();
});

$('.uas').keyup(function (e) {
  _uas = parseInt(40 / 100 * e.target.value);
  calculate();
});

function calculate() {
  const nilai = _absensi + _tugas + _uts + _uas;
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
  else grade = '!!';

  $('#myModal').find('.nilai-akhir').val(nilai);
  $('#myModal').find('.skala-nilai').text(`${nilai} (${grade})`);
}
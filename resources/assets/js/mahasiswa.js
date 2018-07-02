$('#btn-modal-add').click(function () {
  $('#general-modal').modal('show');
});

$(document).on('click', '.detail', function () {
  const selector = $(this).parent();
  const nim = selector.siblings().eq(1).text();
  const nama = selector.siblings().eq(2).text();
  const alamat = $(this).data('alamat');

  $('.modal-nama').text(nama);
  $('.modal-nim').text(nim);
  $('.modal-alamat').text(alamat);
});

$(document).on('click', '.edit', function () {
  const selector = $(this).parent();
  const nim = selector.siblings().eq(1).text();
  const nama = selector.siblings().eq(2).text();
  const gender = selector.siblings().eq(3).text();
  const ttl = selector.siblings().eq(4).text();
  const alamat = $(this).data('alamat');
  const a = selector.siblings().eq(5).text();
  const arr = a.split('/');
  const jurusan = arr[0] == 'MI' ? 'Manajemen Informatika' : 'Komputerisasi Akuntansi';
  const tahun_masuk = arr[1];
  const semester = selector.siblings().eq(6).text();


  $('#general-modal').find('input[name="nim"]').val(nim);
  $('#general-modal').find('input[name=nama]').val(nama);
  $('#general-modal').find('#gender').val(gender)
  $('#general-modal').find('input[name=ttl]').val(ttl);
  $('#general-modal').find('textarea').val(alamat);
  $('#general-modal').find('#jurusan').val(jurusan);
  $('#general-modal').find('input[name=tahun_masuk]').val(tahun_masuk);
  $('#general-modal').find('#semester').val(semester);
});

$(document).on('click', '.delete', function () {
  let id = $(this).data('id');
  swal({
    title: 'Are you sure?',
    text: "Yakin ingin menghapus data mahasiswa!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      $('#delete-form').attr('action', '/mahasiswa/' + id).submit();
    }
  })
});

$('#btn-modal-filter').click(function () {
  $('#modal-filter').modal('show');
});


$('#btn-download').click(function () {
  const semester = $('#semester-modal').val();
  const jurusan = $('#jurusan-modal').val();

  if (semester == null || jurusan == null) {
    $('#warning').show();
    return false;
  } else {
    $('#warning').hide();
  }

  window.location = `/mahasiswa-pdf?semester=${semester}&jurusan=${jurusan}`;
});

$('.modal-footer .btn-danger').click(function () {
  $('input.input-sm').val('');
  $('textarea').val('');
  $('#gender').val('pilih gender');
  $('#jurusan').val('pilih jurusan');
  $('#semester').val('pilih semester');
});

$(".table-hover").dataTable({
  stateSave: true,
  responsive: true,
  processing: true,
  serverSide: true,
  ajax: "mahasiswa/datatable",
  columns: [
    { data: 'DT_Row_Index', width: '1%', searchable: false, orderable: false },
    { data: 'nim', name: 'nim' },
    { data: 'nama', name: 'nama' },
    { data: 'gender', name: 'gender', searcable: false, orderable: false },
    { data: 'ttl', name: 'ttl', searchable: false, orderable: false },
    { data: 'jurusan', name: 'jurusan', searcable: false, orderable: false },
    { data: 'semester', name: 'semester', searcable: false, },
    { data: 'action', width: '14%', name: 'action', orderable: false, searchable: false },
  ]
});
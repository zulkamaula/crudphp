$(document).ready(function(){

      // menhilangkan tombol cari dengan jquery
      $('#tombol-cari').hide();
    
    // menggunakan event ketika keyword di tulis

    $('#keyword').on('keyup', function(){
        // munculkan icon loading
        $('.loader').show();

        // $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());
        // fungsi load mempunyai keterbatasan, karna dia hanya bisa menggunakan GET saja. maka harus menggunakan fungsi ajax yang lain

        // bisa menggunakan $.get()
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {

            $('#container').html(data);
            $('.loader').hide();

        });
    });

    
    

});

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="">
        Form Return Barang        
      </h1>      
    </section>




    <!-- Main content -->
    <section class="content container-fluid" >

      <!--------------------------
        | Your Page Content Here |
        -------------------------->    
<!-- Default box -->
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title" id="judul2">Dari Suplier</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
              





<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
              <th width="10px">Id Barang</th>           
              <th>Barang</th>                                           
              <th>Jumlah</th>                     
              <th>Uang Kembali</th>                     
              <th>Dari</th>                     
              <th>No HP</th>                     
              <th>Kondisi</th>                     
              <th>Posisi</th>                     
              <th>Keterangan</th>                     
              <th>Tgl</th>
              <th>Action</th>                     
                                  
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        foreach($all as $x)
        {
          $no++;
            $btn = "<button class='btn  btn-block btn-xs btn-warning' onclick='barang_baru($x->id_ret)'>Barang Baru</button>";

            $btn .= "<button class='btn btn-xs btn-primary btn-block' onclick='uang($x->id_ret)'>Uang</button>";
            $btn .= "<button class='btn btn-xs btn-danger btn-block' onclick='buang($x->id_ret)'>Buang</button>";
            echo (" 
              
              <tr>
                <td>$no</td>
                <td>$x->id</td>
                <td>$x->nama_barang</td>                
                <td>$x->jumlah</td>                
                <td>".rupiah($x->uang_kembali)."</td>                
                <td>$x->nama_pembeli</td>                
                <td>$x->hp_pembeli</td>                
                <td>$x->kondisi</td>                
                <td>$x->posisi</td>                
                <td>$x->ket</td>                
                <td>$x->tgl_trx</td>                
                <td>$btn</td>                
                
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>




</div>
</div>
<!-- /.box -->
</section>
    <!-- /.content -->






    <!-- Main content -->
    <section class="content container-fluid" >

      <!--------------------------
        | Your Page Content Here |
        -------------------------->    
<!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title" id="judul2">History Return Suplier</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
              




<table id="tbl_datanya_a" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
              <th width="10px">Id Barang</th>           
              <th>Barang</th>                                           
              <th>Qty</th>                     
              <th>Jumlah</th>                     
              <th>Dari</th>                     
              <th>No HP</th>                     
              <th>Kondisi</th>                     
              <th>Aksi</th>                     
              <th>Keterangan</th>                     
              <th>Tgl</th>
                                 
                                  
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        foreach($history_suplier as $x)
        {
          $no++;
           
            echo (" 
              
              <tr>
                <td>$no</td>
                <td>$x->id</td>
                <td>$x->nama_barang</td>                
                <td>$x->jumlah</td>                
                <td>".rupiah($x->uang_kembali)."</td>                
                <td>$x->nama_pembeli</td>                
                <td>$x->hp_pembeli</td>                
                <td>$x->kondisi</td>                
                <td>$x->posisi</td>                
                <td>$x->ket</td>                
                <td>$x->tgl_trx</td>                
                         
                
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>




</div>
</div>
<!-- /.box -->
</section>
    <!-- /.content -->




<script>
console.log("<?php echo $this->router->fetch_class();?>");
var classnya = "<?php echo $this->router->fetch_class();?>";


<?php
$o=''; 
foreach($all_barang as $barang)
{
 $o.='{
        value:"'.$barang->id.'",
        label:"'.htmlentities($barang->nama_barang).'",
        stok:"'.htmlentities($barang->qty).'",
        harga_retail:"'.htmlentities($barang->harga_retail).'",
        harga_lusin:"'.htmlentities($barang->harga_lusin).'",
        harga_koli:"'.htmlentities($barang->harga_koli).'",
        jum_per_koli:"'.htmlentities($barang->jum_per_koli).'"
      },';
} 
?>


<?php
$p=''; 
foreach($this->m_pelanggan->m_data() as $pelanggan)
{
 $p.='{
        value:"'.$pelanggan->id_pelanggan.'",
        label:"'.htmlentities($pelanggan->nama_pembeli).'"
      },';
} 
?>



$( function() {
    var semuaBarang = [
      <?php echo $o?>
    ];
    $( ".barang" ).autocomplete({
      source: semuaBarang,
                      minLength: 1,
                select: function(event, ui) {
                  console.log(ui);
                 

                $(this).val(ui.item.label);
                $("#id_barang").val(ui.item.value);
                $("#uang_kembali").val(ui.item.harga_retail);
                $("#uang_kembali_hide").val(ui.item.harga_retail);
                return false;
                }



    });


});



$( function() {
    var semuaPelanggan = [
      <?php echo $p?>
    ];
    $( ".id_pelanggan" ).autocomplete({
      source: semuaPelanggan,
                      minLength: 1,
                select: function(event, ui) {
                  console.log(ui);
                 

                $(this).val(ui.item.label);
                $("#id_pelanggan").val(ui.item.value);                
                return false;
                }



    });


});

function barang_baru(id)
{
  if(confirm("Anda yakin?"))
  {
    
    $.get("<?php echo base_url()?>index.php/barang/barang_baru_dapat_return/"+id,function(e){
        eksekusi_controller('<?php echo base_url()?>index.php/barang/return_list_suplier','Return Suplier');
        console.log(e);

    })
    
    console.log(id);
  }
  return false;
}


function uang(id)
{
  if(confirm("Anda yakin?"))
  {
    $.get("<?php echo base_url()?>index.php/barang/uang_dapat_return/"+id,function(e){
        eksekusi_controller('<?php echo base_url()?>index.php/barang/return_list_suplier','Return Suplier');
        console.log(e);

    })
  }
  return false;
}



function buang(id)
{
  if(confirm("Anda yakin?"))
  {
    $.get("<?php echo base_url()?>index.php/barang/buang_barang/"+id,function(e){
        eksekusi_controller('<?php echo base_url()?>index.php/barang/return_list_suplier','Return Suplier');
        console.log(e);

    })
  }
  return false;
}






function buang_titik(mystring)
{
  return (mystring.replace(/\./g,''));
}


$("#jumlah_barang").on("keydown keyup mousedown mouseup select contextmenu drop",function(){
    var jum   = parseInt(buang_titik($(this).val()));
    var uang  = parseInt(buang_titik($("#uang_kembali_hide").val()));

    console.log(jum);
    console.log(uang);
    var hasil_kali = jum*uang;

    console.log(hasil_kali);
    if(isNaN(hasil_kali))
    {
      hasil_kali=0;
    }
    $("#uang_kembali").val(hasil_kali);
})

$("#form_return").on("submit",function(){
  console.log($(this).serialize());
  if(confirm("Anda yakin?"))
  {
    $.post("<?php echo base_url()?>index.php/barang/go_return_barang",$(this).serialize(),function(e){
      cetak(e);
      eksekusi_controller('<?php echo base_url()?>index.php/barang/return_barang','Return Barang');
    })
  }
  return false;
})

function cetak(id_ret)
{
  window.open("<?php echo base_url()?>index.php/barang/cetak_return_by_id/"+id_ret); 
}

$(document).ready(function(){

  $('#tbl_datanya').dataTable();
  $('#tbl_datanya_a').dataTable();

});

hanya_nomor(".nomor");

</script>

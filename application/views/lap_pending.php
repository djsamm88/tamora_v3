
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="judul">
        Selamat datang di POS
        <small></small>
      </h1>      
    </section>

    <!-- Main content -->
    <section class="content container-fluid" >

      <!--------------------------
        | Your Page Content Here |
        -------------------------->    
<!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title" id="judul2"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
<div class="table-responsive">              
<table id="tbl_datanya_barang" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>                    
              <th>Kasir</th>                     
              <th>Tanggal</th>                     
              <th>Tgl.Manual</th>                     
              <th>Kode Trx.</th>                     
              <th>Kepada</th>                     
              <th>Sub Total</th>                     
              <th>Diskon</th>                     
              <th>Ekspedisi</th>                     
              <th>Transport Ke Ekspedisi</th>                     
              <th>Total</th>                     
              <th>Struk</th>                     
              
              
        </tr>
      </thead>
      <tbody>
        <?php         
        $no = 0;
        foreach($all as $x)
        {
          $no++;
            
            echo (" 
              
              <tr>
                <td>$no</td>                
                <td>".($x->nama_admin)." <br>".($x->email_admin)."</td>
                <td>".($x->tgl_transaksi)."</td>
                <td>".($x->tgl_trx_manual)."</td>

                <td>$x->grup_penjualan</td>                
                <td>$x->nama_pembeli -[ $x->id_pelanggan ]</td>                
                <td align=right>".rupiah($x->total)."</td>                
                <td align=right>".rupiah($x->diskon)."</td>                
                <td align=right>".rupiah($x->harga_ekspedisi)."</td>                
                <td align=right>".rupiah($x->transport_ke_ekspedisi)."</td>                
                <td align=right>".rupiah($x->total-$x->diskon+($x->harga_ekspedisi+$x->transport_ke_ekspedisi))."</td>                
                <td>
                  <button class='btn btn-primary btn-block btn-xs' onclick='proses_pending(\"$x->grup_penjualan\")'>Proses</button>

                    <button class='btn btn-danger btn-block btn-xs' onclick='hapus_pending(\"$x->grup_penjualan\")'>Hapus</button>
                </td>                                
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>
</div>


        </div>
        
      </div>
      <!-- /.box -->

</section>
    <!-- /.content -->




<script>
console.log("<?php echo $this->router->fetch_class();?>");
var classnya = "<?php echo $this->router->fetch_class();?>";

function proses_pending(grup_penjualan)
{
  eksekusi_controller('<?php echo base_url()?>index.php/barang/form_penjualan_pending/'+grup_penjualan,'Penjualan Pending');
  console.log('<?php echo base_url()?>index.php/barang/form_penjualan_pending/'+grup_penjualan,'Penjualan Pending');
  //alert(grup_penjualan)
}


function hapus_pending(grup_penjualan)
{
  if(confirm("Anda yakin?"))
  {
    $.get("<?php echo base_url()?>index.php/barang/hapus_pending/"+grup_penjualan,function(){
        eksekusi_controller('<?php echo base_url()?>index.php/barang/lap_pending/','Penjualan Pending');  
      })
  }
  
}

$(document).ready(function(){

  $('#tbl_datanya_barang').dataTable();

});
$("#judul2").html("DataTable "+document.title);
</script>

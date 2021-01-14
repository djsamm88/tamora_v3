
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 id="judul">
        Kasir
        
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
          <h3 class="box-title" id="judul2">Penjualan</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">


<form id="penjualan_barang">
  <div class="row">
  
  <div class="col-sm-4">
    <input type="text" name="nama_pembeli" id="nama_pembeli" value="<?php echo $pelanggan->nama_pembeli?>" class="form-control" required placeholder="Nama pembeli" readonly>
    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $pelanggan->id_pelanggan?>">
    <small><i>Nama Pembeli</i></small>
  </div>
  <div class="col-sm-4">
    <input type="text" name="hp_pembeli" id="hp_pembeli" value="<?php echo $pelanggan->hp_pembeli?>" class="form-control" required placeholder="HP pembeli" readonly>
    <small><i>HP Pembeli</i></small>
  </div>
  
  <div class="col-sm-4">
    <input type="text" name="tgl_trx_manual" value="<?php echo date('Y-m-d H:i:s')?>" class="form-control datepicker" readonly>
    <small><i>Format Y-m-d H:i:s</i></small>
    <input type="hidden" name="grup_penjualan" value="<?php echo date('ymdHis')?>" class="form-control " readonly>
  </div>

</div>
  <div style="clear: both;"></div>
  <br>
<input type="text"   class="form-control barang" placeholder="Barang">
<br>
<div class="table-responsive">
<table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th width="10px">Id</th>                                                      
              <th>Barang</th>                                                                                  
              <th>Berat</th>                                                                                  
              <th>Satuan</th>                                   
              <th>Harga</th>                                                 
              <th>Qty</th>
              <th>Sub Total</th>
              <th>Sub Berat(g)</th>  
              <th>-</th>                                          
                              
              
              
        </tr>
      </thead>
      <tbody id="t4_order">
        
      </tbody>
      <tfoot>


        <tr>
          
          <td colspan="7" align="right"><b></b></td>
          <td  align="right" >

              <input type="text" name="total_berat" class="form-control" readonly="" id="total_berat" style="text-align: right;"><small>gram</small>
          </td>
          <td></td>
        </tr>

        <tr>

          <td colspan="6" align="right"><b>Ekspedisi</b></td>
          <td  align="right" >
            
            <select class="form-control" id="province_id" name="province_id">              
            </select>
            <select class="form-control" id="city_id" name="city_id">              
            </select>
            <select class="form-control" id="subdistrict_id" name="subdistrict_id">              
            </select>
            <select class="form-control" id="courier" name="courier">              
            </select>

            <select class="form-control" id="service" name="service">              
            </select>

            <input id="ongkir" type="text" name="ongkir" class="form-control nomor" style="text-align:right;" readonly>

            <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" placeholder="alamat lengkap"></textarea>
            
            <input type="hidden" id="t4_service" name="nama_ekspedisi">
            <input type="hidden" id="t4_alamat_lengkap" name="alamat">


          </td>
          <td></td>
        </tr>



        <tr>
          <td colspan="6" align="right"><b>Saldo</b></td>
          <td  align="right" >
            <input id="t4_saldo" type="text" name="saldo" class="form-control nomor" value="<?php echo $pelanggan->saldo?>" style="text-align:right;" readonly>
          </td>
          <td></td>
        </tr>




        <tr>
          <td colspan="6" align="right"><b>Total</b></td>
          <td id="t4_total" align="right" style="font-weight: bold;"></td><td></td>
        </tr>


      </tfoot>
  </table>
</div>
  <textarea class="form-control" name="keterangan" placeholder="keterangan"></textarea><br>

<div class="col-sm-6" style="text-align: right;">
    <input type="submit" value="Pesan" class="btn btn-primary" id="simpan"> 
</div>
<div style="clear: both;"></div>




</form>


      </div>
      <!-- /.box -->

</section>
    <!-- /.content -->





<script type="text/javascript">
var classnya = "<?php echo $this->router->fetch_class();?>";
$(".barang").focus();

$('.datepicker').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd <?php echo date('H:i:s')?>' 
})
notif_member(); 

total();


$("#nama_ekspedisi").on("change",function(){
  if($(this).val()=="")
  {
    $("#t4_ekspedisi").val("0");
  }
  $.get("<?php echo base_url()?>index.php/ekspedisi/by_nama/"+encodeURI($(this).val()),function(e){
      console.log(e);
      
      $("#t4_ekspedisi").val(e[0].harga_ekspedisi);
      total();

  })
})

/********* ongkir ********/
$(document).ready(function(){
  list_province();
})
function list_province()
{
  $.get("<?php echo base_url()?>index.php/ongkir/list_province",function(e){
      //console.log(e.rajaongkir.results);
      $("#province_id").empty();
      $("#province_id").append("<option value=''>--- Provinsi ---</option>");
      $.each(e.rajaongkir.results,function(key,val){
          
          $("#province_id").append("<option value='"+val.province_id+"'>"+val.province+"</option>");

      })
  })
}

$("#province_id").on("change",function(e){
  total();
  var province_id = $(this).val();
  console.log("province_id:"+province_id);
  list_city(province_id);
  $("#subdistrict_id").empty();
  $("#courier").empty();
  $("#service").empty();
  $("#ongkir").val("");
})

function list_city(province_id)
{
  $.get("<?php echo base_url()?>index.php/ongkir/list_city/"+province_id,function(e){
      //console.log(e.rajaongkir.results);
      $("#city_id").empty();
      $("#city_id").append("<option value=''>--- Kota/Kab ---</option>");
      $.each(e.rajaongkir.results,function(key,val){
          
          $("#city_id").append("<option value='"+val.city_id+"'>"+val.city_name+"</option>");
      })
  })
}

$("#city_id").on("change",function(e){
  total();
  var city_id = $(this).val();
  console.log("city:"+city_id);
  list_subdistrict(city_id);
  $("#subdistrict_id").empty();
  $("#courier").empty();
  $("#service").empty();
  $("#ongkir").val("");
})

function list_subdistrict(city_id)
{
  $.get("<?php echo base_url()?>index.php/ongkir/list_subdistrict/"+city_id,function(e){
      //console.log(e.rajaongkir.results);
      $("#subdistrict_id").empty();
      $("#subdistrict_id").append("<option value=''>--- Kecamatan ---</option>");
      $.each(e.rajaongkir.results,function(key,val){
          
          $("#subdistrict_id").append("<option value='"+val.subdistrict_id+"'>"+val.subdistrict_name+"</option>");
      })
  }) 
}


$("#subdistrict_id").on("change",function(e){
  total();
  var subdistrict_id = $(this).val();
  console.log("subdistrict_id:"+subdistrict_id);
  list_courier();

  $("#courier").empty();
  $("#service").empty();
  $("#ongkir").val("");
})

function list_courier()
{
  $.get("<?php echo base_url()?>index.php/ongkir/list_kurir/",function(e){
      //console.log(e.rajaongkir.results);
      $("#courier").empty();
      $("#courier").append("<option value=''>--- Kurir ---</option>");
      $.each(e,function(key,val){          
          $("#courier").append("<option value='"+val+"'>"+val+"</option>");
      })
  }) 
}

$("#courier").on("change",function(){
  total();
  
  var weight = buang_titik($("#total_berat").val());//disini nanti berat gram
  var origin = "1558";
  var originType = "subdistrict";
  var destination = $("#subdistrict_id").val();
  var destinationType = "subdistrict";
  var courier = $(this).val();

  var all = {
              weight:weight,
              origin:origin,
              originType:originType,
              destination:destination,
              destinationType:destinationType,
              courier:courier
            };
  $.get("<?php echo base_url()?>index.php/ongkir/cost/",all,function(e){

      $("#ongkir").empty();
      $("#ongkir").val("");
      $("#service").empty();
      $("#service").append("<option value=''>--- Layanan ---</option>");
      $.each(e,function(key,val){          
          console.log(val);  

          $("#t4_alamat_lengkap").val(val.destination_details.province+", "+val.destination_details.type+" "+val.destination_details.city+", Kec."+val.destination_details.subdistrict_name);


          $.each(val.results,function(x,y){
            

            $.each(y.costs,function(a,b){
              //console.log(b);
              var layanan = b.description+" | "+b.service;
              $("#service").append("<option value='"+b.cost[0].value+"'>"+layanan+"</option>");
              
            })
          })        
      })
      
  }) 

})

$("#service").on("change",function(){
  total();
  var ongkir  = $(this).val();
  var desc    =  $(this).find('option:selected').text();
  $("#t4_service").val(desc);
  $("#ongkir").val(formatRupiah(ongkir));
})
/********* ongkir ********/


$( function() {

    var semuaBarang = function(request,response){
            console.log(request.term);
            var serialize = {cari:request.term};
            $.get("<?php echo base_url()?>index.php/pelanggan/json_barang_member",serialize,
              function(data){
                /*
                response(data);
                console.log(data);
                */
                response($.map(data, function(obj) {
                    return {
                        label: obj.nama_barang,
                        value: obj.id,
                        stok: obj.qty,
                        harga_retail: obj.harga_retail, 
                        harga_lusin: obj.harga_lusin, 
                        harga_koli: obj.harga_koli, 
                        jum_per_koli: obj.jum_per_koli, 
                        jum_per_lusin: obj.jum_per_lusin, 
                        reminder: obj.reminder, 
                        berat:obj.berat
                    };
                }));
                
            })
          }

    var ii=0;
    $( ".barang" ).autocomplete({
      source: semuaBarang,
      minLength: 1,

      select: function(event, ui) {
        console.log(ui);        
        $(this).val('');

       if(ui.item.stok=="0")
       {
        alert("Stok gudang KOSONG. Item : "+ui.item.label);
        return false;
       }

       if(ui.item.stok<ui.item.reminder)
       {
        //notif();//notif ini dari footer welcome
       }

      var option =   "<option value='retail'>Retail</option>"+
                      "<option value='lusin'>Lusin</option>"+
                      "<option value='koli'>Koli</option>";

      var stok          = parseInt(ui.item.stok);
      var jum_per_lusin = parseInt(ui.item.jum_per_lusin);
      var jum_per_koli  = parseInt(ui.item.jum_per_koli);

      if(stok<jum_per_lusin){
        var option =   "<option value='retail'>Retail</option>"+                        
                        "<option value='koli'>Koli</option>";
      }

      if(stok<jum_per_koli){
        var option =   "<option value='retail'>Retail</option>"+                        
                        "<option value='lusin'>Lusin</option>";
      }

      if(stok<jum_per_koli && stok<jum_per_lusin ){
        var option =   "<option value='retail'>Retail</option>";
      }

      

       
                  
       var pilih_satuan = "<select name='satuan_jual["+ii+"]' class='form-control' id='pilihSatuan' onchange='gantiHarga("+ui.item.harga_retail+","+ui.item.harga_lusin+","+ui.item.harga_koli+","+ui.item.jum_per_koli+","+ui.item.jum_per_lusin+",$(this))'>"+
                          option+
                         "</select>";

        var jum_batas = "<input id='stok' type='hidden' value='"+stok+"'>"+
                        "<input id='jum_per_koli' type='hidden' value='"+ui.item.jum_per_koli+"'>"+
                        "<input id='jum_per_lusin' type='hidden' value='"+ui.item.jum_per_lusin+"'>"+
                        "<input id='id_barang' name='id_barang["+ii+"]' type='hidden' value='"+ui.item.value+"'>";

        var template = "<tr>"+                
                "<td>"+jum_batas+ui.item.value+"</td>"+

                "<td>"+ui.item.label+"</td>"+                
                "<td align='right' id='t4_berat'>"+ui.item.berat+"</td>"+
                "<td>"+pilih_satuan+"</td>"+
                "<td align='right'>"+
                  "<input  id='t4_harga' class='form-control' readonly name='harga_jual["+ii+"]' value='"+formatRupiah(ui.item.harga_retail)+"'>"+
                "</td>"+
                "<td>"+
                "<input class='form-control' type='number' id='jumlah_beli' name='jumlah["+ii+"]'  placeholder='qty' required value='1'>"+
                "</td>"+
                "<td align='right' id='t4_sub_total'>"+ui.item.harga_retail+"</td>"+
                "<td align='right' id='t4_sub_berat'>"+ui.item.berat+"</td>"+
                "<td><button class='btn btn-danger btn-xs' id='remove_order' type='button'>Hapus</button></td></tr>"
                
                          ;
                  $("#t4_order").append(template);
                  $(".barang").val("");
                  
                  //console.log(template);
              ii++;

              //alert(ii);
              return false;
        }

    });


});

function gantiHarga(a,b,c,d,e,ini)
{

  var t4_harga = ini.parent().parent().find("#t4_harga");
  var t4_sub_total = ini.parent().parent().find("#t4_sub_total");
  var jumlah_beli = ini.parent().parent().find("#jumlah_beli");



  $("#t4_total").html('');


  jumlah_beli.val("");
  t4_sub_total.html("");

  var ret;
  if(ini.val()=="retail")
  {
    ret = a;
  }

  if(ini.val()=="lusin")
  {
    ret = b;
    jumlah_beli.val(e);
  }

  if(ini.val()=="koli")
  {
    ret = c;
    jumlah_beli.val(d);
  }  


  t4_harga.val(formatRupiah(ret));

  sub_total(jumlah_beli);
  sub_total_berat(jumlah_beli);
  
}

$("#tbl_datanya").on("click","tbody tr td button#remove_order",function(x){
  $(this).parent().parent().remove();
  
  return false;
})


$("#tbl_datanya").on("keydown keyup mousedown mouseup select contextmenu drop","tbody tr td input#jumlah_beli",function(){ 
  
  var dibeli        = parseInt($(this).val());
  var jum_per_koli  = parseInt($(this).parent().parent().find("#jum_per_koli").val());
  var jum_per_lusin = parseInt($(this).parent().parent().find("#jum_per_lusin").val());
  var stok = parseInt($(this).parent().parent().find("#stok").val());

  var pilihSatuan   = $(this).parent().parent().find("#pilihSatuan").val();


  
  if(pilihSatuan=='koli' && dibeli<jum_per_koli){
    console.log("jum_per_koli"+jum_per_koli);
    //alert("Minimal beli Koli barang ini = "+jum_per_koli);
    $(this).attr('min',jum_per_koli);
    //$(this).val(jum_per_koli);
  }

  if(pilihSatuan=='lusin' && dibeli<jum_per_lusin){
    console.log("jum_per_koli"+jum_per_lusin);
    //alert("Minimal beli Lusin barang ini = "+jum_per_lusin);
    $(this).attr('min',jum_per_lusin);
    //$(this).val(jum_per_lusin);
  }

  if(stok<dibeli)
  {
    alert("Maaf, Stok barang tinggal "+stok);
    $(this).val(stok);
  }
  


  sub_total($(this));  
  sub_total_berat($(this));
  

})





$("body,#t4_diskon,#nama_ekspedisi,#t4_transport_ke_ekspedisi,#t4_ekspedisi,.barang,#nama_pembeli,#alamat_lengkap,#alamat").on("keydown keyup mousedown mouseup select contextmenu drop",function(){
    total();
})


$("#t4_bayar").on("keydown keyup mousedown mouseup select contextmenu drop",function(){
    var tot = parseInt(buang_titik($("#t4_total").text()));
    var bayar = parseInt(buang_titik($(this).val()));

    var kembalian = bayar - tot;
    $("#t4_kembali").html(formatRupiah(kembalian));
    console.log(tot);

})

function sub_total(ini)
{
    var qty = ini.val();
    if(qty=="")
    {
      qty=0;
    }
    var harga = buang_titik(ini.parent().parent().find("#t4_harga").val());

    var sub_total = parseInt(qty)*parseInt(harga);

    ini.parent().parent().find("#t4_sub_total").html(formatRupiah(sub_total));  
    
    total();
}

function sub_total_berat(ini)
{
  var qty = ini.val() || 0;
  var berat = buang_titik(ini.parent().parent().find("#t4_berat").text()) || 0;
  var sub_total_berat = parseInt(qty)*parseInt(berat);
  ini.parent().parent().find("#t4_sub_berat").html(formatRupiah(sub_total_berat)); 
  total();
}


function total()
{
  var total=0;
  $("tbody#t4_order tr td#t4_sub_total").each(function(){
     total+= parseInt(buang_titik($(this).text()));

  })
  console.log(total);

  var saldo  = parseInt(buang_titik($("#t4_saldo").val())) || 0;
  var ongkir = parseInt(buang_titik($("#ongkir").val())) || 0;
  total+=ongkir;
  total-=saldo;
  $("#t4_total").html(formatRupiah(total));



  //berat
  var tot_berat = 0;
  $("tbody#t4_order tr td#t4_sub_berat").each(function(){
     tot_berat+= parseInt(buang_titik($(this).text()));

  })
  $("#total_berat").val(formatRupiah(tot_berat));

}




$("#penjualan_barang").on("submit",function(){
  if($("#t4_total").html()=="")
  {
    total();
    return false;
  }
  if(confirm("Anda yakin selesai?"))
  {
   
    $.post("<?php echo base_url()?>index.php/pelanggan/go_pesan",$(this).serialize(),function(x){
      console.log(x);
      eksekusi_controller('<?php echo base_url()?>index.php/pelanggan/pesanan_member','Pesanan Member');
      notif_member();
    })
  
  }

return false;  
})





hanya_nomor(".nomor");
function buang_titik(mystring)
{
  return (mystring.replace(/\./g,''));
}

function formatRupiah(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


</script>
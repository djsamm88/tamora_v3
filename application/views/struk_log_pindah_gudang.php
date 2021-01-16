<link rel="stylesheet" href="<?php echo base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
<style>
body{
  font-size: 12px;
  padding: 50px;
}
table{
    border-collapse: collapse;
}
table tr td, th  { 
  
  font-size: 12px; padding:5px;
  

}
table th{
      text-align: center;
        border: 1px solid black;

      
    }

td {
      
      padding:5px;
        border: 1px solid black;

      
    }
  .col-sm-4{
    width: 30%;
  }
  .col-sm-8{
   width: 70%; 
  }
</style>
<?php 
  $x = $all[0];
?>

<body>
  
  <div class="text-center" style="font-weight:bold;font-size: 14">      
      BUKTI SERAH TERIMA PINDAH GUDANG
  </div>
  <table id="tbl_datanya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
    <tr>
      <td width="30%">Tgl</td><td><?php echo $x->tgl?></td>
    </tr>


  </table>
    
<table id="tbl_newsnya" class="table  table-striped table-bordered"  cellspacing="0" width="100%">
      <thead>
        <tr>
              
              <th>No</th>
               <th width="100px">Tgl</th>
                <th>Nama Barang</th>
                <th>Gudang Lama</th>
                <th>Gudang Baru</th>
                <th>Jumlah</th>
                <th>Oleh</th>
                <th>Catatan</th>
                
              
              
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
                <td>$x->tgl</td>
                <td>$x->nama_barang</td>
                <td>$x->nama_gudang_lama</td>
                <td>$x->nama_gudang_baru</td>
                <td>$x->jumlah</td>
                <td>$x->nama_admin</td>
                <td>$x->catatan</td>
                
                
              </tr>
          ");
          
        }
        
        
        ?>
      </tbody>
  </table>


</body>

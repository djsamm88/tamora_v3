<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');				
		$this->load->helper('custom_func');
		if ($this->session->userdata('id_admin')=="") {
			redirect(base_url().'index.php/login');
		}
		$this->load->helper('text');
		date_default_timezone_set("Asia/jakarta");
		//$this->load->library('datatables');
		$this->load->model('m_barang');
		$this->load->model('m_ambil');

	}


	public function barang_transaksi()
	{
		$data['all'] = $this->m_barang->m_barang_transaksi();	
		$this->load->view('barang_transaksi',$data);
	}


	public function kalkulasi_barang()
	{
		header('Content-Type: application/json');
		$serialize = $this->input->post();
		
		echo json_encode($serialize);
	}

	public function go_jual()
	{
		$data = $this->input->post();

		//var_dump($data);
		$total_tanpa_diskon =0; 
		$total_harga_beli 	=0; 
		foreach ($data['harga_jual'] as $key => $harga_jual) {
			# code...
			//echo $key;
			/********** mengambil detail barang dari db***********/
			$q_detail_barang = $this->m_barang->m_by_id($key);
			$barang = $q_detail_barang[0];
			/********** mengambil detail barang dari db***********/


			$serialize['id_admin'] 		= $this->session->userdata('id_admin');
			$serialize['id_barang'] 	= $key;
			$serialize['harga_jual'] 	= hanya_nomor($harga_jual);
			$serialize['satuan_jual'] 	= $data['satuan_jual'][$key];
			$serialize['jenis'] 		= 'keluar';
			$serialize['grup_penjualan'] = $data['grup_penjualan'];			
			$serialize['nama_pembeli'] 	= $data['nama_pembeli'];
			$serialize['hp_pembeli'] 	= $data['hp_pembeli'];
			
			$serialize['nama_packing'] 	= $data['nama_packing'];
			$serialize['tgl_trx_manual']= $data['tgl_trx_manual'];
			$serialize['keterangan']	= $data['keterangan'];




			$serialize['diskon'] 		= hanya_nomor($data['diskon']);
			$serialize['bayar'] 		= hanya_nomor($data['bayar']);

			$serialize['sub_total_jual']= $serialize['harga_jual']*$data['jumlah'][$key];
			$serialize['sub_total_beli']= $barang->harga_pokok*$data['jumlah'][$key];
			$serialize['qty_jual']		= $data['jumlah'][$key];
			$serialize['jum_per_koli']	= $barang->jum_per_koli;
			$serialize['harga_beli']	= $barang->harga_pokok;
			


			$serialize['jumlah'] = $data['jumlah'][$key];

			/************ insert ke tbl_barang_transaksi *************/
			$this->m_barang->insert_trx_barang($serialize);
			/************ insert ke tbl_barang_transaksi *************/

			$total_tanpa_diskon	+=$serialize['sub_total_jual'];
			$total_harga_beli	+=$serialize['sub_total_beli'];
		}



		/*********** insert ke transaksi **************/	
		$ket = "Kpd: [".$data['nama_pembeli']."] nama packing: [".$data['nama_packing']."] Kode TRX:[".$data['grup_penjualan']."] Jumlah:[".rupiah($total_tanpa_diskon)."] diskon:[".$data['diskon']."] ".$data['keterangan'];

		$ser_trx = array(
						"id_group"		=> "8",							
						"keterangan"	=> $ket,
						"jumlah"		=> ($total_tanpa_diskon),
						"harga_beli"	=> ($total_harga_beli),
						"diskon"		=> $serialize['diskon'],
						"id_referensi"	=> $data['grup_penjualan']
					);				
		/* untuk id_referensi = id_group/id_table*/				
		$this->db->set($ser_trx);
		$this->db->insert('tbl_transaksi');
		/*********** insert ke transaksi **************/

		/********* insert diskon **********/
		if(hanya_nomor($data['diskon'])>0)
		{
			$ser_trx_diskon = array(
						"id_group"=>"9",							
						"keterangan"=>$ket,
						"jumlah"=>hanya_nomor($data['diskon']),
						"id_referensi"=>$data['grup_penjualan']
					);	
			$this->db->set($ser_trx_diskon);
			$this->db->insert('tbl_transaksi');

		}		
		/********* insert diskon **********/

		echo $data['grup_penjualan'];
	}

	public function form_penjualan()
	{
		$data['all'] = $this->m_barang->m_data();		
		$this->load->view('form_penjualan_barang',$data);
	}

	public function struk_penjualan($group_penjualan)
	{
		$data['data'] = $this->m_barang->m_detail_penjualan($group_penjualan);		
		$this->load->view('struk',$data);
	}



	public function slip_barang()
	{
		
		
		
		$id_jamaah 	= $this->input->get('id_jamaah');
		$id_paket 	= $this->input->get('id_paket');
		$data['id_paket'] = $id_paket;
		$data['id_jamaah'] = $id_jamaah;		
		$data['trx'] = $this->m_barang->m_history($id_paket,$id_jamaah);


		$q = $this->db->query("SELECT * FROM tbl_jamaah WHERE id_jamaah='$id_jamaah'");
		$qq = $q->result();

		$data['jamaah'] = $qq[0];

		$q_p = $this->db->query("SELECT * FROM tbl_paket WHERE id='$id_paket'");
		$qq_p = $q_p->result();

		$data['paket'] = $qq_p[0];


		//var_dump($staff_arr);
		$filename = "slip_barang_".$this->router->fetch_class()."_".date('d_m_y_h_i_s');
		
		// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
		$pdfFilePath = FCPATH."/downloads/$filename.pdf";
		
		 //$html = $this->load->view('slip_pembayaran.php',$data);
    
    	//echo json_encode($data);
    	//$this->load->view('template/part/laporan_pdf.php',$data);
    	
    	
		if (file_exists($pdfFilePath) == FALSE)
		{
			//ini_set('memory_limit','512M'); // boost the memory limit if it's low <img class="emoji" draggable="false" alt="" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
        	ini_set('memory_limit', '2048M');
			//$html = $this->load->view('laporan_mpdf/pdf_report', $data, true); // render the view into HTML
			$html = $this->load->view('slip_barang.php',$data,true);
			
			$this->load->library('pdf_potrait'); 
			$pdf = $this->pdf_potrait->load();
			//$this->load->library('pdf');
			//$pdf = $this->pdf->load();

			$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date("YmdHis")."_".$this->session->userdata('id_admin')); // Add a footer for good measure <img class="emoji" draggable="false" alt="" src="https://s.w.org/images/core/emoji/72x72/1f609.png">
			$pdf->WriteHTML($html); // write the HTML into the PDF
			$pdf->Output($pdfFilePath, 'F'); // save to file because we can
		}
		 
		redirect(base_url()."downloads/$filename.pdf","refresh");
		
		
	}



	public function data()
	{
		$data['all'] = $this->m_barang->m_data();	
		$this->load->view('data_barang',$data);
	}


	public function return_barang()
	{
		$data['all'] = $this->m_barang->m_return_barang();	
		$data['all_barang'] = $this->m_barang->m_data();	
		$this->load->view('return_barang',$data);
	}

	public function go_return_barang()
	{
		$data = $this->input->post();
		$nama_barang = $data['nama_barang'];
		$uang_total = hanya_nomor($data['uang_kembali']);

		unset($data['nama_barang']);
		unset($data['uang_kembali']);

		$data['uang_kembali'] = $uang_total;

		$this->db->set($data);
		$this->db->insert('tbl_barang_return');



		/*********** insert ke transaksi **************/	
		$ket = "Kpd: [".$data['nama']."] nama barang: [".$nama_barang."] id_barang:[".$data['id_barang']."] Jumlah:[".($data['jumlah'])."]  -".$data['ket'];

		$ser_trx = array(
						"id_group"=>"6",							
						"keterangan"=>$ket,
						"jumlah"=>($uang_total),
						"id_referensi"=>$data['id_barang']
					);				
		/* untuk id_referensi = id_group/id_table*/				
		$this->db->set($ser_trx);
		$this->db->insert('tbl_transaksi');
		/*********** insert ke transaksi **************/
	}


	public function lap_penjualan()
	{
		$data['all'] = $this->m_barang->m_lap_penjualan();	
		$this->load->view('lap_penjualan',$data);
	}


	public function data_beli()
	{
		$data['all'] = $this->m_barang->m_data();	
		$this->load->view('data_barang_beli',$data);
	}

	public function go_beli()
	{
		$qty = $this->input->post('qty');
		$harga = $this->input->post('harga');
		$harga_beli = $this->input->post('harga_beli');

		$id_barang = $this->input->post('id_barang');

		if($harga>0 && $harga!='')
		{
		$this->db->query("INSERT INTO tbl_barang_transaksi 
								SET 
								jenis='masuk', 
								jumlah='$qty',
								harga_beli='$harga_beli',
								id_barang='$id_barang'
							");			
		
		$this->db->query("UPDATE tbl_barang 
							SET 
							harga_pokok='$harga' 
							WHERE 
							id='$id_barang'
						");

		$ket = "Barang masuk id[$id_barang] qty=[$qty], harga[$harga_beli]";

		/*********** insert ke transaksi **************/	
		$ser_trx = array(
						"id_group"=>"1",							
						"keterangan"=>$ket,
						"jumlah"=>($harga_beli*$qty),
						"id_barang"=>$id_barang
					);				
		/* untuk id_referensi = id_group/id_table*/
		$qq = $this->db->query("SELECT id_transaksi FROM `tbl_barang_transaksi` ORDER BY id_transaksi DESC LIMIT 1");
		$qqq = $qq->result();
		$ser_trx['id_referensi'] = $qqq[0]->id_transaksi;	
		$this->db->set($ser_trx);
		$this->db->insert('tbl_transaksi');
		/*********** insert ke transaksi **************/


		
		}
		
	}

	public function data_json()
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_barang->m_data();	
		echo json_encode($data['all']);
	}


	public function by_id($id)
	{
		header('Content-Type: application/json');
		$data['all'] = $this->m_barang->m_by_id($id);
		echo json_encode($data['all']);
	}


	public function simpan_form()
	{
		$id = $this->input->post('id');
		
		$serialize = $this->input->post();

		
		$serialize['harga_retail'] = hanya_nomor($serialize['harga_retail']);
		$serialize['harga_lusin'] = hanya_nomor($serialize['harga_lusin']);
		$serialize['harga_koli'] = hanya_nomor($serialize['harga_koli']);
		$serialize['jum_per_koli'] = hanya_nomor($serialize['jum_per_koli']);
		$serialize['harga_pokok'] = hanya_nomor($serialize['harga_pokok']);

		if($id=='')
		{
			
			$this->m_barang->tambah_data($serialize);
			die('1');
		}else{

			$this->m_barang->update_data($serialize,$id);
			die('1');			

		}
		

	}

	public function hapus($id)
	{
		$this->m_barang->m_hapus_data($id);
	}


}
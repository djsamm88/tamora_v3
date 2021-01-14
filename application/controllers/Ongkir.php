<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ongkir extends CI_Controller {
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
		$this->load->model('m_admin');


		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: *");
		header('Content-Type: application/json');

		
	}

	public function list_province()
	{
		echo ($this->exec_url("https://pro.rajaongkir.com/api/province"));
	}


	public function list_city($province_id)
	{
		echo ($this->exec_url("https://pro.rajaongkir.com/api/city/?province=$province_id"));
	}

	public function list_subdistrict($city_id)
	{
		echo ($this->exec_url("https://pro.rajaongkir.com/api/subdistrict/?city=$city_id"));	
	}


	public function list_kurir()
	{
		echo json_encode(array("jne","pos", "tiki","wahana", "sicepat", "jnt"));
	}


	public function cost()
	{
		$weight = $this->input->get('weight');
		$origin = $this->input->get('origin');
		$originType = $this->input->get('originType');
		$destination = $this->input->get('destination');
		$destinationType = $this->input->get('destinationType');
		$courier = $this->input->get('courier');
 
		echo (
				$this->exec_post(
						"https://pro.rajaongkir.com/api/cost",
						"origin=$origin&originType=$originType&destination=$destination&destinationType=$destinationType&weight=$weight&courier=$courier"
					)
			);	
	}


	private function  exec_post($fullurl,$fields)
	{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_FAILONERROR, 0);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");			   
			curl_setopt($ch, CURLOPT_URL, $fullurl);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'key: 2a59604567925a9ab9cf3d8a10af34b6'
			));
			
			$returned =  curl_exec($ch);
		
			return ($returned);

	}


	private function  exec_url($fullurl)
	{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_FAILONERROR, 0);
			curl_setopt($ch, CURLOPT_URL, $fullurl);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'key: 2a59604567925a9ab9cf3d8a10af34b6'
			));
			
			$returned =  curl_exec($ch);
		
			return ($returned);

	}


}

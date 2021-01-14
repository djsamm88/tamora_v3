<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_login extends CI_Model {

	public function cek_admin($data) {
		
		$query = $this->db->get_where('tbl_admin',$data);			
		return $query;
	}


	public function cek_user($user,$pass) {
		
		//$query = $this->db->query("SELECT * FROM tbl_admin  WHERE (user_admin='$user' AND pass_admin='$pass') OR (email_admin='$user' AND pass_admin='$pass')");
        $user = iconv(mb_detect_encoding($user, mb_detect_order(), true), "UTF-8", $user);
        $pass = iconv(mb_detect_encoding($pass, mb_detect_order(), true), "UTF-8", $pass);
		$query = $this->db->query("
					SELECT * FROM 
						(
							SELECT 
								id_admin,
								email_admin,
								user_admin,
								nama_admin,
								pass_admin,
								level,
								status_admin

								FROM tbl_admin a 

								UNION ALL 

								SELECT 
								id_pelanggan AS id_admin,
								email_pembeli AS email_admin,
								email_pembeli AS user_admin,
								nama_pembeli AS nama_admin,
								CONVERT(MD5(password) USING utf8) AS pass_admin,
								'5' AS level,
								'1' AS status_admin

								FROM `tbl_pelanggan` WHERE status='member'

						)a 
					WHERE (user_admin='$user' AND pass_admin='$pass') OR (email_admin='$user' AND pass_admin='$pass')

			");

		return $query;
	}

	public function m_cek_email($email)
	{
		$q = $this->db->query("SELECT email_admin FROM tbl_admin WHERE email_admin='$email'");
		return $q->num_rows();
	}

	public function cek_request_status($email)
	{
		$q = $this->db->query("SELECT request_status FROM tbl_admin WHERE email_admin='$email'");
		if($q->num_rows()>0)
		{
			$x = $q->result();
			$y = $x[0]->request_status;
			return $y;
			
		}else{
			return '0';
		}
	}

}

?>

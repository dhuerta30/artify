<?php 

namespace App\Models;

use App\core\DB;

class UserModel
{
	private $id;
	private $email;
	private $table;
	private $token_api;

	public function __construct()
	{
		$this->id = "id";
		$this->email = "email";
		$this->table = "usuario";
		$this->token_api = "token_api";
	}

    public function select_users()
	{
		$Queryfy = DB::Queryfy();
		$query = $Queryfy->select($this->table);
		return $query;
	}

	public function select_userBy_email($email){
		$Queryfy = DB::Queryfy();
		$Queryfy->where($this->email, $email);
		$data = $Queryfy->select($this->table);
		return $data;
	}

	public function update_userBy_email($email, $data = array()){
		$Queryfy = DB::Queryfy();
		$Queryfy->where($this->email, $email);
		$Queryfy->update($this->table, $data);
		return $Queryfy;
	}

	public function select_userBy_token($token){
		$Queryfy = DB::Queryfy();
        $data = $Queryfy->where($this->token_api, $token)->select($this->table);
		return $data;
	}

	public function obtener_usuario_porId($id){
		$Queryfy = DB::Queryfy();
		$Queryfy->where($this->id, $id);
		$data = $Queryfy->select($this->table);
		return $data;
	}
}
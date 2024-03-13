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
		$pdomodel = DB::PDOModel();
		$query = $pdomodel->select($this->table);
		return $query;
	}

	public function select_userBy_email($email){
		$pdomodel = DB::PDOModel();
		$pdomodel->where($this->email, $email);
		$data = $pdomodel->select($this->table);
		return $data;
	}

	public function update_userBy_email($email, $data = array()){
		$pdomodel = DB::PDOModel();
		$pdomodel->where($this->email, $email);
		$pdomodel->update($this->table, $data);
		return $pdomodel;
	}

	public function select_userBy_token($token){
		$pdomodel = DB::PDOModel();
        $data = $pdomodel->where($this->token_api, $token)->select($this->table);
		return $data;
	}

	public function obtener_usuario_porId($id){
		$pdomodel = DB::PDOModel();
		$pdomodel->where($this->id, $id);
		$data = $pdomodel->select($this->table);
		return $data;
	}
}
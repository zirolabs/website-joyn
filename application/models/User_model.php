<?php

class User_model extends CI_Model
{
    private $_table = "admin";

    public $user_id;
    public $nik;
    public $password;
    public $email;
    public $role;

    public function rules()
    {
        return [
            ['field' => 'nik',
            'label' => 'Name',
            'rules' => 'required'],
			
            ['field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[3]'],
            
            ['field' => 'email',
            'label' => 'Email',
            'rules' => 'required|valid_email']
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        $this->nik = $post["nik"];
        $this->email = $post["email"];
        $this->password = password_hash($post["password"], PASSWORD_DEFAULT);
        // $this->role = $post["role"] ?? "customer";
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->nik = $post["nik"];
        $this->email = $post["email"];
        $this->password = $post["password"];
        // $this->email = $post["email"];
        $this->db->update($this->_table, $this, array('user_id' => $post['id']));
    }

    public function doLogin(){
		$post = $this->input->post();

        $this->db->where('email', $post["email"])
                ->or_where('email', $post["email"]);
        $user = $this->db->get($this->_table)->row();

        if($user){
            $isPasswordTrue = password_verify($post["password"], $user->password);
            // $isAdmin = $user->role == "admin";
            if($isPasswordTrue){ 
                $this->session->set_userdata(['user_logged' => $user]);
                $this->_updateLastLogin($user->user_id);
                return true;
            }
		}
		return false;
    }

    public function isNotLogin(){
        return $this->session->userdata('user_logged') === null;
    }

    private function _updateLastLogin($user_id){
        $sql = "UPDATE {$this->_table} SET last_login=now() WHERE user_id={$user_id}";
        $this->db->query($sql);
    }

}

<?php
Class User_model extends CI_Model{
    
    public function login($username, $password){
        $this->db->select('gebruikersID, gebruikersNaam, wachtwoord');
        $this->db->from('aanmeldgegevens');
        $this->db->where('gebruikersNaam', $username);
        $this->db->where('wachtwoord', MD5($password));
        //$this->db->where('wachtwoord', $password);
        $this->db->limit(1);

        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->result();
        }else{
            return false;
        }
    }
}	
?>

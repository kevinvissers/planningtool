<?php
Class User_model extends CI_Model{
    
    public function login($username, $password){
        $this->db->select('*');
        $this->db->from('aanmeldgegevens');
        $this->db->join('functiegebruiker', 'functiegebruiker.idfunctie = aanmeldgegevens.idfunctie');
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

<?php

class Timetable extends CI_Model
{
    protected $xml = null;
    protected $something = array();

    public function __construct()
    {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH, 'timetable.xml');

        // approach 1
        foreach($this->xml->patties->patty as $something)
        {
            $this->patty_name[(string) $something['code']] = (string) $something;
        }
    }
    /**
    public $code;
    public $name;
    public $category;
    public $value;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_all(){
        $query = $this->db->get('transactions');
        return $query->result();
    }

    public function get_player_stock($name)
    {
        $sql = 'SELECT * FROM holdings WHERE player = ?;';
        $query = $this->db->query($sql, array($name));

        return $query->result();
    }

    public function get_player_history($name)
    {
        $sql = 'SELECT * FROM transactions WHERE player = ?;';
        $query = $this->db->query($sql, array($name));

        return $query->result();
    }**/
}
<?php

class Timetable extends CI_Model
{
    protected $xml          = null;
    protected $year         = null;
    protected $term         = null;
    protected $set          = null;
    protected $program      = null;
    protected $days         = array();
    protected $periods      = array();
    protected $courses      = array();

    public function __construct()
    {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH, 'schedule1.xml');

        foreach($this->xml->days->day as $day)
        {
            $record             = new stdClass();
            $record->day        = (string) $day->datatype;  /////?????
            $record->time       = (string) $day->booking['time'];
            $record->room       = (string) $day->booking['room'];
            $record->instructor = (string) $day->booking->instructor['name'];
            $this->days[$record->day] = $record;
        }
    }
}
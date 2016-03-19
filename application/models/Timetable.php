<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 3/9/2016
 * Time: 9:57 AM
 */

class Timetable extends CI_Model {
    protected $xml = null;
    protected $days = array();
    protected $period = array();
    protected $courses = array();
    protected $year = '';
    protected $term = '';
    protected $set = '';
    protected $program = '';


    public function _construct() {
        parent::_construct();
        $this->xml = simplexml_load_file(DATAPATH. 'schedule1.xml');

        foreach($this->xml->days->day as $day){
            $this->days[(string) $day['type']] = $day;
        }

        foreach($this->xml->period->timeslot as $time){
            $this->period = $time;
        }
    }



}
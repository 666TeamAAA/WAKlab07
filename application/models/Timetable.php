<?php
class Timetable extends CI_Model
{
    protected $xml = null;
    protected $days = array();
    protected $periods = array();
    protected $courses = array();

    public function __construct()
    {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . '/schedule1.xml');
        $this->initDay();
        $this->initCourse();
        $this->initPeriod();
    }
    public function initDay(){
        foreach($this->xml->days->day as $day) {
            $currentDay = (string) $day["type"];
            foreach($day->booking as $booking){
                $room = (string) $booking["room"];
                $time = (string) $booking["timeslot"];
                $instructor = (string) $booking["instructor"];
                $type = (string)$booking ["bookingtype"];
                $course = (string)$booking["coursename"];
                $this->days[] = new Booking($instructor,$room,$type,$time, $course,$currentDay);
            }
        }
    }

    function initCourse() {
        foreach($this->xml->courses->course as $course) {
            $courseCode = (string) $course["code"];
            foreach($course->booking as $book){
                $instructor = (string)$book["instructor"];
                $room = (string)$book["room"];
                $type = (string)$book["bookingtype"];
                $day = (string)$book["dayofweek"];
                $time = (string) $book["timeslot"];
                $this->courses[] = new Booking($instructor,$room,$type,$time, $courseCode,$day);
            }
        }
    }
    function initPeriod() {
        foreach($this->xml->periods->period as $period){
            $time = $period["time"];
            foreach($period->booking as $book){
                $room = $book["room"];
                $instructor = $book["instructor"];
                $type = $book["bookingtype"];
                $course = $book["coursename"];
                $day = $book["dayofweek"];
                $this->periods[] = new Booking($instructor,$room,$type,$time,$course,$day);
            }
        }
    }
    public function getDays(){
        return $this->days;
    }
    /**
     * @return accessor to periods
     */
    public function getPeriods(){
        return $this->periods;
    }
    /**
     * @return accessor to courses
     */
    public function getCourses()
    {
        return $this->courses;
    }
    /**
     * @return array that makes the dropdown menu for days
     */
    public function  getDayOfWeek(){
        return array('mon' => 'mon',
            'tues'=>'tues',
            'wed'=>'wed',
            'thu'=>'thu',
            'fri'=>'fri');
    }
    /**
     * @return array that makes the dropdown menu for time slots
     */
    public function getTimeSlot(){
        return array (
            "8:30" => "8:30",
            "9:30" => "9:30",
            "10:30" => "10:30",
            "11:30" => "11:30",
            "12:30" => "12:30",
            "14:30" => "14:30",
            "15:30" => "15:30",
            "13:30" => "13:30",
            "12:30" => "12:30",
            "14:30" => "14:30"
        );
    }

    /**
     * Search for the course
     * @param $dayOfWeek day of the week from user input
     * @param $chosenTimeslot time slot from user input
     * @return booking object for that day at that time
     */
    public function searchDays($dayOfWeek,$chosenTimeslot){
        foreach($this->days as $book){
            if($book->day == $dayOfWeek && $book->time == $chosenTimeslot){
                return $book;
            }
        }
    }
    public function searchPeriods($dayOfWeek,$chosenTimeslot){
        foreach($this->periods as $book){
            if($book->time == $chosenTimeslot && $book->day == $dayOfWeek){
                return $book;
            }
        }
    }
    public function searchCourses($dayOfWeek,$chosenTimeslot){
        foreach($this->courses as $book){
            if($book->time == $chosenTimeslot && $book->day == $dayOfWeek){
                return $book;
            }
        }
    }

}

class Booking extends CI_Model {
    // Attributes
    public $time;
    public $course;
    public $type;
    public $room;
    public $instructor;
    public $day;

    function __construct($instructor, $room, $type, $time,$courseName, $day)
    {
        $this->instructor = $instructor;
        $this->room = $room;
        $this->type = $type;
        $this->time = $time;
        $this->course = $courseName;
        $this->day = $day;
    }
}

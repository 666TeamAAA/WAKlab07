<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TimetableController extends Application {

    public function index()
    {
        $this->data["title"] = "CST Timetable";
        $this->data['pagebody'] = 'welcome';

        $this->data["daysofweek"] = $this->Timetable->getDays();
        $this->data["courses"] = $this->Timetable->getCourses();
        $this->data["periods"] = $this->Timetable->getPeriods();

        $this->data['daysSearch'] = form_dropdown('day', $this->Timetable->getDaysOfWeek());
        $this->data['periodSearch'] = form_dropdown('period', $this->Timetable->getPeriods());

        $this->render();
    }

    public function result(){

        $day = $this->input->post('day');
        $period = $this->input->post('period');

        $bookingDay = $this->Timetable->checkDays($day,$period);
        $bookingPeriod = $this->Timetable->checkPeriods($day,$period);
        $bookingCourses = $this->Timetable->checkCourses($day,$period);

        $this->data["title"] = "CST Timetable (Result)";
        $this->data['pagebody'] = 'result';

        $proceed = true;

        if($bookingDay == null){
            $proceed = false;
            $this->data["daysofweek"] = $this->bookingEmpty();
        } else {
            $this->data["daysofweek"] = $this->bookingToString($bookingDay);
        }

        if($bookingPeriod == null){
            $proceed = false;
            $this->data["periods"] = $this->bookingEmpty();
        } else {
            $this->data["periods"] = $this->bookingToString($bookingPeriod);
        }

        if($bookingCourses == null){
            $proceed = false;
            $this->data["courses"] = $this->bookingEmpty();
        } else {
            $this->data["courses"] = $this->bookingToString($bookingCourses);
        }

        if($proceed && $this->Timetable->compareBooking($bookingDay,$bookingPeriod)
            && $this->Timetable->compareBooking($bookingDay,$bookingCourses)){
            $this->data["resultBingo"] = "BINGO";
        } else {
            $this->data["resultBingo"] = "No BINGO";
        }

        $this->render();
    }

    public function bookingToString($booking)
    {
        $returnBooking = array();
        $returnBooking['day'] = (string) $booking->day;
        $returnBooking['time'] = (string) $booking->time;
        $returnBooking['timeEnd'] = (string) $booking->timeEnd;
        $returnBooking['course'] = (string) $booking->course;
        $returnBooking['instructor'] = (string) $booking->instructor;
        $returnBooking['building'] = (string) $booking->building;
        $returnBooking['room'] = (string) $booking->room;
        $returnBooking['type'] = (string) $booking->type;
        return array($returnBooking);
    }

    public function bookingEmpty()
    {
        $returnBooking = array();
        $returnBooking['day'] = "";
        $returnBooking['time'] = "";
        $returnBooking['timeEnd'] = "";
        $returnBooking['course'] = "";
        $returnBooking['instructor'] = "";
        $returnBooking['building'] = "";
        $returnBooking['room'] = "";
        $returnBooking['type'] = "";
        return array($returnBooking);
    }
}
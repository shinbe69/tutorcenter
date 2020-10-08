<?php

namespace App\Http\Controllers;

use App\Competitor;
use App\Searchkey;
use App\Tutor;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;
use App\Classes;
use App\Subject;

class getData extends Controller
{
//    GET SEARCH REULT DISPLAY IN DROPDOWN BOX
    public function getSearchKey(Request $data) {
        $searchValue = $data['searchKey'];
        $searchResultArray = array();
        reset($searchResultArray);
        $searchkey = Searchkey::all();
        foreach ($searchkey as $singleSearchKey) {
            if(strpos($singleSearchKey, $searchValue) !== false) {
                array_push($searchResultArray, $singleSearchKey['searchvalue']);
            }
            else {
                continue;
            }
        }
        return response()->json($searchResultArray);
    }

    //    GET HOMEPAGE DATA
    public  function getAllClasses() {
        $classes = Classes::orderBy('id', 'desc')->get();
        $subject = Subject::all();
        return view('allClasses', ['class' => $classes, 'subject' => $subject]);
    }

    //    GET STRIKING CLASS DATA
    public  function getStrikingClass() {
        $strikingClass = Classes::where('isStriking', 1) -> get();
        $subject = Subject::all();
        $stack = array();

    //    SET RANDOM INDEX
        $k = rand(0, count($strikingClass) - 1);
        array_push($stack, $k);
        while (count($stack) < 8) {
            $k = rand(0, count($strikingClass) - 1);
            $sizeOfStack = count($stack);
            for ($i = 0; $i < $sizeOfStack; $i++) {
                if ($k == $stack[$i]) {
                    break;
                }
                elseif ($i == $sizeOfStack - 1) {
                    array_push($stack, $k);
                }
                else {
                    continue;
                }
            }
        }
        return view('homepage', ['stack' => $stack, 'strikingClass' => $strikingClass, 'subject' => $subject]);
    }

//    GET CLASSES ORDER BY SORT
    public function getSortedClasses(Request $data) {
        $allowSubject = Subject::all();
        $subjectCondition = $data['subject'];
        $gradeCondition = $data['grade'];
        $numOfDayCondition = intval($data['numOfDay']);
        $query = [];
        if($subjectCondition != "") {
            $query = ['subject'=> $subjectCondition];
        }
        if($gradeCondition != "") {
            $query = $query + ['grade'=> $gradeCondition];
        }
        if($numOfDayCondition != "") {
            $query = $query + ['dayInAWeek'=> $numOfDayCondition];
        }
        $class = Classes::where($query)-> get();
        return response()->json(["class" =>[$class], "subject" => $allowSubject]);
//        return view('allClasses', ['class' => $class, 'subject' => $allowSubject]);
    }

//    GET CLASS DETAIL
    public function getClassDetail(Request $data) {
        $class = Classes::where('id', $data['classID'])->get();
        $competitors = Competitor::where('classID', $data['classID'])->get();
        $tutor = array();
        for($i = 0; $i < count($competitors); $i++) {
            array_push($tutor, (Tutor::where('id', $competitors[$i]['tutorID'])->get()));
           $tutor[$i][0]['status']  = $competitors[$i]['status'];
        }
        $subject = Subject::all();
        return view('classDetail', ['class' => $class, 'subject' => $subject, 'competitors' => $tutor]);
    }
}

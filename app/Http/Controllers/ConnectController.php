<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;

date_default_timezone_set('Africa/Harare');

class ConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_mac = request()->user_mac;

        if ($user_mac == "") {
            $url = "https://www.poshto.co.zw";
            echo "<script> window.location.href='$url'; </script>";
        }

        //to get user name
        $user = DB::select('SELECT * FROM clients WHERE mac_address = ?', [$user_mac]);

        /************************************************************DEFAULT LOGIN PAGE************************************************************************** */

        if (count($user) === 0){
            return view('login')->with('user', $user);
        }

        /*************************************************************SET OF QUESTIONS**************************************************************************** */
 
        $response_tracker =  DB::SELECT("SELECT pro.id AS profileId, cli.id AS clientId, cli.firstname AS firstName, cli.lastname AS lastName, cli.created_at AS dateRegistered, pro.question_id AS lastQuestionId, pro.response AS lastResponseId, pro.created_at AS lastResponseDate, (SELECT conn.created_at FROM connections AS conn WHERE conn.client_id = cli.id ORDER BY conn.id DESC LIMIT 1) AS lastConnectionDate FROM clients AS cli LEFT JOIN client_profile AS pro ON cli.id = pro.client_id WHERE cli.id = ? ORDER BY profileId DESC LIMIT 1", [$user[0]->id]);

        $created_at = (is_null($response_tracker[0]->lastResponseDate)) ? (is_null($response_tracker[0]->lastConnectionDate)) ? $response_tracker[0]->dateRegistered : $response_tracker[0]->lastConnectionDate : $response_tracker[0]->lastResponseDate;
        $nextDate = date("Y-m-d H:s:i", strtotime('+5 day', strtotime($created_at)));
        
        // $data = DB::select('SELECT questions.id, questions_group.id AS group_id, questions.question, questions.control_id, questions.control_id, questions_group.set_name, CONCAT("[",(
        //     SELECT GROUP_CONCAT(JSON_OBJECT(id, answer))
        //     FROM responses
        //     WHERE question_id = questions.id
        //     ORDER BY questions.id ASC),"]") AS answers
        //     FROM questions
        //     JOIN questions_group ON questions_group.id = questions.group_id AND questions_group.id = (
        //     SELECT grp.id
        //     FROM questions_group AS grp
        //     JOIN questions AS prevQ ON grp.id > prevQ.group_id WHERE prevQ.id = (CASE WHEN (? IS NULL ) THEN (SELECT MIN(p.id)  FROM questions AS p WHERE p.`status` = 1 ORDER BY p.id ASC LIMIT 1) ELSE ? END) AND grp.status = 1
        //     ORDER BY grp.id ASC
        //     LIMIT 1) AND NOW() >= ?
        //     ORDER BY questions_group.id ASC ', [$response_tracker[0]->lastQuestionId,$response_tracker[0]->lastQuestionId, $nextDate]);
      
        $data = DB::select('SELECT * FROM questions WHERE control_id = 10');
        
       
        return view('login')->with('data', $data)->with('user', $user);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $ap_id = DB::select("SELECT `apConnection`(?) as ap_id", [$request->ap_id]);
        //check which form to process
        if ($request->group_id == '0') { //process general info questions
            
            foreach($request as $field)
            {
                if(empty($field))
                {
                    \Session::flash('danger', 'Fill all fields');
                    return back();
                }
            }

            $this->validate($request, [
                'email' => 'email|required'
            ]);

            $maxDate = date("Y-m-d H:s:i", strtotime('+13 year', strtotime($request->dob)));

            if ($maxDate > date("Y-m-d H:s:i")){
                \Session::flash('danger', 'Below minimum age requirement.');
                return back();
            }
            //check length of phone number
            $check_phone_validity = strlen($request->phone);
            $check = (int) $check_phone_validity;

            if ($check < 9) {
                \Session::flash('danger', 'Invalid phone number.');
                return back();
            }

            //insert into users table
            DB::insert('insert into clients (firstname, lastname, mac_address, email, phone, gender, dob, created_at, updated_at) 
            values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [$request->firstname, $request->lastname, $request->user_mac, $request->email, $request->phone, $request->gender, $request->dob, now(), now()]);

            $client_id = DB::getPdo()->lastInsertId();
            //insert into connections table
            
        } else { //process other
            $user = DB::select('SELECT * FROM clients WHERE mac_address = ?', [$request->user_mac]);
            $client_id = $user[0]->id;
            if(!empty($request->qstn)){
                $responseSql = "insert into client_profile (question_id, client_id, response) values ";
                $count = 0;
                
                foreach($request->qstn as $question_id)
                { 
                    if($request["answer-$question_id"] === "" || $request["answer-$question_id"] == null){
                        \Session::flash('danger', 'Fill all fields');
                        return back();
                    }
                    foreach($request["answer-$question_id"] as $key => $value)
                    {
                        
                        $ext = ($count == 0) ? " " : ",";
                        $responseSql .= "$ext ($question_id, $client_id, " . $value . ")";
                        $count++;
                    }
                }
                DB::insert($responseSql);
            }
        }   
        
        DB::insert('insert into connections (client_id, ap_id, banner_id , created_at, updated_at) 
        values (?, ?, ?, ?, ?)', [$client_id, $ap_id[0]->ap_id, $request->banner_id,now(), now()]);

        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $shuffled = str_shuffle($str);
        $pwd = substr($shuffled, 0, 10);

        $url = "http://" . $request->ap_ip . ":" . $request->ap_port . "/logon?user=" . $request->user_mac . "&passwd=" . $pwd . "&user_mac=" . $request->user_mac . "&user_url=" . $request->user_url . "&ap_id=" . $request->ap_id;

        return Redirect::to($url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

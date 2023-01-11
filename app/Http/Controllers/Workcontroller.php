<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Workcontroller extends Controller
{
    public function store(Request $request){
        $work = new Work;

        $work->name = $request->name;
        $work->start = $request->start;
        $work->end = $request->end;
                                              
        $work->save();
    }


    public function list(){

        $data = Work::all();

        //A와 B밖에 없고
        //무조건 2개씩 묶어서 들어온다 가정함
        
        $nameA = DB::table('schedule')
            ->where('name', '=', 'A')
            ->get();
        $nameB = DB::table('schedule')
            ->where('name', '=', 'B')
            ->get();
        //dd($nameA);
        $cntA = count($nameA);
        $cntB = count($nameB);

        //$total = new stdClass();
        $total = array();
        $A = array();
        $B = array();

        for($c = 0; $c < $cntA; $c+=2){
            if($nameA[$c]->name == $nameA[$c+1]->name){
                $mini = min($nameA[$c]->start, $nameA[$c+1]->start);
                $maxi = max($nameA[$c]->end, $nameA[$c+1]->end);

                $temp = new stdClass();
                $temp->start_time = $mini;
                $temp->end_time = $maxi;
                
                $time_dif = ceil((strtotime($maxi) - strtotime($mini))/(60));
                $temp->minute = $time_dif;

                array_push($A, $temp);
                //dd($A);
            }
            $tempC = $c;
        }
        for($c = 0; $c < $cntB; $c+=2){
            if($nameB[$c]->name == $nameB[$c+1]->name){
                $mini = min($nameB[$c]->start, $nameB[$c+1]->start);
                $maxi = max($nameB[$c]->end, $nameB[$c+1]->end);

                $temp = new stdClass();
                $temp->start_time = $mini;
                $temp->end_time = $maxi;
                
                $time_dif = ceil((strtotime($maxi) - strtotime($mini))/(60));
                $temp->minute = $time_dif;

                array_push($B, $temp);
                //dd($A);
            }
            $tempC = $c;
        }
        //$total->A = $A;
        //$total->B = $B;
        $total['A'] = $A;
        $total['B'] = $B;
        dd($total);



        // $nitem = Work::get(['name'])->map(function($item) {
        //     return array_values($item->toArray());
        // });

        // $before = $nitem[0];
        // //dd($before);
        // $cnt = count($data);
        // $ctemp = 0;
        // for($c = 0; $c < $cnt; $c++){
        //     if($before != $nitem[$c] || $c == $cnt-1){ //앞 인덱스와 뒤 인덱스의 이름이 다르거나 마지막 인덱스라면
        //         $startarr = DB::table('schedule')
        //         ->limit($ctemp,$cnt-($cnt-$ctemp)+1)
        //         ->get('start');
        //         //dd($cnt-($cnt-$ctemp)+1);
        //         dd($startarr);
        //         // $c-1 까지 쿼리 오름차순, 내림차순으로
        //     }
            
            
        //     $ctemp = $c;
        //     $before = $nitem[$c]; // 이전 인덱스 이름 업데이트
        // }
        
        // //dd($cnt-($cnt-$ctemp));

        


        
        // // 2.
        // $temp = 0;
        // $term = array();
        // $start = array();
        // $end = array();
        // $cnt = count($data);
        // //     //같은이름의 작업줄이 3개 4개일 경우는?
        // //     //다른이름의 작업이 나올때까지 저장하여
        // //     //다른이름의 작업이 나올경우 한번에 계산
        // $nitem = Work::get(['name'])->map(function($item) {
        //     return array_values($item->toArray());
        // });
        // $sitem = Work::get(['start'])->map(function($item) {
        //     return array_values($item->toArray());
        // });
        // $eitem = Work::get(['end'])->map(function($item) {
        //     return array_values($item->toArray());
        // });
        // $ctemp = 0;
        // $before = $nitem[0];
        // for($c = 0; $c < $cnt; $c++){
        //     if($before != $nitem[$c] || $c == $cnt-1){ //앞 인덱스와 뒤 인덱스의 이름이 다르거나 마지막 인덱스라면

        //         for($s = $ctemp; $s < $c; $s++){
        //             if($sitem[$s] < $sitem[$c-1]){
        //                 $starta = 0;//$sitem[$s];
        //                 //dd(1);
        //             }else{
        //                 $starta = 1;//$sitem[$c-1];
        //                 //dd(1);
        //             }
        //             if($eitem[$s] > $eitem[$c-1]){
        //                 $enda = 0;//$eitem[$s];
        //             }else{
        //                 $enda = 1;//$eitem[$c-1];
        //             }
                    
        //             $ctemp = $c;
        //             array_push($term, [$starta, $enda]);
        //         }
        //         //$time_dif = strtotime($enda[0]) - strtotime($starta[0]);
                

        //         //$mixarr = [$starta[0], $enda[0], ceil($time_dif/(60))];
               
        //         // array_push($term, $mixarr);
        //         //dd($term);
                
        //         $before = $nitem[$c];   //이전원소 업데이트  
        //     }
        //     else{
        //         $before = $nitem[$c];   //이전원소 업데이트
        //     }
        // }
        // dd($term);




        // //1.
        // //min max 값이 올바른 값으로 반환되지 않아서
        // //start에 빠른시간이 아니라 느린시간이 들어갈수도 있게 됨
        // for($c = 0; $c < $cnt-1; $c++){
            

        //     if($nitem[$c] == $nitem[$c+1]){ //앞 인덱스와 뒤 인덱스의 이름이 같으면 계산
                
        //         //걸리는시간 계산...
        //         $start = min($sitem[$c], $sitem[$c+1]);
        //         $end = max($eitem[$c], $eitem[$c+1]);
                
        //         // $startT = data("y-m-d h:i", $start);
        //         // dd($startT);
                
        //         $time_dif = strtotime($end[0]) - strtotime($start[0]);
        //         $term[$temp] = ceil($time_dif / (60)); //시간계산한 값, 분으로 나오게 설정;
        //         //dd($term[$temp]);
        //         $temp++;
        //     }
        // }
        // dd($term);

        

        

        return view('index')->with('data',$data);
    }
}

<?php

namespace App\Http\Controllers;

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
        //$temp = DB::table('schedule')->where('name','A') -> first();
        
        $orders = DB::table('schedule')
        ->orderByRaw('id DESC')
        ->get();
        
        $nitem = Work::get(['name'])->map(function($item) {
            return array_values($item->toArray());
        });
        $sitem = Work::get(['start'])->map(function($item) {
            return array_values($item->toArray());
        });
        $eitem = Work::get(['end'])->map(function($item) {
            return array_values($item->toArray());
        });
        
        $temp = 0;
        $term = array();
        $start = array();
        $end = array();
        $cnt = count($data);

        //     //같은이름의 작업줄이 3개 4개일 경우는?
        //     //다른이름의 작업이 나올때까지 저장하여
        //     //다른이름의 작업이 나올경우 한번에 계산

        $ctemp = 0;
        $before = $nitem[0];
        for($c = 0; $c < $cnt; $c++){
            if($before != $nitem[$c] || $c == $cnt-1){ //앞 인덱스와 뒤 인덱스의 이름이 다르거나 마지막 인덱스라면
                for($s = $ctemp; $s < $c; $s++){
                    $starta = min($sitem[$s], $sitem[$c-1]);
                    $enda = max($eitem[$s], $eitem[$c-1]);
                }
                
                $time_dif = strtotime($enda[0]) - strtotime($starta[0]);
                $mixarr = [$starta[0], $enda[0], ceil($time_dif/(60))];
                
                array_push($term, $mixarr);
                //dd($term);
                
                $before = $nitem[$c];   //이전원소 업데이트
                $ctemp = $c;    
            }
            // array_push($start, $sitem[$c]);
            // array_push($end, $eitem[$c]);
            
            $before = $nitem[$c];   //이전원소 업데이트
        }

        //같은 이름의 작업일경우 함수에 넣어서 반환하기
        //처음값만 제대로 나오고 두번째값 부터는 원래있던 원소와 합해서 계산되기 때문에
        //제대로 안나옴, 그렇다고 배열을 초기화하면 배열이 아니라면서 오류남
        // -> 다른 작업명이 나올 경우 함수로 처리해서 하나씩 저장하자.

        dd($term);
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



        // for($c = 0; $c < $temp; $c++){
        //     print($term[$c]);
        // }

        return view('index')->with('data',$data)->with('term',$term);
    }
}

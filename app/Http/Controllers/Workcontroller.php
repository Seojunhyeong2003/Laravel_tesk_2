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
        
        $cnt = count($data);
        $nitem = Work::get(['name'])->map(function($item) {
            return array_values($item->toArray());
        });
        $sitem = Work::get(['start'])->map(function($item) {
            return array_values($item->toArray());
        });
        $eitem = Work::get(['end'])->map(function($item) {
            return array_values($item->toArray());
        });

        $term = array();

        $temp = 0;
        for($c = 0; $c < $cnt-1; $c++){
            if($nitem[$c] == $nitem[$c+1]){ //앞 인덱스와 뒤 인덱스의 이름이 같으면 계산
                //걸리는시간 계산...
                $start = min($sitem[$c], $sitem[$c+1]);
                $end = max($eitem[$c], $eitem[$c+1]);
                
                // $startT = data("y-m-d h:i", $start);
                // dd($startT);
                
                $time_dif = strtotime($end[0]) - strtotime($start[0]);
                $term[$temp] = ceil($time_dif / (60)); //시간계산한 값, 분으로 나오게 설정;
                //dd($term[$temp]);
                $temp++;
            }
        }

        // for($c = 0; $c <= $temp; $c++){
        //     dd($term[$c]);
        // }
        dd($term[0]);
        //dd($term[1]);
        //dd($term[2]);
        //print_r($temp);

        return view('index', ['data'=>$data, 'orders'=>$sitem]);
    }
}

<?php

namespace App\Http\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SharedService
{
    //
    public function getshared()//共養畫面共養寵物列表
    {
        $shared = DB::select('SELECT a.id,a.pet_id,b.img,b.user_id,d.location,b.name,b.age,b.variety,b.size,b.sex,count(y.user_id)+1 as headcount
        from adoptions as a
        INNER JOIN pets as b on a.pet_id = b.id
        INNER JOIN users as c on b.user_id = c.id
        INNER JOIN locations as d on c.location_id = d.id
        LEFT JOIN adopters as y on a.id = y.adoption_id
        GROUP by a.id
        ');

        return $shared;
    }

    public function getSharedForLook($id)
    {
        $result = DB::table('adoptions')->where('id',$id)->get();
        return $result;
    }

    public function getMain_Sharer($id)//主共養者資訊
    {
        $sharer = DB::table('adoptions')
        ->join('pets', 'adoptions.pet_id', '=', 'pets.id')
        ->join('users', 'pets.user_id', '=', 'users.id')
        ->select('adoptions.id', 'pets.id','users.*')
        ->where('adoptions.id',$id)->first();
        
        $location = DB::table('locations')->where('id',$sharer->location_id)->first()->location;
        
        $birth = $sharer->birth;
        $diff = Carbon::now()->diff($birth);
        $age = $diff->y;

        $sharer -> age = $age;
        $sharer -> location = $location;

        // dd(array($sharer));
        return array($sharer);
    }

    public function getSharer($id)//次共養者資訊
    { 
        if(!$sharer = DB::table('adopters')->where('adoption_id','=',$id)->first()){
            return '目前無共養人';
        }
        $sharer = DB::table('adopters')->where('adoption_id','=',$id)->get();

        $tatalSharer = array();
        
        for($i = 0 ; $i<=count($sharer)-1 ; $i++){
            $id =$sharer[$i]->user_id;

            $sharerInFor = DB::table('users')
            ->where('id',$id)->first();

            $location = DB::table('locations')->where('id',$sharerInFor->location_id)->first()->location;

            $birth = $sharerInFor->birth;
            $diff = Carbon::now()->diff($birth);
            $age = $diff->y;

            $sharerInFor -> age = $age;
            $sharerInFor -> location = $location;

            $tatalSharer = array_merge($tatalSharer,array($sharerInFor));
            
        }
        return $tatalSharer;
    }

    public function getSharerIsMy($id)//看共養內是否有我
    {
        $sharer = DB::table('adopters')->where('adoption_id',$id)->get();
        return $sharer;
    }
}

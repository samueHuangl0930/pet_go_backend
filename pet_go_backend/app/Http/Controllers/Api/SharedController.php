<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Service\LoctaionService;
use App\Http\Service\SharedService;
use App\Http\Service\PetService;
use App\Http\Service\UserService;

class SharedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $location;
    protected $shared;
    protected $pet;
    protected $user;

    public function __construct()
    {
        $this->location = new LoctaionService();
        $this->shared = new SharedService();
        $this->pet = new PetService();
        $this->user = new UserService();
    }

    // 共養首頁
    public function index()
    {
        //
        return response()->json([
            'status' => 'true',
            'citys' => $this->location->getcitys(),
            'area' => $this->location->getareas(),
            'shared' => $this->shared->getshared(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $pet_id = DB::table('adoptions')->where('id',$id)->first()->pet_id;
        $user_id = $request['userData']->id;
        $x = $this->shared->getMain_Sharer($id)[0]->id;
        $y = $this->shared->getSharer($id);

        $button = "按鈕：顯示!";
        if($user_id ==  $x){
            $button = "按鈕：不顯示!";
        }elseif($y != '目前無共養人'){
            for($i=0;$i<count((array)$y);$i++){
                if($user_id == $y[$i]->id){
                    $button = "按鈕：不顯示!";
                }
            }   
        }
        
        return response()->json([
            'status' =>'success',
            'pets' => $this->pet->petDetail($pet_id),
            'shared' => $this->shared->getSharedForLook($id),
            'main_sharer' => $this->shared->getMain_Sharer($id),
            'sharer' => $this->shared->getSharer($id),
            'button_status'=>$button,
        ],200);
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

    //共養的共享者經歷
    public function sharershow($id)
    {
        //
        return response()->json([
            'status' =>'success',
            'rearing_pet' => $this->user->getRearingPet($id),
        ],200);
    }
}

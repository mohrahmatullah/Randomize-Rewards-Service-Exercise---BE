<?php

namespace App\Http\Controllers;

Use App\Model\Rewards;
Use App\Model\Users;
use Illuminate\Support\Facades\Input;
use Request;
use Validator;

class ServiceController extends Controller
{
    public function index( Users $u ){
    	$data['rewards'] = $this->get_rewards($u);
    	return view('rewards', $data);
    }

    public function post( ){
    	$data = Input::all();
        $rules =  ['random_reward'  => 'required'];
        $validator = Validator:: make($data, $rules);
    	if($validator->fails()){
            return redirect()->back()
            ->withInput()
            ->withErrors( $validator );
        }else{
        	$users = new Users;
	    	$users->user = Input::get('name');
	    	if($users->save()){
				$array = array();
		        $array['random_reward']  =   Input::get('random_reward');
		        $array['get_reward']     =   Input::get('get_reward');

		        $limit_rewards = $this->get_limit_rewards();
		        if ($limit_rewards - Input::get('get_reward') > 0){
		        	$array['balance_daily_limit_rewards'] = $limit_rewards - Input::get('get_reward');
			        $update = array(
			        	'details' => $array['balance_daily_limit_rewards']
			        );
			        $this->update_daily_limit_rewards($update);
		        }
		        else{
		        	$array['balance_daily_limit_rewards'] = ($limit_rewards - $limit_rewards) + $limit_rewards;
		        	$update = array(
			        	'details' => $limit_rewards - $limit_rewards
			        );
			        $this->update_daily_limit_rewards($update);
		        }
		        $this->insert_rewards($users->id, $array);
	    	}    	   
		    return redirect()->route('service');
        }
    	
    }

    public function delete( $id ){
    	if(Users::where('id',$id)->delete()){
    		Rewards::where('user_id',$id)->delete();
    	}
    	return redirect()->route('service');
    }

    public function update( $id )
    {
    	$data = array(
    		'details' => Input::get('daily_limit_rewards')
    	);
    	Rewards::where('user_id',$id)->update( $data );
    	return redirect()->route('service');
    }

    function get_rewards( $u ){
    	$rewards = $u->join('rewards','rewards.user_id','users.id')->select('users.user','users.id','rewards.details')->get();
    	return $rewards;
    }
    function get_limit_rewards( )
    {
    	$limit_rewards = Users::where('users.user','Daily limit rewards')->join('rewards','rewards.user_id','users.id')->select('rewards.details')->first()->details;
    	return $limit_rewards;
    } 

    function update_daily_limit_rewards( $update ){
    	$update_daily_limit_rewards = Users::where('users.user','Daily limit rewards')->join('rewards','rewards.user_id','users.id')->update($update);
    	return $update_daily_limit_rewards;
    }

    function insert_rewards($id, $array){
    	$insert_rewards = Rewards::insert(array(
						                    array(
						                    	'user_id' => $id,
						                        'details' =>  json_encode(array('rewards' => $array))
						                    )));
    	return $insert_rewards;
    }
}

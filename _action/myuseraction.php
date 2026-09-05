<?php

if(isset($_POST["POST"]))
{
    

    

    if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "edituser")
    {
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array('required' => true,'min' => 2,'max' => 20)
		));

		if (Input::get('employeeid')) {
			$employeeid = Input::get('employeeid');
			
		} else {
			$employeeid = 0;
		}
		
		if($validation->passed() && $employeeid)
		{
					$updatedata = array(
									'username' => Input::get('username'),
									'employeeid' => Input::get('employeeid'),
									'name' => Input::get('firstname').' '.Input::get('lastname'),
						    		'formhash' => Input::get('formhash'),
									'roleid' => Input::get("roleid"),
									'statusid' => Input::get("statusid"),
									'updateduserid' => $user->data()->id,
		    						'updatedtime' => date('Y-m-d h:i'),
									'deleted' => 0
								);

					$edituser = new User();
					try{
						$edituser->update($updatedata,Input::get('userid'));
						$showstatus = 1;
						$init_status .= ' user change saved.. : ' . date('H:i:s d-m-Y');
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetedit');
						Redirect::to('dashboard.php');
						}catch(Exception $e){die($e->getMessage());}
		} else
		{
			foreach($validation->errors() as $error){ $showstatus = 1; $init_status .= $error . ' &rarr; ';}	
		} 

		Session::put('init_status',$init_status);
		if(Input::get('submit') == 'Save & Close') Redirect::to('dashboard.php');
    }

    if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "editpassword")
    {
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password' => array('required' => true,'min' => 6),
			'passwordagain' => array('required' => true,'matches' => 'password')
		));



		if($validation->passed())
		{
				//echo "TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- TEST -- ";
				$edituser = new User();
				$salt = Hash::salt(32);
			 	$passwordarray = array(
			 		'password' => Hash::make(Input::get('password'),$salt),
			 		'lastp' => Input::get("password"),
		    		'updateduserid' => $user->data()->id,
		    		'updatedtime' => date('Y-m-d h:i'),
					'formhash' => Input::get('formhash'),
			 		'salt' => $salt
			 		);
					try{
						$edituser->update($passwordarray,Input::get('userid'));
						$showstatus = 1;
						$init_status .= 'Password updated for user.. '. date('H:i:s d-m-Y');
						$passwordupdated = 1;
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetedit');
						Redirect::to('dashboard.php');
						}catch(Exception $e){die($e->getMessage());}

		} else
		{
			foreach($validation->errors() as $error){ $showstatus = 1; $init_status .= $error . ' &rarr; ';}	
		} 
		Session::put('init_status',$init_status);
		if(Input::get('submit') == 'Save & Close') Redirect::to('dashboard.php');
    }

    if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "deluser")
    {
		$edituser = new User();
	 	$edituserarray = array(
 		'deleted' => 1,
 		);
		try{
			$edituser->update($edituserarray,Input::get('id'));
			$showstatus = 1;
			$init_status .= ' User succesfully deleted! ';
			$passwordupdated = 1;
			}catch(Exception $e){die($e->getMessage());}


		Session::put('init_status',$init_status);
		if(Input::get('submit') == 'Delete & Close') Redirect::to('dashboard.php');
    }
}

?>
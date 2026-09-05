<?php
if(isset($_POST["POST"]))
{
	echo "<br/>POST";
//'incidentnr' => array('required' => true,'min' => 1,'unique' => 'gbvcases'),
	$myuserinfo = Session::get('USERINFO');
    if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "addlegalaidcase"){
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'legalcasetypeid' => array('required' => true,'min' => 1),
			'legalcasesubtypeid' => array('required' => true,'min' => 1),
			'arrestdate' => array('required' => true,'min' => 1)
		));

		Session::put('newlegalaidcase4',$_POST);

		if (Session::exists('newlegalaidcase4')) {
		   $newlegalaidcase4 = Session::get('newlegalaidcase4');
		}

		if($validation->passed()){ 
			echo "<br/>Validation";
			if ($formhashcheck) {
				echo "<br/>formhashcheck";
				$gbvcaseid = 0;
				$legalcasetypeid = 0;
				$legalcasesubtypeid = 0;
				$detentioncenterid = 0;
				$incidentprefixid = 0;
				$incidentnr = 0;
				$casefilenr = "";
				$legalcasecourttypeid = 0;
				$arrestdate = NULL;
				$reportdate = NULL;
				$clientname = "";
				$clientage = 0;
				$clientsexid = 0;
				$clientmaritalstatusid = 0;
				$survivoroccupationid = 0;
				$residentdistrictid = 0;
				$clientstatusid = 0;
				$contactnumber = "";
				$mothersname = "";
				$motherscontactnumber = "";
				$accusertypeid = 0;
				$accusername = "";
				$accusedlegislationarticleid1 = "";
				$accusedlegislationarticleid2 = "";
				$accusedlegislationarticleid3 = "";
				$actualsentenceid = 0;
				$legalincidentdetail = "";
				$legaladvice = "";
				$legaladviceinfo = "";
				$legalrepresentation = "";
				$legalrepresentationinfo = "";
				$otherlegalservices = "";
				$otherlegalservicesinfo = "";
				$casestatusid = 0;
				$legalcasestatusid = 0;
				$processtypeid = 0;
				$casestatusdetail = "";
				$staffcodeid = 0;
				$projectid = 0;
				$registermonthid = 0;
				$registeryear = "";
				$openeddate = NULL;
				$incidentdate = NULL;
				$staffcode = NULL;
				$survivorotheroccupation = "";
				$survivordisplacementid = 0;
				$allegedperpetratorsname = "";
				$perpetratornumberid = 0;
				$perpetratorrelationshipid = 0;
				$perpetratoroccupationid = 0;
				$otherperpetratoroccupation = "";
				$perpetratorsexid = 0;
				$agegroupid = 0;
				$followupsessionid = 0;
				$placedtypeid = 0;
				$policestationdistrictid = 0;

				if (Session::exists('newlegalaidcase4')) {
					echo "<br/>Session exists";
				    $newlegalaidcase4 = Session::get('newlegalaidcase4');
				    if (isset($newlegalaidcase4["gbvcaseid"])) $gbvcaseid = $newlegalaidcase4["gbvcaseid"];
				    if (isset($newlegalaidcase4["legalcasetypeid"])) $legalcasetypeid = $newlegalaidcase4["legalcasetypeid"];
				    if (isset($newlegalaidcase4["legalcasesubtypeid"])) $legalcasesubtypeid = $newlegalaidcase4["legalcasesubtypeid"];
				    if (isset($newlegalaidcase4["detentioncenterid"])) $detentioncenterid = $newlegalaidcase4["detentioncenterid"];
				    if (isset($newlegalaidcase4["incidentprefixid"])) $incidentprefixid = $newlegalaidcase4["incidentprefixid"];
				    if (isset($newlegalaidcase4["incidentnr"])) $incidentnr = $newlegalaidcase4["incidentnr"];
				    if (isset($newlegalaidcase4["casefilenr"])) $casefilenr = $newlegalaidcase4["casefilenr"];
				    if (isset($newlegalaidcase4["legalcasecourttypeid"])) $legalcasecourttypeid = $newlegalaidcase4["legalcasecourttypeid"];
				    if (isset($newlegalaidcase4["arrestdate"])) $arrestdate = $newlegalaidcase4["arrestdate"];
				    if (isset($newlegalaidcase4["reportdate"])) $reportdate = $newlegalaidcase4["reportdate"];
				    if (isset($newlegalaidcase4["clientname"])) $clientname = $newlegalaidcase4["clientname"];
				    if (isset($newlegalaidcase4["clientage"])) $clientage = $newlegalaidcase4["clientage"];
				    if (isset($newlegalaidcase4["clientsexid"])) $clientsexid = $newlegalaidcase4["clientsexid"];
				    if (isset($newlegalaidcase4["clientmaritalstatusid"])) $clientmaritalstatusid = $newlegalaidcase4["clientmaritalstatusid"];
				    if (isset($newlegalaidcase4["survivoroccupationid"])) $survivoroccupationid = $newlegalaidcase4["survivoroccupationid"];
				    if (isset($newlegalaidcase4["residentdistrictid"])) $residentdistrictid = $newlegalaidcase4["residentdistrictid"];
				    if (isset($newlegalaidcase4["clientstatusid"])) $clientstatusid = $newlegalaidcase4["clientstatusid"];
				    if (isset($newlegalaidcase4["contactnumber"])) $contactnumber = $newlegalaidcase4["contactnumber"];
				    if (isset($newlegalaidcase4["mothersname"])) $mothersname = $newlegalaidcase4["mothersname"];
				    if (isset($newlegalaidcase4["accusertypeid"])) $accusertypeid = $newlegalaidcase4["accusertypeid"];
				    if (isset($newlegalaidcase4["accusername"])) $accusername = $newlegalaidcase4["accusername"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid1"])) $accusedlegislationarticleid1 = $newlegalaidcase4["accusedlegislationarticleid1"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid2"])) $accusedlegislationarticleid2 = $newlegalaidcase4["accusedlegislationarticleid2"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid3"])) $accusedlegislationarticleid3 = $newlegalaidcase4["accusedlegislationarticleid3"];
				    if (isset($newlegalaidcase4["actualsentenceid"])) $actualsentenceid = $newlegalaidcase4["actualsentenceid"];
				    if (isset($newlegalaidcase4["legaladvice"])) $legaladvice = $newlegalaidcase4["legaladvice"];
				    if (isset($newlegalaidcase4["legaladviceinfo"])) $legaladviceinfo = $newlegalaidcase4["legaladviceinfo"];
				    if (isset($newlegalaidcase4["legalrepresentation"])) $legalrepresentation = $newlegalaidcase4["legalrepresentation"];
				    if (isset($newlegalaidcase4["legalrepresentationinfo"])) $legalrepresentationinfo = $newlegalaidcase4["legalrepresentationinfo"];
				    if (isset($newlegalaidcase4["otherlegalservices"])) $otherlegalservices = $newlegalaidcase4["otherlegalservices"];
				    if (isset($newlegalaidcase4["otherlegalservicesinfo"])) $otherlegalservicesinfo = $newlegalaidcase4["otherlegalservicesinfo"];
				    if (isset($newlegalaidcase4["casestatusid"])) $casestatusid = $newlegalaidcase4["casestatusid"];
				    if (isset($newlegalaidcase4["legalcasestatusid"])) $legalcasestatusid = $newlegalaidcase4["legalcasestatusid"];
				    if (isset($newlegalaidcase4["processtypeid"])) $processtypeid = $newlegalaidcase4["processtypeid"];
				    if (isset($newlegalaidcase4["casestatusdetail"])) $casestatusdetail = $newlegalaidcase4["casestatusdetail"];
				    if (isset($newlegalaidcase4["staffcodeid"])) $staffcodeid = $newlegalaidcase4["staffcodeid"];
				    if (isset($newlegalaidcase4["projectid"])) $projectid = $newlegalaidcase4["projectid"];
				    if (isset($newlegalaidcase4["registermonthid"])) $registermonthid = $newlegalaidcase4["registermonthid"];
				    if (isset($newlegalaidcase4["registeryear"])) $registeryear = $newlegalaidcase4["registeryear"];

				    if (isset($newlegalaidcase4["openeddate"])) $openeddate = $newlegalaidcase4["openeddate"];
				    if (isset($newlegalaidcase4["incidentdate"])) $incidentdate = $newlegalaidcase4["incidentdate"];
				    if (isset($newlegalaidcase4["staffcode"])) $staffcode = $newlegalaidcase4["staffcode"];
				    if (isset($newlegalaidcase4["survivorotheroccupation"])) $survivorotheroccupation = $newlegalaidcase4["survivorotheroccupation"];
				    if (isset($newlegalaidcase4["survivordisplacementid"])) $survivordisplacementid = $newlegalaidcase4["survivordisplacementid"];
				    if (isset($newlegalaidcase4["allegedperpetratorsname"])) $allegedperpetratorsname = $newlegalaidcase4["allegedperpetratorsname"];
				    if (isset($newlegalaidcase4["perpetratornumberid"])) $perpetratornumberid = $newlegalaidcase4["perpetratornumberid"];
				    if (isset($newlegalaidcase4["perpetratorrelationshipid"])) $perpetratorrelationshipid = $newlegalaidcase4["perpetratorrelationshipid"];
				    if (isset($newlegalaidcase4["perpetratoroccupationid"])) $perpetratoroccupationid = $newlegalaidcase4["perpetratoroccupationid"];
					if (isset($newlegalaidcase4["otherperpetratoroccupation"])) $otherperpetratoroccupation = $newlegalaidcase4["otherperpetratoroccupation"];
				    if (isset($newlegalaidcase4["perpetratorsexid"])) $perpetratorsexid = $newlegalaidcase4["perpetratorsexid"];
				    if (isset($newlegalaidcase4["agegroupid"])) $agegroupid = $newlegalaidcase4["agegroupid"];

				    if (isset($newlegalaidcase4["followupsessionid"])) $followupsessionid = $newlegalaidcase4["followupsessionid"];
				    if (isset($newlegalaidcase4["placedtypeid"])) $placedtypeid = $newlegalaidcase4["placedtypeid"];
				    if (isset($newlegalaidcase4["legalincidentdetail"])) $legalincidentdetail = $newlegalaidcase4["legalincidentdetail"];
				    if (isset($newlegalaidcase4["policestationdistrictid"])) $policestationdistrictid = $newlegalaidcase4["policestationdistrictid"];
				}		


				$arrestdate = NULL;
				if(isset($newlegalaidcase4['arrestdate'])) $arrestdate = date("Y-m-d", strtotime($newlegalaidcase4['arrestdate']));  
				else $arrestdate = NULL;

				$openeddate = NULL;
				if(isset($newlegalaidcase4['openeddate'])) $openeddate = date("Y-m-d", strtotime($newlegalaidcase4['openeddate']));  
				else $openeddate = NULL;

				$incidentdate = NULL;
				if(isset($newlegalaidcase4['incidentdate'])) $incidentdate = date("Y-m-d", strtotime($newlegalaidcase4['incidentdate']));  
				else $incidentdate = NULL;

				$reportdate = NULL;
				if(isset($newlegalaidcase4['reportdate'])) $reportdate = date("Y-m-d", strtotime($newlegalaidcase4['reportdate']));  
				else $reportdate = NULL;
				

				$loginuserinfo = Session::get('USERINFO');

				$incidentrecorderid = $loginuserinfo['employeeid'];
				$placedemployeeid = $loginuserinfo['employeeid'];
				$placedroleid = $loginuserinfo['roleid'];		

				if ($gbvcaseid == "") $gbvcaseid = 0;
				if ($incidentprefixid == "") $incidentprefixid = 0;
				if ($casefilenr == "") $casefilenr = 0;
				if ($incidentnr == "") $incidentnr = 0;
				if ($survivoroccupationid == "") $survivoroccupationid = 22;
				if ($policestationdistrictid == "") $policestationdistrictid = 0;

				$newlegalcasedata = array(
					'gbvcaseid' => $gbvcaseid,
					'legalcasetypeid' => $legalcasetypeid,
					'legalcasesubtypeid' => $legalcasesubtypeid,
					'detentioncenterid' => $detentioncenterid,
					'policestationdistrictid' => $policestationdistrictid,
					'incidentprefixid' => $incidentprefixid,
					'incidentnr' => $incidentnr,
					'casefilenr' => $casefilenr,
					'legalcasecourttypeid' => $legalcasecourttypeid,
					'arrestdate' => $arrestdate,
					'reportdate' => $reportdate,
					'clientname' => $clientname,
					'clientage' => $clientage,
					'clientsexid' => $clientsexid,
					'clientmaritalstatusid' => $clientmaritalstatusid,
					'survivoroccupationid' => $survivoroccupationid,
					'residentdistrictid' => $residentdistrictid,
					'clientstatusid' => $clientstatusid,
					'contactnumber' => $contactnumber,
					'mothersname' => $mothersname,
					'motherscontactnumber' => $motherscontactnumber,
					'accusertypeid' => $accusertypeid,
					'accusername' => $accusername,
					'accusedlegislationarticleid1' => $accusedlegislationarticleid1,
					'accusedlegislationarticleid2' => $accusedlegislationarticleid2,
					'accusedlegislationarticleid3' => $accusedlegislationarticleid3,
					'actualsentenceid' => $actualsentenceid,
					'legalincidentdetail' => $legalincidentdetail,
					'legaladvice' => $legaladvice,
					'legaladviceinfo' => $legaladviceinfo,
					'legalrepresentation' => $legalrepresentation,
					'legalrepresentationinfo' => $legalrepresentationinfo,
					'otherlegalservices' => $otherlegalservices,
					'otherlegalservicesinfo' => $otherlegalservicesinfo,
					'casestatusid' => $casestatusid,
					'legalcasestatusid' => $legalcasestatusid,
					'processtypeid' => $processtypeid,
					'casestatusdetail' => $casestatusdetail,
					'staffcodeid' => $staffcodeid,
					'projectid' => $projectid,
					'registermonthid' => $registermonthid,
					'registeryear' => $registeryear,
					'openeddate' => $openeddate,
					'incidentdate' => $incidentdate,
					'staffcode' => $staffcode,
					'agegroupid' => $agegroupid,
					'survivorotheroccupation' => $survivorotheroccupation,
					'survivordisplacementid' => $survivordisplacementid,
					'allegedperpetratorsname' => $allegedperpetratorsname,
					'perpetratornumberid' => $perpetratornumberid,
					'perpetratorrelationshipid' => $perpetratorrelationshipid,
					'perpetratoroccupationid' => $perpetratoroccupationid,
					'otherperpetratoroccupation' => $otherperpetratoroccupation,
					'perpetratorsexid' => $perpetratorsexid,
					'followupsessionid' => $followupsessionid,
					'placedtypeid' => $placedtypeid,
					'placedemployeeid' => $placedemployeeid,
					'placedroleid' => $placedroleid,
					'incidentrecorderid' => $incidentrecorderid,
					'createduserid' => $user->data()->id,
					'createdtime' => date('Y-m-d h:i'),
					'updateduserid' => $user->data()->id,
					'updatedtime' => date('Y-m-d h:i'),
					'formhash' => Input::get('formhash'),
					'deleted' => 0 
					);
				var_dump($newlegalcasedata);
				$legalaidcase = new DBTable("legalaidcases");
			    try{
					$legalaidcase->create($newlegalcasedata);
					$newlegalaidcaseid = $legalaidcase->lastinsertid();
					$legalaidcasecreated = 1;
					echo "<br/>new Case created";
					}catch(Exception $e){
						$legalaidcasecreated = 0;
						$newlegalaidcaseid = 0;
						//die($e->getMessage());
					}

				if ($newlegalaidcaseid) {

					$legalcaseid = $newlegalaidcaseid + 12000;
					if ($casefilenr == "") {
						$casefilenr = "LID-".$legalcaseid;
					}

			        $updlegalaidcasedata = array(
			        'legalcaseid' => $legalcaseid,
			        'casefilenr' => $casefilenr
					);

					// ACTION UPDATE GBVCASE DATA
					$legalaidcase = new DBTable("legalaidcases");	
					try{
						$legalaidcase->update($updlegalaidcasedata,$newlegalaidcaseid);
						$updatedlegalcase = 1;	
						echo "<br/>Updated Case";
						}catch(Exception $e){$updatedlegalcase = 0;die($e->getMessage());}


					if ($updatedlegalcase) {

						// -- BEGIN UPDATE CASESTATUS --
							$insertdata2 = array(
								'legalaidcaseid' => $newlegalaidcaseid,
								'statusdatetime' => date('Y-m-d h:i:s'),
								'staffcodeid' => $staffcodeid,
								'statusinfo' => $casestatusdetail,
								'legalcasestatusid' => $legalcasestatusid,
								'casestatusid' => $casestatusid,
								'processtypeid' => $processtypeid,
								'actualsentenceid' => $actualsentenceid,
								'statusrecorderid' => $placedemployeeid,
								'createduserid' => $user->data()->id,
								'createdtime' => date('Y-m-d h:i:s'),
								'updateduserid' => $user->data()->id,
								'updatedtime' => date('Y-m-d h:i:s'),
								'deleted' => 0 
							);

							$newlegalaidcasestatus = new DBTable("legalaidcasestatuss");							
							try{
								$newlegalaidcasestatus->create($insertdata2);
								$legalaidcasestatuscreated = 1;	
								echo "<br/>Case Status";
								}catch(Exception $e){$legalaidcasestatuscreated = 0;die($e->getMessage());}
						// -- END UPDATE CASESTATUS --


						$showstatus = 1;
						$init_status .=' intakeform created.';
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetadd');
						Session::delete('newlegalaidcase1');
						Session::delete('newlegalaidcase2');
						Session::delete('newlegalaidcase3');
						Session::delete('newlegalaidcase4');

						Redirect::to('viewlegalaidcase.php?legalaidcaseid='.$newlegalaidcaseid);
						//Redirect::to('viewlegalaidcase.php?legalaidcaseid='.$newlegalaidcaseid);
						
					}	
				} 
			}
		} else {
			$showstatus = 1;
			$init_status .=' Legal Aid Case not created, missing data, please fill the forms correct.';
			Session::put('init_status',$init_status);
		} 
	}

	if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "editlegalaidcase411"){
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'legalcasetypeid' => array('required' => true,'min' => 1),
			'legalcasesubtypeid' => array('required' => true,'min' => 1),
			'arrestdate' => array('required' => true,'min' => 1)
		));

		Session::put('newlegalaidcase4',$_POST);

		if (Session::exists('newlegalaidcase4')) {
		   $newlegalaidcase4 = Session::get('newlegalaidcase4');
		}

		if($validation->passed()){ 
			echo "<br/>Validation";
			if ($formhashcheck) {
				echo "<br/>formhashcheck";
				$legalaidcaseid = 0;
				$gbvcaseid = 0;
				$legalcasetypeid = 0;
				$legalcasesubtypeid = 0;
				$detentioncenterid = 0;
				$incidentprefixid = 0;
				$incidentnr = 0;
				$casefilenr = "";
				$legalcasecourttypeid = 0;
				$arrestdate = NULL;
				$reportdate = NULL;
				$clientname = "";
				$clientage = 0;
				$clientsexid = 0;
				$clientmaritalstatusid = 0;
				$survivoroccupationid = 0;
				$residentdistrictid = 0;
				$clientstatusid = 0;
				$contactnumber = "";
				$mothersname = "";
				$motherscontactnumber = "";
				$accusertypeid = 0;
				$accusername = "";
				$accusedlegislationarticleid1 = "";
				$accusedlegislationarticleid2 = "";
				$accusedlegislationarticleid3 = "";
				$actualsentenceid = 0;
				$legalincidentdetail = "";
				$legaladvice = "";
				$legaladviceinfo = "";
				$legalrepresentation = "";
				$legalrepresentationinfo = "";
				$otherlegalservices = "";
				$otherlegalservicesinfo = "";
				$casestatusid = 0;
				$legalcasestatusid = 0;
				$processtypeid = 0;
				$casestatusdetail = "";
				$staffcodeid = 0;
				$projectid = 0;
				$registermonthid = 0;
				$registeryear = "";
				$openeddate = NULL;
				$incidentdate = NULL;
				$staffcode = NULL;
				$survivorotheroccupation = "";
				$survivordisplacementid = 0;
				$allegedperpetratorsname = "";
				$perpetratornumberid = 0;
				$perpetratorrelationshipid = 0;
				$perpetratoroccupationid = 0;
				$otherperpetratoroccupation = "";
				$perpetratorsexid = 0;
				$agegroupid = 0;
				$followupsessionid = 0;
				$placedtypeid = 0;
				$policestationdistrictid = 0;

				if (Session::exists('newlegalaidcase4')) {
					echo "<br/>Session exists";
				    $newlegalaidcase4 = Session::get('newlegalaidcase4');
				    if (isset($newlegalaidcase4["legalaidcaseid"])) $legalaidcaseid = $newlegalaidcase4["legalaidcaseid"];
				    if (isset($newlegalaidcase4["gbvcaseid"])) $gbvcaseid = $newlegalaidcase4["gbvcaseid"];
				    if (isset($newlegalaidcase4["legalcasetypeid"])) $legalcasetypeid = $newlegalaidcase4["legalcasetypeid"];
				    if (isset($newlegalaidcase4["legalcasesubtypeid"])) $legalcasesubtypeid = $newlegalaidcase4["legalcasesubtypeid"];
				    if (isset($newlegalaidcase4["detentioncenterid"])) $detentioncenterid = $newlegalaidcase4["detentioncenterid"];
				    if (isset($newlegalaidcase4["incidentprefixid"])) $incidentprefixid = $newlegalaidcase4["incidentprefixid"];
				    if (isset($newlegalaidcase4["incidentnr"])) $incidentnr = $newlegalaidcase4["incidentnr"];
				    if (isset($newlegalaidcase4["casefilenr"])) $casefilenr = $newlegalaidcase4["casefilenr"];
				    if (isset($newlegalaidcase4["legalcasecourttypeid"])) $legalcasecourttypeid = $newlegalaidcase4["legalcasecourttypeid"];
				    if (isset($newlegalaidcase4["arrestdate"])) $arrestdate = $newlegalaidcase4["arrestdate"];
				    if (isset($newlegalaidcase4["reportdate"])) $reportdate = $newlegalaidcase4["reportdate"];
				    if (isset($newlegalaidcase4["clientname"])) $clientname = $newlegalaidcase4["clientname"];
				    if (isset($newlegalaidcase4["clientage"])) $clientage = $newlegalaidcase4["clientage"];
				    if (isset($newlegalaidcase4["clientsexid"])) $clientsexid = $newlegalaidcase4["clientsexid"];
				    if (isset($newlegalaidcase4["clientmaritalstatusid"])) $clientmaritalstatusid = $newlegalaidcase4["clientmaritalstatusid"];
				    if (isset($newlegalaidcase4["survivoroccupationid"])) $survivoroccupationid = $newlegalaidcase4["survivoroccupationid"];
				    if (isset($newlegalaidcase4["residentdistrictid"])) $residentdistrictid = $newlegalaidcase4["residentdistrictid"];
				    if (isset($newlegalaidcase4["clientstatusid"])) $clientstatusid = $newlegalaidcase4["clientstatusid"];
				    if (isset($newlegalaidcase4["contactnumber"])) $contactnumber = $newlegalaidcase4["contactnumber"];
				    if (isset($newlegalaidcase4["mothersname"])) $mothersname = $newlegalaidcase4["mothersname"];
				    if (isset($newlegalaidcase4["accusertypeid"])) $accusertypeid = $newlegalaidcase4["accusertypeid"];
				    if (isset($newlegalaidcase4["accusername"])) $accusername = $newlegalaidcase4["accusername"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid1"])) $accusedlegislationarticleid1 = $newlegalaidcase4["accusedlegislationarticleid1"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid2"])) $accusedlegislationarticleid2 = $newlegalaidcase4["accusedlegislationarticleid2"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid3"])) $accusedlegislationarticleid3 = $newlegalaidcase4["accusedlegislationarticleid3"];
				    if (isset($newlegalaidcase4["actualsentenceid"])) $actualsentenceid = $newlegalaidcase4["actualsentenceid"];
				    if (isset($newlegalaidcase4["legaladvice"])) $legaladvice = $newlegalaidcase4["legaladvice"];
				    if (isset($newlegalaidcase4["legaladviceinfo"])) $legaladviceinfo = $newlegalaidcase4["legaladviceinfo"];
				    if (isset($newlegalaidcase4["legalrepresentation"])) $legalrepresentation = $newlegalaidcase4["legalrepresentation"];
				    if (isset($newlegalaidcase4["legalrepresentationinfo"])) $legalrepresentationinfo = $newlegalaidcase4["legalrepresentationinfo"];
				    if (isset($newlegalaidcase4["otherlegalservices"])) $otherlegalservices = $newlegalaidcase4["otherlegalservices"];
				    if (isset($newlegalaidcase4["otherlegalservicesinfo"])) $otherlegalservicesinfo = $newlegalaidcase4["otherlegalservicesinfo"];
				    if (isset($newlegalaidcase4["casestatusid"])) $casestatusid = $newlegalaidcase4["casestatusid"];
				    if (isset($newlegalaidcase4["legalcasestatusid"])) $legalcasestatusid = $newlegalaidcase4["legalcasestatusid"];
				    if (isset($newlegalaidcase4["processtypeid"])) $processtypeid = $newlegalaidcase4["processtypeid"];
				    if (isset($newlegalaidcase4["casestatusdetail"])) $casestatusdetail = $newlegalaidcase4["casestatusdetail"];
				    if (isset($newlegalaidcase4["staffcodeid"])) $staffcodeid = $newlegalaidcase4["staffcodeid"];
				    if (isset($newlegalaidcase4["projectid"])) $projectid = $newlegalaidcase4["projectid"];
				    if (isset($newlegalaidcase4["registermonthid"])) $registermonthid = $newlegalaidcase4["registermonthid"];
				    if (isset($newlegalaidcase4["registeryear"])) $registeryear = $newlegalaidcase4["registeryear"];

				    if (isset($newlegalaidcase4["openeddate"])) $openeddate = $newlegalaidcase4["openeddate"];
				    if (isset($newlegalaidcase4["incidentdate"])) $incidentdate = $newlegalaidcase4["incidentdate"];
				    if (isset($newlegalaidcase4["staffcode"])) $staffcode = $newlegalaidcase4["staffcode"];
				    if (isset($newlegalaidcase4["survivorotheroccupation"])) $survivorotheroccupation = $newlegalaidcase4["survivorotheroccupation"];
				    if (isset($newlegalaidcase4["survivordisplacementid"])) $survivordisplacementid = $newlegalaidcase4["survivordisplacementid"];
				    if (isset($newlegalaidcase4["allegedperpetratorsname"])) $allegedperpetratorsname = $newlegalaidcase4["allegedperpetratorsname"];
				    if (isset($newlegalaidcase4["perpetratornumberid"])) $perpetratornumberid = $newlegalaidcase4["perpetratornumberid"];
				    if (isset($newlegalaidcase4["perpetratorrelationshipid"])) $perpetratorrelationshipid = $newlegalaidcase4["perpetratorrelationshipid"];
				    if (isset($newlegalaidcase4["perpetratoroccupationid"])) $perpetratoroccupationid = $newlegalaidcase4["perpetratoroccupationid"];
					if (isset($newlegalaidcase4["otherperpetratoroccupation"])) $otherperpetratoroccupation = $newlegalaidcase4["otherperpetratoroccupation"];
				    if (isset($newlegalaidcase4["perpetratorsexid"])) $perpetratorsexid = $newlegalaidcase4["perpetratorsexid"];
				    if (isset($newlegalaidcase4["agegroupid"])) $agegroupid = $newlegalaidcase4["agegroupid"];

				    if (isset($newlegalaidcase4["followupsessionid"])) $followupsessionid = $newlegalaidcase4["followupsessionid"];
				    if (isset($newlegalaidcase4["placedtypeid"])) $placedtypeid = $newlegalaidcase4["placedtypeid"];
				    if (isset($newlegalaidcase4["legalincidentdetail"])) $legalincidentdetail = $newlegalaidcase4["legalincidentdetail"];
				    if (isset($newlegalaidcase4["policestationdistrictid"])) $policestationdistrictid = $newlegalaidcase4["policestationdistrictid"];
				}		


				$arrestdate = NULL;
				if(isset($newlegalaidcase4['arrestdate'])) $arrestdate = date("Y-m-d", strtotime($newlegalaidcase4['arrestdate']));  
				else $arrestdate = NULL;

				$openeddate = NULL;
				if(isset($newlegalaidcase4['openeddate'])) $openeddate = date("Y-m-d", strtotime($newlegalaidcase4['openeddate']));  
				else $openeddate = NULL;

				$incidentdate = NULL;
				if(isset($newlegalaidcase4['incidentdate'])) $incidentdate = date("Y-m-d", strtotime($newlegalaidcase4['incidentdate']));  
				else $incidentdate = NULL;

				$reportdate = NULL;
				if(isset($newlegalaidcase4['reportdate'])) $reportdate = date("Y-m-d", strtotime($newlegalaidcase4['reportdate']));  
				else $reportdate = NULL;
				

				$loginuserinfo = Session::get('USERINFO');

				$incidentrecorderid = $loginuserinfo['employeeid'];
				$placedemployeeid = $loginuserinfo['employeeid'];
				$placedroleid = $loginuserinfo['roleid'];		

				if ($gbvcaseid == "") $gbvcaseid = 0;
				if ($incidentprefixid == "") $incidentprefixid = 0;
				if ($casefilenr == "") $casefilenr = 0;
				if ($incidentnr == "") $incidentnr = 0;
				if ($survivoroccupationid == "") $survivoroccupationid = 22;
				if ($policestationdistrictid == "") $policestationdistrictid = 0;			

				$updlegalaidcasedata = array('policestationdistrictid' => $policestationdistrictid,
													'incidentprefixid' => $incidentprefixid,
													'incidentnr' => $incidentnr,
													'casefilenr' => $casefilenr,
													'legalcasecourttypeid' => $legalcasecourttypeid,
													'arrestdate' => $arrestdate,
													'reportdate' => $reportdate,
													'clientname' => $clientname,
													'clientage' => $clientage,
													'clientsexid' => $clientsexid,
													'clientmaritalstatusid' => $clientmaritalstatusid,
													'survivoroccupationid' => $survivoroccupationid,
													'residentdistrictid' => $residentdistrictid,
													'clientstatusid' => $clientstatusid,
													'contactnumber' => $contactnumber,
													'mothersname' => $mothersname,
													'motherscontactnumber' => $motherscontactnumber,
													'accusertypeid' => $accusertypeid,
													'accusername' => $accusername,
													'accusedlegislationarticleid1' => $accusedlegislationarticleid1,
													'accusedlegislationarticleid2' => $accusedlegislationarticleid2,
													'accusedlegislationarticleid3' => $accusedlegislationarticleid3,
													'actualsentenceid' => $actualsentenceid,
													'legalincidentdetail' => $legalincidentdetail,
													'legaladvice' => $legaladvice,
													'legaladviceinfo' => $legaladviceinfo,
													'legalrepresentation' => $legalrepresentation,
													'legalrepresentationinfo' => $legalrepresentationinfo,
													'otherlegalservices' => $otherlegalservices,
													'otherlegalservicesinfo' => $otherlegalservicesinfo,
													'casestatusid' => $casestatusid,
													'legalcasestatusid' => $legalcasestatusid,
													'processtypeid' => $processtypeid,
													'casestatusdetail' => $casestatusdetail,
													'staffcodeid' => $staffcodeid,
													'projectid' => $projectid,
													'registermonthid' => $registermonthid,
													'registeryear' => $registeryear,
													'openeddate' => $openeddate,
													'incidentdate' => $incidentdate,
													'staffcode' => $staffcode,
													'agegroupid' => $agegroupid,
													'survivorotheroccupation' => $survivorotheroccupation,
													'survivordisplacementid' => $survivordisplacementid,
													'allegedperpetratorsname' => $allegedperpetratorsname,
													'perpetratornumberid' => $perpetratornumberid,
													'perpetratorrelationshipid' => $perpetratorrelationshipid,
													'perpetratoroccupationid' => $perpetratoroccupationid,
													'otherperpetratoroccupation' => $otherperpetratoroccupation,
													'perpetratorsexid' => $perpetratorsexid,
													'followupsessionid' => $followupsessionid,
													'updateduserid' => $user->data()->id,
													'updatedtime' => date('Y-m-d h:i'),
													'formhash' => Input::get('formhash'),
													'deleted' => 0  
												);

					// ACTION UPDATE LEGAL AID CASE  DATA
					$legalaidcase = new DBTable("legalaidcases");	
					try{
						$legalaidcase->update($updlegalaidcasedata,$legalaidcaseid);
						$updatedlegalcase = 1;	
						echo "<br/>Updated Case";
						}catch(Exception $e){$updatedlegalcase = 0;die($e->getMessage());}


					if ($updatedlegalcase) {

						$showstatus = 1;
						$init_status .=' Legal aid case updated.';
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetedit');
						Session::delete('newlegalaidcase1');
						Session::delete('newlegalaidcase2');
						Session::delete('newlegalaidcase3');
						Session::delete('newlegalaidcase4');

						Redirect::to('viewlegalaidcase.php?legalaidcaseid='.$legalaidcaseid);

						
					}	
				 
			}
		} else {
			$showstatus = 1;
			$init_status .=' Legal Aid Case not created, missing data, please fill the forms correct.';
			Session::put('init_status',$init_status);
		} 
	}

	if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "editlegalaidcase412"){
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'legalcasetypeid' => array('required' => true,'min' => 1),
			'legalcasesubtypeid' => array('required' => true,'min' => 1),
			'arrestdate' => array('required' => true,'min' => 1)
		));

		Session::put('newlegalaidcase4',$_POST);

		if (Session::exists('newlegalaidcase4')) {
		   $newlegalaidcase4 = Session::get('newlegalaidcase4');
		}

		if($validation->passed()){ 
			echo "<br/>Validation";
			if ($formhashcheck) {
				echo "<br/>formhashcheck";
				$gbvcaseid = 0;
				$legalaidcaseid = 0;
				$legalcasetypeid = "";
				$legalcasesubtypeid = 0;
				$detentioncenterid = 0;
				$incidentprefixid = 0;
				$incidentnr = 0;
				$casefilenr = "";
				$legalcasecourttypeid = 0;
				$arrestdate = NULL;
				$clientname = "";
				$clientage = "";
				$clientsexid = 0;
				$clientmaritalstatusid = 0;
				$survivoroccupationid = 0;
				$residentdistrictid = 0;
				$clientstatusid = 0;
				$contactnumber = "";
				$mothersname = "";
				$motherscontactnumber = "";
				$accusertypeid = 0;
				$accusername = "";
				$accusedlegislationarticleid1 = "";
				$accusedlegislationarticleid2 = "";
				$accusedlegislationarticleid3 = "";
				$actualsentenceid = 0;
				$legalincidentdetail = "";
				$legaladvice = "";
				$legaladviceinfo = "";
				$legalrepresentation = "";
				$legalrepresentationinfo = "";
				$otherlegalservices = "";
				$otherlegalservicesinfo = "";
				$casestatusid = 0;
				$legalcasestatusid = 0;
				$processtypeid = 0;
				$casestatusdetail = "";
				$staffcodeid = 0;
				$projectid = 0;
				$registermonthid = 0;
				$registeryear = "";
				$openeddate = NULL;
				$incidentdate = NULL;
				$staffcode = NULL;
				$survivorotheroccupation = "";
				$survivordisplacementid = 0;
				$allegedperpetratorsname = "";
				$perpetratornumberid = 0;
				$perpetratorrelationshipid = 0;
				$perpetratoroccupationid = 0;
				$otherperpetratoroccupation = "";
				$perpetratorsexid = 0;
				$agegroupid = 0;

				$followupsessionid = 0;
				$placedtypeid = 0;

				if (Session::exists('newlegalaidcase4')) {
					echo "<br/>Session exists";
				    $newlegalaidcase4 = Session::get('newlegalaidcase4');
				    if (isset($newlegalaidcase4["gbvcaseid"])) $gbvcaseid = $newlegalaidcase4["gbvcaseid"];
				    if (isset($newlegalaidcase4["legalaidcaseid"])) $legalaidcaseid = $newlegalaidcase4["legalaidcaseid"];
				    if (isset($newlegalaidcase4["legalcasetypeid"])) $legalcasetypeid = $newlegalaidcase4["legalcasetypeid"];
				    if (isset($newlegalaidcase4["legalcasesubtypeid"])) $legalcasesubtypeid = $newlegalaidcase4["legalcasesubtypeid"];
				    if (isset($newlegalaidcase4["detentioncenterid"])) $detentioncenterid = $newlegalaidcase4["detentioncenterid"];
				    if (isset($newlegalaidcase4["incidentprefixid"])) $incidentprefixid = $newlegalaidcase4["incidentprefixid"];
				    if (isset($newlegalaidcase4["incidentnr"])) $incidentnr = $newlegalaidcase4["incidentnr"];
				    if (isset($newlegalaidcase4["casefilenr"])) $casefilenr = $newlegalaidcase4["casefilenr"];
				    if (isset($newlegalaidcase4["legalcasecourttypeid"])) $legalcasecourttypeid = $newlegalaidcase4["legalcasecourttypeid"];
				    if (isset($newlegalaidcase4["arrestdate"])) $arrestdate = $newlegalaidcase4["arrestdate"];
				    if (isset($newlegalaidcase4["clientname"])) $clientname = $newlegalaidcase4["clientname"];
				    if (isset($newlegalaidcase4["clientage"])) $clientage = $newlegalaidcase4["clientage"];
				    if (isset($newlegalaidcase4["clientsexid"])) $clientsexid = $newlegalaidcase4["clientsexid"];
				    if (isset($newlegalaidcase4["clientmaritalstatusid"])) $clientmaritalstatusid = $newlegalaidcase4["clientmaritalstatusid"];
				    if (isset($newlegalaidcase4["survivoroccupationid"])) $survivoroccupationid = $newlegalaidcase4["survivoroccupationid"];
				    if (isset($newlegalaidcase4["residentdistrictid"])) $residentdistrictid = $newlegalaidcase4["residentdistrictid"];
				    if (isset($newlegalaidcase4["clientstatusid"])) $clientstatusid = $newlegalaidcase4["clientstatusid"];
				    if (isset($newlegalaidcase4["contactnumber"])) $contactnumber = $newlegalaidcase4["contactnumber"];
				    if (isset($newlegalaidcase4["mothersname"])) $mothersname = $newlegalaidcase4["mothersname"];
				    if (isset($newlegalaidcase4["accusertypeid"])) $accusertypeid = $newlegalaidcase4["accusertypeid"];
				    if (isset($newlegalaidcase4["accusername"])) $accusername = $newlegalaidcase4["accusername"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid1"])) $accusedlegislationarticleid1 = $newlegalaidcase4["accusedlegislationarticleid1"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid2"])) $accusedlegislationarticleid2 = $newlegalaidcase4["accusedlegislationarticleid2"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid3"])) $accusedlegislationarticleid3 = $newlegalaidcase4["accusedlegislationarticleid3"];
				    if (isset($newlegalaidcase4["actualsentenceid"])) $actualsentenceid = $newlegalaidcase4["actualsentenceid"];
				    if (isset($newlegalaidcase4["legaladvice"])) $legaladvice = $newlegalaidcase4["legaladvice"];
				    if (isset($newlegalaidcase4["legaladviceinfo"])) $legaladviceinfo = $newlegalaidcase4["legaladviceinfo"];
				    if (isset($newlegalaidcase4["legalrepresentation"])) $legalrepresentation = $newlegalaidcase4["legalrepresentation"];
				    if (isset($newlegalaidcase4["legalrepresentationinfo"])) $legalrepresentationinfo = $newlegalaidcase4["legalrepresentationinfo"];
				    if (isset($newlegalaidcase4["otherlegalservices"])) $otherlegalservices = $newlegalaidcase4["otherlegalservices"];
				    if (isset($newlegalaidcase4["otherlegalservicesinfo"])) $otherlegalservicesinfo = $newlegalaidcase4["otherlegalservicesinfo"];
				    if (isset($newlegalaidcase4["casestatusid"])) $casestatusid = $newlegalaidcase4["casestatusid"];
				    if (isset($newlegalaidcase4["legalcasestatusid"])) $legalcasestatusid = $newlegalaidcase4["legalcasestatusid"];
				    if (isset($newlegalaidcase4["processtypeid"])) $processtypeid = $newlegalaidcase4["processtypeid"];
				    if (isset($newlegalaidcase4["casestatusdetail"])) $casestatusdetail = $newlegalaidcase4["casestatusdetail"];
				    if (isset($newlegalaidcase4["staffcodeid"])) $staffcodeid = $newlegalaidcase4["staffcodeid"];
				    if (isset($newlegalaidcase4["projectid"])) $projectid = $newlegalaidcase4["projectid"];
				    if (isset($newlegalaidcase4["registermonthid"])) $registermonthid = $newlegalaidcase4["registermonthid"];
				    if (isset($newlegalaidcase4["registeryear"])) $registeryear = $newlegalaidcase4["registeryear"];

				    if (isset($newlegalaidcase4["openeddate"])) $openeddate = $newlegalaidcase4["openeddate"];
				    if (isset($newlegalaidcase4["incidentdate"])) $incidentdate = $newlegalaidcase4["incidentdate"];
				    if (isset($newlegalaidcase4["staffcode"])) $staffcode = $newlegalaidcase4["staffcode"];
				    if (isset($newlegalaidcase4["survivorotheroccupation"])) $survivorotheroccupation = $newlegalaidcase4["survivorotheroccupation"];
				    if (isset($newlegalaidcase4["survivordisplacementid"])) $survivordisplacementid = $newlegalaidcase4["survivordisplacementid"];
				    if (isset($newlegalaidcase4["allegedperpetratorsname"])) $allegedperpetratorsname = $newlegalaidcase4["allegedperpetratorsname"];
				    if (isset($newlegalaidcase4["perpetratornumberid"])) $perpetratornumberid = $newlegalaidcase4["perpetratornumberid"];
				    if (isset($newlegalaidcase4["perpetratorrelationshipid"])) $perpetratorrelationshipid = $newlegalaidcase4["perpetratorrelationshipid"];
				    if (isset($newlegalaidcase4["perpetratoroccupationid"])) $perpetratoroccupationid = $newlegalaidcase4["perpetratoroccupationid"];
					if (isset($newlegalaidcase4["otherperpetratoroccupation"])) $otherperpetratoroccupation = $newlegalaidcase4["otherperpetratoroccupation"];
				    if (isset($newlegalaidcase4["perpetratorsexid"])) $perpetratorsexid = $newlegalaidcase4["perpetratorsexid"];
				    if (isset($newlegalaidcase4["agegroupid"])) $agegroupid = $newlegalaidcase4["agegroupid"];

				    if (isset($newlegalaidcase4["followupsessionid"])) $followupsessionid = $newlegalaidcase4["followupsessionid"];
				    if (isset($newlegalaidcase4["placedtypeid"])) $placedtypeid = $newlegalaidcase4["placedtypeid"];
				    if (isset($newlegalaidcase4["legalincidentdetail"])) $legalincidentdetail = $newlegalaidcase4["legalincidentdetail"];
				}	


				$arrestdate = NULL;
				if(isset($newlegalaidcase4['arrestdate'])) $arrestdate = date("Y-m-d", strtotime($newlegalaidcase4['arrestdate']));  
				else $arrestdate = NULL;

				$openeddate = NULL;
				if(isset($newlegalaidcase4['openeddate'])) $openeddate = date("Y-m-d", strtotime($newlegalaidcase4['openeddate']));  
				else $openeddate = NULL;

				$incidentdate = NULL;
				if(isset($newlegalaidcase4['incidentdate'])) $incidentdate = date("Y-m-d", strtotime($newlegalaidcase4['incidentdate']));  
				else $incidentdate = NULL;
				

				$loginuserinfo = Session::get('USERINFO');

				$incidentrecorderid = $loginuserinfo['employeeid'];
				$placedemployeeid = $loginuserinfo['employeeid'];
				$placedroleid = $loginuserinfo['roleid'];			

				$updlegalaidcasedata = array(
					'incidentnr' => $incidentnr,
					'casefilenr' => $casefilenr,
					'legalcasecourttypeid' => $legalcasecourttypeid,
					'arrestdate' => $arrestdate,
					'clientname' => $clientname,
					'clientage' => $clientage,
					'clientsexid' => $clientsexid,
					'clientmaritalstatusid' => $clientmaritalstatusid,
					'survivoroccupationid' => $survivoroccupationid,
					'residentdistrictid' => $residentdistrictid,
					'clientstatusid' => $clientstatusid,
					'contactnumber' => $contactnumber,
					'mothersname' => $mothersname,
					'motherscontactnumber' => $motherscontactnumber,
					'accusertypeid' => $accusertypeid,
					'accusername' => $accusername,
					'accusedlegislationarticleid1' => $accusedlegislationarticleid1,
					'accusedlegislationarticleid2' => $accusedlegislationarticleid2,
					'accusedlegislationarticleid3' => $accusedlegislationarticleid3,
					'actualsentenceid' => $actualsentenceid,
					'legalincidentdetail' => $legalincidentdetail,
					'legaladvice' => $legaladvice,
					'legaladviceinfo' => $legaladviceinfo,
					'legalrepresentation' => $legalrepresentation,
					'legalrepresentationinfo' => $legalrepresentationinfo,
					'otherlegalservices' => $otherlegalservices,
					'otherlegalservicesinfo' => $otherlegalservicesinfo,
					'casestatusid' => $casestatusid,
					'legalcasestatusid' => $legalcasestatusid,
					'processtypeid' => $processtypeid,
					'casestatusdetail' => $casestatusdetail,
					'staffcodeid' => $staffcodeid,
					'projectid' => $projectid,
					'registermonthid' => $registermonthid,
					'registeryear' => $registeryear,
					'openeddate' => $openeddate,
					'incidentdate' => $incidentdate,
					'staffcode' => $staffcode,
					'agegroupid' => $agegroupid,
					'survivorotheroccupation' => $survivorotheroccupation,
					'survivordisplacementid' => $survivordisplacementid,
					'allegedperpetratorsname' => $allegedperpetratorsname,
					'perpetratornumberid' => $perpetratornumberid,
					'perpetratorrelationshipid' => $perpetratorrelationshipid,
					'perpetratoroccupationid' => $perpetratoroccupationid,
					'otherperpetratoroccupation' => $otherperpetratoroccupation,
					'perpetratorsexid' => $perpetratorsexid,
					'updateduserid' => $user->data()->id,
					'updatedtime' => date('Y-m-d h:i'),
					'formhash' => Input::get('formhash'),
					'deleted' => 0 
					);

					// ACTION UPDATE LEGAL AID CASE  DATA
					$legalaidcase = new DBTable("legalaidcases");	
					try{
						$legalaidcase->update($updlegalaidcasedata,$legalaidcaseid);
						$updatedlegalcase = 1;	
						echo "<br/>Updated Case";
						}catch(Exception $e){$updatedlegalcase = 0;die($e->getMessage());}


					if ($updatedlegalcase) {

						$showstatus = 1;
						$init_status .=' Legal aid case updated.';
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetadd');
						Session::delete('newlegalaidcase1');
						Session::delete('newlegalaidcase2');
						Session::delete('newlegalaidcase3');
						Session::delete('newlegalaidcase4');

						Redirect::to('mylegalaidcases.php');

						
					}	
				 
			}
		} else {
			$showstatus = 1;
			$init_status .=' Legal Aid Case not created, missing data, please fill the forms correct.';
			Session::put('init_status',$init_status);
		} 
	}


	if(isset($_POST["POSTACTION"]) && $_POST["POSTACTION"] == "editlegalaidcase421"){
    	$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'legalcasetypeid' => array('required' => true,'min' => 1),
			'legalcasesubtypeid' => array('required' => true,'min' => 1),
			'arrestdate' => array('required' => true,'min' => 1)
		));

		Session::put('newlegalaidcase4',$_POST);

		if (Session::exists('newlegalaidcase4')) {
		   $newlegalaidcase4 = Session::get('newlegalaidcase4');
		}

		if($validation->passed()){ 
			echo "<br/>Validation";
			if ($formhashcheck) {
				echo "<br/>formhashcheck";
				$gbvcaseid = 0;
				$legalaidcaseid = 0;
				$legalcasetypeid = "";
				$legalcasesubtypeid = 0;
				$detentioncenterid = 0;
				$incidentprefixid = 0;
				$incidentnr = 0;
				$casefilenr = "";
				$legalcasecourttypeid = 0;
				$arrestdate = NULL;
				$clientname = "";
				$clientage = "";
				$clientsexid = 0;
				$clientmaritalstatusid = 0;
				$survivoroccupationid = 0;
				$residentdistrictid = 0;
				$clientstatusid = 0;
				$contactnumber = "";
				$mothersname = "";
				$motherscontactnumber = "";
				$accusertypeid = 0;
				$accusername = "";
				$accusedlegislationarticleid1 = "";
				$accusedlegislationarticleid2 = "";
				$accusedlegislationarticleid3 = "";
				$actualsentenceid = 0;
				$legalincidentdetail = "";
				$legaladvice = "";
				$legaladviceinfo = "";
				$legalrepresentation = "";
				$legalrepresentationinfo = "";
				$otherlegalservices = "";
				$otherlegalservicesinfo = "";
				$casestatusid = 0;
				$legalcasestatusid = 0;
				$processtypeid = 0;
				$casestatusdetail = "";
				$staffcodeid = 0;
				$projectid = 0;
				$registermonthid = 0;
				$registeryear = "";
				$openeddate = NULL;
				$incidentdate = NULL;
				$staffcode = NULL;
				$survivorotheroccupation = "";
				$survivordisplacementid = 0;
				$allegedperpetratorsname = "";
				$perpetratornumberid = 0;
				$perpetratorrelationshipid = 0;
				$perpetratoroccupationid = 0;
				$otherperpetratoroccupation = "";
				$perpetratorsexid = 0;
				$agegroupid = 0;

				$followupsessionid = 0;
				$placedtypeid = 0;

				if (Session::exists('newlegalaidcase4')) {
					echo "<br/>Session exists";
				    $newlegalaidcase4 = Session::get('newlegalaidcase4');
				    if (isset($newlegalaidcase4["gbvcaseid"])) $gbvcaseid = $newlegalaidcase4["gbvcaseid"];
				    if (isset($newlegalaidcase4["legalaidcaseid"])) $legalaidcaseid = $newlegalaidcase4["legalaidcaseid"];
				    if (isset($newlegalaidcase4["legalcasetypeid"])) $legalcasetypeid = $newlegalaidcase4["legalcasetypeid"];
				    if (isset($newlegalaidcase4["legalcasesubtypeid"])) $legalcasesubtypeid = $newlegalaidcase4["legalcasesubtypeid"];
				    if (isset($newlegalaidcase4["detentioncenterid"])) $detentioncenterid = $newlegalaidcase4["detentioncenterid"];
				    if (isset($newlegalaidcase4["incidentprefixid"])) $incidentprefixid = $newlegalaidcase4["incidentprefixid"];
				    if (isset($newlegalaidcase4["incidentnr"])) $incidentnr = $newlegalaidcase4["incidentnr"];
				    if (isset($newlegalaidcase4["casefilenr"])) $casefilenr = $newlegalaidcase4["casefilenr"];
				    if (isset($newlegalaidcase4["legalcasecourttypeid"])) $legalcasecourttypeid = $newlegalaidcase4["legalcasecourttypeid"];
				    if (isset($newlegalaidcase4["arrestdate"])) $arrestdate = $newlegalaidcase4["arrestdate"];
				    if (isset($newlegalaidcase4["clientname"])) $clientname = $newlegalaidcase4["clientname"];
				    if (isset($newlegalaidcase4["clientage"])) $clientage = $newlegalaidcase4["clientage"];
				    if (isset($newlegalaidcase4["clientsexid"])) $clientsexid = $newlegalaidcase4["clientsexid"];
				    if (isset($newlegalaidcase4["clientmaritalstatusid"])) $clientmaritalstatusid = $newlegalaidcase4["clientmaritalstatusid"];
				    if (isset($newlegalaidcase4["survivoroccupationid"])) $survivoroccupationid = $newlegalaidcase4["survivoroccupationid"];
				    if (isset($newlegalaidcase4["residentdistrictid"])) $residentdistrictid = $newlegalaidcase4["residentdistrictid"];
				    if (isset($newlegalaidcase4["clientstatusid"])) $clientstatusid = $newlegalaidcase4["clientstatusid"];
				    if (isset($newlegalaidcase4["contactnumber"])) $contactnumber = $newlegalaidcase4["contactnumber"];
				    if (isset($newlegalaidcase4["mothersname"])) $mothersname = $newlegalaidcase4["mothersname"];
				    if (isset($newlegalaidcase4["accusertypeid"])) $accusertypeid = $newlegalaidcase4["accusertypeid"];
				    if (isset($newlegalaidcase4["accusername"])) $accusername = $newlegalaidcase4["accusername"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid1"])) $accusedlegislationarticleid1 = $newlegalaidcase4["accusedlegislationarticleid1"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid2"])) $accusedlegislationarticleid2 = $newlegalaidcase4["accusedlegislationarticleid2"];
				    if (isset($newlegalaidcase4["accusedlegislationarticleid3"])) $accusedlegislationarticleid3 = $newlegalaidcase4["accusedlegislationarticleid3"];
				    if (isset($newlegalaidcase4["actualsentenceid"])) $actualsentenceid = $newlegalaidcase4["actualsentenceid"];
				    if (isset($newlegalaidcase4["legaladvice"])) $legaladvice = $newlegalaidcase4["legaladvice"];
				    if (isset($newlegalaidcase4["legaladviceinfo"])) $legaladviceinfo = $newlegalaidcase4["legaladviceinfo"];
				    if (isset($newlegalaidcase4["legalrepresentation"])) $legalrepresentation = $newlegalaidcase4["legalrepresentation"];
				    if (isset($newlegalaidcase4["legalrepresentationinfo"])) $legalrepresentationinfo = $newlegalaidcase4["legalrepresentationinfo"];
				    if (isset($newlegalaidcase4["otherlegalservices"])) $otherlegalservices = $newlegalaidcase4["otherlegalservices"];
				    if (isset($newlegalaidcase4["otherlegalservicesinfo"])) $otherlegalservicesinfo = $newlegalaidcase4["otherlegalservicesinfo"];
				    if (isset($newlegalaidcase4["casestatusid"])) $casestatusid = $newlegalaidcase4["casestatusid"];
				    if (isset($newlegalaidcase4["legalcasestatusid"])) $legalcasestatusid = $newlegalaidcase4["legalcasestatusid"];
				    if (isset($newlegalaidcase4["processtypeid"])) $processtypeid = $newlegalaidcase4["processtypeid"];
				    if (isset($newlegalaidcase4["casestatusdetail"])) $casestatusdetail = $newlegalaidcase4["casestatusdetail"];
				    if (isset($newlegalaidcase4["staffcodeid"])) $staffcodeid = $newlegalaidcase4["staffcodeid"];
				    if (isset($newlegalaidcase4["projectid"])) $projectid = $newlegalaidcase4["projectid"];
				    if (isset($newlegalaidcase4["registermonthid"])) $registermonthid = $newlegalaidcase4["registermonthid"];
				    if (isset($newlegalaidcase4["registeryear"])) $registeryear = $newlegalaidcase4["registeryear"];

				    if (isset($newlegalaidcase4["openeddate"])) $openeddate = $newlegalaidcase4["openeddate"];
				    if (isset($newlegalaidcase4["incidentdate"])) $incidentdate = $newlegalaidcase4["incidentdate"];
				    if (isset($newlegalaidcase4["staffcode"])) $staffcode = $newlegalaidcase4["staffcode"];
				    if (isset($newlegalaidcase4["survivorotheroccupation"])) $survivorotheroccupation = $newlegalaidcase4["survivorotheroccupation"];
				    if (isset($newlegalaidcase4["survivordisplacementid"])) $survivordisplacementid = $newlegalaidcase4["survivordisplacementid"];
				    if (isset($newlegalaidcase4["allegedperpetratorsname"])) $allegedperpetratorsname = $newlegalaidcase4["allegedperpetratorsname"];
				    if (isset($newlegalaidcase4["perpetratornumberid"])) $perpetratornumberid = $newlegalaidcase4["perpetratornumberid"];
				    if (isset($newlegalaidcase4["perpetratorrelationshipid"])) $perpetratorrelationshipid = $newlegalaidcase4["perpetratorrelationshipid"];
				    if (isset($newlegalaidcase4["perpetratoroccupationid"])) $perpetratoroccupationid = $newlegalaidcase4["perpetratoroccupationid"];
					if (isset($newlegalaidcase4["otherperpetratoroccupation"])) $otherperpetratoroccupation = $newlegalaidcase4["otherperpetratoroccupation"];
				    if (isset($newlegalaidcase4["perpetratorsexid"])) $perpetratorsexid = $newlegalaidcase4["perpetratorsexid"];
				    if (isset($newlegalaidcase4["agegroupid"])) $agegroupid = $newlegalaidcase4["agegroupid"];

				    if (isset($newlegalaidcase4["followupsessionid"])) $followupsessionid = $newlegalaidcase4["followupsessionid"];
				    if (isset($newlegalaidcase4["placedtypeid"])) $placedtypeid = $newlegalaidcase4["placedtypeid"];
				    if (isset($newlegalaidcase4["legalincidentdetail"])) $legalincidentdetail = $newlegalaidcase4["legalincidentdetail"];
				}	


				$arrestdate = NULL;
				if(isset($newlegalaidcase4['arrestdate'])) $arrestdate = date("Y-m-d", strtotime($newlegalaidcase4['arrestdate']));  
				else $arrestdate = NULL;

				$openeddate = NULL;
				if(isset($newlegalaidcase4['openeddate'])) $openeddate = date("Y-m-d", strtotime($newlegalaidcase4['openeddate']));  
				else $openeddate = NULL;

				$incidentdate = NULL;
				if(isset($newlegalaidcase4['incidentdate'])) $incidentdate = date("Y-m-d", strtotime($newlegalaidcase4['incidentdate']));  
				else $incidentdate = NULL;
				

				$loginuserinfo = Session::get('USERINFO');

				$incidentrecorderid = $loginuserinfo['employeeid'];
				$placedemployeeid = $loginuserinfo['employeeid'];
				$placedroleid = $loginuserinfo['roleid'];			

				$updlegalaidcasedata = array(
					'incidentnr' => $incidentnr,
					'casefilenr' => $casefilenr,
					'legalcasecourttypeid' => $legalcasecourttypeid,
					'arrestdate' => $arrestdate,
					'clientname' => $clientname,
					'clientage' => $clientage,
					'clientsexid' => $clientsexid,
					'clientmaritalstatusid' => $clientmaritalstatusid,
					'survivoroccupationid' => $survivoroccupationid,
					'residentdistrictid' => $residentdistrictid,
					'clientstatusid' => $clientstatusid,
					'contactnumber' => $contactnumber,
					'mothersname' => $mothersname,
					'motherscontactnumber' => $motherscontactnumber,
					'accusertypeid' => $accusertypeid,
					'accusername' => $accusername,
					'accusedlegislationarticleid1' => $accusedlegislationarticleid1,
					'accusedlegislationarticleid2' => $accusedlegislationarticleid2,
					'accusedlegislationarticleid3' => $accusedlegislationarticleid3,
					'actualsentenceid' => $actualsentenceid,
					'legalincidentdetail' => $legalincidentdetail,
					'legaladvice' => $legaladvice,
					'legaladviceinfo' => $legaladviceinfo,
					'legalrepresentation' => $legalrepresentation,
					'legalrepresentationinfo' => $legalrepresentationinfo,
					'otherlegalservices' => $otherlegalservices,
					'otherlegalservicesinfo' => $otherlegalservicesinfo,
					'casestatusid' => $casestatusid,
					'legalcasestatusid' => $legalcasestatusid,
					'processtypeid' => $processtypeid,
					'casestatusdetail' => $casestatusdetail,
					'staffcodeid' => $staffcodeid,
					'projectid' => $projectid,
					'registermonthid' => $registermonthid,
					'registeryear' => $registeryear,
					'openeddate' => $openeddate,
					'incidentdate' => $incidentdate,
					'staffcode' => $staffcode,
					'agegroupid' => $agegroupid,
					'survivorotheroccupation' => $survivorotheroccupation,
					'survivordisplacementid' => $survivordisplacementid,
					'allegedperpetratorsname' => $allegedperpetratorsname,
					'perpetratornumberid' => $perpetratornumberid,
					'perpetratorrelationshipid' => $perpetratorrelationshipid,
					'perpetratoroccupationid' => $perpetratoroccupationid,
					'otherperpetratoroccupation' => $otherperpetratoroccupation,
					'perpetratorsexid' => $perpetratorsexid,
					'updateduserid' => $user->data()->id,
					'updatedtime' => date('Y-m-d h:i'),
					'formhash' => Input::get('formhash'),
					'deleted' => 0 
					);

					// ACTION UPDATE LEGAL AID CASE  DATA
					$legalaidcase = new DBTable("legalaidcases");	
					try{
						$legalaidcase->update($updlegalaidcasedata,$legalaidcaseid);
						$updatedlegalcase = 1;	
						echo "<br/>Updated Case";
						}catch(Exception $e){$updatedlegalcase = 0;die($e->getMessage());}


					if ($updatedlegalcase) {

						$showstatus = 1;
						$init_status .=' Legal aid case updated.';
						Session::put('init_status',$init_status);
						Session::put('init_status_sweet','sweetadd');
						Session::delete('newlegalaidcase1');
						Session::delete('newlegalaidcase2');
						Session::delete('newlegalaidcase3');
						Session::delete('newlegalaidcase4');

						Redirect::to('mylegalaidcases.php');

						
					}	
				 
			}
		} else {
			$showstatus = 1;
			$init_status .=' Legal Aid Case not created, missing data, please fill the forms correct.';
			Session::put('init_status',$init_status);
		} 
	}

} else {
				$showstatus = 1;
				$init_status .=' Not sended yet.';
				Session::put('init_status',$init_status);
}


?>



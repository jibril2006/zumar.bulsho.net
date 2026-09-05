<?php

class Form {

    private $FormAttributes = array();
    private $FullForm;
    private $FormField;
    private $FormFieldHidden;
    private $FormStart;
    private $FormEnd;
    private $FormBody;
    public  $form = array();


    public function __construct($formtypevar)
    {
            $this->FormAttributes = $formtypevar; 
            $formhash = (isset($this->FormAttributes['formhash'])) ? $this->FormAttributes['formhash'] : bin2hex(random_bytes(16)) ;

            $this->FormStart .= '<div class="modal fade '.$this->FormAttributes['formid'].'" id="myModal" styles="overflow:hidden" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';
            $this->FormStart .= '<div class="modal-dialog" role="document">';
            $this->FormStart .= '<div class="modal-content">';
            $this->FormStart .= '<div class="modal-header">';
            $this->FormStart .= '<h4 class="modal-title" id="myModalLabel">'.$this->FormAttributes['formtitle'].'</h4>';
            $this->FormStart .= '<button type="button push-right" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
            $this->FormStart .= '<div class="modal-body">';
            if(!empty($this->FormAttributes['action']))
            $this->FormStart .= '<form action="'.$this->FormAttributes['action'].'" enctype="multipart/form-data" method="post" id="'.$this->FormAttributes['formid'].'">';
            else 
            $this->FormStart .= '<form action="" method="post" id="'.$this->FormAttributes['formid'].'" enctype="multipart/form-data">';
            $this->FormStart .= '<input id="POST" name="POST" type="hidden" value="1">';
            $this->FormStart .= '<input id="POSTACTION" name="POSTACTION" type="hidden" value="'.$this->FormAttributes['postaction'].'">';

            if(isset($this->FormAttributes['token'])) $this->FormStart .= '<input type="hidden" name="token" value="'.$this->FormAttributes['token'].'">';
            $this->FormStart .= '<input id="formhash" name="formhash" type="hidden" value="'.$formhash.'">';

            $this->FormEnd .= '</form>';
            $this->FormEnd .= '</div>';
            $this->FormEnd .= '<div class="modal-footer">';
            $this->FormEnd .= '<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">'.$this->FormAttributes['cancelvalue'].'</button>';
            $this->FormEnd .= '<button type="submit" class="btn btn-success btn-sm" form="'.$this->FormAttributes['formid'].'">'.$this->FormAttributes['submitvalue'].'</button>';
            $this->FormEnd .= '</div></div>';
            $this->FormEnd .= '</div>';
            $this->FormEnd .= '</div>';

    }
    
    public function addfield($fieldArray){
    	$fieldtype = (isset($fieldArray['type'])) ? $fieldArray['type'] : 'text' ;
    	$theformname = (isset($fieldArray['name'])) ? $fieldArray['name'] : $fieldArray['id'] ;
    	$id = (isset($fieldArray['id'])) ? $fieldArray['id'] : '' ;
    	$value = (isset($fieldArray['value'])) ? $fieldArray['value'] : '' ;
    	$placeholder = (isset($fieldArray['placeholder'])) ? $fieldArray['placeholder'] : '' ;
    	$extra = (isset($fieldArray['extra'])) ? $fieldArray['extra'] : '' ;

		$FormField = '';
		$FormField .= '<div class="form-group">';
		$FormField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
		$FormField .= '<input type="'.$fieldtype.'" class="form-control" style="max-width:300px;" id="'.$id.'" name="'.$theformname.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
		$FormField .= '</div>'; 
		return $FormField;
    }

    public function adddatefield($fieldArray){
        $fieldtype = (isset($fieldArray['type'])) ? $fieldArray['type'] : 'text' ;
        $theformname = (isset($fieldArray['name'])) ? $fieldArray['name'] : $fieldArray['id'] ;
        $id = (isset($fieldArray['id'])) ? $fieldArray['id'] : '' ;
        $value = (isset($fieldArray['value'])) ? $fieldArray['value'] : '' ;
        $placeholder = (isset($fieldArray['placeholder'])) ? $fieldArray['placeholder'] : '' ;
        $extra = (isset($fieldArray['extra'])) ? $fieldArray['extra'] : '' ;

        $FormField = '';
        $FormField .= '<div class="form-group">';
        $FormField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
        $FormField .= '<input type="'.$fieldtype.'" class="form-control" style="max-width:300px;" id="'.$id.'" name="'.$theformname.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$extra.'>';
        $FormField .= '<script type="text/javascript">';
        $FormField .= " $('#";
        $FormField .= $id;
        $FormField .= "').datepicker({";
        $FormField .= ' language: strlanguage, firstDay: strfirstDay, autoClose: strautoClose, dateFormat: strdateFormat,';
        // $FormField .= ' autoClose: true,';
        $FormField .= " onRenderCell: function (date, cellType) { if (cellType == 'day') {";
        $FormField .= ' var day = date.getDay(),';
        $FormField .= ' isDisabled = disabledDays.indexOf(day) != -1;';
        $FormField .= ' return { disabled: isDisabled }';
        $FormField .= '} } }) </script>';
        $FormField .= '';
        $FormField .= '</div>'; 
        return $FormField;
    }


    public function addfilefield($fieldArray){
    	$fieldtype = (isset($fieldArray['type'])) ? $fieldArray['type'] : 'text' ;
    	$theformname = (isset($fieldArray['name'])) ? $fieldArray['name'] : $fieldArray['id'] ;
    	$id = (isset($fieldArray['id'])) ? $fieldArray['id'] : '' ;
    	$value = (isset($fieldArray['value'])) ? $fieldArray['value'] : '' ;
    	$placeholder = (isset($fieldArray['placeholder'])) ? $fieldArray['placeholder'] : '' ;
    	$extra = (isset($fieldArray['extra'])) ? $fieldArray['extra'] : '' ;

    	$FormField = '';
		$FormField .= '<div class="form-group">';
		$FormField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
		$FormField .= '<input type="file" id="'.$id.'" name="'.$theformname.'"  '.$extra.'>';
		$FormField .= '</div>'; 
		return $FormField;
    }



    public function addselectfield1($fieldArray){
		$FormSelectField = '';
		$FormSelectField .= '<div class="form-group">';
		$FormSelectField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
		$FormSelectField .= '    <select class="js-example-basic-single pure-input-1-5" name="'.$fieldArray['name'].'" size="1">';

		$results = $wpdb->get_results("SELECT * FROM ".$fieldArray['tabelname']." WHERE deleted = 0 order by ".$fieldArray['ordername']);
            if(!empty($results)) {
            foreach($results as $r)
            {
                $FormSelectField .= '<option value="'.$r->id. '"'; 
                if($fieldArray['selectedid'] == $r->id) $FormSelectField .= 'selected'; 
                $FormSelectField .= '>' . $r->facultyname . '</option>';
            }
            } 

        $FormSelectField .= '</select></div>';
        return $FormSelectField;
    }

    public function addselectfield($fieldArray){
		$FormSelectField = '';
		$FormSelectField .= '<div class="form-group" id="'.$fieldArray['id'].'div">';
		$FormSelectField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
        $FormSelectField .= '    <select class="jqs" style="min-width:300px;" name="'.$fieldArray['name'].'" id="'.$fieldArray['id'].'" size="1">';

		$FormSelectField .= $fieldArray['option'];

        $FormSelectField .= '</select>';
        $FormSelectField .= '</div>';
        return $FormSelectField;
    }

    public function addselectfieldblock($fieldArray){
        $FormSelectField = '';
        $FormSelectField .= '<div class="form-group" id="'.$fieldArray['id'].'div" style="display:none;">';
        $FormSelectField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
        $FormSelectField .= '    <select class="jqs" style="min-width:300px;" name="'.$fieldArray['name'].'" id="'.$fieldArray['id'].'" size="1">';

        $FormSelectField .= $fieldArray['option'];

        $FormSelectField .= '</select>';
        $FormSelectField .= '</div>';
        return $FormSelectField;
    }

    public function addselectfieldnon($fieldArray){
		$FormSelectField = '';
		$FormSelectField .= '<div class="form-group">';
		$FormSelectField .= '<label style="margin-bottom:0px;">'.$fieldArray['label'].':</label>';
        $FormSelectField .= '    <select class="" style="min-width:300px;" name="'.$fieldArray['name'].'" id="'.$fieldArray['id'].'" size="1">';

		$FormSelectField .= $fieldArray['option'];

        $FormSelectField .= '</select>';
        $FormSelectField .= '</div>';
        return $FormSelectField;
    }

    public function addtextarea($fieldArray){
        $extra = isset($fieldArray['extra']) ? $fieldArray['extra'] : '' ;
        $FormTextarea = '';
		$FormTextarea .= '<div class="form-group">';
		$FormTextarea .= '<label style="margin-bottom:0px;padding-left:2px; max-width:100% !important;" class="col-sm-2 col-form-label col-form-label-sm">'.$fieldArray['label'].':</label>';
		$FormTextarea .= '<textarea class="form-control" id="'.$fieldArray['id'].'" name="'.$fieldArray['name'].'" rows="'.$fieldArray['rows'].'" cols="'.$fieldArray['cols'].'" '.$extra.'>'.$fieldArray['textvalue'].'</textarea>';
		$FormTextarea .= '</div>';
		return $FormTextarea;
    }
    
    public function addfieldhidden($fieldhiddenArray){
		$this->FormFieldHidden .= '<input type="hidden"';
		$this->FormFieldHidden .= ' name="'.$fieldhiddenArray['name'].'"'; 
		$this->FormFieldHidden .= ' id="'.$fieldhiddenArray['id'].'"';
		$this->FormFieldHidden .= ' value="'.$fieldhiddenArray['value'].'">';	
		return $this->FormFieldHidden; 
    }

   public function addformbody($FormBody){
		$this->FormBody = $FormBody;
    }

    
    public function FullForm(){
    	$this->FullForm .= $this->FormStart;
     	$this->FullForm .= $this->FormBody;
    	$this->FullForm .= $this->FormEnd;
    	return $this->FullForm;
    }
    
    
}

?>
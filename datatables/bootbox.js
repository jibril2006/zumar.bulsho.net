var UIBootbox = function () {

    var handleDemo = function() {

        $('#consentform_auth1').click(function(){
                bootbox.alert("1.   <br/><br/>I understand that in giving my authorization below, I am giving (SWDC) permission to share the specific case information from my incident report with the service provider(s) I have indicated, so that I can receive help with safety, health, psychosocial, and/or legal needs.<br/><br/>I understand that shared information will be treated with confidentiality and respect, and shared only as needed to provide the assistance I request.<br/><br/>I understand that releasing this information means that a person from the agency or service ticked below may come to talk to me.  At any point, I have the right to change my mind about sharing information with the designated agency / focal point listed below.<br><br>I would like information released to the specified services.: <br>(ticked service, with specified name, facility and agency/organization.)");
            });
            //end #demo_1
        $('#consentform_auth2').click(function(){
                bootbox.alert("2).   <br/><br/>I have been informed and understand that some non-identifiable information may also be shared for reporting. <br/><br/>Any information shared will not be specific to me or the incident. <br/>There will be no way for someone to identify me based on the information that is shared.<br/><br/>I understand that shared information will be treated with confidentiality and respect.");
            });
            //end #demo_1
        }

    return {

        //main function to initiate the module
        init: function () {
            handleDemo();
        }
    };

}();

jQuery(document).ready(function() {    
   UIBootbox.init();
});
var ComponentsTypeahead = function () {

    var handleTwitterTypeahead = function() {

  
        // Example #2
        var locations = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          prefetch: {
            url: '../_data/jsonlocations.php',
            filter: function(list) {
              return $.map(list, function(country) { return { name: country }; });
            }
          }
        });
 
        locations.initialize();
         
        if (App.isRTL()) {
          $('#jsonlocations').attr("dir", "rtl");  
        } 
        $('#jsonlocations').typeahead(null, {
          name: 'jsonlocations',
          displayKey: 'name',
          hint: (App.isRTL() ? false : true),
          source: locations.ttAdapter()
        });

        

    }

    var handleTwitterTypeaheadModal = function() {


        // Example #2
        var locations = new Bloodhound({
          datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.name); },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          limit: 10,
          prefetch: {
            url: '../_data/jsonlocations.php',
            filter: function(list) {
              return $.map(list, function(country) { return { name: country }; });
            }
          }
        });
 
        locations.initialize();
         
        if (App.isRTL()) {
          $('#jsonlocations').attr("dir", "rtl");  
        }
        $('#jsonlocations').typeahead(null, {
          name: 'jsonlocations',
          displayKey: 'name',
          hint: (App.isRTL() ? false : true),
          source: locations.ttAdapter()
        });

        

    }

    return {
        //main function to initiate the module
        init: function () {
            handleTwitterTypeahead();
            handleTwitterTypeaheadModal();
        }
    };

}();

jQuery(document).ready(function() {    
   ComponentsTypeahead.init(); 
});
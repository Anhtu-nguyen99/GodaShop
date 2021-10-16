// Call the dataTables jQuery plugin
$(document).ready(function() {
  	var table = $('#dataTable').DataTable();
  	$('form').on('submit', function(e){
      // // Prevent actual form submission
      // e.preventDefault();

      // // Serialize form data
      // var data = table.$('input').serializeArray();

      // // Include extra data if necessary
      // // data.push({'name': 'extra_param', 'value': 'extra_value'});

      // // Submit form data via Ajax
      // $.post({
      //    url: 'test.php',
      //    data: data
      // });

      var form = this;

      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input').serializeArray();
      // Iterate over all form elements
      $.each(params, function(){
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element

            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name + "[]")
                  .val(this.value)
            );
         }
      });
   });

});


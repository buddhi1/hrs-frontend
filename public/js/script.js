$(function() {
    $( "#from" ).datepicker({
      defaultDate: "",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#to" ).datepicker( "option", "minDate", selectedDate);
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });


document.getElementById('room_type').onchange = function(){
  console.log(this.value);
  sendRequestToServerPost(http_path+'/loadItem','room_type_id='+this.value,handleResponce);
}

  var handleResponce = function(res){
    var services = JSON.parse(res);


    
    document.getElementById("service").options.length=0;
    for(var i=0; services.length;++i){
      console.log(services);
      
      var option = document.createElement("option");
      option.text = services[i]['name'];
      option.value = services[i]['service_id'];
      var select = document.getElementById("service");
      select.appendChild(option);
    }   
  }


window.onload = function(){
  sendRequestToServerPost(http_path+'/loadItem','room_type_id='+document.getElementById('room_type').value,handleResponce);
}


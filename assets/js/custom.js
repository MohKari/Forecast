$(document).ready(function () {
  
  
  $("#search-city").keyup(function(){

    var keyword = $(this).val();

    if(keyword.length > 2)
      {

          $.ajax({
              type: "POST",
              url: "Classes/Data.php",
              data:'keyword='+$(this).val(),
              beforeSend: function(){
                //$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
              },
             
              success: function(data){
                $("#suggesstion-box").show();
                $("#suggesstion-box").removeClass("d-none");
                $("#suggesstion-box ul").html(data);
                $("#search-box").css("background","#FFF");
              }
        });

      }  
        
  });

  $("#city").click(function() {

      var location =  $(this).text(); // gets text contents of clicked li
    
  });
  
  $('#search-city').focusout(function() { 
   // $('#suggesstion-box').hide();
  });

  $('#search-city').focus(function() { 
    $('#suggesstion-box').show();
  });

});  
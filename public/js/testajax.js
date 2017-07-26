$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
              'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3RoZWxhc3RibG9vZC9wdWJsaWMvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE1MDAzNjIyNTksImV4cCI6MTUwMDM2OTQ1OSwibmJmIjoxNTAwMzYyMjU5LCJqdGkiOiJpaW1maEZ0WVpwR044V2QxIn0.D2nY-l8D6Mlac4gNoMwi6Z0FA_RRrky2nHJde1smQEI',
              'Content-type': 'application/json',
          }
      });

$(document).ready(function(){

  $.get("ajax1", function(Response){
    var txt = "<span>"+ Response +"&nbsp;</span>";
     $('#tbtxt1').append(txt);
  });

  $.ajax({
    type: 'GET',
    url: 'ajax3',
    dataType: 'json',
    success: function (data) {
        $.each(data, function(index, element) {
            $('#tbtxt3').append($('<div>', {
                text: element
            }));
        });
    }
  });

  $('#tbtxt4').append('<tr><th>edit</th><th>delete</th><th>id</th><th>name</th><th>email</th><th>password</th><th>blood</th><th>blood_type</th><th>birthyear</th><th>firstname</th><th>lastname</th><th>phone</th><th>province</th><th>countdonate</th><th>img</th><th>last_date_donate</th><th>status</th><th>created_at</th><th>updated_at</th></tr>');
    $.ajax({
      type: 'GET',
      url: 'ajax4',
      dataType: 'json',
      data: data
      success: function (data) {
          $.each(data, function(index1, element1) {
            $('#tbtxt4').append('<tr><th><div class="box"><a class="button" href="#popup4edit">Edit</a></div></th><th><div class="box"><a class="button" href="#popup4del">Delete</a></div></th><th>'+ element1.id+'</th><th>'+element1.name+'</th><th>'+element1.email+'</th><th>'+element1.password+'</th><th>'+element1.blood+'</th><th>'+element1.blood_type+'</th><th>'+element1.birthyear+'</th><th>'+element1.firstname+'</th><th>'+element1.lastname+'</th><th>'+element1.phone+'</th><th>'+element1.province+'</th><th>'+element1.countdonate+'</th><th>'+element1.img+'</th><th>'+element1.last_date_donate+'</th><th>'+element1.status+'</th><th>'+element1.created_at+'</th><th>'+element1.updated_at+'</th></tr>');
          });
      }
    });

    // $("#ajax3").click(function(){
    //     $.ajax({
    //       type: 'GET',
    //       url: 'ajax3',
    //       dataType: 'json',
    //       success: function (data) {
    //           $.each(data, function(index, element) {
    //               $('#txt3').append($('<div>', {
    //                   text: element
    //               }));
    //           });
    //       }
    //     });
    // });
    //
    //
    // $("#ajax4").click(function(){
    //     $('#txt4').append('<tr><th>id</th><th>name</th><th>email</th><th>password</th><th>blood</th><th>blood_type</th><th>birthyear</th><th>firstname</th><th>lastname</th><th>phone</th><th>province</th><th>countdonate</th><th>img</th><th>last_date_donate</th><th>status</th><th>created_at</th><th>updated_at</th></tr>');
    //       $.ajax({
    //         type: 'GET',
    //         url: 'ajax4',
    //         dataType: 'json',
    //         success: function (data) {
    //             $.each(data, function(index1, element1) {
    //               $('#txt4').append('<tr><th>'+ element1.id+'</th><th>'+element1.name+'</th><th>'+element1.email+'</th><th>'+element1.password+'</th><th>'+element1.blood+'</th><th>'+element1.blood_type+'</th><th>'+element1.birthyear+'</th><th>'+element1.firstname+'</th><th>'+element1.lastname+'</th><th>'+element1.phone+'</th><th>'+element1.province+'</th><th>'+element1.countdonate+'</th><th>'+element1.img+'</th><th>'+element1.last_date_donate+'</th><th>'+element1.status+'</th><th>'+element1.created_at+'</th><th>'+element1.updated_at+'</th></tr>');
    //             });
    //         }
    //       });
    // });

    // contact form animations
      $('#contact').click(function() {
        $('#contactForm').fadeToggle();
        document.getElementById("body").style.background = 'lightblue';
      })
      $(document).mouseup(function (e) {
        var container = $("#contactForm");

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
          document.getElementById("body").style.background = 'white';
            container.fadeOut();
        }
      });

});

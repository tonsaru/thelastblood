$.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
              'Authorization': 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE2LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0L3RoZWxhc3RibG9vZC9wdWJsaWMvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE1MDAzNjIyNTksImV4cCI6MTUwMDM2OTQ1OSwibmJmIjoxNTAwMzYyMjU5LCJqdGkiOiJpaW1maEZ0WVpwR044V2QxIn0.D2nY-l8D6Mlac4gNoMwi6Z0FA_RRrky2nHJde1smQEI',
              'Content-type': 'application/json',
          }
      });


$(document).ready(function(){
// Initialize collapse button
 $(".button-collapse").sideNav();
 // Initialize collapsible (uncomment the line below if you use the dropdown variation)
 //$('.collapsible').collapsible();

 $('.button-collapse').sideNav({
      menuWidth: 300, // Default is 300
      edge: 'right', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens,
      onOpen: function(el) { /* Do Stuff* / }, // A function to be called when sideNav is opened
      onClose: function(el) { /* Do Stuff* / }, // A function to be called when sideNav is closed
    }
  );
}


$(document).ready(function (){
	
	
	
	$("#signup").click(function(){
		$("#login_first").slideUp("slow", function(){
			$("#login_second").slideDown("slow");
		});
	});
	
	$("#signin").click(function(){
		$("#login_second").slideUp("slow", function(){
			$("#login_first").slideDown("slow");
		});
	});
});


$(document).ready(function() {
	$("#login_first").show();
	$("#login_second").hide();
});

function getLiveSearchUsers(value, user) {

	$.post("includes/handlers/ajax_search.php", {query:value, userLoggedIn: user}, function(data) {

		if($(".search_results_footer_empty")[0]) {
			$(".search_results_footer_empty").toggleClass("search_results_footer");
			$(".search_results_footer_empty").toggleClass("search_results_footer_empty");
		}

		$('.search_results').html(data);
		$('.search_results_footer').html("<a href='search.php?q=" + value + "'>See All Results</a>");

		if(data == "") {
			$('.search_results_footer').html("");
			$('.search_results_footer').toggleClass("search_results_footer_empty");
			$('.search_results_footer').toggleClass("search_results_footer");
		}

	});

}



var x = document.getElementById("demo");
var loading = document.getElementById("loading");

function getLocation(){
	 $("#locationstatus").text(' ');
	 
    if (navigator.geolocation) {
    	
       navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    var latlon = new google.maps.LatLng(lat, lon);
    var mapholder = document.getElementById('mapholder')
    mapholder.style.height = '400px';
    mapholder.style.width = '550px';

    var myOptions = {
    center:latlon,zoom:14,
    mapTypeId:google.maps.MapTypeId.ROADMAP,
    mapTypeControl:false,
    navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
    }
    
    var map = new google.maps.Map(document.getElementById("mapholder"), myOptions);
    var marker = new google.maps.Marker(
    		{
    		position:latlon,
    		map:map,
    		title:"Share Location"
    		}); 
    
    google.maps.event.addListener(marker, 'click', function () {
   
    	$.ajax({
    	      url: "includes/handlers/ajax_load_location_post.php",
    	      type: "POST",
    	      data: {
    	    	  'latitude':lat,
    	    	  'longitude':lon
    	      },
    	      cache:false,

    	      success: function(data) {
    	    	  console.log('m here');
    	    	  $("#locationstatus").text('Your location has been updated!');
    	    	 
    	        
    	      }
    	    });
    	

    
    });
}
// To use this code on your website, get a free API key from Google.
// Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

function errorFunction() {
	  alert("Geocoder failed");
}


function codeLatLng(lat, lng) {
	
	  var itemLocality = '';
	  var latlng = new google.maps.LatLng(lat, lng);
	  geocoder = new google.maps.Geocoder();
	  geocoder.geocode({latLng: latlng}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
	      if (results[1]) {
	        var arrAddress = results;
	        console.log(results);
	        $.each(arrAddress, function(i, address_component) {
	          if (address_component.types[0] == "locality" || address_component.types[0] == "neighborhood") {
	            console.log("City: " + address_component.address_components[0].long_name);
	            itemLocality += address_component.address_components[0].long_name+ ', ';
	            console.log(itemLocality)
	            
	          }
	        });
	        console.log(itemLocality);
	      } else {
	        alert("No results found");
	      }
	    } else {
	      alert("Geocoder failed due to: " + status);
	    }
	  });
}

 

$('.slider').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    centerMode: true,
    variableWidth: true,
    infinite: true,
    focusOnSelect: true,
    cssEase: 'linear',
    touchMove: true,
    prevArrow:'<i class="bi bi-arrow-left"></i>',
    nextArrow:'<i class="bi bi-arrow-right"></i>',
    
    responsive: [                        
        {
          breakpoint: 576,
          settings: {
            centerMode: false,
            variableWidth: false,
          }
        },
    ]
  });
$('.program-slider').slick({
  prevArrow:'<i class="fas fa-chevron-left"></i>',
  nextArrow:'<i class="fas fa-chevron-right"></i>',
  dots: true,
});
  $('.icon-input i').on('click',function(e){
    let x = $(this).prev().attr('type');
    if (x === "password") {
      x = $(this).prev().attr('type','text');
      $(this).removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
    } else {
      x =  $(this).prev().attr('type','password');
      $(this).removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
    }
  })








$("#address").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#id_of_button").click();
    }
});

var locations = [
  ["John Doe", "145 Rock Ridge Road, Chester, NY ", "41.314926,-74.270134", "http://maps.google.com/mapfiles/ms/icons/blue.png"],
  ["Jim Smith", "12 Williams Rd, Montvale, NJ ", "41.041599,-74.019554", "http://maps.google.com/mapfiles/ms/icons/green.png"],
  ["John Jones", "689 Fern St Township of Washington, NJ ", "40.997704,-74.050598", "http://maps.google.com/mapfiles/ms/icons/yellow.png"],
];
var worldMapData = [
      // {
      //   "John Doe", 
      //   "145 Rock Ridge Road, Chester, NY ", 
      //   "41.314926,-74.270134", 
      //   "http://maps.google.com/mapfiles/ms/icons/blue.png"
      // }
      {
        "Id": "10020",
        "PropertyCode": "HELHAK",
        "address": "Siltasaarenkatu 14",
        "latitude": "60.1791466",
        "longitude": "24.9473743",
        "GMapIconImage": "/assets/markers/marker.png",
        "type": "Hotel",
        "hotelName": "Cumulus Hakaniemi Helsinki"
      },
      {
        "Id": "10080",
        "PropertyCode": "HELKAI",
        "address": "Kaisaniemenkatu 7",
        "latitude": "60.1716867",
        "longitude": "24.9458183",
        "GMapIconImage": "/assets/markers/marker.png",
        "type": "Hotel",
        "hotelName": "Cumulus Kaisaniemi Helsinki"
      },
      {
        "Id": "10170",
        "PropertyCode": "HELMEI",
        "address": "Tukholmankatu 2",
        "latitude": "60.1910171",
        "longitude": "24.9090258",
        "GMapIconImage": "/assets/markers/marker.png",
        "type": "Hotel",
        "hotelName": "Cumulus Meilahti Helsinki"
      },
      {
        "Id": "10090",
        "PropertyCode": "HELOLY",
        "address": "Läntinen Brahenkatu 2",
        "latitude": "60.1868253",
        "longitude": "24.946055",
        "GMapIconImage": "/assets/markers/marker.png",
        "type": "Hotel",
        "hotelName": "Cumulus Kallio Helsinki"
      },
      {
        "Id": "10280",
        "PropertyCode": "HELSEU",
        "address": "Kaivokatu 12",
        "latitude": "60.1700957",
        "longitude": "24.9377173",
        "GMapIconImage": "/assets/markers/marker.png",
        "type": "Hotel",
        "hotelName": "Hotel Seurahuone Helsinki"
      }
    ];
// alert(locations.length);
var geocoder = null;
var map = null;
var customerMarker = null;
var gmarkers = [];
var closest = [];
//var directionsDisplay = new google.maps.DirectionsRenderer();;
//var directionsService = new google.maps.DirectionsService();


var northEastLat = 37.468404;
  var northEastLng = -122.095122;
  var southWestLat = 37.415386;
  var southWestLng = -122.188678;



var USbounds = {
      "south": -74.270134,
      "west": -74.019554,
      "north": 41.314926,
      "east": 40.997704
    };
var EuropeBounds = {
      "south": 34.5428,
      "west": -31.464799900000003,
      "north": 82.1673907,
      "east": 74.35550009999997
    };
function centerMap(bounds) {

   var bounds = new google.maps.LatLngBounds(
    /* sw */
    {
      lat: southWestLat,
      lng: southWestLng
    },
    /* ne */
    {
      lat: northEastLat,
      lng: northEastLng
    }); 
   map.fitBounds(bounds);
   map.setZoom(9);
}
var map;

  function initMap() {
    geocoder = new google.maps.Geocoder();
    
    
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(60.1791466, 24.9473743),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var input = document.getElementById('address');

    var options = {
      types: ['address'],
      // componentRestrictions: {
      //   country: 'us'
      // }
    };

    autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      var place = autocomplete.getPlace();
      for (var i = 0; i < place.address_components.length; i++) {
        for (var j = 0; j < place.address_components[i].types.length; j++) {
          if (place.address_components[i].types[j] == "postal_code") {
            document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;

          }
        }
      }
    })
  
  
    var marker, i, markerContent, 
      infowindow = new google.maps.InfoWindow();
    var bounds = new google.maps.LatLngBounds();
    //document.getElementById('info').innerHTML = "found " + locations.length + " locations<br>";
    
    for (i = 0; i < worldMapData.length; i++) { 
      var pt = new google.maps.LatLng(worldMapData[i].latitude, worldMapData[i].longitude);
      
      bounds.extend(pt); 
      marker = new google.maps.Marker({
        position: pt,
        map: map,
        animation: google.maps.Animation.DROP,
        address: worldMapData[i].address,
        title: worldMapData[i].PropertyCode,
        html: worldMapData[i].PropertyCode + "<br>" + worldMapData[i].address + "<br><br><a href='javascript:getDirections(customerMarker.getPosition(),&quot;" + worldMapData[i].address + "&quot;);'>Get Directions</a>"
      });
      gmarkers.push(marker);
  
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(marker.html);
          infowindow.open(map, marker);
        }
      })(marker, i));
  
    }
    console.log(bounds);
    map.fitBounds(bounds);

    google.maps.event.addListener(map, "click", function (event) {
      codeAddressByClick(event);
      var newBounds = new google.maps.LatLngBounds(event.latLng,event.latLng);
      
      map.fitBounds( newBounds.getCenter() );
      map.setZoom(12);
    }); //end addListener
  
  }












function codeAddressByClick(locationV) {
  console.log('sssss');
  closest = findClosestN(locationV.latLng, 12);
  // get driving distance
  closest = closest.splice(0, 12);
  calculateDistances(locationV.latLng, closest, 12);
  //MAKE AJAX CALL TO GOOGLE API BY CLICKED LAT & LNG CLICK POSITION
  jQuery.get( "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + locationV.latLng.lat() + ',' + locationV.latLng.lng(), function( data )   {
    //RUN THROUGH THE OBJECT AND SEE IF FIRST FORMATTED ADDRESS IS AVAILABLE
    if(data.results[0].formatted_address){
      //POPULATE THE ADDRESS FIELD
      jQuery('#address').val(data.results[0].formatted_address);
    }
  });
}

function codeAddress() {
  var address = document.getElementById('address').value;
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      if (customerMarker) customerMarker.setMap(null);
      customerMarker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
      console.log(results[0].geometry.location);
      closest = findClosestN(results[0].geometry.location, 12);
      // get driving distance
      closest = closest.splice(0, 12);
      calculateDistances(results[0].geometry.location, closest, 12);
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function findClosestN(pt, numberOfResults) {
  var closest = [];
  //document.getElementById('info').innerHTML += "processing " + gmarkers.length + "<br>";
  for (var i = 0; i < gmarkers.length; i++) {
    gmarkers[i].distance = google.maps.geometry.spherical.computeDistanceBetween(pt, gmarkers[i].getPosition());
    //document.getElementById('info').innerHTML += "process " + i + ":" + gmarkers[i].getPosition().toUrlValue(6) + ":" + gmarkers[i].distance.toFixed(2) + "<br>";
    gmarkers[i].setMap(null);
    closest.push(gmarkers[i]);
    closest.sort(sortByDist);
  }

  return closest;
}

function sortByDist(a, b) {
  return (a.distance - b.distance)
}

function calculateDistances(pt, closest, numberOfResults) {
  var service = new google.maps.DistanceMatrixService();
  var request = {
    origins: [pt],
    destinations: [],
    travelMode: google.maps.TravelMode.DRIVING,
    unitSystem: google.maps.UnitSystem.IMPERIAL,
    avoidHighways: false,
    avoidTolls: false
  };
  for (var i = 0; i < closest.length; i++) {
    request.destinations.push(closest[i].getPosition());
  }
  service.getDistanceMatrix(request, function(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
      alert('Error was: ' + status);
    } else {
      var origins = response.originAddresses;
      var destinations = response.destinationAddresses;
      var outputDiv = document.getElementById('side_bar');
      var sidebarHtml = '<div class="address-group">';

      var results = response.rows[0].elements;
      // save title and address in record for sorting
      for (var i = 0; i < closest.length; i++) {
        results[i].title = closest[i].title;
        results[i].address = closest[i].address;
        results[i].idx_closestMark = i;
      }
      results.sort(sortByDistDM);
      for (var i = 0;
        ((i < numberOfResults) && (i < closest.length)); i++) {
        closest[i].setMap(map);
  //var letterMarkers = String.fromCharCode(97 + i);
  var letterMarkers = i + 1;
  closest[results[i].idx_closestMark].setLabel(letterMarkers);
  sidebarHtml += '<div class="address">';
      sidebarHtml += '<div class="number">';
        sidebarHtml += '<img src="img/Ellipse 17.png" alt="" srcset="">';
        sidebarHtml += '<span>'+letterMarkers+'</span>';
      sidebarHtml += '</div>';
      sidebarHtml += '<div class="description">';
          sidebarHtml += "<h5><a href='javascript:google.maps.event.trigger(closest[" + results[i].idx_closestMark + "],\"click\");'>" + results[i].title + "</a><br></h5>";
          sidebarHtml += '<a href="">info@kitsfsc.ca</a><p>'+ results[i].address +'</p>';
          sidebarHtml += '<a href="">www.kitsfsc.ca</a>';
          sidebarHtml += '<h6>3,79 kilometers</h6>';
          sidebarHtml += '<p class="gray">Directions</p>';
          sidebarHtml += '</div>';
        sidebarHtml += '</div>';
         //sidebarHtml += "<tr><td><div class='numberCircle'>" + letterMarkers + "</div><a href='javascript:google.maps.event.trigger(closest[" + results[i].idx_closestMark + "],\"click\");'>" + results[i].title + '</a><br>' + results[i].address + "<br>" + results[i].distance.text + ' approximately ' + results[i].duration.text + "<br><a href='javascript:getDirections(customerMarker.getPosition(),&quot;" + results[i].address + "&quot;);'>Get Directions</a></td></tr>"

        }
        sidebarHtml += '</div>';
        outputDiv.innerHTML = sidebarHtml;
      }
    });
}

function getDirections(origin, destination) {
  var request = {
    origin: origin,
    destination: destination,
    travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setMap(map);
      directionsDisplay.setDirections(response);
      $("#side_bar").css({
        "z-index": -100,
        "top": "135px"
      });
      $("#panel").css("z-index", 100);
      $("#mdiv").css("display", "block");

      directionsDisplay.setPanel(document.getElementById('panel'));


    }
  });
}

function sortByDistDM(a, b) {
  return (a.distance.value - b.distance.value)
}

//google.maps.event.addDomListener(window, 'load', initialize);





  $(function(){
    //coach edit js
    //multiselect 
    $('#language,#rinks,#speciality,.listdates,.campdates').multiselect();
    //img preview
    // imgInp.onchange = evt => {
    //   const [file] = imgInp.files
    //   if (file) {
    //     blah.src = URL.createObjectURL(file)
    //   }
    // }
    //file input trigger
    $(".img-upload .bi-plus-lg").click(function(){
      $(this).siblings('input').trigger("click");

    });
    $('.upClick,.fa-file-image').click(function(){
      $(this).prev().trigger('click');
    });

    var today = $('input[name="start_date"]').val();
    var endDate = $('input[name="end_date"]').val();

    //daterangepicker
    $('input[name="dates"]').daterangepicker({
      startDate: today, // after open picker you'll see this dates as picked
      endDate: endDate,
      locale: {
        format: 'YYYY-MM-DD'
      }
    });

    $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('YYYY-MM-DD'));
      console.log(picker.endDate.format('YYYY-MM-DD'));

      //[startDate, endDate] = $('.date_range').val().split(' - ');
      $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
      $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
    });

    var todayReg = $('input[name="reg_start_date"]').val();
    var endDateReg = $('input[name="reg_end_date"]').val();
    //daterangepicker
    $('input[name="reg_dates"]').daterangepicker({
      startDate: todayReg, // after open picker you'll see this reg_dates as picked
      endDate: endDateReg,
      locale: {
        format: 'YYYY-MM-DD'
      }
    });

    $('input[name="reg_dates"]').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('YYYY-MM-DD'));
      console.log(picker.endDate.format('YYYY-MM-DD'));

      //[startDate, endDate] = $('.date_range').val().split(' - ');
      $('input[name="reg_start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
      $('input[name="reg_end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
    });

    var todaySch = $('input[name="schedule_start_date[]"]').val();
    var endDateSch = $('input[name="schedule_end_date[]"]').val();
    // $('input[name="schedule_period"]').daterangepicker({
    //   startDate: $(this).parent().find('input[name="schedule_start_date[]"]').val(), // after open picker you'll see this reg_dates as picked
    //   endDate: $(this).parent().find('input[name="schedule_end_date[]"]').val(),
    //   locale: {
    //     format: 'YYYY-MM-DD'
    //   }
    // });

    $('input[name="schedule_period"]').daterangepicker({
        autoUpdateInput: true,
        //startDate: this.element.parent().find('input[name="schedule_start_date[]"]').val(), // after open picker you'll see this reg_dates as picked
        //endDate: this.element.parent().find('input[name="schedule_end_date[]"]').val(),
        locale: {
          format: 'YYYY-MM-DD'
        }
    });

    $('input[name="schedule_period"]').on('apply.daterangepicker', function(ev, picker) {
      console.log(picker.startDate.format('YYYY-MM-DD'));
      console.log(picker.endDate.format('YYYY-MM-DD'));
      $(this).parent().find('input[name="schedule_start_date[]"]').val(picker.startDate.format('YYYY-MM-DD'));
      $(this).parent().find('input[name="schedule_end_date[]"]').val(picker.endDate.format('YYYY-MM-DD'));
    });


    var i = 0;
    $(".check-section input:checkbox").on('change', function(){

      var name = $(this).attr("name");
      
      var checkedVals = $('input:checkbox[name='+name+']:checked').map(function() {
          return this.value;
      }).get();

      console.log(checkedVals);
      var url = checkedVals; // get selected value
      if (url.length != 0) { 
        //if (url) { // require a URL
        var newUrl = CURRENT_URL;
        //var id = ['a', 'b'];
        

        if (url instanceof Array) {
          var url = url.join(",");
        } 
        var newurl = replaceUrlParam(name,url,newUrl);
        newurl = newurl.replace("&amp;", "&");
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
        //console.log(newurl);
        window.location = newurl; // redirect
      }
      return false;
    });

    $(".location").on('change', function(){

      var name = $(this).attr("name");
      
      // var checkedVals = $('input:checkbox[name='+name+']:checked').map(function() {
      //     return this.value;
      // }).get();

      //console.log(checkedVals);
      var url = $(this).val(); // get selected value
      if (url.length != 0) { 
        //if (url) { // require a URL
        var newUrl = CURRENT_URL;
        //var id = ['a', 'b'];
        

        if (url instanceof Array) {
          var url = url.join(",");
        } 
        var newurl = replaceUrlParam(name,url,newUrl);
        newurl = newurl.replace("&amp;", "&");
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
        window.location = newurl; // redirect
      }
      return false;
    });


    function getURLParameter(name, urlsearch) {

        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(urlsearch || location.search) || [ , "" ])[1].replace(
                /\+/g, '%20'))
                || null;
    }

    function toNumber(str) {
       return str*1;
    }

    // var url = window.location.href;
    // //var recommand = getURLParameter('recommand', url);
    // var min = getURLParameter('min', url);
    // var max = getURLParameter('max', url);
    // if (min == null) {
    //     min = minDefault;        
    // }
    // if (max == null) {
    //     max = maxDefault;
    // }



    //range
    $("#ex2").bootstrapSlider({}).change(function(oldValue,newValue){
      


      let val=oldValue.value.newValue;
      $('.minVal').html('$'+val[0]);
      $('.maxVal').html('$'+val[1]);
      var href = window.location.href;

      if (href.indexOf("min") > -1)
      {
          href = href.replace(/(min)=\w+((?=[&])|)/, "min="+val[0]);
      }
      else 
      {
          var char = (href.indexOf("?") == -1 ? "?" : "&");
          
          href+= char + "min=" + val[0];
      }

      if (href.indexOf("max") > -1)
      {
          href = href.replace(/(max)=\w+((?=[&])|)/, "max="+val[1]);
      }
      else 
      {
          var char = (href.indexOf("?") == -1 ? "?" : "&");
          
          href+= char + "max=" + val[1];
      }
      window.location=href;

    });
  });

  function removeParam(parameter, url) {
    var urlParts = url.split('?');

    if (urlParts.length >= 2) {
      // Get first part, and remove from array
      var urlBase = urlParts.shift();

      // Join it back up
      var queryString = urlParts.join('?');

      var prefix = encodeURIComponent(parameter) + '=';
      var parts = queryString.split(/[&;]/g);

      // Reverse iteration as may be destructive
      for (var i = parts.length; i-- > 0; ) {
        // Idiom for string.startsWith
        if (parts[i].lastIndexOf(prefix, 0) !== -1) {
          parts.splice(i, 1);
        }
      }

      url = urlBase + '?' + parts.join('&');
    }

    //return url;
    url = url.replace(/&amp/g, "");
    if (url.indexOf('amp&') > -1)
    {
      url = url.replace(/amp&/g, "");
      //url = url.replace(/amp/g, "");
    } else {
      //url = url.replace(/amp/g, "");
    }
    url = url.replace(/&amp;/g, "&");
    
    url = url.replace(/%2C/g,",");
    return url;
  }


  function replaceUrlParam(paramName, paramValue,newUrl){
    var url = newUrl;

    if (paramValue == null) {
        paramValue = '';
    }

    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        return url.replace(pattern,'$1' + paramValue + '$2');
    }

    url = url.replace(/[?#]$/,'');
    url=url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
    url = url.replace(/%2C/g,",");
    url = url.replace(/&amp;/g, "&");
    return url = url.replace("&amp;", "&");
    //var reg = new RegExp( '&', g );
    //return url.replace( reg, '%26' );
    //return encodeURL = encodeURIComponent( url );
    console.log(url);
    
  }
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

  /**
   * Download PDF file
   */
  function downloadPDF(url) {
      download_file(url,'schedule');
      return false;
  }
  /* Helper function */
  function download_file(fileURL, fileName) {
      // for non-IE
      if (!window.ActiveXObject) {
          var save = document.createElement('a');
          save.href = fileURL;
          save.target = '_blank';
          var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
          save.download = fileName || filename;
             if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
                  document.location = save.href;
              }else{
                  var evt = new MouseEvent('click', {
                      'view': window,
                      'bubbles': true,
                      'cancelable': false
                  });
                  save.dispatchEvent(evt);
                  (window.URL || window.webkitURL).revokeObjectURL(save.href);
              }   
      }

      // for IE < 11
      else if ( !! window.ActiveXObject && document.execCommand)     {
          var _window = window.open(fileURL, '_blank');
          _window.document.close();
          _window.document.execCommand('SaveAs', true, fileName || fileURL)
          _window.close();
      }
  }

  function preview_image() 
  {
    $("#image_preview").empty();//you can remove this code if you want previous user input
    var total_file=document.getElementById("imgInp").files.length;
    for(var i=0;i<total_file;i++)
    {
      $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
    }
  }
      
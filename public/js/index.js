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

  function initMap() {
    var worldMapData = [
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
  
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(60.1791466, 24.9473743),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  
  
    var marker, i, markerContent, 
      infowindow = new google.maps.InfoWindow();
  
    for (i = 0; i < worldMapData.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(worldMapData[i].latitude, worldMapData[i].longitude),
        map: map
      });
  
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        markerContent = '<div><b>Hotel Name: </b> ' +
          worldMapData[i].hotelName +
          '</div><div><b>Address: </b>' +
          worldMapData[i].address + '</div>'; 
        
        infowindow.setContent(markerContent);
        infowindow.open(map, marker);
      }
    })(marker, i));
  
    }
  
  }

  $(function(){
    //coach edit js
    //multiselect 
    $('#language,#rinks,#speciality').multiselect();
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

    //daterangepicker
    $('input[name="dates"],input[name="period"]').daterangepicker();

    //range
    $("#ex2").bootstrapSlider({}).change(function(oldValue,newValue){
      let val=oldValue.value.newValue;
      $('.minVal').html('$'+val[0]);
      $('.maxVal').html('$'+val[1]);

    });
  });

  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };

  function preview_image() 
  {
    var total_file=document.getElementById("imgInp").files.length;
    for(var i=0;i<total_file;i++)
    {
      $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
    }
  }
      
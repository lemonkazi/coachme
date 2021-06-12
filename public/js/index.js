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
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
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
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
        window.location = newurl; // redirect
      }
      return false;
    });


    //range
    $("#ex2").bootstrapSlider({}).change(function(oldValue,newValue){
      let val=oldValue.value.newValue;
      $('.minVal').html('$'+val[0]);
      $('.maxVal').html('$'+val[1]);

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
    url = url.replace(/amp/g, "");
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
    url = url.replace(/&amp;/g, "&");
    return url = url.replace(/%2C/g,",");
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
      
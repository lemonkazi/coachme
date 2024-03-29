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
            prevArrow:'<i class="bi bi-arrow-up"></i>',
            nextArrow:'<i class="bi bi-arrow-down"></i>',
    //         centerMode: false,
    // variableWidth: false,
            // centerMode: true,
            // prevArrow:'<i class="bi bi-arrow-up"></i>',
            // nextArrow:'<i class="bi bi-arrow-down"></i>',
            // slidesToScroll: 1,
            // dots: false,
            // vertical: true,
            // verticalSwiping: true
          },

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











  $(function(){
    //coach edit js
    //multiselect 
    $('#language,#level,#speciality,#age,.listdates,.campdates,#camp_type_id,#program_type_id').multiselect();
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
    $('input[name="dates"]').on("show.daterangepicker", function (ev, picker) {
        console.log(picker.startDate.format("YYYY-MM-DD"));
        console.log(picker.endDate.format("YYYY-MM-DD"));

        //[startDate, endDate] = $('.date_range').val().split(' - ');
        $('input[name="start_date"]').val(
            picker.startDate.format("YYYY-MM-DD")
        );
        $('input[name="end_date"]').val(picker.endDate.format("YYYY-MM-DD"));
    });
    $('input[name="dates"]').on("hide.daterangepicker", function (ev, picker) {
        console.log(picker.startDate.format("YYYY-MM-DD"));
        console.log(picker.endDate.format("YYYY-MM-DD"));

        //[startDate, endDate] = $('.date_range').val().split(' - ');
        $('input[name="start_date"]').val(
            picker.startDate.format("YYYY-MM-DD")
        );
        $('input[name="end_date"]').val(picker.endDate.format("YYYY-MM-DD"));
    });
    $('input[name="dates"]').on(
        "hideCalendar.daterangepicker",
        function (ev, picker) {
            console.log(picker.startDate.format("YYYY-MM-DD"));
            console.log(picker.endDate.format("YYYY-MM-DD"));

            //[startDate, endDate] = $('.date_range').val().split(' - ');
            $('input[name="start_date"]').val(
                picker.startDate.format("YYYY-MM-DD")
            );
            $('input[name="end_date"]').val(
                picker.endDate.format("YYYY-MM-DD")
            );
        }
    );

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
      let advanced = $(this).data('advanced');
      
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
        var newurl = replaceUrlParam(name,url,newUrl,advanced);
        newurl = newurl.replace(/%2C/g,",");
        newurl = newurl.replace(/&amp;/g, "&");
        newurl = newurl.replace("&amp;", "&");
        newurl = newurl.replace("amp;", "");
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
        advanced = getURLParameter('advanced', newurl);
        if (advanced == 1) {
          if (typeof advanced !== "undefined" && advanced !== null) {
            let language = getURLParameter('language', newurl);
            let level = getURLParameter('level', newurl);
            let age = getURLParameter('age', newurl);
            console.log(language);
            if (language == null && level == null && age == null) {
              newurl = removeParam('advanced',newurl);
            }
          }
        }
        window.location = newurl; // redirect
      }
      return false;
    });

    $(".location").on('change', function(){

      var name = $(this).attr("name");
      let advanced = $(this).data('advanced');
      
      // var checkedVals = $('input:checkbox[name='+name+']:checked').map(function() {
      //     return this.value;
      // }).get();

      
      var url = $(this).val(); // get selected value
      
      if (url.length != 0) { 
        //if (url) { // require a URL
        var newUrl = CURRENT_URL;
        //var id = ['a', 'b'];
        

        if (url instanceof Array) {
          var url = url.join(",");
        } 
        
        var newurl = replaceUrlParam(name,url,newUrl,advanced);
        
        newurl = newurl.replace(/%2C/g,",");
        newurl = newurl.replace(/&amp;/g, "&");
        newurl = newurl.replace("&amp;", "&");
        newurl = newurl.replace("amp;", "");
        //console.log(newurl);
        //console.log(newurl);
        window.location = newurl; // redirect
        
      } else {
        var newurl = removeParam(name,CURRENT_URL);
        advanced = getURLParameter('advanced', newurl);
        if (advanced == 1) {
          if (typeof advanced !== "undefined" && advanced !== null) {
            let language = getURLParameter('language', newurl);
            let level = getURLParameter('level', newurl);
            let age = getURLParameter('age', newurl);
            console.log(language);
            if (language == null && level == null && age == null) {
              newurl = removeParam('advanced',newurl);
            }
          }
        }
        //console.log(advanced);
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


  function replaceUrlParam(paramName, paramValue,newUrl,advanced=null){
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
    if (typeof advanced !== "undefined" && advanced !== null) {
      paramName = 'advanced';
      var patternadvanced = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
      paramValue = 1;
      if (url.search(patternadvanced)>=0) {
          return url.replace(patternadvanced,'$1' + paramValue + '$2');
      }

      url = url.replace(/[?#]$/,'');
      url=url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
      url = url.replace(/%2C/g,",");
      url = url.replace(/&amp;/g, "&");
    }

    console.log(newUrl);

    return url = url.replace("&amp;", "&");
    //var reg = new RegExp( '&', g );
    //return url.replace( reg, '%26' );
    //return encodeURL = encodeURIComponent( url );
    
    
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
      
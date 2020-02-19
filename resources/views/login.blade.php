<?php
  $url = URL::to('/');
  $ogLink = "https://content.poshto.co.zw/adserverdev?ap_ip={$_GET['ap_ip']}&ap_port={$_GET['ap_port']}&user_mac={$_GET['user_mac']}&ap_id={$_GET['ap_id']}&ap_group={$_GET['ap_group']}&user_url={$_GET['user_url']}&vendor={$_GET['vendor']}&version={$_GET['version']}";
  $src = file_get_contents($ogLink);

 function getBannerId($content, $start, $end){
   $r = explode($start, $content);
   if(isset($r[1])){
     $r = explode($end, $r[1]);
     return $r[0];
   }
   return '';
 }

 $start = 'banner_id=';
 $end = '&';
 $banner_id = getBannerId($src, $start, $end);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Poshto SplashPage</title>
  <!-- Bootstrap core CSS -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="{{asset('css/mdb.min.css')}}" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('build/css/intlTelInput.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
   <!-- JQuery -->
   <script type="text/javascript" src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
  
  <script>
  
      var timeleft = 18;

      var downloadTimer = function (){
          setInterval(function(){
          document.getElementById("timer").innerHTML = "<strong>Please wait for the advert...</strong><br />" + timeleft + " sec";
          timeleft -= 1;
              if(timeleft <= 0){
                  clearInterval(downloadTimer);
                  document.getElementById("timer").innerHTML = "<button class=\"btn btn-danger btn-sm\" id=\"close-btn\"  onclick=\"myFunction()\"><i class=\"fas fa-times\"></i>&nbsp;Close</button>"
              }
          }, 1000);
        };

        function myFunction() {
        var x = document.getElementById("popup-id");
            x.style.display = "none";

        //display form
        var y = document.getElementById("card");
            y.style.display = "block";
        }


  
</script>
</head>

<body onload="downloadTimer();">

<div class="popup" id="popup-id" style="<?php
  if($message = Session::get('danger') || count($errors) > 0){
      echo "display: none !important;";
    }
  ?>">
  <!----ad url-->
  <div class="popup-content">
    <div id="timer"> </div>
    {{-- <img  src="" id="myimage" alt="banner" style="display: none;"/> --}}
    <?php print '<img  src="' . $src . '" id="myimage" alt="banner" />'; ?>
  </div>
</div>

  <!-- Start your project here-->
  <div style="height: 100vh;">
      <div class="row">
        <div class="col-lg-3 col-md-12 col-sm-12"><!--Leave Blank--></div>
        <div class="col-lg-6 col-md-12 col-sm-12 align-middle">
          <!--Loader-->
            <div class="card m-1" id="card-loader">
                @include('includes/partial/loader')
            </div>
          <!--End Loader-->
          <!-- Card -->
          <div class="card m-1" id="card" style="<?php
              if($message = Session::get('danger') || count($errors) > 0){
                echo "display: block !important;";
              }
            ?> background-image: url('img/artboard2.png')">
            <!-- top banner -->
            <!-- Card image -->
            <div class="view overlay">
              <img class="card-img-top" src="/img/banner.jpg" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>

            <!-- Card content -->
            <div class="card-body">
                @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$error}}
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                    @endforeach
                @endif

              @if($message = Session::get('danger'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 {{$message}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif

              <!---end errors-->
              <!-- Default form subscription -->
              <form id="splash-form" class="p-1" method="POST" action="/">
                  @csrf
                  @if(count($user) > 0)
                    <p class="text-center h5 mb-2">Hi {{ucfirst($user[0]->firstname)}}</p>
                    <p class="text-center">Welcome back to Poshto! <br />Enjoy your session and explore zvese.</p>
                  @else
                    <p class="text-center h5 mb-2">Welcome to Poshto Free Wifi</p>
                    <p class="text-center">Enjoy your session and explore zvese.</p>
                  @endif
                  <!--GET URL PARAMS-->
                  <hr />
                  <!----./Banner ID------>
                  <input type="hidden" id="banner_id" name="banner_id" value="<?php echo $banner_id; ?>">
                  <?php if(isset($_GET['ap_ip'])) { ?>
                    <input type="hidden" value="{{$_GET['ap_ip']}}" name="ap_ip">
                  <?php } ?>
                  <?php if(isset($_GET['ap_port'])) { ?>
                    <input type="hidden" value="{{$_GET['ap_port']}}" name="ap_port">
                  <?php } ?>
                  <?php if(isset($_GET['user_mac'])) { ?>
                    <input type="hidden" value="{{$_GET['user_mac']}}" name="user_mac">
                  <?php } ?>
                  <?php if(isset($_GET['ap_id'])) { ?>
                    <input type="hidden" value="{{$_GET['ap_id']}}" name="ap_id">
                  <?php } ?>
                  <?php if(isset($_GET['ap_group'])) { ?>
                    <input type="hidden" value="{{$_GET['ap_group']}}" name="ap_group">
                  <?php } ?>
                  <?php if(isset($_GET['user_url'])) { ?>
                    <input type="hidden" value="{{$_GET['user_url']}}" name="user_url">
                  <?php } ?>
                  <?php if(isset($_GET['vendor'])) { ?>
                    <input type="hidden" value="{{$_GET['vendor']}}" name="vendor">
                  <?php } ?>
                  <?php if(isset($_GET['version'])) { ?>
                    <input type="hidden" value="{{$_GET['version']}}" name="version">
                  <?php } ?>
                    <!---Form start----->
                      @if(count($user) === 0)
                        @include('includes/general_info')
                      @elseif(count($data) > 0)
                        @include('includes/questions')
                      @endif
                 
                 <!----Form end----->
                   <!-- Sign in button -->
                  <button class="btn bg-green btn-block mt-3 btn-font" type="submit" id="submit-button"><i class="fas fa-unlock"></i>&nbsp; Login</button> <hr />
                  <button class="btn bg-red btn-block btn-sm radius18 mt-3 btn-font" type="button" id="submit-button1" data-toggle="modal" data-target="#modalPoll-3"><i class="fas fa-map-marker"></i>&nbsp; Where to find us</button>
                  <button class="btn bg-blue btn-block btn-sm radius18 mt-3 btn-font" type="button" id="submit-button2"  data-toggle="modal" data-target="#modalPoll-2"><i class="fas fa-phone"></i>&nbsp; View Contact Details</button>
                  <button class="btn bg-purple btn-block btn-sm radius18 mt-3 btn-font" type="button" id="submit-button3"  data-toggle="modal" data-target="#modalPoll-1"><i class="fas fa-gavel"></i>&nbsp; Read Terms and Conditions</button>

              </form>
              <!-- Default form sponsor -->
              @if(count($user) > 0)
                @include('includes/partial/sponsor')
              @endif
            </div>
            <div class="card-footer text-center text-white" style="background: #0C5494;">
              <p class="m-0 p-0">Internet Powered By</p>
              <img class="m-0 p-0" src="img/contitouch-logo-white.png" style="height: 55px;" />
            </div>
            
          </div>
          <!-- Card -->
        </div>
        <div class="col-lg-3 col-md-12 col-sm-12"><!--Leave Blank--></div>
      </div>

      <!--POPUP AD-->
      

      <!--MODAL FORM-->
      @include('includes/documentation/terms_and_conditions')
      @include('includes/documentation/contact_details')
      @include('includes/documentation/find_us')
  </div>
  <!-- Start your project here-->

  <!-- SCRIPTS -->
 
    <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="{{asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- MDB core JavaScript -->
  <script type="text/javascript" src="{{asset('js/mdb.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/all.min.js')}}"></script>
  <script src="{{asset('build/js/intlTelInput.js')}}"></script>
  <script src="{{asset('js/jquery.validate.min.js')}}"></script>
  
  <script>
      $(document).ready(function () {
    
        $('#splash-form').validate({ // initialize the plugin
            ignore: ':hidden',
            rules: {
              firstname: {
                required: true,
                minlength: 3
                },
              lastname: {
                required: true,
                minlength: 2
              },
              email: {
                required: true,
	              rangelength: [12, 50]
              },
              phone: {
                required: true,
                minlength: 9,
                maxlength: 14
              },
              dob: {
                required: true
              },
              gender: {
                required: true
              }

            },
            messages: {
              firstname: {
                required: 'Firstname is required'
              },
              lastname: {
                required: 'Lastname is required'
              },
              email: {
                required: 'E-mail is required'
              },
              phone: {
                required: 'Phone number is required',
                minlength: 'Enter a valid Phone number',
                maxlength: 'Enter a valid Phone number'
              },
              gender: {
                required: 'Gender is required'
              }

            },
            // submitHandler: function (form) {
            //     return false; 
            // }
        });
    

    $("#dob").keyup(function(){
        var dob = $("#dob").val();
        $.post("datevalidation.php",{dob:dob},function(data){
             $("#display_results").html(data);
        });
    });


       $("#submit-button").click(function(){
            let card = document.getElementById('card');
            card.style.display = 'none';

            document.getElementById('card-loader').style.display = 'block';
      }); 

      /************************************************* PHONE VALIDATOR **************************************************/
      var input = document.querySelector("#phone");
      window.intlTelInput(input, {
        formatOnDisplay: false,
        geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "";
        callback(countryCode);
        });
        },
      hiddenInput: "full_number",
        initialCountry: "zw",
        localizedCountries: { 'zw': 'Zimbabwe' },
        nationalMode: false,
        placeholderNumberType: "+263 775 111 222",
        utilsScript: "build/js/utils.js",
      });

    });

   
    </script>
    <div id="display_results"></div>
</body>

</html>

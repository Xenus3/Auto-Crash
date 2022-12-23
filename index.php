<?php 
include_once('inclure.php');



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <script
  src="https://code.jquery.com/jquery-3.6.3.slim.js"
  integrity="sha256-DKU1CmJ8kBuEwumaLuh9Tl/6ZB6jzGOBV/5YpNE2BWc="
  crossorigin="anonymous" defer></script>

  <!-- Quantcast Cookies. Consent Manager  -->

<script type="text/javascript" async=true>
(function() {
  var host = window.location.hostname;
  var element = document.createElement('script');
  var firstScript = document.getElementsByTagName('script')[0];
  var url = 'https://cmp.quantcast.com'
    .concat('/choice/', 'vesrJ16x4F0hG', '/', host, '/choice.js?tag_version=V2');
  var uspTries = 0;
  var uspTriesLimit = 3;
  element.async = true;
  element.type = 'text/javascript';
  element.src = url;

  firstScript.parentNode.insertBefore(element, firstScript);

  function makeStub() {
    var TCF_LOCATOR_NAME = '__tcfapiLocator';
    var queue = [];
    var win = window;
    var cmpFrame;

    function addFrame() {
      var doc = win.document;
      var otherCMP = !!(win.frames[TCF_LOCATOR_NAME]);

      if (!otherCMP) {
        if (doc.body) {
          var iframe = doc.createElement('iframe');

          iframe.style.cssText = 'display:none';
          iframe.name = TCF_LOCATOR_NAME;
          doc.body.appendChild(iframe);
        } else {
          setTimeout(addFrame, 5);
        }
      }
      return !otherCMP;
    }

    function tcfAPIHandler() {
      var gdprApplies;
      var args = arguments;

      if (!args.length) {
        return queue;
      } else if (args[0] === 'setGdprApplies') {
        if (
          args.length > 3 &&
          args[2] === 2 &&
          typeof args[3] === 'boolean'
        ) {
          gdprApplies = args[3];
          if (typeof args[2] === 'function') {
            args[2]('set', true);
          }
        }
      } else if (args[0] === 'ping') {
        var retr = {
          gdprApplies: gdprApplies,
          cmpLoaded: false,
          cmpStatus: 'stub'
        };

        if (typeof args[2] === 'function') {
          args[2](retr);
        }
      } else {
        if(args[0] === 'init' && typeof args[3] === 'object') {
          args[3] = Object.assign(args[3], { tag_version: 'V2' });
        }
        queue.push(args);
      }
    }

    function postMessageEventHandler(event) {
      var msgIsString = typeof event.data === 'string';
      var json = {};

      try {
        if (msgIsString) {
          json = JSON.parse(event.data);
        } else {
          json = event.data;
        }
      } catch (ignore) {}

      var payload = json.__tcfapiCall;

      if (payload) {
        window.__tcfapi(
          payload.command,
          payload.version,
          function(retValue, success) {
            var returnMsg = {
              __tcfapiReturn: {
                returnValue: retValue,
                success: success,
                callId: payload.callId
              }
            };
            if (msgIsString) {
              returnMsg = JSON.stringify(returnMsg);
            }
            if (event && event.source && event.source.postMessage) {
              event.source.postMessage(returnMsg, '*');
            }
          },
          payload.parameter
        );
      }
    }

    while (win) {
      try {
        if (win.frames[TCF_LOCATOR_NAME]) {
          cmpFrame = win;
          break;
        }
      } catch (ignore) {}

      if (win === window.top) {
        break;
      }
      win = win.parent;
    }
    if (!cmpFrame) {
      addFrame();
      win.__tcfapi = tcfAPIHandler;
      win.addEventListener('message', postMessageEventHandler, false);
    }
  };

  makeStub();

  var uspStubFunction = function() {
    var arg = arguments;
    if (typeof window.__uspapi !== uspStubFunction) {
      setTimeout(function() {
        if (typeof window.__uspapi !== 'undefined') {
          window.__uspapi.apply(window.__uspapi, arg);
        }
      }, 500);
    }
  };

  var checkIfUspIsReady = function() {
    uspTries++;
    if (window.__uspapi === uspStubFunction && uspTries < uspTriesLimit) {
      console.warn('USP is not accessible');
    } else {
      clearInterval(uspInterval);
    }
  };

  if (typeof window.__uspapi === 'undefined') {
    window.__uspapi = uspStubFunction;
    var uspInterval = setInterval(checkIfUspIsReady, 6000);
  }
})();
</script>
<!-- fin de Quantcast Cookies. Consent Manager  -->
    <script src="assets/script.js" defer></script>
    <title>Document</title>
</head>
<body data-title="accueil">
<?php 
include_once('logo.php');
include_once('menu.php');?>

<div class="slider">
        <img src="image/photo_4.jpeg" alt="img1" class="img__slider active" />
        <img src="image/photo_5.jpeg" alt="img2" class="img__slider" />
        <img src="image/photo_6.jpeg" alt="img3" class="img__slider" />
        <div class="suivant">
            <i class="fa-solid fa-arrow-right"></i>
        </div>
        <div class="precedent">
           <i class="fa-solid fa-arrow-left"></i>
        </div>
    </div>


    <div class="title-tab">
<h3><span> Bienvenue sur auto-crash </span></h3>
</div>


<div class="container">
<div class="polaroid">
  <img src="image/photo_8.jpg" style="width:100%">
  <div class="container2">
  <p><a href="rendez-vous.php"> DECALAMINAGE </a></p>
  </div>
  </div>

  <div class="polaroid">
  <img src="image/photo_9.jpg" style="width:100%">
  <div class="container2">
  <p><a href="devis.php"> DEVIS </a></p>
</div>
</div>

    <div class="polaroid">
  <img src="image/photo_10.jpg" style="width:100%">
  <div class="container2">
  <p><a href="carte_grise.php"> CARTE GRISE </a></p>
  </div>

</div>
</div>

<div class="title"> Vous avez une question ?  <a href="contact.php" class="btn2"> NOUS CONTACTER </a> </div>
<br />


<div class= "content-descript">
    <div class="descript">
    <div class="title-tab">
<h3><span> Qui sommes nous ? </span></h3>
</div>

Le Garage Autocrash est une entreprise familiale en activité depuis 1996 . Forte d'une expérience de plus de 30 ans elle intervient dans le secteur de l'entretien et la réparation de véhicules avec des employés qualifiés et passionnés
Propose également la vente de véhicules d'occasion, révises et garanties </div> 

<img src="image/img1.jpg">
</div></div>


<div class="title-tab">
<h3><span> L'équipe</span></h3>
</div>



<div class="content-equip">
<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Patrick </span><br />
Gérant mécanicien </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Mélissa </span> <br />
Assistante de direction </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Brenda </span><br />
Chargé d'accueil </div>

<div class="content-equipe">
<img src="image/avatar.png"><br />
<span> Kevin </span><br />
Mécanicien 
</div>
</div>

<?php include_once('footer.php'); ?>

</body>
</html>


/*
  crossbrowser :
    internet explorer 6/7/8
    firefox           2/3
    chrome            le dernier
    safari            3/4/5
    opera             9/10
    portables ?
  
  créer/détruire un élément du DOM : addElement()
  attacher/détacher un écouteur d'événement à un élément du DOM : addListener()/removeListener()
  modifier className d'un élément du DOM : swapClass(), removeClass(), addClass(), checkClass()
  animer un élément du DOM 
  formater du texte : formatText()
  gérer une requète AJAX : ajaxConnect()
  
  widgets ??
*/

  (function(global)
  {
    var d = d || document;
    var w = w || window;

    var getStyle = function(el, sn)
    {
      /*
        RETOURNE LA VALEUR DU STYLE CALCULÉ style DE L'ÉLÉMENT element :

        var elem = document.getElementById('elem');
        var maCouleur = var getStyle(elem,'backgroundColor');
        // rgb(0, 250, 100)
      */

      var cs;
      if (typeof(el.currentStyle) != 'undefined')
      {
        cs = el.currentStyle;
      }
      else if (typeof(d.defaultView) != 'undefined' && typeof(d.defaultView.getComputedStyle) != 'undefined')
      {
        cs = d.defaultView.getComputedStyle(el, null);
      }

      return cs[sn];

      /*
        ajouter possibilité de zapper l'unité
        ou de retourner un objet du genre :
        { 'value' : '15', 'unit' : 'px' }
        ou
        { 'value' : ['Helvetica','Arial','sans-serif'] }
        etc.
      */
    };

    var stopProp = function(ev)
    {
      /*
        EMPECHE LA PROPAGATION DE L'EVENEMENT
      */
      if (typeof(ev) != 'undefined' && typeof(ev.stopPropagation) != 'undefined')
      {
        ev.stopPropagation();
      }
      else
      {
        event.cancelBubble = true;
      }
    };

    var stopDef = function(ev)
    {
      /*
        EMPECHE L'EXECUTION DU COMPORTEMENT PAR DEFAUT DE L'EVENEMENT
      */
      if (typeof(ev) != 'undefined' && typeof(ev.preventDefault) != 'undefined')
      {
        ev.preventDefault();
        return true;
      }
      else
      {
        return false;
      }
    };

    var formatText = function(txt)
    {
      /*
        PERMET DE REMPLACER DES VARIABLES DANS UNE CHAÎNE DE CARACTÈRES
        VOIR http://github.com/just3ws/dotnet_string_formatting_for_javascript/

        var monResultat = format('Hello, {0}!', 'world!');
        // Hello, world!
      */

      if (arguments.length <= 1)
      {
        return txt;
      }
      var tCount = arguments.length - 2;
      for (var token = 0; token <= tCount; ++token)
      {
        txt = txt.replace(new RegExp("\\{" + token + "\\}", "gi"), arguments[token + 1]);
      }
      return txt;
    };

    var randNum = function(min, max)
    {
      /*
        RETOURNE UN NOMBRE À VIRGULE ENTRE min ET max
      */
      return Math.random() * (max - min) + min;
    };

    var randInt = function(min, max)
    {
      /*
        RETOURNE UN NOMBRE ENTIER ENTRE min ET max
      */
      return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    var _cleanCss = function(cn)
    {
      /*
        http://www.onlinevar.org/articles/unobtrusivejavascript/cssjsseparation.html

        var lien = document.getElementsByTagName('a')[0];
        console.log(lien.className);
        > emmanuelle romain wanda merlin
      */
      cn = cn.replace(/^\s+|\s+$/g,'');
      return cn.replace(/\s{2,}/g,' ');
    };

    var checkClass = function(el,cl)
    {
      /*
        console.log(checkClass(lien,'merlin'));
        > true
      */
      return new RegExp('\\b'+cl+'\\b').test(el.className);
    };

    var addClass = function(el,cl)
    {
      /*
        addClass(lien,'merlinou');
        console.log(lien.className);
        > emmanuelle romain wanda merlin
      */
      if(!checkClass(el,cl))
      {
        el.className += el.className ? ' ' + cl : cl;
        el.className = _cleanCss(el.className);
      }
    };

    var removeClass = function(el,cl)
    {
      /*
        removeClass(lien,'merlin');
        console.log(lien.className);
        > emmanuelle romain wanda
      */
      var rep = el.className.match(' ' + cl) ? ' ' + cl : cl;
      el.className = el.className.replace(rep,'');
      el.className = _cleanCss(el.className);
    };

    var swapClass = function(el,cl1,cl2)
    {
      /*
        swapClass(lien,'merlinou','merlin');
        console.log(lien.className);
        > emmanuelle romain wanda merlin
      */
      el.className = !checkClass(el,cl1) ? el.className.replace(cl2,cl1) : el.className.replace(cl1,cl2);
      el.className = _cleanCss(el.className);
    };

    var addElement = function(nn, n)
    {
      /*
        PERMET DE CRÉER UN NOUVEL ÉLÉMENT, AVEC OU SANS ATTRIBUT name, MÊME DANS IE

        var monDiv = addElement('div');
        var maCheckbox = addElement('checkbox','monGroupe');
      */
      var node;
      var d = d || document;

      function createElementMsie(nn, n) 
      {
        if (n)
        {
          return d.createElement('<' + nn + ' name=' + n + '>');
        }
        else
        {
          return d.createElement(nn);
        }
      }

      function createElementStandard(nn, n) 
      {
        node = d.createElement(nn);
        if (n) {
          node.name = n;
        }
        return node;
      }

      try {
        node = createElementStandard(nn, n);
      } catch (e) {
        node = createElementMsie(nn, n);
      }

      return node;
    };

    var ajaxConnect = function(meth, url, fn, args)
    {
      /*
        http://groups.google.com/group/comp.lang.javascript/msg/e98b5f5bed140727?

        OK, SUPER EASY, J'AI SUREMENT ZAPPÉ UN TRUC IMPORTANT MAIS ÇA A L'AIR DE MARCHER COMME ÇA
        FONCTION AJAX COMPLETE : GÈRE LA CONNEXION ET LE CALLBACK

        TODO : arranger la gestion des codes de status et d'erreur

        utilisation hyper simple :
        ajaxConnect('GET','page.html',handler[, args]);
        function handler(args)
        {
          //this REPRÉSENTE L'OBJET xmlhttprequest DONC
          //ON PEUT DIRECTEMENT UTILISER TOUTES SES PROPRIÉTÉS UTILES :
          console.log(this.responseText[,args]);
        };
      */
      var rq         = null;
      var errMessage = 'Sorry. No AJAX for you.';
      if (typeof(window.XMLHttpRequest) != 'undefined')
      { 
        // IE7+, FF, Opera 8.0+, Safari. 
        try {rq = new XMLHttpRequest();}
        catch (ex1) {alert(errMessage);}
      }
      else if (typeof(window.ActiveXObject) != 'undefined')
      { 
        //IE 5+, 6, or IE7/8 with native XMLHTTP support disabled. 
        try {rq = new ActiveXObject('Msxml2.XMLHTTP.6.0');} 
        catch (ex2) { 
          try {rq = new ActiveXObject('Msxml2.XMLHTTP.3.0');} 
          catch (ex3) { 
            try {rq = new ActiveXObject('Microsoft.XMLHTTP');} 
            catch (ex4) {alert(errMessage);} 
          } 
        } 
      }
      else
      { 
        alert(errMessage); 
      } 

      rq.open(meth, url, true);
      
      if (meth === 'POST')
      {
        rq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        rq.send(args);
      }
      else if (meth === 'GET')
      {
        rq.send(null);
      }
      rq.onreadystatechange = function()
      {
        /*
          rq.readyState === 0 : The object has been created, but not initialized (the open method has not been called).
          rq.readyState === 1 : A request has been opened, but the send method has not been called.
          rq.readyState === 2 : The send method has been called. No data is available yet.
          rq.readyState === 3 : Some data has been received; however, neither responseText nor responseBody is available.
          rq.readyState === 4 : All the data has been received.
        */
        if (rq.readyState === 4)
        {
          if (rq.status === 200 || rq.status === 0 || rq.status === 304)
          {
            /*
              étoffer cette partie avec les codes HTTP suivants ?

              Number Description
              100    Continue
              101    Switching protocols
              200    OK
              201    Created
              202    Accepted
              203    Non-Authoritative Information
              204    No Content
              205    Reset Content
              206    Partial Content
              300    Multiple Choices
              301    Moved Permanently
              302    Found
              303    See Other
              304    Not Modified
              305    Use Proxy
              307    Temporary Redirect
              400    Bad Request
              401    Unauthorized
              402    Payment Required
              403    Forbidden
              404    Not Found
              405    Method Not Allowed
              406    Not Acceptable
              407    Proxy Authentication Required
              408    Request Timeout
              409    Conflict
              410    Gone
              411    Length Required
              412    Precondition Failed
              413    Request Entity Too Large
              414    Request-URI Too Long
              415    Unsupported Media Type
              416    Requested Range Not Suitable
              417    Expectation Failed
              500    Internal Server Error
              501    Not Implemented
              502    Bad Gateway
              503    Service Unavailable
              504    Gateway Timeout
              505    HTTP Version Not Supported
            */
            fn.apply(this);
          }
        }
      };
    };

    global.d           = d;
    global.w           = w;
    global.getStyle    = getStyle;
    global.stopDef     = stopDef;
    global.stopProp    = stopProp;
    global.formatText  = formatText;
    global.randInt     = randInt;
    global.randNum     = randNum;
    global.checkClass  = checkClass;
    global.addClass    = addClass;
    global.removeClass = removeClass;
    global.swapClass   = swapClass;
    global.addElement  = addElement;
    global.ajaxConnect = ajaxConnect;
  })(this);

  // addListener & removeListener
  (function(global)
  {
    var d = d || document;
    var addListener, removeListener;

    if (typeof(d.addEventListener) != 'undefined')
    {
      addListener = function(el, ev, fn)
      {
        el.addEventListener(ev, fn, false);
      };
    }
    else if (typeof(d.attachEvent) != 'undefined')
    {
      addListener = function(el, ev, fn)
      {
        el.attachEvent('on' + ev, fn);
      };
    }

    if (typeof(d.removeEventListener) != 'undefined')
    {
      removeListener = function(el, ev, fn)
      {
        el.removeEventListener(ev, fn, false);
      };
    }
    else if (typeof(d.detachEvent) != 'undefined')
    {
      removeListener = function(el, ev, fn)
      {
        el.detachEvent('on' + ev, fn);
      };
    }

    global.addListener    = addListener;
    global.removeListener = removeListener;
  })(this);

  // getViewportH & getViewportW
  (function(global)
  {
    var d = d || document;
    var w = w || window;
    var getViewportH,getViewportW;

    /*
      RETOURNENT LA HAUTEUR ET LA LARGEUR DU VIEWPORT
    */
    if (typeof(w.innerHeight) != 'undefined')
    {
      getViewportH = function()
      {
        return w.innerHeight;
      };
      getViewportW = function()
      {
        return w.innerWidth;
      };
    }
    //IE6 en mode standard
    else if (typeof(d.documentElement) != 'undefined' && typeof(d.documentElement.clientHeight) != 'undefined')
    {
      getViewportH = function()
      {
        return d.documentElement.clientHeight;
      };
      getViewportW = function()
      {
        return d.documentElement.clientWidth;
      };
    }
    //IE ancien
    else 
    {
      getViewportH = function()
      {
        return d.body.clientHeight;
      };
      getViewportW = function()
      {
        return d.body.clientWidth;
      };
    }

    global.getViewportW = getViewportW;
    global.getViewportH = getViewportH;
  })(this);



!function (name, definition) {
  if (typeof define == 'function') define(definition)
  else if (typeof module != 'undefined' && module.exports) module.exports['browser'] = definition()
  else this[name] = definition()
}('bowser', function () {
  /**
    * navigator.userAgent =>
    * Chrome:  "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_7) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.57 Safari/534.24"
    * Opera:   "Opera/9.80 (Macintosh; Intel Mac OS X 10.6.7; U; en) Presto/2.7.62 Version/11.01"
    * Safari:  "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; en-us) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1"
    * IE:      "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C)"
    * IE>=11:  "Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; .NET4.0E; .NET4.0C; Media Center PC 6.0; rv:11.0) like Gecko"
    * Firefox: "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0) Gecko/20100101 Firefox/4.0"
    * iPhone:  "Mozilla/5.0 (iPhone Simulator; U; CPU iPhone OS 4_3_2 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8H7 Safari/6533.18.5"
    * iPad:    "Mozilla/5.0 (iPad; U; CPU OS 4_3_2 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8H7 Safari/6533.18.5",
    * Android: "Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; T-Mobile G2 Build/GRJ22) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"
    * Touchpad: "Mozilla/5.0 (hp-tabled;Linux;hpwOS/3.0.5; U; en-US)) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 TouchPad/1.0"
    * PhantomJS: "Mozilla/5.0 (Macintosh; Intel Mac OS X) AppleWebKit/534.34 (KHTML, like Gecko) PhantomJS/1.5.0 Safari/534.34"
    */

  var ua = navigator.userAgent
    , t = true
    , ie = /(msie|trident)/i.test(ua)
    , chrome = /chrome/i.test(ua)
    , phantom = /phantom/i.test(ua)
    , safari = /safari/i.test(ua) && !chrome && !phantom
    , iphone = /iphone/i.test(ua)
    , ipad = /ipad/i.test(ua)
    , touchpad = /touchpad/i.test(ua)
    , android = /android/i.test(ua)
    , opera = /opera/i.test(ua) || /opr/i.test(ua)
    , firefox = /firefox/i.test(ua)
    , gecko = /gecko\//i.test(ua)
    , seamonkey = /seamonkey\//i.test(ua)
    , webkitVersion = /version\/(\d+(\.\d+)?)/i
    , firefoxVersion = /firefox\/(\d+(\.\d+)?)/i
    , o

  function detect() {

    if (ie) return {
        msie: t
      , version: ua.match(/(msie |rv:)(\d+(\.\d+)?)/i)[2]
      }
    if (opera) return {
        opera: t
      , version: ua.match(webkitVersion) ? ua.match(webkitVersion)[1] : ua.match(/opr\/(\d+(\.\d+)?)/i)
      }
    if (chrome) return {
        webkit: t
      , chrome: t
      , version: ua.match(/chrome\/(\d+(\.\d+)?)/i)[1]
      }
    if (phantom) return {
        webkit: t
      , phantom: t
      , version: ua.match(/phantomjs\/(\d+(\.\d+)+)/i)[1]
      }
    if (touchpad) return {
        webkit: t
      , touchpad: t
      , version : ua.match(/touchpad\/(\d+(\.\d+)?)/i)[1]
      }
    if (iphone || ipad) {
      o = {
        webkit: t
      , mobile: t
      , ios: t
      , iphone: iphone
      , ipad: ipad
      }
      // WTF: version is not part of user agent in web apps
      if (webkitVersion.test(ua)) {
        o.version = ua.match(webkitVersion)[1]
      }
      return o
    }
    if (android) return {
        webkit: t
      , android: t
      , mobile: t
      , version: (ua.match(webkitVersion) || ua.match(firefoxVersion))[1]
      }
    if (safari) return {
        webkit: t
      , safari: t
      , version: ua.match(webkitVersion)[1]
      }
    if (gecko) {
      o = {
        gecko: t
      , mozilla: t
      , version: ua.match(firefoxVersion)[1]
      }
      if (firefox) o.firefox = t
      return o
    }
    if (seamonkey) return {
        seamonkey: t
      , version: ua.match(/seamonkey\/(\d+(\.\d+)?)/i)[1]
      }
    return {}
  }

  var bowser = detect()

  // Graded Browser Support
  // http://developer.yahoo.com/yui/articles/gbs
  if ((bowser.msie && bowser.version >= 8) ||
      (bowser.chrome && bowser.version >= 10) ||
      (bowser.firefox && bowser.version >= 4.0) ||
      (bowser.safari && bowser.version >= 5) ||
      (bowser.opera && bowser.version >= 10.0)) {
    bowser.a = t;
  }

  else if ((bowser.msie && bowser.version < 8) ||
      (bowser.chrome && bowser.version < 10) ||
      (bowser.firefox && bowser.version < 4.0) ||
      (bowser.safari && bowser.version < 5) ||
      (bowser.opera && bowser.version < 10.0)) {
    bowser.c = t
  } else bowser.x = t

  return bowser
});



(function(c){function h(){}function f(b,c){if(r)return c.indexOf(b);for(var e=c.length;e--;)if(c[e]===b)return e;return-1}var e=h.prototype,r=Array.prototype.indexOf?!0:!1;e._getEvents=function(){return this._events||(this._events={})};e.getListeners=function(b){var c,e,f=this._getEvents();if("object"==typeof b)for(e in c={},f)f.hasOwnProperty(e)&&b.test(e)&&(c[e]=f[e]);else c=f[b]||(f[b]=[]);return c};e.getListenersAsObject=function(b){var c,e=this.getListeners(b);return e instanceof Array&&(c={},
c[b]=e),c||e};e.addListener=function(b,c){var e,h=this.getListenersAsObject(b);for(e in h)h.hasOwnProperty(e)&&-1===f(c,h[e])&&h[e].push(c);return this};e.on=e.addListener;e.defineEvent=function(b){return this.getListeners(b),this};e.defineEvents=function(b){for(var c=0;b.length>c;c+=1)this.defineEvent(b[c]);return this};e.removeListener=function(b,c){var e,h,t=this.getListenersAsObject(b);for(h in t)t.hasOwnProperty(h)&&(e=f(c,t[h]),-1!==e&&t[h].splice(e,1));return this};e.off=e.removeListener;e.addListeners=
function(b,c){return this.manipulateListeners(!1,b,c)};e.removeListeners=function(b,c){return this.manipulateListeners(!0,b,c)};e.manipulateListeners=function(b,c,e){var f,h,r=b?this.removeListener:this.addListener;b=b?this.removeListeners:this.addListeners;if("object"!=typeof c||c instanceof RegExp)for(f=e.length;f--;)r.call(this,c,e[f]);else for(f in c)c.hasOwnProperty(f)&&(h=c[f])&&("function"==typeof h?r.call(this,f,h):b.call(this,f,h));return this};e.removeEvent=function(b){var c,e=typeof b,
f=this._getEvents();if("string"===e)delete f[b];else if("object"===e)for(c in f)f.hasOwnProperty(c)&&b.test(c)&&delete f[c];else delete this._events;return this};e.emitEvent=function(b,c){var e,f,h,r=this.getListenersAsObject(b);for(f in r)if(r.hasOwnProperty(f))for(e=r[f].length;e--;)h=c?r[f][e].apply(null,c):r[f][e](),!0===h&&this.removeListener(b,r[f][e]);return this};e.trigger=e.emitEvent;e.emit=function(b){var c=Array.prototype.slice.call(arguments,1);return this.emitEvent(b,c)};"function"==
typeof define&&define.amd?define(function(){return h}):c.EventEmitter=h})(this);


(function(c){var h=document.documentElement,f=function(){};h.addEventListener?f=function(c,b,e){c.addEventListener(b,e,!1)}:h.attachEvent&&(f=function(e,b,f){e[b+f]=f.handleEvent?function(){var b=c.event;b.target=b.target||b.srcElement;f.handleEvent.call(f,b)}:function(){var b=c.event;b.target=b.target||b.srcElement;f.call(e,b)};e.attachEvent("on"+b,e[b+f])});var e=function(){};h.removeEventListener?e=function(c,b,e){c.removeEventListener(b,e,!1)}:h.detachEvent&&(e=function(c,b,e){c.detachEvent("on"+
b,c[b+e]);try{delete c[b+e]}catch(f){c[b+e]=void 0}});h={bind:f,unbind:e};"function"==typeof define&&define.amd?define(h):c.eventie=h})(this);
(function(c){function h(b,c){for(var e in c)b[e]=c[e];return b}function f(b){var c=[];if("[object Array]"===n.call(b))c=b;else if("number"==typeof b.length)for(var e=0,d=b.length;d>e;e++)c.push(b[e]);else c.push(b);return c}function e(c,e){function n(a,b,c){if(!(this instanceof n))return new n(a,b);"string"==typeof a&&(a=document.querySelectorAll(a));this.elements=f(a);this.options=h({},this.options);"function"==typeof b?c=b:h(this.options,b);c&&this.on("always",c);this.getImages();r&&(this.jqDeferred=
new r.Deferred);var d=this;setTimeout(function(){d.check()})}function d(a){this.img=a}n.prototype=new c;n.prototype.options={};n.prototype.getImages=function(){this.images=[];for(var a=0,b=this.elements.length;b>a;a++){var c=this.elements[a];"IMG"===c.nodeName&&this.addImage(c);for(var c=c.querySelectorAll("img"),d=0,e=c.length;e>d;d++)this.addImage(c[d])}};n.prototype.addImage=function(a){a=new d(a);this.images.push(a)};n.prototype.check=function(){function a(a,k){return c.options.debug&&l&&b.log("confirm",
a,k),c.progress(a),d++,d===e&&c.complete(),!0}var c=this,d=0,e=this.images.length;if(this.hasAnyBroken=!1,!e)return this.complete(),void 0;for(var f=0;e>f;f++){var h=this.images[f];h.on("confirm",a);h.check()}};n.prototype.progress=function(a){this.hasAnyBroken=this.hasAnyBroken||!a.isLoaded;this.emit("progress",this,a);this.jqDeferred&&this.jqDeferred.notify(this,a)};n.prototype.complete=function(){var a=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emit(a,this),this.emit("always",this),
this.jqDeferred)this.jqDeferred[this.hasAnyBroken?"reject":"resolve"](this)};r&&(r.fn.imagesLoaded=function(a,b){return(new n(this,a,b)).jqDeferred.promise(r(this))});var s={};return d.prototype=new c,d.prototype.check=function(){var a=s[this.img.src];if(a)return this.useCached(a),void 0;if(s[this.img.src]=this,this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;a=this.proxyImage=new Image;e.bind(a,"load",this);e.bind(a,"error",this);
a.src=this.img.src},d.prototype.useCached=function(a){if(a.isConfirmed)this.confirm(a.isLoaded,"cached was confirmed");else{var b=this;a.on("confirm",function(a){return b.confirm(a.isLoaded,"cache emitted confirmed"),!0})}},d.prototype.confirm=function(a,b){this.isConfirmed=!0;this.isLoaded=a;this.emit("confirm",this,b)},d.prototype.handleEvent=function(a){var b="on"+a.type;this[b]&&this[b](a)},d.prototype.onload=function(){this.confirm(!0,"onload");this.unbindProxyEvents()},d.prototype.onerror=function(){this.confirm(!1,
"onerror");this.unbindProxyEvents()},d.prototype.unbindProxyEvents=function(){e.unbind(this.proxyImage,"load",this);e.unbind(this.proxyImage,"error",this)},n}var r=c.jQuery,b=c.console,l=void 0!==b,n=Object.prototype.toString;"function"==typeof define&&define.amd?define(["eventEmitter","eventie"],e):c.imagesLoaded=e(c.EventEmitter,c.eventie)})(window);
(function(c){c.easyPieChart=function(h,f){var e,r,b,l,n,v,t,w,d=this;this.el=h;this.$el=c(h);this.$el.data("easyPieChart",this);this.init=function(){var b,a;d.options=c.extend({},c.easyPieChart.defaultOptions,f);b=parseInt(d.$el.data("percent"),10);d.percentage=0;d.canvas=c("<canvas width='"+d.options.size+"' height='"+d.options.size+"'></canvas>").get(0);d.$el.append(d.canvas);"undefined"!==typeof G_vmlCanvasManager&&null!==G_vmlCanvasManager&&G_vmlCanvasManager.initElement(d.canvas);d.ctx=d.canvas.getContext("2d");
1<window.devicePixelRatio&&(a=window.devicePixelRatio,c(d.canvas).css({width:d.options.size,height:d.options.size}),d.canvas.width*=a,d.canvas.height*=a,d.ctx.scale(a,a));d.ctx.translate(d.options.size/2,d.options.size/2);d.$el.addClass("easyPieChart");d.$el.css({width:d.options.size,height:d.options.size,lineHeight:""+d.options.size+"px"});d.update(b);return d};this.update=function(c){c=parseFloat(c)||0;!1===d.options.animate?b(c):r(d.percentage,c);return d};t=function(){var b,a,c;d.ctx.fillStyle=
d.options.scaleColor;d.ctx.lineWidth=1;c=[];for(b=a=0;24>=a;b=++a)c.push(e(b));return c};e=function(b){var a;a=0===b%6?0:0.017*d.options.size;d.ctx.save();d.ctx.rotate(b*Math.PI/12);d.ctx.fillRect(d.options.size/2-a,0,0.05*-d.options.size+a,1);d.ctx.restore()};w=function(){var b;b=d.options.size/2-d.options.lineWidth/2;!1!==d.options.scaleColor&&(b-=0.08*d.options.size);d.ctx.beginPath();d.ctx.arc(0,0,b,0,2*Math.PI,!0);d.ctx.closePath();d.ctx.strokeStyle=d.options.trackColor;d.ctx.lineWidth=d.options.lineWidth;
d.ctx.stroke()};v=function(){!1!==d.options.scaleColor&&t();!1!==d.options.trackColor&&w()};b=function(b){var a;v();d.ctx.strokeStyle=c.isFunction(d.options.barColor)?d.options.barColor(b):d.options.barColor;d.ctx.lineCap=d.options.lineCap;d.ctx.lineWidth=d.options.lineWidth;a=d.options.size/2-d.options.lineWidth/2;!1!==d.options.scaleColor&&(a-=0.08*d.options.size);d.ctx.save();d.ctx.rotate(-Math.PI/2);d.ctx.beginPath();d.ctx.arc(0,0,a,0,2*Math.PI*b/100,!1);d.ctx.stroke();d.ctx.restore()};n=function(){return window.requestAnimationFrame||
window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||function(b){return window.setTimeout(b,1E3/60)}}();r=function(c,a){var e,f;d.options.onStart.call(d);d.percentage=a;f=Date.now();e=function(){var h,x;x=Date.now()-f;x<d.options.animate&&n(e);d.ctx.clearRect(-d.options.size/2,-d.options.size/2,d.options.size,d.options.size);v.call(d);h=[l(x,c,a-c,d.options.animate)];d.options.onStep.call(d,h);b.call(d,h);if(x>=d.options.animate)return d.options.onStop.call(d)};n(e)};l=function(b,
a,c,d){var e;e=function(a){return Math.pow(a,2)};b/=d/2;return c/2*(1>b?e(b):2-e(-2*(b/2)+2))+a};return this.init()};c.easyPieChart.defaultOptions={barColor:"#ef1e25",trackColor:"#f2f2f2",scaleColor:"#dfe0e0",lineCap:"round",size:110,lineWidth:3,animate:!1,onStart:c.noop,onStop:c.noop,onStep:c.noop};c.fn.easyPieChart=function(h){return c.each(this,function(f,e){var r;r=c(e);if(!r.data("easyPieChart"))return r.data("easyPieChart",new c.easyPieChart(e,h))})}})(jQuery);


// Generated by CoffeeScript 1.6.2
/*
jQuery Waypoints - v2.0.3
Copyright (c) 2011-2013 Caleb Troughton
Dual licensed under the MIT license and GPL license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/
(function(){var t=[].indexOf||function(t){for(var e=0,n=this.length;e<n;e++){if(e in this&&this[e]===t)return e}return-1},e=[].slice;(function(t,e){if(typeof define==="function"&&define.amd){return define("waypoints",["jquery"],function(n){return e(n,t)})}else{return e(t.jQuery,t)}})(this,function(n,r){var i,o,l,s,f,u,a,c,h,d,p,y,v,w,g,m;i=n(r);c=t.call(r,"ontouchstart")>=0;s={horizontal:{},vertical:{}};f=1;a={};u="waypoints-context-id";p="resize.waypoints";y="scroll.waypoints";v=1;w="waypoints-waypoint-ids";g="waypoint";m="waypoints";o=function(){function t(t){var e=this;this.$element=t;this.element=t[0];this.didResize=false;this.didScroll=false;this.id="context"+f++;this.oldScroll={x:t.scrollLeft(),y:t.scrollTop()};this.waypoints={horizontal:{},vertical:{}};t.data(u,this.id);a[this.id]=this;t.bind(y,function(){var t;if(!(e.didScroll||c)){e.didScroll=true;t=function(){e.doScroll();return e.didScroll=false};return r.setTimeout(t,n[m].settings.scrollThrottle)}});t.bind(p,function(){var t;if(!e.didResize){e.didResize=true;t=function(){n[m]("refresh");return e.didResize=false};return r.setTimeout(t,n[m].settings.resizeThrottle)}})}t.prototype.doScroll=function(){var t,e=this;t={horizontal:{newScroll:this.$element.scrollLeft(),oldScroll:this.oldScroll.x,forward:"right",backward:"left"},vertical:{newScroll:this.$element.scrollTop(),oldScroll:this.oldScroll.y,forward:"down",backward:"up"}};if(c&&(!t.vertical.oldScroll||!t.vertical.newScroll)){n[m]("refresh")}n.each(t,function(t,r){var i,o,l;l=[];o=r.newScroll>r.oldScroll;i=o?r.forward:r.backward;n.each(e.waypoints[t],function(t,e){var n,i;if(r.oldScroll<(n=e.offset)&&n<=r.newScroll){return l.push(e)}else if(r.newScroll<(i=e.offset)&&i<=r.oldScroll){return l.push(e)}});l.sort(function(t,e){return t.offset-e.offset});if(!o){l.reverse()}return n.each(l,function(t,e){if(e.options.continuous||t===l.length-1){return e.trigger([i])}})});return this.oldScroll={x:t.horizontal.newScroll,y:t.vertical.newScroll}};t.prototype.refresh=function(){var t,e,r,i=this;r=n.isWindow(this.element);e=this.$element.offset();this.doScroll();t={horizontal:{contextOffset:r?0:e.left,contextScroll:r?0:this.oldScroll.x,contextDimension:this.$element.width(),oldScroll:this.oldScroll.x,forward:"right",backward:"left",offsetProp:"left"},vertical:{contextOffset:r?0:e.top,contextScroll:r?0:this.oldScroll.y,contextDimension:r?n[m]("viewportHeight"):this.$element.height(),oldScroll:this.oldScroll.y,forward:"down",backward:"up",offsetProp:"top"}};return n.each(t,function(t,e){return n.each(i.waypoints[t],function(t,r){var i,o,l,s,f;i=r.options.offset;l=r.offset;o=n.isWindow(r.element)?0:r.$element.offset()[e.offsetProp];if(n.isFunction(i)){i=i.apply(r.element)}else if(typeof i==="string"){i=parseFloat(i);if(r.options.offset.indexOf("%")>-1){i=Math.ceil(e.contextDimension*i/100)}}r.offset=o-e.contextOffset+e.contextScroll-i;if(r.options.onlyOnScroll&&l!=null||!r.enabled){return}if(l!==null&&l<(s=e.oldScroll)&&s<=r.offset){return r.trigger([e.backward])}else if(l!==null&&l>(f=e.oldScroll)&&f>=r.offset){return r.trigger([e.forward])}else if(l===null&&e.oldScroll>=r.offset){return r.trigger([e.forward])}})})};t.prototype.checkEmpty=function(){if(n.isEmptyObject(this.waypoints.horizontal)&&n.isEmptyObject(this.waypoints.vertical)){this.$element.unbind([p,y].join(" "));return delete a[this.id]}};return t}();l=function(){function t(t,e,r){var i,o;r=n.extend({},n.fn[g].defaults,r);if(r.offset==="bottom-in-view"){r.offset=function(){var t;t=n[m]("viewportHeight");if(!n.isWindow(e.element)){t=e.$element.height()}return t-n(this).outerHeight()}}this.$element=t;this.element=t[0];this.axis=r.horizontal?"horizontal":"vertical";this.callback=r.handler;this.context=e;this.enabled=r.enabled;this.id="waypoints"+v++;this.offset=null;this.options=r;e.waypoints[this.axis][this.id]=this;s[this.axis][this.id]=this;i=(o=t.data(w))!=null?o:[];i.push(this.id);t.data(w,i)}t.prototype.trigger=function(t){if(!this.enabled){return}if(this.callback!=null){this.callback.apply(this.element,t)}if(this.options.triggerOnce){return this.destroy()}};t.prototype.disable=function(){return this.enabled=false};t.prototype.enable=function(){this.context.refresh();return this.enabled=true};t.prototype.destroy=function(){delete s[this.axis][this.id];delete this.context.waypoints[this.axis][this.id];return this.context.checkEmpty()};t.getWaypointsByElement=function(t){var e,r;r=n(t).data(w);if(!r){return[]}e=n.extend({},s.horizontal,s.vertical);return n.map(r,function(t){return e[t]})};return t}();d={init:function(t,e){var r;if(e==null){e={}}if((r=e.handler)==null){e.handler=t}this.each(function(){var t,r,i,s;t=n(this);i=(s=e.context)!=null?s:n.fn[g].defaults.context;if(!n.isWindow(i)){i=t.closest(i)}i=n(i);r=a[i.data(u)];if(!r){r=new o(i)}return new l(t,r,e)});n[m]("refresh");return this},disable:function(){return d._invoke(this,"disable")},enable:function(){return d._invoke(this,"enable")},destroy:function(){return d._invoke(this,"destroy")},prev:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e>0){return t.push(n[e-1])}})},next:function(t,e){return d._traverse.call(this,t,e,function(t,e,n){if(e<n.length-1){return t.push(n[e+1])}})},_traverse:function(t,e,i){var o,l;if(t==null){t="vertical"}if(e==null){e=r}l=h.aggregate(e);o=[];this.each(function(){var e;e=n.inArray(this,l[t]);return i(o,e,l[t])});return this.pushStack(o)},_invoke:function(t,e){t.each(function(){var t;t=l.getWaypointsByElement(this);return n.each(t,function(t,n){n[e]();return true})});return this}};n.fn[g]=function(){var t,r;r=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(d[r]){return d[r].apply(this,t)}else if(n.isFunction(r)){return d.init.apply(this,arguments)}else if(n.isPlainObject(r)){return d.init.apply(this,[null,r])}else if(!r){return n.error("jQuery Waypoints needs a callback function or handler option.")}else{return n.error("The "+r+" method does not exist in jQuery Waypoints.")}};n.fn[g].defaults={context:r,continuous:true,enabled:true,horizontal:false,offset:0,triggerOnce:false};h={refresh:function(){return n.each(a,function(t,e){return e.refresh()})},viewportHeight:function(){var t;return(t=r.innerHeight)!=null?t:i.height()},aggregate:function(t){var e,r,i;e=s;if(t){e=(i=a[n(t).data(u)])!=null?i.waypoints:void 0}if(!e){return[]}r={horizontal:[],vertical:[]};n.each(r,function(t,i){n.each(e[t],function(t,e){return i.push(e)});i.sort(function(t,e){return t.offset-e.offset});r[t]=n.map(i,function(t){return t.element});return r[t]=n.unique(r[t])});return r},above:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset<=t.oldScroll.y})},below:function(t){if(t==null){t=r}return h._filter(t,"vertical",function(t,e){return e.offset>t.oldScroll.y})},left:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset<=t.oldScroll.x})},right:function(t){if(t==null){t=r}return h._filter(t,"horizontal",function(t,e){return e.offset>t.oldScroll.x})},enable:function(){return h._invoke("enable")},disable:function(){return h._invoke("disable")},destroy:function(){return h._invoke("destroy")},extendFn:function(t,e){return d[t]=e},_invoke:function(t){var e;e=n.extend({},s.vertical,s.horizontal);return n.each(e,function(e,n){n[t]();return true})},_filter:function(t,e,r){var i,o;i=a[n(t).data(u)];if(!i){return[]}o=[];n.each(i.waypoints[e],function(t,e){if(r(i,e)){return o.push(e)}});o.sort(function(t,e){return t.offset-e.offset});return n.map(o,function(t){return t.element})}};n[m]=function(){var t,n;n=arguments[0],t=2<=arguments.length?e.call(arguments,1):[];if(h[n]){return h[n].apply(null,t)}else{return h.aggregate.call(null,n)}};n[m].settings={resizeThrottle:100,scrollThrottle:30};return i.load(function(){return n[m]("refresh")})})}).call(this);


(function(c){c.fn.hoverIntent=function(h,f,e){var r={interval:100,sensitivity:7,timeout:0},r="object"===typeof h?c.extend(r,h):c.isFunction(f)?c.extend(r,{over:h,out:f,selector:e}):c.extend(r,{over:h,out:h,selector:f}),b,l,n,v,t=function(c){b=c.pageX;l=c.pageY},w=function(d,e){e.hoverIntent_t=clearTimeout(e.hoverIntent_t);if(Math.abs(n-b)+Math.abs(v-l)<r.sensitivity)return c(e).off("mousemove.hoverIntent",t),e.hoverIntent_s=1,r.over.apply(e,[d]);n=b;v=l;e.hoverIntent_t=setTimeout(function(){w(d,e)},
r.interval)};h=function(b){var e=jQuery.extend({},b),a=this;a.hoverIntent_t&&(a.hoverIntent_t=clearTimeout(a.hoverIntent_t));"mouseenter"==b.type?(n=e.pageX,v=e.pageY,c(a).on("mousemove.hoverIntent",t),1!=a.hoverIntent_s&&(a.hoverIntent_t=setTimeout(function(){w(e,a)},r.interval))):(c(a).off("mousemove.hoverIntent",t),1==a.hoverIntent_s&&(a.hoverIntent_t=setTimeout(function(){a.hoverIntent_t=clearTimeout(a.hoverIntent_t);a.hoverIntent_s=0;r.out.apply(a,[e])},r.timeout)))};return this.on({"mouseenter.hoverIntent":h,
"mouseleave.hoverIntent":h},r.selector)}})(jQuery);


(function(c){c.fn.fitVids=function(h){var f={customSelector:null};if(!document.getElementById("fit-vids-style")){var e=document.createElement("div"),r=document.getElementsByTagName("base")[0]||document.getElementsByTagName("script")[0];e.className="fit-vids-style";e.id="fit-vids-style";e.style.display="none";e.innerHTML="&shy;<style>         .fluid-width-video-wrapper {        width: 100%;                     position: relative;              padding: 0;                      }                                   .fluid-width-video-wrapper iframe,  .fluid-width-video-wrapper object,  .fluid-width-video-wrapper embed {  position: absolute;              top: 0;                          left: 0;                         width: 100%;                     height: 100%;                    }                                   </style>";r.parentNode.insertBefore(e,
r)}h&&c.extend(f,h);return this.each(function(){var b="iframe[src*='player.vimeo.com'] iframe[src*='youtube.com'] iframe[src*='youtube-nocookie.com'] iframe[src*='kickstarter.com'][src*='video.html'] object embed".split(" ");f.customSelector&&b.push(f.customSelector);b=c(this).find(b.join(","));b=b.not("object object");b.each(function(){var b=c(this);if(!("embed"===this.tagName.toLowerCase()&&b.parent("object").length||b.parent(".fluid-width-video-wrapper").length)){var e="object"===this.tagName.toLowerCase()||
b.attr("height")&&!isNaN(parseInt(b.attr("height"),10))?parseInt(b.attr("height"),10):b.height(),f=isNaN(parseInt(b.attr("width"),10))?b.width():parseInt(b.attr("width"),10),e=e/f;b.attr("id")||(f="fitvid"+Math.floor(999999*Math.random()),b.attr("id",f));b.wrap('<div class="fluid-width-video-wrapper"></div>').parent(".fluid-width-video-wrapper").css("padding-top",100*e+"%");b.removeAttr("height").removeAttr("width")}})})}})(jQuery);


jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});



(function($) {

var $event = $.event,
	$special,
	resizeTimeout;

$special = $event.special.debouncedresize = {
	setup: function() {
		$( this ).on( "resize", $special.handler );
	},
	teardown: function() {
		$( this ).off( "resize", $special.handler );
	},
	handler: function( event, execAsap ) {
		// Save the context
		var context = this,
			args = arguments,
			dispatch = function() {
				// set correct event type
				event.type = "debouncedresize";
				$event.dispatch.apply( context, args );
			};

		if ( resizeTimeout ) {
			clearTimeout( resizeTimeout );
		}

		execAsap ?
			dispatch() :
			resizeTimeout = setTimeout( dispatch, $special.threshold );
	},
	threshold: 150
};

})(jQuery);



// Github repo:
// https://github.com/greenball/numinate
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    'use strict';

    // Math conditions & description.
    // 1. Either runningInterval or stepInterval need to be provided.
    // 2. If both stepUnit and stepCount setted then the 'to' value will be overwriten.
    // 3. Either stepUnit or stepCount is need to be provided.
    // 4. If stepInterval is less then 10 ms then the plugin will recalculate the animation with 10 ms stepInterval.
    // 5. If the 'from' and 'to' values are both zer0 the plugin will 
    // count infinity if no runningInterval provided or will count till reaches the runningInterval's end.

    // Default options.
  var defaults = {
    // Counting starts from here.
    from:       0,
    // Counting ends here, if any differental setted.
    to:       0,

    // Interval for the whole running.
    // ! Overwrites the stepInterval if it's setted.
    runningInterval:null,

    // Interval between two step.
    // If not provided will calculate from runningInterval.
    stepInterval:   null,
    // How many times refresh the %counter% value.
    stepCount:    null,
    // How much a step's alters the current value.
    stepUnit:     null,

    // The appering text, the %counter% token will be
    // replaced with the actual step's value.
    format:     '%counter%',
    // Class will be added to the counter DOM(s).
    cclass:      'numinate',
    // The step values will be rounded to this precision,
    // this is directly passed to the currentValue.toFixed(precision) fn.
    precision:    0,
    // The counter starts on call, or do manualy.
    autoStart:    true,
    // The counter remove itself when reaches the goal.
    autoRemove:   false,

    // Event called when the counter has been created.
    onCreate:   null,
    // Event called when the counter starts to count.
    onStart:  null,
    // Event called before the counter update the step value.
    onStep:   null,
    // Event called when the counter reached the goal, or stoped manualy.
    onStop:   null,
    // Event called when the counter reached the goal value, or called manualy.
    onComplete: null,
    // Event called when the counter has been removed.
    onRemove:   null,
  };

    // Constructor, initialise everything you need here
    var Plugin = function(element, options) {
      // Always need some kind of interval.
      if ( ! options.runningInterval && ! options.stepInterval) {
        return window.console.error('No interval was provided.');
      }

      // Calculate differental for further math.
      var diff  = Math.abs(options.from - options.to);

      // Always need at least stepCount or stepUnit.
      if ( ! options.stepCount && ! options.stepUnit) {
        return window.console.error('Provide either stepCount or stepUnit value.');
      }

      // If both stepCount & stepUnit provided then the 'to' will be overwriten.
      if (options.stepUnit && options.stepCount) {
        options.to  = options.from + (options.stepUnit * options.stepCount);
      }

      // Calculate the step count.
      if ( ! options.stepCount) {
        options.stepCount   = (diff / options.stepUnit);
      }

      // Calculate the step unit.
      if ( ! options.stepUnit) {
        options.stepUnit  = (diff / options.stepCount);
      }

    // runningInterval overwrites the stepInterval.
    if (options.runningInterval) {
        options.stepInterval  = (options.runningInterval / options.stepCount);
      }

      // stepUnit cannot be more then the differental.
      if (diff && options.stepUnit > diff) {
        options.stepUnit  = diff;
        options.stepCount   = 1;
      }

      // stepInterval cannot be less then 10 ms.
      if (options.stepInterval < 10) {
        var multiplier      = (10 / options.stepInterval);
        options.stepInterval  *= multiplier;
        options.stepUnit    *= multiplier;
        options.stepCount     /= multiplier;
      }

      this.textBackup   = element.text();
        this.element      = element;
        this.options      = options;
        this.stepper    = null;
        this.current    = options.from;
        this.finished     = false;

        // Add the class.
        this.element.addClass(options.cclass);

        // Fire the event for creation.
        this.fire('onCreate');

        // Auto starter.
        if (this.options.autoStart) {
          this.start();
        };
    };

    // Plugin methods and shared properties
    Plugin.prototype = {
        // Reset constructor - http://goo.gl/EcWdiy
        constructor: Plugin,

        // Fire an event.
        fire: function(event) {
          if ($.isFunction(this.options[event])) {
            this.options[event](this.element, this.options, this.current);
          }
        },

        // Stop the counter.
        stop: function() {
          // Not running.
          if ( ! this.stepper || this.finished) {return;}

          // Free the stepper.
          this.stepper = clearInterval(this.stepper);

          // Fire the event for stop.
          this.fire('onStop');
        },

        // Start the counter.
        start: function() {
          // Already running or finished.
          if (this.stepper || this.finished) {return;}

          // Render the counter with the base value.
          this.render();

          // Start the stepping.
          this.stepper = setInterval($.proxy(this.step, this), this.options.stepInterval);

          // Fire the event for stop.
          this.fire('onStart');
        },

        // Step one.
        step: function() {
          // Infinity loop.
      if ( ! (this.options.from + this.options.to)) {
        this.current  += this.options.stepUnit;
      }
      // Count up till a number.
      else if(this.options.from < this.options.to) {
        this.current  += this.options.stepUnit;
      }
      // Count down till a number.
      else if(this.options.from > this.options.to) {
        this.current  -= this.options.stepUnit;
      }

          // Reached the goal.
      if (this.options.from < this.options.to) {
        if(this.current > this.options.to) {
          return this.completed();
        }
      } else if(this.options.from > this.options.to) {
        if(this.current < this.options.to) {
          return this.completed();
        }
      }

            // Fire the event for stop.
            this.fire('onStep');

      // Render the new value.
      this.render();
        },

        // The current reached the last value.
        completed: function() {
          // Fixing the problem where the stepUnit is
          // an infity long fraction number and the
          // last value is just close to the goal and
          // cannot be equal with it.
        var diff = Math.abs(this.options.from - this.options.to);

        if (diff && this.options.current !== this.options.to) {
          this.current = this.options.to;
          this.render();
        }

          // Stop the counter.
          this.stop();

          // Inform the other fns.
          this.finished   = true;

          // Fire the event for complete.
          this.fire('onComplete');

          // Auto remove if necessary.
          if (this.options.autoRemove) {
            this.remove();
          }
        },

        // Remove.
        remove:   function() {
          // Fire the event for remove.
          this.fire('onRemove');

          // Unbind the data.
          $.removeData(this.element, 'numinate');

          // Clear the text.
          this.element.text(this.textBackup ? this.textBackup : '');

          // Remove the classes.
          this.element.removeClass(this.options.cclass);
        },

        // Render text.
        render: function() {
      this.element.text(this.options.format.replace(/\%counter\%/, this.current.toFixed(this.options.precision)));
        },

        // Restart the process.
        restart: function() {
          this.finished   = false;
          this.current  = this.options.from;
          this.stop();
          this.start();
        }
    }

    // Create the numinate plugin
    $.fn.numinate = function(options) {
      var action;

      // Init config.
      if (typeof options == 'object') {
        // Do a deep copy of the options - http://goo.gl/gOSSrg
        options = $.extend(true, {}, defaults, options);
        action  = 'init';
      }
      // Call an action.
      else if (typeof options == 'string') {
        action  = options;
      } 

        return this.each(function() {
            var $this = $(this);

            // Push the numinate instance to the object.
            if (action == 'init') {
              $this.data('numinate', new Plugin($this, options)); 
            } 
            // Call the action.
            else {
              $this.data('numinate')[action]();
            }
        });
    };

    // Expose defaults and Constructor (allowing overriding of prototype methods for example)
    $.fn.numinate.defaults = defaults;
    $.fn.numinate.Plugin   = Plugin;
}));




(function($) {
  var defaults = {
      topSpacing: 0,
      bottomSpacing: 0,
      className: 'is-sticky',
      wrapperClassName: 'sticky-wrapper',
      center: false,
      getWidthFrom: ''
    },
    $window = $(window),
    $document = $(document),
    sticked = [],
    windowHeight = $window.height(),
    scroller = function() {
      var scrollTop = $window.scrollTop(),
        documentHeight = $document.height(),
        dwh = documentHeight - windowHeight,
        extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

      for (var i = 0; i < sticked.length; i++) {
        var s = sticked[i],
          elementTop = s.stickyWrapper.offset().top,
          etse = elementTop - s.topSpacing - extra;

        if (scrollTop <= etse) {
          if (s.currentTop !== null) {
            s.stickyElement
              .css('position', '')
              .css('top', '');
            s.stickyElement.parent().removeClass(s.className);
            s.currentTop = null;
          }
        }
        else {
          var newTop = documentHeight - s.stickyElement.outerHeight()
            - s.topSpacing - s.bottomSpacing - scrollTop - extra;
          if (newTop < 0) {
            newTop = newTop + s.topSpacing;
          } else {
            newTop = s.topSpacing;
          }
          if (s.currentTop != newTop) {
            s.stickyElement
              .css('position', 'fixed')
              .css('top', newTop);

            if (typeof s.getWidthFrom !== 'undefined') {
              s.stickyElement.css('width', $(s.getWidthFrom).width());
            }

            s.stickyElement.parent().addClass(s.className);
            s.currentTop = newTop;
          }
        }
      }
    },
    resizer = function() {
      windowHeight = $window.height();
    },
    methods = {
      init: function(options) {
        var o = $.extend(defaults, options);
        return this.each(function() {
          var stickyElement = $(this);

          var stickyId = stickyElement.attr('id');
          var wrapper = $('<div></div>')
            .attr('id', stickyId + '-sticky-wrapper')
            .addClass(o.wrapperClassName);
          stickyElement.wrapAll(wrapper);

          if (o.center) {
            stickyElement.parent().css({width:stickyElement.outerWidth(),marginLeft:"auto",marginRight:"auto"});
          }

          if (stickyElement.css("float") == "right") {
            stickyElement.css({"float":"none"}).parent().css({"float":"right"});
          }

          var stickyWrapper = stickyElement.parent();
          stickyWrapper.css('height', stickyElement.outerHeight());
          sticked.push({
            topSpacing: o.topSpacing,
            bottomSpacing: o.bottomSpacing,
            stickyElement: stickyElement,
            currentTop: null,
            stickyWrapper: stickyWrapper,
            className: o.className,
            getWidthFrom: o.getWidthFrom
          });
        });
      },
      update: scroller
    };

  // should be more efficient than using $window.scroll(scroller) and $window.resize(resizer):
  if (window.addEventListener) {
    window.addEventListener('scroll', scroller, false);
    window.addEventListener('resize', resizer, false);
  } else if (window.attachEvent) {
    window.attachEvent('onscroll', scroller);
    window.attachEvent('onresize', resizer);
  }

  $.fn.sticky = function(method) {
    if (methods[method]) {
      return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof method === 'object' || !method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error('Method ' + method + ' does not exist on jQuery.sticky');
    }
  };
  $(function() {
    setTimeout(scroller, 0);
  });
})(jQuery);


/*!
  Zoom v1.7.12 - 2014-02-12
  Enlarge images on click or mouseover.
  (c) 2014 Jack Moore - http://www.jacklmoore.com/zoom
  license: http://www.opensource.org/licenses/mit-license.php
*/
(function(o){var n={url:!1,callback:!1,target:!1,duration:120,on:"mouseover",touch:!0,onZoomIn:!1,onZoomOut:!1,magnify:1};o.zoom=function(n,t,e,i){var u,c,a,m,r,l,s,f=o(n).css("position");return o(n).css({position:/(absolute|fixed)/.test(f)?f:"relative",overflow:"hidden"}),e.style.width=e.style.height="",o(e).addClass("zoomImg").css({position:"absolute",top:0,left:0,opacity:0,width:e.width*i,height:e.height*i,border:"none",maxWidth:"none",maxHeight:"none"}).appendTo(n),{init:function(){c=o(n).outerWidth(),u=o(n).outerHeight(),t===n?(m=c,a=u):(m=o(t).outerWidth(),a=o(t).outerHeight()),r=(e.width-c)/m,l=(e.height-u)/a,s=o(t).offset()},move:function(o){var n=o.pageX-s.left,t=o.pageY-s.top;t=Math.max(Math.min(t,a),0),n=Math.max(Math.min(n,m),0),e.style.left=n*-r+"px",e.style.top=t*-l+"px"}}},o.fn.zoom=function(t){return this.each(function(){var e,i=o.extend({},n,t||{}),u=i.target||this,c=this,a=document.createElement("img"),m=o(a),r="mousemove.zoom",l=!1,s=!1;(i.url||(e=o(c).find("img"),e[0]&&(i.url=e.data("src")||e.attr("src")),i.url))&&(a.onload=function(){function n(n){e.init(),e.move(n),m.stop().fadeTo(o.support.opacity?i.duration:0,1,o.isFunction(i.onZoomIn)?i.onZoomIn.call(a):!1)}function t(){m.stop().fadeTo(i.duration,0,o.isFunction(i.onZoomOut)?i.onZoomOut.call(a):!1)}var e=o.zoom(u,c,a,i.magnify);"grab"===i.on?o(c).on("mousedown.zoom",function(i){1===i.which&&(o(document).one("mouseup.zoom",function(){t(),o(document).off(r,e.move)}),n(i),o(document).on(r,e.move),i.preventDefault())}):"click"===i.on?o(c).on("click.zoom",function(i){return l?void 0:(l=!0,n(i),o(document).on(r,e.move),o(document).one("click.zoom",function(){t(),l=!1,o(document).off(r,e.move)}),!1)}):"toggle"===i.on?o(c).on("click.zoom",function(o){l?t():n(o),l=!l}):"mouseover"===i.on&&(e.init(),o(c).on("mouseenter.zoom",n).on("mouseleave.zoom",t).on(r,e.move)),i.touch&&o(c).on("touchstart.zoom",function(o){o.preventDefault(),s?(s=!1,t()):(s=!0,n(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0]))}).on("touchmove.zoom",function(o){o.preventDefault(),e.move(o.originalEvent.touches[0]||o.originalEvent.changedTouches[0])}),o.isFunction(i.callback)&&i.callback.call(a)},a.src=i.url,o(c).one("zoom.destroy",function(){o(c).off(".zoom"),m.remove()}))})},o.fn.zoom.defaults=n})(window.jQuery);
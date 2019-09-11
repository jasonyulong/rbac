/*!
 * Start Bootstrap - Admin v3.3.7+1 (https://github.com/KevinsDeveloper/bootstrap4-admin)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
!function(e,t,i,n){function a(t,i){this.element=e(t),this.settings=e.extend({},s,i),this._defaults=s,this._name=o,this.init()}var o="metisMenu",s={toggle:!0,doubleTapToGo:!1};a.prototype={init:function(){var t=this.element,n=this.settings.toggle,a=this;this.isIE()<=9?(t.find("li.active").has("ul").children("ul").collapse("show"),t.find("li").not(".active").has("ul").children("ul").collapse("hide")):(t.find("li.active").has("ul").children("ul").addClass("collapse in"),t.find("li").not(".active").has("ul").children("ul").addClass("collapse")),a.settings.doubleTapToGo&&t.find("li.active").has("ul").children("a").addClass("doubleTapToGo"),t.find("li").has("ul").children("a").on("click."+o,function(t){return t.preventDefault(),a.settings.doubleTapToGo&&a.doubleTapToGo(e(this))&&"#"!==e(this).attr("href")&&""!==e(this).attr("href")?(t.stopPropagation(),void(i.location=e(this).attr("href"))):(e(this).parent("li").toggleClass("active").children("ul").collapse("toggle"),void(n&&e(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide")))})},isIE:function(){for(var e,t=3,n=i.createElement("div"),a=n.getElementsByTagName("i");n.innerHTML="<!--[if gt IE "+ ++t+"]><i></i><![endif]-->",a[0];)return t>4?t:e},doubleTapToGo:function(e){var t=this.element;return e.hasClass("doubleTapToGo")?(e.removeClass("doubleTapToGo"),!0):e.parent().children("ul").length?(t.find(".doubleTapToGo").removeClass("doubleTapToGo"),e.addClass("doubleTapToGo"),!1):void 0},remove:function(){this.element.off("."+o),this.element.removeData(o)}},e.fn[o]=function(t){return this.each(function(){var i=e(this);i.data(o)&&i.data(o).remove(),i.data(o,new a(this,t))}),this},e(".side-menu").metisMenu()}(jQuery,window,document),!function(e,t){"use strict";var i,n,a=e.layui&&layui.define,o={getPath:function(){var e=document.currentScript?document.currentScript.src:function(){for(var e,t=document.scripts,i=t.length-1,n=i;n>0;n--)if("interactive"===t[n].readyState){e=t[n].src;break}return e||t[i].src}();return e.substring(0,e.lastIndexOf("/")+1)}(),config:{},end:{},minIndex:0,minLeft:[],btn:["&#x786E;&#x5B9A;","&#x53D6;&#x6D88;"],type:["dialog","page","iframe","loading","tips"],getStyle:function(t,i){var n=t.currentStyle?t.currentStyle:e.getComputedStyle(t,null);return n[n.getPropertyValue?"getPropertyValue":"getAttribute"](i)},link:function(t,i,n){if(s.path){var a=document.getElementsByTagName("head")[0],r=document.createElement("link");"string"==typeof i&&(n=i);var l=(n||t).replace(/\.|\//g,""),c="layuicss-"+l,f=0;r.rel="stylesheet",r.href=s.path+t,r.id=c,document.getElementById(c)||a.appendChild(r),"function"==typeof i&&!function d(){return++f>80?e.console&&console.error("layer.css: Invalid"):void(1989===parseInt(o.getStyle(document.getElementById(c),"width"))?i():setTimeout(d,100))}()}}},s={v:"3.1.1",ie:function(){var t=navigator.userAgent.toLowerCase();return!!(e.ActiveXObject||"ActiveXObject"in e)&&((t.match(/msie\s(\d+)/)||[])[1]||"11")}(),index:e.layer&&e.layer.v?1e5:0,path:o.getPath,config:function(e,t){return e=e||{},s.cache=o.config=i.extend({},o.config,e),s.path=o.config.path||s.path,"string"==typeof e.extend&&(e.extend=[e.extend]),o.config.path&&s.ready(),e.extend?(a?layui.addcss("modules/layer/"+e.extend):o.link("theme/"+e.extend),this):this},ready:function(e){var t="layer",i="",n=(a?"modules/layer/":"theme/")+"default/layer.css?v="+s.v+i;return a?layui.addcss(n,e,t):o.link(n,e,t),this},alert:function(e,t,n){var a="function"==typeof t;return a&&(n=t),s.open(i.extend({content:e,yes:n},a?{}:t))},confirm:function(e,t,n,a){var r="function"==typeof t;return r&&(a=n,n=t),s.open(i.extend({content:e,btn:o.btn,yes:n,btn2:a},r?{}:t))},msg:function(e,n,a){var r="function"==typeof n,c=o.config.skin,f=(c?c+" "+c+"-msg":"")||"layui-layer-msg",d=l.anim.length-1;return r&&(a=n),s.open(i.extend({content:e,time:3e3,shade:!1,skin:f,title:!1,closeBtn:!1,btn:!1,resize:!1,end:a},r&&!o.config.skin?{skin:f+" layui-layer-hui",anim:d}:function(){return n=n||{},(n.icon===-1||n.icon===t&&!o.config.skin)&&(n.skin=f+" "+(n.skin||"layui-layer-hui")),n}()))},load:function(e,t){return s.open(i.extend({type:3,icon:e||0,resize:!1,shade:.01},t))},tips:function(e,t,n){return s.open(i.extend({type:4,content:[e,t],closeBtn:!1,time:3e3,shade:!1,resize:!1,fixed:!1,maxWidth:210},n))}},r=function(e){var t=this;t.index=++s.index,t.config=i.extend({},t.config,o.config,e),document.body?t.creat():setTimeout(function(){t.creat()},30)};r.pt=r.prototype;var l=["layui-layer",".layui-layer-title",".layui-layer-main",".layui-layer-dialog","layui-layer-iframe","layui-layer-content","layui-layer-btn","layui-layer-close"];l.anim=["layer-anim-00","layer-anim-01","layer-anim-02","layer-anim-03","layer-anim-04","layer-anim-05","layer-anim-06"],r.pt.config={type:0,shade:.3,fixed:!0,move:l[1],title:"&#x4FE1;&#x606F;",offset:"auto",area:"auto",closeBtn:1,time:0,zIndex:19891014,maxWidth:360,anim:0,isOutAnim:!0,icon:-1,moveType:1,resize:!0,scrollbar:!0,tips:2},r.pt.vessel=function(e,t){var n=this,a=n.index,s=n.config,r=s.zIndex+a,c="object"==typeof s.title,f=s.maxmin&&(1===s.type||2===s.type),d=s.title?'<div class="layui-layer-title" style="'+(c?s.title[1]:"")+'">'+(c?s.title[0]:s.title)+"</div>":"";return s.zIndex=r,t([s.shade?'<div class="layui-layer-shade" id="layui-layer-shade'+a+'" times="'+a+'" style="'+("z-index:"+(r-1)+"; ")+'"></div>':"",'<div class="'+l[0]+(" layui-layer-"+o.type[s.type])+(0!=s.type&&2!=s.type||s.shade?"":" layui-layer-border")+" "+(s.skin||"")+'" id="'+l[0]+a+'" type="'+o.type[s.type]+'" times="'+a+'" showtime="'+s.time+'" conType="'+(e?"object":"string")+'" style="z-index: '+r+"; width:"+s.area[0]+";height:"+s.area[1]+(s.fixed?"":";position:absolute;")+'">'+(e&&2!=s.type?"":d)+'<div id="'+(s.id||"")+'" class="layui-layer-content'+(0==s.type&&s.icon!==-1?" layui-layer-padding":"")+(3==s.type?" layui-layer-loading"+s.icon:"")+'">'+(0==s.type&&s.icon!==-1?'<i class="layui-layer-ico layui-layer-ico'+s.icon+'"></i>':"")+(1==s.type&&e?"":s.content||"")+'</div><span class="layui-layer-setwin">'+function(){var e=f?'<a class="layui-layer-min" href="javascript:;"><cite></cite></a><a class="layui-layer-ico layui-layer-max" href="javascript:;"></a>':"";return s.closeBtn&&(e+='<a class="layui-layer-ico '+l[7]+" "+l[7]+(s.title?s.closeBtn:4==s.type?"1":"2")+'" href="javascript:;"></a>'),e}()+"</span>"+(s.btn?function(){var e="";"string"==typeof s.btn&&(s.btn=[s.btn]);for(var t=0,i=s.btn.length;t<i;t++)e+='<a class="'+l[6]+t+'">'+s.btn[t]+"</a>";return'<div class="'+l[6]+" layui-layer-btn-"+(s.btnAlign||"")+'">'+e+"</div>"}():"")+(s.resize?'<span class="layui-layer-resize"></span>':"")+"</div>"],d,i('<div class="layui-layer-move"></div>')),n},r.pt.creat=function(){var e=this,t=e.config,a=e.index,r=t.content,c="object"==typeof r,f=i("body");if(!t.id||!i("#"+t.id)[0]){switch("string"==typeof t.area&&(t.area="auto"===t.area?["",""]:[t.area,""]),t.shift&&(t.anim=t.shift),6==s.ie&&(t.fixed=!1),t.type){case 0:t.btn="btn"in t?t.btn:o.btn[0],s.closeAll("dialog");break;case 2:var r=t.content=c?t.content:[t.content||"http://layer.layui.com","auto"];t.content='<iframe scrolling="'+(t.content[1]||"auto")+'" allowtransparency="true" id="'+l[4]+a+'" name="'+l[4]+a+'" onload="this.className=\'\';" class="layui-layer-load" frameborder="0" src="'+t.content[0]+'"></iframe>';break;case 3:delete t.title,delete t.closeBtn,t.icon===-1&&0===t.icon,s.closeAll("loading");break;case 4:c||(t.content=[t.content,"body"]),t.follow=t.content[1],t.content=t.content[0]+'<i class="layui-layer-TipsG"></i>',delete t.title,t.tips="object"==typeof t.tips?t.tips:[t.tips,!0],t.tipsMore||s.closeAll("tips")}if(e.vessel(c,function(n,s,d){f.append(n[0]),c?function(){2==t.type||4==t.type?function(){i("body").append(n[1])}():function(){r.parents("."+l[0])[0]||(r.data("display",r.css("display")).show().addClass("layui-layer-wrap").wrap(n[1]),i("#"+l[0]+a).find("."+l[5]).before(s))}()}():f.append(n[1]),i(".layui-layer-move")[0]||f.append(o.moveElem=d),e.layero=i("#"+l[0]+a),t.scrollbar||l.html.css("overflow","hidden").attr("layer-full",a)}).auto(a),i("#layui-layer-shade"+e.index).css({"background-color":t.shade[1]||"#000",opacity:t.shade[0]||t.shade}),2==t.type&&6==s.ie&&e.layero.find("iframe").attr("src",r[0]),4==t.type?e.tips():e.offset(),t.fixed&&n.on("resize",function(){e.offset(),(/^\d+%$/.test(t.area[0])||/^\d+%$/.test(t.area[1]))&&e.auto(a),4==t.type&&e.tips()}),t.time<=0||setTimeout(function(){s.close(e.index)},t.time),e.move().callback(),l.anim[t.anim]){var d="layer-anim "+l.anim[t.anim];e.layero.addClass(d).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend",function(){i(this).removeClass(d)})}t.isOutAnim&&e.layero.data("isOutAnim",!0)}},r.pt.auto=function(e){var t=this,a=t.config,o=i("#"+l[0]+e);""===a.area[0]&&a.maxWidth>0&&(s.ie&&s.ie<8&&a.btn&&o.width(o.innerWidth()),o.outerWidth()>a.maxWidth&&o.width(a.maxWidth));var r=[o.innerWidth(),o.innerHeight()],c=o.find(l[1]).outerHeight()||0,f=o.find("."+l[6]).outerHeight()||0,d=function(e){e=o.find(e),e.height(r[1]-c-f-2*(0|parseFloat(e.css("padding-top"))))};switch(a.type){case 2:d("iframe");break;default:""===a.area[1]?a.maxHeight>0&&o.outerHeight()>a.maxHeight?(r[1]=a.maxHeight,d("."+l[5])):a.fixed&&r[1]>=n.height()&&(r[1]=n.height(),d("."+l[5])):d("."+l[5])}return t},r.pt.offset=function(){var e=this,t=e.config,i=e.layero,a=[i.outerWidth(),i.outerHeight()],o="object"==typeof t.offset;e.offsetTop=(n.height()-a[1])/2,e.offsetLeft=(n.width()-a[0])/2,o?(e.offsetTop=t.offset[0],e.offsetLeft=t.offset[1]||e.offsetLeft):"auto"!==t.offset&&("t"===t.offset?e.offsetTop=0:"r"===t.offset?e.offsetLeft=n.width()-a[0]:"b"===t.offset?e.offsetTop=n.height()-a[1]:"l"===t.offset?e.offsetLeft=0:"lt"===t.offset?(e.offsetTop=0,e.offsetLeft=0):"lb"===t.offset?(e.offsetTop=n.height()-a[1],e.offsetLeft=0):"rt"===t.offset?(e.offsetTop=0,e.offsetLeft=n.width()-a[0]):"rb"===t.offset?(e.offsetTop=n.height()-a[1],e.offsetLeft=n.width()-a[0]):e.offsetTop=t.offset),t.fixed||(e.offsetTop=/%$/.test(e.offsetTop)?n.height()*parseFloat(e.offsetTop)/100:parseFloat(e.offsetTop),e.offsetLeft=/%$/.test(e.offsetLeft)?n.width()*parseFloat(e.offsetLeft)/100:parseFloat(e.offsetLeft),e.offsetTop+=n.scrollTop(),e.offsetLeft+=n.scrollLeft()),i.attr("minLeft")&&(e.offsetTop=n.height()-(i.find(l[1]).outerHeight()||0),e.offsetLeft=i.css("left")),i.css({top:e.offsetTop,left:e.offsetLeft})},r.pt.tips=function(){var e=this,t=e.config,a=e.layero,o=[a.outerWidth(),a.outerHeight()],s=i(t.follow);s[0]||(s=i("body"));var r={width:s.outerWidth(),height:s.outerHeight(),top:s.offset().top,left:s.offset().left},c=a.find(".layui-layer-TipsG"),f=t.tips[0];t.tips[1]||c.remove(),r.autoLeft=function(){r.left+o[0]-n.width()>0?(r.tipLeft=r.left+r.width-o[0],c.css({right:12,left:"auto"})):r.tipLeft=r.left},r.where=[function(){r.autoLeft(),r.tipTop=r.top-o[1]-10,c.removeClass("layui-layer-TipsB").addClass("layui-layer-TipsT").css("border-right-color",t.tips[1])},function(){r.tipLeft=r.left+r.width+10,r.tipTop=r.top,c.removeClass("layui-layer-TipsL").addClass("layui-layer-TipsR").css("border-bottom-color",t.tips[1])},function(){r.autoLeft(),r.tipTop=r.top+r.height+10,c.removeClass("layui-layer-TipsT").addClass("layui-layer-TipsB").css("border-right-color",t.tips[1])},function(){r.tipLeft=r.left-o[0]-10,r.tipTop=r.top,c.removeClass("layui-layer-TipsR").addClass("layui-layer-TipsL").css("border-bottom-color",t.tips[1])}],r.where[f-1](),1===f?r.top-(n.scrollTop()+o[1]+16)<0&&r.where[2]():2===f?n.width()-(r.left+r.width+o[0]+16)>0||r.where[3]():3===f?r.top-n.scrollTop()+r.height+o[1]+16-n.height()>0&&r.where[0]():4===f&&o[0]+16-r.left>0&&r.where[1](),a.find("."+l[5]).css({"background-color":t.tips[1],"padding-right":t.closeBtn?"30px":""}),a.css({left:r.tipLeft-(t.fixed?n.scrollLeft():0),top:r.tipTop-(t.fixed?n.scrollTop():0)})},r.pt.move=function(){var e=this,t=e.config,a=i(document),r=e.layero,l=r.find(t.move),c=r.find(".layui-layer-resize"),f={};return t.move&&l.css("cursor","move"),l.on("mousedown",function(e){e.preventDefault(),t.move&&(f.moveStart=!0,f.offset=[e.clientX-parseFloat(r.css("left")),e.clientY-parseFloat(r.css("top"))],o.moveElem.css("cursor","move").show())}),c.on("mousedown",function(e){e.preventDefault(),f.resizeStart=!0,f.offset=[e.clientX,e.clientY],f.area=[r.outerWidth(),r.outerHeight()],o.moveElem.css("cursor","se-resize").show()}),a.on("mousemove",function(i){if(f.moveStart){var a=i.clientX-f.offset[0],o=i.clientY-f.offset[1],l="fixed"===r.css("position");if(i.preventDefault(),f.stX=l?0:n.scrollLeft(),f.stY=l?0:n.scrollTop(),!t.moveOut){var c=n.width()-r.outerWidth()+f.stX,d=n.height()-r.outerHeight()+f.stY;a<f.stX&&(a=f.stX),a>c&&(a=c),o<f.stY&&(o=f.stY),o>d&&(o=d)}r.css({left:a,top:o})}if(t.resize&&f.resizeStart){var a=i.clientX-f.offset[0],o=i.clientY-f.offset[1];i.preventDefault(),s.style(e.index,{width:f.area[0]+a,height:f.area[1]+o}),f.isResize=!0,t.resizing&&t.resizing(r)}}).on("mouseup",function(e){f.moveStart&&(delete f.moveStart,o.moveElem.hide(),t.moveEnd&&t.moveEnd(r)),f.resizeStart&&(delete f.resizeStart,o.moveElem.hide())}),e},r.pt.callback=function(){function e(){var e=a.cancel&&a.cancel(t.index,n);e===!1||s.close(t.index)}var t=this,n=t.layero,a=t.config;t.openLayer(),a.success&&(2==a.type?n.find("iframe").on("load",function(){a.success(n,t.index)}):a.success(n,t.index)),6==s.ie&&t.IE6(n),n.find("."+l[6]).children("a").on("click",function(){var e=i(this).index();if(0===e)a.yes?a.yes(t.index,n):a.btn1?a.btn1(t.index,n):s.close(t.index);else{var o=a["btn"+(e+1)]&&a["btn"+(e+1)](t.index,n);o===!1||s.close(t.index)}}),n.find("."+l[7]).on("click",e),a.shadeClose&&i("#layui-layer-shade"+t.index).on("click",function(){s.close(t.index)}),n.find(".layui-layer-min").on("click",function(){var e=a.min&&a.min(n);e===!1||s.min(t.index,a)}),n.find(".layui-layer-max").on("click",function(){i(this).hasClass("layui-layer-maxmin")?(s.restore(t.index),a.restore&&a.restore(n)):(s.full(t.index,a),setTimeout(function(){a.full&&a.full(n)},100))}),a.end&&(o.end[t.index]=a.end)},o.reselect=function(){i.each(i("select"),function(e,t){var n=i(this);n.parents("."+l[0])[0]||1==n.attr("layer")&&i("."+l[0]).length<1&&n.removeAttr("layer").show(),n=null})},r.pt.IE6=function(e){i("select").each(function(e,t){var n=i(this);n.parents("."+l[0])[0]||"none"===n.css("display")||n.attr({layer:"1"}).hide(),n=null})},r.pt.openLayer=function(){var e=this;s.zIndex=e.config.zIndex,s.setTop=function(e){var t=function(){s.zIndex++,e.css("z-index",s.zIndex+1)};return s.zIndex=parseInt(e[0].style.zIndex),e.on("mousedown",t),s.zIndex}},o.record=function(e){var t=[e.width(),e.height(),e.position().top,e.position().left+parseFloat(e.css("margin-left"))];e.find(".layui-layer-max").addClass("layui-layer-maxmin"),e.attr({area:t})},o.rescollbar=function(e){l.html.attr("layer-full")==e&&(l.html[0].style.removeProperty?l.html[0].style.removeProperty("overflow"):l.html[0].style.removeAttribute("overflow"),l.html.removeAttr("layer-full"))},e.layer=s,s.getChildFrame=function(e,t){return t=t||i("."+l[4]).attr("times"),i("#"+l[0]+t).find("iframe").contents().find(e)},s.getFrameIndex=function(e){return i("#"+e).parents("."+l[4]).attr("times")},s.iframeAuto=function(e){if(e){var t=s.getChildFrame("html",e).outerHeight(),n=i("#"+l[0]+e),a=n.find(l[1]).outerHeight()||0,o=n.find("."+l[6]).outerHeight()||0;n.css({height:t+a+o}),n.find("iframe").css({height:t})}},s.iframeSrc=function(e,t){i("#"+l[0]+e).find("iframe").attr("src",t)},s.style=function(e,t,n){var a=i("#"+l[0]+e),s=a.find(".layui-layer-content"),r=a.attr("type"),c=a.find(l[1]).outerHeight()||0,f=a.find("."+l[6]).outerHeight()||0;a.attr("minLeft"),r!==o.type[3]&&r!==o.type[4]&&(n||(parseFloat(t.width)<=260&&(t.width=260),parseFloat(t.height)-c-f<=64&&(t.height=64+c+f)),a.css(t),f=a.find("."+l[6]).outerHeight(),r===o.type[2]?a.find("iframe").css({height:parseFloat(t.height)-c-f}):s.css({height:parseFloat(t.height)-c-f-parseFloat(s.css("padding-top"))-parseFloat(s.css("padding-bottom"))}))},s.min=function(e,t){var a=i("#"+l[0]+e),r=a.find(l[1]).outerHeight()||0,c=a.attr("minLeft")||181*o.minIndex+"px",f=a.css("position");o.record(a),o.minLeft[0]&&(c=o.minLeft[0],o.minLeft.shift()),a.attr("position",f),s.style(e,{width:180,height:r,left:c,top:n.height()-r,position:"fixed",overflow:"hidden"},!0),a.find(".layui-layer-min").hide(),"page"===a.attr("type")&&a.find(l[4]).hide(),o.rescollbar(e),a.attr("minLeft")||o.minIndex++,a.attr("minLeft",c)},s.restore=function(e){var t=i("#"+l[0]+e),n=t.attr("area").split(",");t.attr("type"),s.style(e,{width:parseFloat(n[0]),height:parseFloat(n[1]),top:parseFloat(n[2]),left:parseFloat(n[3]),position:t.attr("position"),overflow:"visible"},!0),t.find(".layui-layer-max").removeClass("layui-layer-maxmin"),t.find(".layui-layer-min").show(),"page"===t.attr("type")&&t.find(l[4]).show(),o.rescollbar(e)},s.full=function(e){var t,a=i("#"+l[0]+e);o.record(a),l.html.attr("layer-full")||l.html.css("overflow","hidden").attr("layer-full",e),clearTimeout(t),t=setTimeout(function(){var t="fixed"===a.css("position");s.style(e,{top:t?0:n.scrollTop(),left:t?0:n.scrollLeft(),width:n.width(),height:n.height()},!0),a.find(".layui-layer-min").hide()},100)},s.title=function(e,t){var n=i("#"+l[0]+(t||s.index)).find(l[1]);n.html(e)},s.close=function(e){var t=i("#"+l[0]+e),n=t.attr("type"),a="layer-anim-close";if(t[0]){var r="layui-layer-wrap",c=function(){if(n===o.type[1]&&"object"===t.attr("conType")){t.children(":not(."+l[5]+")").remove();for(var a=t.find("."+r),s=0;s<2;s++)a.unwrap();a.css("display",a.data("display")).removeClass(r)}else{if(n===o.type[2])try{var c=i("#"+l[4]+e)[0];c.contentWindow.document.write(""),c.contentWindow.close(),t.find("."+l[5])[0].removeChild(c)}catch(f){}t[0].innerHTML="",t.remove()}"function"==typeof o.end[e]&&o.end[e](),delete o.end[e]};t.data("isOutAnim")&&t.addClass("layer-anim "+a),i("#layui-layer-moves, #layui-layer-shade"+e).remove(),6==s.ie&&o.reselect(),o.rescollbar(e),t.attr("minLeft")&&(o.minIndex--,o.minLeft.push(t.attr("minLeft"))),s.ie&&s.ie<10||!t.data("isOutAnim")?c():setTimeout(function(){c()},200)}},s.closeAll=function(e){i.each(i("."+l[0]),function(){var t=i(this),n=e?t.attr("type")===e:1;n&&s.close(t.attr("times")),n=null})};var c=s.cache||{},f=function(e){return c.skin?" "+c.skin+" "+c.skin+"-"+e:""};s.prompt=function(e,t){var a="";if(e=e||{},"function"==typeof e&&(t=e),e.area){var o=e.area;a='style="width: '+o[0]+"; height: "+o[1]+';"',delete e.area}var r,l=2==e.formType?'<textarea class="layui-layer-input"'+a+">"+(e.value||"")+"</textarea>":function(){return'<input type="'+(1==e.formType?"password":"text")+'" class="layui-layer-input" value="'+(e.value||"")+'">'}(),c=e.success;return delete e.success,s.open(i.extend({type:1,btn:["&#x786E;&#x5B9A;","&#x53D6;&#x6D88;"],content:l,skin:"layui-layer-prompt"+f("prompt"),maxWidth:n.width(),success:function(e){r=e.find(".layui-layer-input"),r.focus(),"function"==typeof c&&c(e)},resize:!1,yes:function(i){var n=r.val();""===n?r.focus():n.length>(e.maxlength||500)?s.tips("&#x6700;&#x591A;&#x8F93;&#x5165;"+(e.maxlength||500)+"&#x4E2A;&#x5B57;&#x6570;",r,{tips:1}):t&&t(n,i,r)}},e))},s.tab=function(e){e=e||{};var t=e.tab||{},n="layui-this",a=e.success;return delete e.success,s.open(i.extend({type:1,skin:"layui-layer-tab"+f("tab"),resize:!1,title:function(){var e=t.length,i=1,a="";if(e>0)for(a='<span class="'+n+'">'+t[0].title+"</span>";i<e;i++)a+="<span>"+t[i].title+"</span>";return a}(),content:'<ul class="layui-layer-tabmain">'+function(){var e=t.length,i=1,a="";if(e>0)for(a='<li class="layui-layer-tabli '+n+'">'+(t[0].content||"no content")+"</li>";i<e;i++)a+='<li class="layui-layer-tabli">'+(t[i].content||"no  content")+"</li>";return a}()+"</ul>",success:function(t){var o=t.find(".layui-layer-title").children(),s=t.find(".layui-layer-tabmain").children();o.on("mousedown",function(t){t.stopPropagation?t.stopPropagation():t.cancelBubble=!0;var a=i(this),o=a.index();a.addClass(n).siblings().removeClass(n),s.eq(o).show().siblings().hide(),"function"==typeof e.change&&e.change(o)}),"function"==typeof a&&a(t)}},e))},s.photos=function(t,n,a){function o(e,t,i){var n=new Image;return n.src=e,n.complete?t(n):(n.onload=function(){n.onload=null,t(n)},void(n.onerror=function(e){n.onerror=null,i(e)}))}var r={};if(t=t||{},t.photos){var l=t.photos.constructor===Object,c=l?t.photos:{},d=c.data||[],u=c.start||0;r.imgIndex=(0|u)+1,t.img=t.img||"img";var p=t.success;if(delete t.success,l){if(0===d.length)return s.msg("&#x6CA1;&#x6709;&#x56FE;&#x7247;")}else{var h=i(t.photos),y=function(){d=[],h.find(t.img).each(function(e){var t=i(this);t.attr("layer-index",e),d.push({alt:t.attr("alt"),pid:t.attr("layer-pid"),src:t.attr("layer-src")||t.attr("src"),thumb:t.attr("src")})})};if(y(),0===d.length)return;if(n||h.on("click",t.img,function(){var e=i(this),n=e.attr("layer-index");s.photos(i.extend(t,{photos:{start:n,data:d,tab:t.tab},full:t.full}),!0),y()}),!n)return}r.imgprev=function(e){r.imgIndex--,r.imgIndex<1&&(r.imgIndex=d.length),r.tabimg(e)},r.imgnext=function(e,t){r.imgIndex++,r.imgIndex>d.length&&(r.imgIndex=1,t)||r.tabimg(e)},r.keyup=function(e){if(!r.end){var t=e.keyCode;e.preventDefault(),37===t?r.imgprev(!0):39===t?r.imgnext(!0):27===t&&s.close(r.index)}},r.tabimg=function(e){if(!(d.length<=1))return c.start=r.imgIndex-1,s.close(r.index),s.photos(t,!0,e)},r.event=function(){r.bigimg.hover(function(){r.imgsee.show()},function(){r.imgsee.hide()}),r.bigimg.find(".layui-layer-imgprev").on("click",function(e){e.preventDefault(),r.imgprev()}),r.bigimg.find(".layui-layer-imgnext").on("click",function(e){e.preventDefault(),r.imgnext()}),i(document).on("keyup",r.keyup)},r.loadi=s.load(1,{shade:!("shade"in t)&&.9,scrollbar:!1}),o(d[u].src,function(n){s.close(r.loadi),r.index=s.open(i.extend({type:1,id:"layui-layer-photos",area:function(){var a=[n.width,n.height],o=[i(e).width()-100,i(e).height()-100];if(!t.full&&(a[0]>o[0]||a[1]>o[1])){var s=[a[0]/o[0],a[1]/o[1]];s[0]>s[1]?(a[0]=a[0]/s[0],a[1]=a[1]/s[0]):s[0]<s[1]&&(a[0]=a[0]/s[1],a[1]=a[1]/s[1])}return[a[0]+"px",a[1]+"px"]}(),title:!1,shade:.9,shadeClose:!0,closeBtn:!1,move:".layui-layer-phimg img",moveType:1,scrollbar:!1,moveOut:!0,isOutAnim:!1,skin:"layui-layer-photos"+f("photos"),content:'<div class="layui-layer-phimg"><img src="'+d[u].src+'" alt="'+(d[u].alt||"")+'" layer-pid="'+d[u].pid+'"><div class="layui-layer-imgsee">'+(d.length>1?'<span class="layui-layer-imguide"><a href="javascript:;" class="layui-layer-iconext layui-layer-imgprev"></a><a href="javascript:;" class="layui-layer-iconext layui-layer-imgnext"></a></span>':"")+'<div class="layui-layer-imgbar" style="display:'+(a?"block":"")+'"><span class="layui-layer-imgtit"><a href="javascript:;">'+(d[u].alt||"")+"</a><em>"+r.imgIndex+"/"+d.length+"</em></span></div></div></div>",success:function(e,i){r.bigimg=e.find(".layui-layer-phimg"),r.imgsee=e.find(".layui-layer-imguide,.layui-layer-imgbar"),r.event(e),t.tab&&t.tab(d[u],e),"function"==typeof p&&p(e)},end:function(){r.end=!0,i(document).off("keyup",r.keyup)}},t))},function(){s.close(r.loadi),s.msg("&#x5F53;&#x524D;&#x56FE;&#x7247;&#x5730;&#x5740;&#x5F02;&#x5E38;<br>&#x662F;&#x5426;&#x7EE7;&#x7EED;&#x67E5;&#x770B;&#x4E0B;&#x4E00;&#x5F20;&#xFF1F;",{time:3e4,btn:["&#x4E0B;&#x4E00;&#x5F20;","&#x4E0D;&#x770B;&#x4E86;"],yes:function(){d.length>1&&r.imgnext(!0,!0)}})})}},o.run=function(t){i=t,n=i(e),l.html=i("html"),s.open=function(e){var t=new r(e);return t.index}},e.layui&&layui.define?(s.ready(),layui.define("jquery",function(t){s.path=layui.cache.dir,o.run(layui.$),e.layer=s,t("layer",s)})):"function"==typeof define&&define.amd?define(["jquery"],function(){return o.run(e.jQuery),s}):function(){o.run(e.jQuery),s.ready()}()}(window),function(e,t,i){var n=e();e.fn.dropdownHover=function(i){return n=n.add(this.parent()),this.each(function(){var i,a=e(this).parent(),o={delay:500,instantlyCloseOthers:!0},s={delay:e(this).data("delay"),instantlyCloseOthers:e(this).data("close-others")},r=e.extend(!0,{},o,r,s);a.hover(function(){r.instantlyCloseOthers===!0&&n.removeClass("open"),t.clearTimeout(i),e(this).addClass("open")},function(){i=t.setTimeout(function(){a.removeClass("open")},r.delay)})})},e('[data-hover="dropdown"]').dropdownHover()}(jQuery,this),$(function(){var e=window.screen.height-200;$("#page-wrapper").css("min-height",e+"px"),$(window).bind("load resize",function(){var e=50,t=this.window.innerWidth>0?this.window.innerWidth:this.screen.width;t<768?($("div.navbar-collapse").addClass("collapse"),e=100):$("div.navbar-collapse").removeClass("collapse");var i=(this.window.innerHeight>0?this.window.innerHeight:this.screen.height)-1;i-=e,i<1&&(i=1)}),$(document).on("click",".sidebar-toggle",function(e){if(!$(this).hasClass("unclickable")){var t=".adaptive .navbar-collapse",i="#page-wrapper";$(this).hasClass("open")?($(t).hide(),$(i).css("margin-left","0px"),$(this).removeClass("open")):($(t).show(),$(i).css("margin-left","180px"),$(this).addClass("open"))}});for(var t=window.location,i=$("ul.nav a").filter(function(){return this.href==t}).addClass("active").parent();;){if(!i.is("li"))break;i=i.parent().addClass("in").parent()}}),$(function(){});
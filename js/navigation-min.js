"use strict";!function(){function e(){n.classList.add("menu--active"),r.setAttribute("aria-expanded","true"),i.setAttribute("aria-expanded","true")}function t(){n.classList.remove("menu--active"),r.setAttribute("aria-expanded","false"),i.setAttribute("aria-expanded","false")}function a(){for(var e=this;-1===e.className.indexOf("nav-menu");)"li"===e.tagName.toLowerCase()&&(-1!==e.className.indexOf("focus")?e.className=e.className.replace(" focus",""):e.className+=" focus"),e=e.parentElement}var n=document.querySelector("body"),r=document.getElementById("menu-toggle"),s=document.querySelector(".mobile-nav-overlay"),i=document.getElementById("primary-menu-wrap"),c;i.querySelector("#primary-menu > .content-width").insertAdjacentHTML("beforeend",'<div id="menu-close">╳</div>');var d=document.getElementById("menu-close");r.addEventListener("click",function(){e()}),d.addEventListener("click",function(){t()}),s.addEventListener("click",function(){n.classList.remove("menu--active"),r.setAttribute("aria-expanded","false"),i.setAttribute("aria-expanded","false")});for(var u=i.getElementsByTagName("a"),o=i.getElementsByTagName("ul"),l=0,m=o.length;l<m;l++)o[l].parentNode.setAttribute("aria-haspopup","true");for(l=0,m=u.length;l<m;l++)u[l].addEventListener("focus",a,!0),u[l].addEventListener("blur",a,!0)}();
//# sourceMappingURL=navigation-min.js.map
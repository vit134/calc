$(document).ready(function(){console.log("search");for(var e=$(".js-search-item"),a=$(".js-search-input"),s=0;e.length>s;s++){var r=a.val(),c=e.eq(s).html();-1===c.indexOf(r)&&(r=r.charAt(0).toUpperCase()+r.substr(1));var n='<span class="search__find">'+r+"</span>",t=c.replace(r,n);e.eq(s).html(t)}});
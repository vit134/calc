$(document).ready(function(){console.log("all service page");var e=$(".js-delete-res-btn"),t=$(".js-modal-confirm-delete"),a=$("#modal-delete");e.on("click",function(e){e.preventDefault();var l=$(this).attr("data-res-id"),r=t.attr("href");r=r.split("="),r=r[0]+"="+l,t.attr("href",r),a.modal()})});
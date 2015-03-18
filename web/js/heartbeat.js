$(document).ready(function(){
    $(".sticky").sticky({topSpacing:60});
	$(".knob").knob({
	    'format' : function (value) {
	     	return bytesToSize(value * 1024);
	    }
	});
});

function bytesToSize(bytes) {
   if(bytes == 0) return '0 Byte';
   var k = 1024;
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
   var i = Math.floor(Math.log(bytes) / Math.log(k));
   return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];
}
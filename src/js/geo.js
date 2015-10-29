var Geo = {
	watchId : null,
	running : false,
	currentPos : null,
	currentPosInfo : null,
	statusText : "",
	callback : null,
	
	start : function()
	{
		console.log("Geo.start called");
		if(navigator.geolocation)
		{
			this.setStatusText("(Checker 'litterne...)");
			var timeoutVal = 60000;
  			this.watchId = navigator.geolocation.watchPosition(
    			Geo.newPosition, 
    			Geo.error,
    			{ enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
  			);
		}
		else
			this.setStatusText("(Geolocation not supported)");
		
	},
	stop : function()
	{
		this.callback = null;
		this.running = false;
		this.currentPos = null;
		this.currentPosInfo = null;
		navigator.geolocation.clearWatch(this.watchId);
	},
	newPosition : function(position) // is called from geoapi, this wont work
	{
		//console.log(position);
		Geo.currentPos = position;
		Geo.running = true;
		
		$.ajax({
  			url: 'index.php?q=mingapi_pos',
  			dataType: 'json',
  			type: 'POST',
  			data: {lat: position.coords.latitude, long: position.coords.longitude},
  			success: function(data)
  			{
  				Geo.currentPosInfo = data;
  				if(data.id != 0)
  				{
  					var txt = "(" + data.place + " [" + data.distance + "m])";
  					Geo.setStatusText(txt);	
  				}
  				else
  				{
  					var txt = "(Ukendt [" + data.latitude + "," + data.longitude + "])"; 
  					Geo.setStatusText(txt);
  				}
  				if(Geo.callback != null)
  				{
  					console.log("about to call callback");
  					Geo.callback(Geo.currentPosInfo);	
  				}
  			}
		});
		
		//Geo.setStatusText("Lortehavnen");
	},
	setStatusText : function(txt)
	{
		this.statusText = txt;
		$(".geoInfo").each(function()
		{
			$(this).html(Geo.statusText);
		});
	},
	error : function(error)
	{
		var errors = { 
			1: 'Permission denied',
			2: 'Position unavailable',
			3: 'Request timeout'
		};
  		var txterror = errors[error.code];
  		Geo.setStatusText("(" + txterror + ")");
		console.log(txterror);
	},
	getPosition : function(cb)
	{
		Geo.callback = cb;
		if(Geo.running && Geo.currentPosInfo != null)  // if we already got a position callback immediately
		{
			Geo.callback(Geo.currentPosInfo);
		}
	},
};

(function($){
$(document).ready(function()
{
	//var url = window.location.href;
	//if(url.search('login') != -1)
	//{
		console.log("Geo.running: " + Geo.running);
		if(!Geo.running)
			Geo.start();
		else
			Geo.setStatusText(Geo.statusText);	
	//}
	$('#page').live('pageinit',function(event)
	{
		console.log("Geo.running: " + Geo.running);
		if(!Geo.running)
			Geo.start();
		else
			Geo.setStatusText(Geo.statusText);
	});
});
})(jQuery);

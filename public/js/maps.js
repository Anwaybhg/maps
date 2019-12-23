 

var map; 
var marker = false; 
        

function initMap() {
 
    
    var center = new google.maps.LatLng(19.387971, 72.836758);
 
    var config = {
      center: center, 
      zoom: 12
    };
 
    
    map = new google.maps.Map(document.getElementById('gmap'), config);
 
  
    google.maps.event.addListener(map, 'click', function(event) {                
       
        var clickedLocation = event.latLng;
        
        if(marker === false){
           
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true 
            });
           
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
           
            marker.setPosition(clickedLocation);
        }
        
        setLocation();
    });
}
        

function setLocation(){
    
    var currentLocation = marker.getPosition();
 
    document.getElementById('lat').value = currentLocation.lat(); 
    document.getElementById('long').value = currentLocation.lng(); 
}
        
        

google.maps.event.addDomListener(window, 'load', initMap);
function initMap() {
  Lat = "34.699875";
  Lng = "135.493032";
  LatLng = new google.maps.LatLng(Lat,Lng);
  Lat2 = "34.702485";
  Lng2 = "135.495951";
  LatLng2 = new google.maps.LatLng(Lat,Lng);
  opts = {
    zoom: 15,
    center: LatLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  
    //マップ生成をオブジェクト化
    mapObj = new google.maps.Map(document.getElementById("gmap"), opts);
    gMarkerCenter = drawMarkerCenterInit();
    gMarkerCenter2 = drawMarkerCenterInit2();
}


function drawMarkerCenterInit() {
  var markerImg = new google.maps.MarkerImage(
          "../images/tera2.png",
          new google.maps.Size(45,60),
          new google.maps.Point(0,0),
          new google.maps.Point(22,60)
  );
  var markerCenter = new google.maps.Marker({

    map: mapObj,
    icon:markerImg
  });
  console.log(markerImg)
  return markerCenter;
}

function drawMarkerCenterInit2() {
  var markerCenter2 = new google.maps.Marker({
    map: mapObj,
  });
  return markerCenter2;
}

var key = localStorage.getItem("testEq");
var key1 = sessionStorage.getItem("testEq");
$(window).load(function(){
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address':key,'region':'jp'},
    function(result,status){
        if(status == google.maps.GeocoderStatus.OK){
          mapObj.setCenter(result[0].geometry.location);/*中心を決める*/
          gMarkerCenter.setPosition(result[0].geometry.location);
        };//if
    });//geocode

    geocoder1 = new google.maps.Geocoder();
    geocoder1.geocode({'address':key1,'region':'jp'},
    function(result,status){
        if(status == google.maps.GeocoderStatus.OK){
          //mapObj.setCenter(result[0].geometry.location);
          gMarkerCenter2.setPosition(result[0].geometry.location);
        };//if
    });//geocode
})



placeNameArray = new Array();
i=0;
$(function(){
    $("#button").on("click",function(){
        Lat3 = "34.699875";
        Lng3 = "135.493032";
        LatLng3 = new google.maps.LatLng(Lat3,Lng3);
        var val = $('input[name=mapInfo]').val();
        placeNameArray[i] = val;
        // console.log(placeNameArray[i]);
        // console.log(placeNameArray.length)
        $("#output ol").append("<li>" + val + "</li>");
        var gMarkerCenter3 = new google.maps.Marker({
          map: mapObj,
          animation:google.maps.Animation.DROP
        });
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address':val,'region':'jp'},
        function(result,status){
            if(status == google.maps.GeocoderStatus.OK){
              mapObj.setCenter(result[0].geometry.location);/*中心を決める*/
              gMarkerCenter3.setPosition(result[0].geometry.location);
            };//if
        });//geocode
        i ++;
    })
    $("#button1").on("click",function(){
      $("#output ol").empty();
      mapObj = new google.maps.Map(document.getElementById("gmap"), opts);
      var key = localStorage.getItem("testEq");
      var key1 = sessionStorage.getItem("testEq");
      geocoder = new google.maps.Geocoder();
      geocoder.geocode({'address':key,'region':'jp'},
      function(result,status){
          if(status == google.maps.GeocoderStatus.OK){
            mapObj.setCenter(result[0].geometry.location);/*中心を決める*/
            gMarkerCenter.setPosition(result[0].geometry.location);
          };//if
      });//geocode

      geocoder1 = new google.maps.Geocoder();
      geocoder1.geocode({'address':key1,'region':'jp'},
      function(result,status){
          if(status == google.maps.GeocoderStatus.OK){
            //mapObj.setCenter(result[0].geometry.location);
            gMarkerCenter2.setPosition(result[0].geometry.location);
          };//if
      });//geocode
      gMarkerCenter = drawMarkerCenterInit();
      gMarkerCenter2 = drawMarkerCenterInit2();
    })
})






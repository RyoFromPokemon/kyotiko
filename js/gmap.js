function initMap() {
//緯度・軽度の初期化
  var Lat = "34.699875";
  var Lng = "135.493032";
    var LatLng = new google.maps.LatLng(Lat,Lng);
    var opts = {
        zoom: 18,
        center: LatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    //マップ生成をオブジェクト化
    var mapObj = new google.maps.Map(document.getElementById("gmap"), opts);

    //マーカーの表示
    var markerObj = new google.maps.Marker({
      position:LatLng,
      map:mapObj,
      //icon:markerImg,//アイコン化
      titile:"HAL大阪"
    });

    google.maps.event.addListener(markerObj,"click",function(){
      alert("マーカークリック！");
      //html文字列を作成
      var html = "<h2>HAL大阪</h2>";
      //infoWindowを作成する
      var infoWindow = new google.maps.InfoWindow();
      infoWindow.setContent(html);
      infoWindow.open(mapObj,markerObj);
    });

    var clickBtn = document.getElementById("shopClick");
    google.maps.event.addDomListener(clickBtn,"click",function(){
        alert("ハリルをクリックしたよ！");
        var Lat2 = "34.669528";
        var Lng2 = "135.476003";
        var LatLng2 = new google.maps.LatLng(Lat2,Lng2);
        var opts = {
            zoom: 18,
            center: LatLng2,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

      //マップ生成をオブジェクト化
      var mapObj = new google.maps.Map(document.getElementById("gmap"), opts);
    });
}

function drawMarkerCenterInit() {
  var markerCenter = new google.maps.Marker({
    map: mapObj,
  });
  return markerCenter;
}



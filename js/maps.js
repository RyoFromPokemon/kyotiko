function initMap() {
  //緯度・軽度の初期化
  Lat = "34.699875";
  Lng = "135.493032";
  LatLng = new google.maps.LatLng(Lat,Lng);
  opts = {
    zoom: 18,
    center: LatLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  //マップ生成をオブジェクト化
  mapObj = new google.maps.Map(document.getElementById("gmap"), opts);
  //マーカー生成をオブジェクト化
  gMarkerCenter = drawMarkerCenterInit(LatLng);
}     

//マーカー生成関数
function drawMarkerCenterInit() {
  var markerCenter = new google.maps.Marker({
    map: mapObj,
  });
  return markerCenter;
}


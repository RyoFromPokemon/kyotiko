function initMap() {
  console.log("initMap")
  //緯度・軽度の初期化
  Lat = "34.699875";
  Lng = "135.493032";
  LatLng = new google.maps.LatLng(Lat,Lng);
  opts = {
    zoom: 17,
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


$(function(){
  $("body").click(function(){
    $("#cont_detail").empty();
    $("#gmap").css("display","none");
  })
  $(".photoIn").click(function(){
    $("#cont_detail").empty();
    $("#bgBox")
    .show()
    .css({
      "height":"100%",
      "width":"100vw",
      "background-color":"black",
      "opacity":"0.5",
      "position":"absolute",
      "top":"0",
      "left":"0",
      "z-index":"1"
    })
  $("#bgBox").click(function(){
    $("#bgBox").hide();
  })
  testEq = $(this).index();
  $.ajax({
    url:'../searchJson.php',
      dataType:'text',
      success:function(dataIn){
        jsonObj = JSON.parse(dataIn);
        console.log(jsonObj)
        checkPlace = jsonObj.photoDetail[testEq].tourist;
        console.log(checkPlace)
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address':checkPlace,'region':'jp'},
        function(result,status){
            if(status == google.maps.GeocoderStatus.OK){
              mapObj.setCenter(result[0].geometry.location);
              gMarkerCenter.setPosition(result[0].geometry.location);
          };//if
        });//geocode
        $("#cont_detail").append("<div id=\"contItem\"></div>") ;
            $("#contItem").append("<p><img src='../images/"+ jsonObj.photoDetail[testEq].photo + "'></p>") ;
            $("#contItem").append("<div id=\"itemInfo\"></div>") ;
              $("#itemInfo").append("<div id=\"userInfo\"></div>") ;
                $("#contItem #itemInfo #userInfo").append("<p><img src='../images/" + jsonObj.photoDetail[testEq].picture + "'</p>") ;
                $("#contItem #itemInfo #userInfo").append("<h3>" + jsonObj.photoDetail[testEq].user_name + "</h3>") ;
              $("#contItem #itemInfo").append("<p id='shopName'>お店の名前：" + jsonObj.photoDetail[testEq].shop_name + "</p>") ;
              $("#contItem #itemInfo").append("<p>近くの観光地：" + jsonObj.photoDetail[testEq].tourist + "</p>") ;
              $("#gmap").css({
                  "display":"block",
                  "position":"absolute",
                  "top":"390px",
                  "right":"180px",
                  "z-index":"2000"}
              );
            $("#contItem")
            .css({
              "width":"900px",
              "height":"550px",
              "background-color":"white",
              "position":"absolute",
              "top":"50%",
              "left":"50%",
              "display":"flex",
              "margin":"-250px 0px 0px -440px",
              "z-index":"1000"
            });
            $("#contItem img:first-child")
            .css({
              "width":"550px",
              "height":"550px"
            });
            $("#itemInfo")
            .css({
              "width":"100%",
              "padding":"10px"
            })
            $("#userInfo")
            .css({
              "width":"100%",
              "display":"flex",
              "justify-content":"left",
              "align-items":"center",
              "border-bottom":"solid 1px lightgray"
            })
            $("#userInfo p")
            .css({
              "margin-left":"10px"
            })
            $("#userInfo h3")
            .css({
              "font-size":"1.2em",
              "margin-left":"10px"
            })
            $("#contItem #itemInfo img")
            .css({
              "width":"50px",
              "height":"50px",
              "border-radius":"50px"
            })
            $("#itemInfo #shopName")
            .css({
              "margin-top":"10px"
            })
            //css
        },//success
        error: function(dataIn){
          console.log("エラー")
        }
  });//ajax
  });//click
});
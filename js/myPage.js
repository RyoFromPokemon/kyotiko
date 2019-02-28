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
      "backgroundSize":"cover",
      "opacity":"0.5",
      "position":"fixed",
      "top":"0",
      "left":"0",
      "z-index":"1"
    })
  $("#bgBox").click(function(){
    $("#bgBox").hide();
  })
  testEq = $(this).index();
  $.ajax({
    url:'../json.php',
      dataType:'text',
      success:function(dataIn){
        jsonObj = JSON.parse(dataIn);
        console.log(jsonObj)
        json = jsonObj.photoDetail[testEq];
        checkPlace = json.tourist;
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
          $("#contItem").append("<p><img src='../images/"+ json.photo + "'></p>") ;
          $("#contItem").append("<div id=\"itemInfo\"></div>") ;
            $("#itemInfo").append("<div id=\"userInfo\"></div>") ;
              $("#contItem #itemInfo #userInfo").append("<p><img src='../images/" + json.picture + "'</p>") ;
              $("#contItem #itemInfo #userInfo").append("<h3>" + json.user_name + "</h3>") ;
            $("#itemInfo").append("<div id=\"infoDetail\"></div>") ;
              $("#contItem #itemInfo #infoDetail")
                .append(
                  "<p id='shopName'>お店の名前：" + json.shop_name + "</p>") ;
              $("#contItem #itemInfo #infoDetail")
                .append("<p id='shopUrl'>お店のURL：<a href='json.shop_url'>" + json.shop_url + "</a></p>") ;
              $("#contItem #itemInfo #infoDetail").append("<p>近くの観光地：" + json.tourist + "</p>") ;
              $("#contItem #itemInfo #infoDetail").append("<p>近くの観光地：" + json.tourist + "</p>") ;
              $("#contItem #itemInfo #infoDetail").append("<p>近くの観光地：" + json.tourist + "</p>") ;
              $("#contItem #itemInfo #infoDetail").append("<p>近くの観光地：" + json.tourist + "</p>") ;
              $("#contItem #itemInfo #infoDetail").append("<p>近くの観光地：" + json.tourist + "</p>") ;
            $("#gmap")
              .css({
                "display":"block",
                "position":"fixed",
                "top":"460px",
                "right":"210px",
                "z-index":"2000"}
              );
            //$("#contItem #itemInfo").append("<div id='gmap'></div>");
            //$("#contItem #itemInfo")
              //.append("<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBWL3ftdFyjayPW47hTxBgan9ONt6gop1Y&callback=initMap' async defer></script>");
          $("#contItem")
          .css({
            "width":"1050px",
            "height":"550px",
            "background-color":"white",
            "position":"fixed",
            "top":"50%",
            "left":"50%",
            "display":"flex",
            "margin":"-250px 0px 0px -520px",
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
            "height":"54%",
            "padding":"10px",
            "backgroundColor":"red"
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
            "margin-top":"5px"
          })
          $("#infoDetail")
          .css({
            "width":"100%",
            "height":"54%",
            "backgroundColor":"blue",
            "overflow":"scroll"
          })
          //css
        },//success
        error: function(dataIn){
          console.log("エラー")
        }
  });//ajax
  });//click
});







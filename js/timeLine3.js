
function initMap() {
    //緯度・軽度の初期化
    var Lat = "34.69987";//緯度の情報を変数に格納
    var Lng = "135.493032";//軽度の情報を変数に格納
        var LatLng = new google.maps.LatLng(Lat,Lng);//数値情報を使える情報に変換
        //以降、オプション
        var opts = {
            zoom: 18,//表示倍率
            center: LatLng,//中心地
            mapTypeId: google.maps.MapTypeId.ROADMAP//グラフィックも表示状態
        }

        //マップ生成をオブジェクト化
        var mapObj = new google.maps.Map(document.getElementById("gmap"), opts);//gooleMap生成のメソッドをmapObjに格納
        //マーカーを画像に変換
        
        var markerImg = new google.maps.MarkerImage(//画像マーカーの表示処理を変数markerImgに格納
          //画像のURL
          "../images/gmap_marker.png",
          //マーカーのサイズ
          new google.maps.Size(45,60),
          //画像の基準位置
          new google.maps.Point(0,0),
          //Anchorポイント
          new google.maps.Point(22,60)

        );

        //オリジナル画像マーカーの生成処理をmarkerObjに格納
        var markerObj = new google.maps.Marker({
          position:LatLng,
          map:mapObj,
          icon:markerImg,
          title:"HAL東京"
        });
        
        //マーカーへクリックイベントを設定
        google.maps.event.addListener(markerObj,"click",function(){
          alert("マーカークリック！");
          //html文字列を作成
          var html = "<h2>HAL大阪</h2>";
          //infoWindowを作成する
          var infoWindow = new google.maps.InfoWindow();
          infoWindow.setContent(html);//内容を登録
          infoWindow.open(mapObj,markerObj);//openメソッドで表示。
        })  
}

$(function(){
  // jsonファイルから持ってきたデータを表示
	$.ajax({
    url　: '../json/document.json',
      dataType : 'json',
      success　: function(data){
      // ループでjsonのデータを１つずつ取り出す
        for(i=0;i<data.recomendMeals.length;i++){
          $("#data_list ul").append("<div id=\"data_id" + i + "\" class='polaroid'></div>") ;
          $("#data_list #data_id"+i)
            .append("<li><img src='" + data.recomendMeals[i].mealImg + "'></li>")
            var imgWidth = $("#data_list #data_id"+i).width();
            var imgHeight = imgWidth*1.5;
            $("#data_list #data_id"+i).css("height",imgHeight);
            $("#data_list img").css({"width":imgWidth,"height":imgHeight,"object-fit":"cover"});
            $("#data_list #data_id"+i).click(function(){
              var testId = $(this).attr("id").slice(-1);
              $.ajax({
                url:'../json/document.json',
                dataType:'json',
                  success　:function(dataIn){
                    testDiv = "<div> id='gmap'></div>"; 
                    $("#data_detail").append("<div id=\"detailItem\"></div>") ;
                    $("#detailItem").append("<p><img src='" + dataIn.recomendMeals[testId].mealImg + "'></p>") ;
                    $("#detailItem").append("<h3>" + dataIn.recomendMeals[testId].placeName + "</h3>") ;
                    $("#detailItem").append("<div id='gmap'></div>");
                    $("#detailItem").append("<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBWL3ftdFyjayPW47hTxBgan9ONt6gop1Y&callback=initMap' async defer></script>"
);
                    $("#detailItem")
                    .css({
                      "width":"550px",
                      "height":"550px",
                      "background-color":"white",
                      "position":"absolute",
                      "top":"50%",
                      "left":"50%",
                      "margin":"-275px 0px 0px -275px"
                    })
                  },
                  error: function(data){
                    console.log("エラー")
                  }
              })//ajax
            })//click(function()
          };//for
        },//success
        error: function(data){
          console.log("エラー")
        }
  });//ajax
});//function

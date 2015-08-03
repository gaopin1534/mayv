<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title></title>
<script src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
  var loginFlg = <?=($userId)?1:0?>;
  $(document).ready(function(){
    if(loginFlg != 1){
      $('.wannaSee').click(function(event){
          event.preventDefault();
          $(this).blur();
          if($("#modal-overlay")[0]) return false ;
          $("body").append('<div id="modal-overlay"></div>');
          $("#modal-overlay").fadeIn("slow");
          centeringModalSyncer();
          $("#modal-content").fadeIn("slow");
          $("#modal-overlay,#modal-close").unbind().click(function(){
              $("#modal-content,#modal-overlay").fadeOut("slow",function(){
              $("#modal-overlay").remove();
            });
          });
      });
    }
    $(window).resize(centeringModalSyncer) ;

  });
 function centeringModalSyncer(){
    var w = $(window).width() ;
    var h = $(window).height() ;
    var cw = $( "#modal-content" ).outerWidth( {margin:true} );
    var ch = $( "#modal-content" ).outerHeight( {margin:true} );
    $( "#modal-content" ).css( {"left": ((w - cw)/2) + "px","top": ((h - ch)/2) + "px"} ) ;
  }

</script>
<style type="text/css">
.button{
  width:150px;
  font-size: 25px;
  text-align: center;
  background-color:#87CEEB;
  border-radius:15px;
  display:block;
}
.button:hover{
  background-color:#478EAB;
  color:#DFDFDF;
}
.button a{
  display:block;
  height:100%;
  width:100%;
  text-decoration: none;
  color:white;
}
#modal-content{
  width: 50% ;
  margin: 0 ;
  padding: 10px 20px ;
  border: 2px solid #aaa ;
  background: #fff ;
  position: fixed ;
  display: none ;
  z-index: 2 ;
}
#modal-overlay{
  z-index: 1 ;
  display: none ;
  position: fixed ;
  top: 0 ;
  left: 0 ;
  width: 100% ;
  height: 120% ;
  background-color: rgba( 0,0,0, 0.75 ) ;
}
</style>
</head>
<body>
<?=$login?><br>
<div id="modal-content">
  <p>ログインしてください</p>
  <p><a id="modal-close" class="button-link">閉じる</a></p>
</div>
<table>
  <tr>
    <th>No.</th>
    <th>映画名</th>
    <th>投票日</th>
  </tr>
  <?php
  $index = 0;
  foreach($form["votes"] as $key => $value) {
    $index++;
  ?>
  <tr>
    <td><?=$index?></td>
    <td><a href="../movie_detail/movie_detail.php?movie_id=<?=$value["movie_id"]?>"><?=$value["original_name"]?></a></td>
    <td><?=dateUtil::listDateFormat($value["vote_date"])?></td>
  </tr>
  <?php
  if($index == 20){break;}
  } ?>
</table>

</body>
</html>


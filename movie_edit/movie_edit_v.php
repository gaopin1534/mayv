<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8" />
<title></title>
<script src="js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

</script>
<style type="text/css">
.button{
  width:150px;
  font-size: 25px;
  text-align: center;
  background-color:#87CEEB;
  border-radius:15px;
  display:block;
  height:40px;
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

</style>
</head>
<body>
<form name="form1" action="movie_edit.php?mode=submit&movie_id=<?=$_REQUEST["movie_id"]?>" method="post" accept-charset="utf-8">
<table>
    <tr><th>ID</th><td><?=$form["movie_info"]['movie_id']?></td></tr>
    <tr><th>映画名</th><td><input type="text" name="movie_name" value="<?=$form["movie_info"]['movie_name']?>"></td></tr>
    <tr><th>概要</th><td><input type="text" name="outline" value="<?=$form["movie_info"]['outline']?>"></td></tr>
    <tr><th>監督</th><td><input type="text" name="directer" value="<?=$form["movie_info"]['directer']?>"></td></tr>
    <tr><th>説明</th><td><input type="text" name="explanation" value="<?=$form["movie_info"]['explanation']?>"></td></tr>
    <tr><th>米公開日</th><td><input type="text" name="us_published" value="<?=$form["movie_info"]['us_published']?>"></td></tr>
    <tr><th>日公開日</th><td><input type="text" name="jp_published" value="<?=$form["movie_info"]['jp_published']?>"></td></tr>
    <tr><th>時間</th><td><input type="text" name="duration" value="<?=$form["movie_info"]['duration']?>"></td></tr>
    <tr><th>英語タイトル</th><td><input type="text" name="original_name" value="<?=$form["movie_info"]['original_name']?>"></td></tr>
    <tr><th>ビデオ</th><td><input type="text" name="video_url" value="<?=$form["movie_info"]['video_url']?>"></td></tr>
    <tr><th>総売上</th><td><input type="text" name="total_sales" value="<?=$form["movie_info"]['total_sales']?>"></td></tr>
    <tr><th>役者１</th><td><input type="text" name="actor_name1" value="<?=$form["movie_info"]['actor_name1']?>"></td></tr>
    <tr><th>役者２</th><td><input type="text" name="actor_name2" value="<?=$form["movie_info"]['actor_name2']?>"></td></tr>
</table>
<div class="button"><a href="javascript:document.form1.submit();">送信</a></div>
<div class="button"><a href="edit_index.php">戻る</a></div>

</form>
</body>
</html>


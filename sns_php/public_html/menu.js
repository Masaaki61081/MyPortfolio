let over_flg;
$(function () {
  $('.header_userinfo_icon').click(function() {
    // メニュー表示/非表示
    $('.menu').slideToggle(60);
  });

  //　マウスカーソルの位置（メニュー上/メニュー外）
  $('.header_userinfo').hover(function(){
    over_flg = true;
  }, function(){
    over_flg = false;
  });

  // メニュー領域外をクリックしたらメニューを閉じる
  $('body').click(function() {
    if (over_flg === false) {
      $('.menu').slideUp(60);
    }
  });
});

<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Main extends Controller {
  public function __construct() {
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function delete() {
    wtfTo('MainIndex');
    
    $obj = null;

    validator(function() use (&$obj) {
      $deleteTime = Session::getData('deleteTime');
      $deleteTime && time() < $deleteTime + 10 && error('太快了，請等 10 秒後再刪除吧！');
      
      $obj = \M\Message::one('id = ?', Router::params('id'));
      $obj || error('找不到資料');
    });

    transaction(function() use (&$obj) {
      return $obj->delete();
    });

    Session::setData('deleteTime', time());
    Url::refreshWithSuccessFlash(Url::toRouter('MainIndex'), '刪除成功！');
  }

  public function submit() {
    wtfTo('MainIndex');

    $params = Input::post();

    validator(function() use (&$params) {
      $createTime = Session::getData('createTime');

      $createTime && time() < $createTime + 10 && error('太快了，請等 10 秒後再留言吧！');

      Validator::need($params, 'title', '標題')->isVarchar(190);
      Validator::need($params, 'content', '內容')->isVarchar(190);
    });

    transaction(function() use (&$params) {
      return \M\Message::create($params);
    });

    Session::setData('createTime', time());

    Url::refreshWithSuccessFlash(Url::toRouter('MainIndex'), '新增成功！');
  }

  public function index() {
    $flash = Session::getFlashData('flash');
    !isset($flash['params']) || $flash['params'] || $flash['params'] = null;

    return View::create('site/Main/index.php')
               ->with('flash', $flash);
  }
}

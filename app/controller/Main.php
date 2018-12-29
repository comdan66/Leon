<?php defined('MAPLE') || exit('此檔案不允許讀取！');

class Main extends Controller {
  public function __construct() {
    Load::sysLib('Session.php');
    Load::sysLib('Validator.php');
  }

  public function delete() {
    wtfTo('MainIndex');
    
    transaction(function() {
      $obj = \M\Message::one('id = ?', Router::params('id'));
      $obj || error('找不到資料');
      return $obj->delete();
    });

    Url::refreshWithSuccessFlash(Url::toRouter('MainIndex'), '刪除成功！');
  }

  public function submit() {
    wtfTo('MainIndex');

    $params = Input::post();

    validator(function() use (&$params) {
      Validator::need($params, 'title', '標題')->isVarchar(190);
      Validator::need($params, 'content', '內容')->isVarchar(190);
    });

    transaction(function() use (&$params) {
      return \M\Message::create($params);
    });

    Url::refreshWithSuccessFlash(Url::toRouter('MainIndex'), '新增成功！');
  }

  public function index() {
    $flash = Session::getFlashData('flash');
    !isset($flash['params']) || $flash['params'] || $flash['params'] = null;

    return View::create('site/Main/index.php')
               ->with('flash', $flash);
  }
}

<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('')->controller('Main@index');
Router::get('delete/(id:num)')->controller('Main@delete');
Router::post('submit')->controller('Main@submit');

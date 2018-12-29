<?php defined('MAPLE') || exit('此檔案不允許讀取！');

Router::get('')->controller('Main@index');
Router::post('submit')->controller('Main@submit');

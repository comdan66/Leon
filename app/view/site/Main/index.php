<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>Leon 留言板</title>
    <style type="text/css">
      *, *:after, *:before {
        vertical-align: top;
        -webkit-box-sizing: border-box;
           -moz-box-sizing: border-box;
                box-sizing: border-box;
      }

      .row, .buttons {
        display: block;
        width: 300px;
      }
      .row input, .row textarea {
        width: 100%;
        border: 1px solid rgba(200, 200, 200, 1.00);
        color: rgba(120, 120, 120, 1.00);
        -webkit-border-radius: 2px;
           -moz-border-radius: 2px;
                border-radius: 2px;
      }
      .row input {
        height: 30px;
        line-height: 30px;
        padding: 0 8px;
        border: 1px solid rgba(200, 200, 200, 1.00);

      }
      .row textarea {
        height: 88px;
        line-height: 22px;
        padding: 4px;
      }
      .row input:focus, .row textarea:focus {
        outline: 0;
        border: 1px solid rgba(100, 175, 235, 1.00);
        -webkit-box-shadow: 0 0 8px rgba(100, 175, 235, 0.6);
           -moz-box-shadow: 0 0 8px rgba(100, 175, 235, 0.6);
                box-shadow: 0 0 8px rgba(100, 175, 235, 0.6);
      }
      .row + .row {
        margin-top: 8px;
      }
      
      .buttons {
        border-top: 1px solid rgba(180, 180, 180, 1.00);
        margin-top: 16px;
        padding-top: 16px;
        text-align: right;
        margin-bottom: 16px;
      }
      .buttons > * {
        cursor: pointer;
      }

      .messages {
        display: inline-block;
        width: 100%;
        margin-top: 16px;
      }
      .messages .message {
        position: relative;
        display: block;
        width: 300px;
        padding: 8px 16px;
        border: 1px solid rgba(23, 171, 196, 1.00);
        background-color: rgba(235, 255, 251, 1.00);
        
        -webkit-border-radius: 3px;
           -moz-border-radius: 3px;
                border-radius: 3px;
      }
      .messages .message + .message {
        margin-top: 8px;
      }
      .messages .message > * {
        display: inline-block;
        width: 100%;
      }
      .messages .message span {
        font-size: 14px;
        padding-bottom: 4px;
        color: rgba(50, 50, 50, 1);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      .messages .message div {
        font-size: 14px;
        border-top: 1px solid rgba(180, 180, 180, 1);
        border-bottom: 1px solid rgba(180, 180, 180, 1);
        padding: 8px 0;
        color: rgba(111, 111, 111, 1);
      }
      .messages .message time {
        font-size: 10px;
        text-align: right;
      }
      .messages .message a {
        text-decoration: none;

        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        line-height: 18px;
        font-size: 14px;
        text-align: center;

        -webkit-border-radius: 3px;
           -moz-border-radius: 3px;
                border-radius: 3px;

        border: 1px solid rgba(255, 0, 0, .3);
        background-color: rgba(255, 0, 0, .3);
        color: rgba(175, 38, 38, 1.00);

        cursor: pointer;
        filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
        opacity: 0.8;

        -webkit-transition: opacity 0.3s;
             -o-transition: opacity 0.3s;
                transition: opacity 0.3s;
      }
      .messages .message a:hover {
        filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=false);
        opacity: 1;
      }
      .flash {
        display: block;
        width: 300px;
        border: 1px solid rgba(255, 0, 0, .3);
        padding: 8px 8px;
        
        text-align: left;

        font-size: 15px;
        line-height: 18px;

        border: 1px solid transparent;
        word-break: break-all;
      }
      .flash:empty {
        display: none;
      }
      .flash.success {
        color: #34708d;
        background-color: #daedf7;
        border-color: #bee8f0;
      }
      .flash.failure {
        color: #a74544;
        background-color: #f2dede;
        border-color: #eaccd1;
      }

    </style>
  </head>
  <body lang="zh-tw">
    <h1>Leon 留言板</h1>
    <hr>
    
    <form action='<?php echo Url::toRouter('MainSubmit');?>' method='post'>
      <label class='row'>
        <div>標題</div>
        <input type='text' name='title' placeholder='請輸入標題，最多 190 個字' maxlength='190' autofocus/>
      </label>

      <label class='row'>
        <div>內容</div>
        <textarea name='content' placeholder='請輸入內容，最多 190 個字' maxlength='190'></textarea>
      </label>

      <div class='buttons'>
        <button type='reset'>重填</button>
        <button type='submit'>送出</button>
      </div>
    </form>
    <hr>
    <div class='flash <?php echo $flash['type'];?>'><?php echo $flash['msg'];?></div>

    <div class='messages'>
      <?php echo implode('', array_map(function($message) {
        $return = '';
        $return .= '<div class="message">';
          $return .= '<span>' . $message->title . '</span>';
          $return .= '<div>' . $message->content . '</div>';
          $return .= '<time>' . $message->createAt->format('Y-m-d H:i:s') . '</time>';
          $return .= '<a href="' . Url::toRouter('MainDelete', $message) . '">x</a>';
        $return .= '</div>';
        return $return;
      }, \M\Message::all(['order' => 'id DESC'])));?>
    </div>

  </body>
</html>

Chat widget
============

Chat widget is called OnChat.

### Usage

1. Put the following code in your view file:

  ```php
  <?php 
  $this->widget('ext.onchat.OnChat', array(
  	'url' => Yii::app()->createUrl("site/chat")
	)); 
  ?><!-- chat -->
  ```
  
2. Put this code in your controller class:

  ```php
  //protected/controllers/SiteController.php
  class SiteController extends CController
  {
      public function actions()
      {
          return array(
              'chat'=>array(
                  'class'=>'ext.onchat.actions.OnChatAction',
              ),
          );
      }
  }
  ```

3. MySql table for chat.

  ```mysql
  CREATE TABLE IF NOT EXISTS `tbl_chat` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(32) NOT NULL,
    `datetime` int(11) NOT NULL,
    `text` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;
  ```

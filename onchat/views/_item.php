<div class="chat-item" item-id="<?php echo $item['id']; ?>">

	<div class="chat-title">
		<span class="chat-user"><?php echo $item['username']; ?></span> 
		<span class="chat-datetime"><?php echo date("H:s, j M. Y", $item['datetime']); ?></span>
	</div>
	
	<div class="chat-text"><?php echo $item['text']; ?></div>
	
</div>
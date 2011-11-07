		<section<?php echo isset($message) ? ' class="message"' : "";?>>
			<hgroup>
				<h1><a href="<?php echo isset($home) ? $home : "/";?>">flickr<span>Queue</span></a></h1>
			</hgroup>
			
			<?php echo $message;?>
		</section>

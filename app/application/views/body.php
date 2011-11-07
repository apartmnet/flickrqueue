		<section<?php echo isset($message) ? ' class="message"' : "";?>>
			<h1><a href="<?php echo isset($home) ? $home : "/";?>">flickr<span>Queue</span></a></h1>
			
			<?php echo $message;?>
			<?php if(isset($photolist)) {
				echo '<div id="photolist">';
				echo "<h2>Photos in your queue</h2>\n";
				echo "<ul>\r\n";
				foreach($photolist as $photo) {
					
					echo '<li><img src="' . $photo['thumb'] . '" width="75" height="75" alt="thumbnail preview" /></li>' . "\r\n";
					
				}
				echo "</ul>\r\n";
				echo "</div>\r\n";
			
			}?>
		</section>

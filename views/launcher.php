
<div class="_launcher">
	<div class="_launcher_items">
		<?php foreach ($items as $item): ?>
			<a href="<?php echo $item['link']; ?>" class="_action">
				<div class="_inside">
					<div class="_icon">
						<div class="_symbol">
							<?php if (isset($item['count']) && $item['count'] > -1): ?>
								<div class="_count">
									<?php echo $item['count']; ?>
								</div>
							<?php endif; ?>
							<i class="fa <?php echo $item['icon']; ?>"></i>
						</div>
					</div>
					<div class="_label"><?php echo $item['label']; ?></div>
				</div>
			</a>
		<?php endforeach; ?>
	</div>
</div>
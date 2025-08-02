<?php

$items = [
	[
		'label' => 'Users',
		'count' => $users['count'],
		'icon' => 'fa-users',
		'link' => '/admin/config.php?display=userman'
	],
	[
		'label' => 'Extensions',
		'count' => $extensions['count'],
		'icon' => 'fa-phone',
		'link' => '/admin/config.php?display=extensions'
	],
	[
		'label' => 'Trunks',
		'count' => $trunks['count'],
		'icon' => 'fa-plug',
		'link' => '/admin/config.php?display=trunks'
	],
	[
		'label' => 'Inbound Routes',
		'count' => $inbound_routes['count'],
		'icon' => 'fa-road',
		'link' => '/admin/config.php?display=did'
	],
	[
		'label' => 'Outbound Routes',
		'count' => $outbound_routes['count'],
		'icon' => 'fa-phone-square',
		'link' => '/admin/config.php?display=routing'
	],
	[
		'label' => 'Voicemail',
		'count' => $voicemail['count'],
		'icon' => 'fa-microphone',
		'link' => '/admin/config.php?display=voicemail'
	],
	[
		'label' => 'Call Logs',
		'count' => $call_logs['count'],
		'icon' => 'fa-history',
		'link' => '/admin/config.php?display=cdr'
	],
	[
		'label' => 'GUI',
		//'count' => 0, // Placeholder for help count
		'icon' => 'fa-paint-brush',
		'link' => '/admin/config.php?display=oryk_gui'
	]
	// Add more items as needed
];

?>

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
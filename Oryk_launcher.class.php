<?php

// Launcher.class.php

namespace FreePBX\modules;
use BMO;
use PDO;
use FreePBX_Helpers;

class Oryk_launcher extends FreePBX_Helpers implements \BMO
{
	public function __construct($freepbx = null)
	{
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}
		$this->FreePBX = $freepbx;
		$this->db = $freepbx->Database;
		$this->astman = $freepbx->astman;
	}

	public function showPage()
	{
		$page = isset($_REQUEST['display']) ? $_REQUEST['display'] : 'index';

		switch ($page) {
			case 'index':
				return load_view(__DIR__ . '/views/launcher.php', [
					'items' => $this->getLaunchable(),
				]);
			default:
				break;
		}
	}

	public function getLaunchable()
	{
		$launchable = [];

		if (!isset($_SESSION['AMP_user'])) {
			return $launchable;
		}

		if ($_SESSION['AMP_user']->checkSection('userman')) array_push($launchable, [
			'label' => 'Users',
			'count' => $this->getCount('userman_users'),
			'icon' => 'fa-users',
			'link' => '/admin/config.php?display=userman'
		]);

		if ($_SESSION['AMP_user']->checkSection('extensions')) array_push($launchable, [
			'label' => 'Extensions',
			'count' => $this->getCount('users'),
			'icon' => 'fa-phone',
			'link' => '/admin/config.php?display=extensions'
		]);

		if ($_SESSION['AMP_user']->checkSection('trunks')) array_push($launchable, [
			'label' => 'Trunks',
			'count' => $this->getCount('trunks'),
			'icon' => 'fa-plug',
			'link' => '/admin/config.php?display=trunks'
		]);

		if ($_SESSION['AMP_user']->checkSection('inbound_routes')) array_push($launchable, [
			'label' => 'Inbound Routes',
			'count' => $this->getCount('incoming'),
			'icon' => 'fa-road',
			'link' => '/admin/config.php?display=did'
		]);

		if ($_SESSION['AMP_user']->checkSection('outbound_routes')) array_push($launchable, [
			'label' => 'Outbound Routes',
			'count' => $this->getCount('outbound_routes'),
			'icon' => 'fa-phone-square',
			'link' => '/admin/config.php?display=routing'
		]);

		// if ($_SESSION['AMP_user']->checkSection('voicemail')) array_push($launchable, [
		// 	'label' => 'Voicemail',
		// 	'count' => $this->getCount('voicemail'),
		// 	'icon' => 'fa-microphone',
		// 	'link' => '/admin/config.php?display=voicemail'
		// ]);

		if ($_SESSION['AMP_user']->checkSection('cdr')) array_push($launchable, [
			'label' => 'CDRs',
			'count' => $this->getCount('cdr'),
			'icon' => 'fa-history',
			'link' => '/admin/config.php?display=cdr'
		]);

		array_push($launchable, [
			'label' => 'GUI',
			'icon' => 'fa-paint-brush',
			'link' => '/admin/config.php?display=oryk_gui'
		]);
		
		return $launchable;
	}

	public function getCount($table = null)
	{
		if (!$table) {
			return;
		}

		$sqlCheck = "SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = :table";

		$stmt = $this->db->prepare($sqlCheck);
		$stmt->execute([':table' => $table]);

		if (!$stmt->fetch()) {
			return; // Table does not exist
		}

		try {
			$sql = "SELECT COUNT(*) FROM `$table`";
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
			return (int) $stmt->fetchColumn();
		} catch (\PDOException $e) {
			return;
		}
	}

	//Install method. use this or install.php using both may cause weird behavior
	public function install()
	{
		$this->FreePBX->Config->update('SHOWLANGUAGE', '0');
	}

	//Uninstall method. use this or install.php using both may cause weird behavior
	public function uninstall()
	{
	}

	//Not yet implemented
	public function backup()
	{
	}

	//not yet implimented
	public function restore($backup)
	{
	}

	//process form
	public function doConfigPageInit($page)
	{
	}

	public function ajaxRequest($req, &$setting)
	{
		return false;
	}

	public function ajaxHandler()
	{
		return false;
	}

	public function get_users()
	{
		return $this->db->getUsers();
	}
}
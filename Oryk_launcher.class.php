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
		$page = isset($_REQUEST['display']) ? $_REQUEST['display'] : 'default';

		switch ($page) {
			case 'oryk_launcher':

				return load_view(__DIR__ . '/views/launcher.php', [
					'users' => ['count' => $this->getCount('userman_users')],
					'extensions' => ['count' => $this->getCount('users')],
					'trunks' => ['count' => $this->getCount('trunks')],
					'inbound_routes' => ['count' => $this->getCount('inbound_routes')],
					'outbound_routes' => ['count' => $this->getCount('outbound_routes')],
					'voicemail' => ['count' => $this->getCount('voicemail')],
					'call_logs' => ['count' => $this->getCount('cdr')]
				]);
			default:
				break;
		}
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
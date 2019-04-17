<?php
/**
 * Copyright © Magehub. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magehub\CustomerSessionEnd\Model;

class Session
{
	protected $sessionConfig;
	protected $driverFile;

	public function __construct(
		\Magento\Framework\Session\Config $sessionConfig,
		\Magento\Framework\Filesystem\Driver\File $driverFile
	)
	{
		$this->sessionConfig = $sessionConfig;
		$this->driverFile = $driverFile;

		if(!session_id())
			session_start();
	}

	public function customerSessionEnd($customer_ids = [])
	{
		$deleted_session_count = 0;

		if(!is_array($customer_ids))
			$customer_ids = [];

		$session_path = $this->getSessionPath();
		$files = $this->getSessionFiles($session_path);
		
		$old_session = $_SESSION;

		foreach($files as $file)
		{
			$file_content = $this->driverFile->fileGetContents($file);
			session_decode($file_content);

			$session_customer_id = $_SESSION['default']['visitor_data']['customer_id'] ?? false;

			if(!$customer_ids || in_array($session_customer_id, $customer_ids))
			{
				$this->driverFile->deleteFile($file);
				$deleted_session_count++;
			}
		}

		$_SESSION = $old_session;

		return $deleted_session_count;
	}

	public function getSessionPath()
	{
		return $this->sessionConfig->getSavePath();
	}

	public function getSessionFiles($path)
	{
		return $this->driverFile->readDirectory($path);
	}
}
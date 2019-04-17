<?php
/**
 * Copyright © Magehub. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magehub\CustomerSessionEnd\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CustomerSessionEnd extends Command
{
	const INPUT_KEY_CUSTOMERS = 'customer_ids';
	protected $sessionModel;

	public function __construct(
		\Magehub\CustomerSessionEnd\Model\Session $sessionModel
	)
	{
		parent::__construct();
		$this->sessionModel = $sessionModel;
	}

	protected function configure()
	{
		$this->setName('mh:customersessionend');
		$this->setDescription('This will kill all customer session based on customer ID');

		$this->addArgument(
            self::INPUT_KEY_CUSTOMERS,
            InputArgument::IS_ARRAY | InputArgument::REQUIRED,
            'Customer ID'
        );
		//OPTIONAL

		parent::configure();
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$customer_ids = $input->getArgument(self::INPUT_KEY_CUSTOMERS);
		$deleted_session_count = $this->sessionModel->customerSessionEnd($customer_ids);
		$output->writeln("Total of $deleted_session_count session(s) have been cleared");
	}
}
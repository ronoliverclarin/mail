<?php

namespace OCA\DAV\Command;

use OCA\Mail\Db\MailAccount;
use OCA\Mail\Service\AccountService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddMailAccount extends Command {

	/**
	 * AddMailAccount constructor.
	 *
	 * @param AccountService $accountService
	 */
	function __construct(AccountService $accountService) {
		parent::__construct();
		$this->accountService = $accountService;
	}

	protected function configure() {
		$this
			->setName('mail:add-account')
			->setDescription('Create a new mail account')
			->addArgument('user',
				InputArgument::REQUIRED,
				'User for whom the mail account will be created')
			->addArgument('name',
				InputArgument::REQUIRED,
				'Display name of the user')
			->addArgument('email',
				InputArgument::REQUIRED,
				'Email address fo the account');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$user = $input->getArgument('user');
		$name = $input->getArgument('name');
		$email = $input->getArgument('email');

		$newAccount = new MailAccount();
		$newAccount->setEmail($email);
		$newAccount->setName($name);
		$newAccount->setUserId($user);
		$this->accountService->save($newAccount);
	}
}

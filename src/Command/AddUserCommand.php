<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'add:user',
    description: 'Add a short description for your command',
)]
class AddUserCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->setDescription('Créer un nouveau utilisateur dans la base de données')
        ->setHelp($this->getCommandHelp())
        ->addArgument('email', InputArgument::REQUIRED, "L'email de l'utilisateur")
        ->addArgument('password', InputArgument::REQUIRED, "Le mot de passe")
        ->addOption('admin', null, InputOption::VALUE_NONE, "Cette option, si présente, définit
un nouveau utilisateur comme administrateur")
    ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $stopwatch = new Stopwatch();
        $stopwatch->start('add-user-command');
        $plainPassword = $input->getArgument('password');
        $email = $input->getArgument('email');
        $isAdmin = $input->getOption('admin');
        // create the user and encode its password
        $user = new User();

        $io->success(sprintf('%s was successfully created: %s ', $isAdmin ? 'Administrator user' :
            'User', $user->getEmail()));
        $event = $stopwatch->stop('add-user-command');
        if ($output->isVerbose()) {
            $io->comment(sprintf('New user database id: %d / Elapsed time: %.2f ms / Consumed
memory: %.2f MB', $user->getId(), $event->getDuration(), $event->getMemory() / (1024 ** 2)));
        }
        return Command::SUCCESS;
    }
    private function getCommandHelp(): string
    {
        return <<<__HELP
            La commande <info>%command.name%</info> crée un nouveau utilisateur dans la base de
            données:
            <info>php %command.full_name%</info> <comment>email password</comment>
            Par défaut, la commande crée un utilisateur avec rôle ROLE_USER. Pour créer un
            administrateur,
            Ajouter l'option <comment>--admin</comment> :
            <info>php %command.full_name%</info> email password <comment>--admin</
            comment>
        __HELP;
    }
}

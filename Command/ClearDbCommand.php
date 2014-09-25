<?php

namespace BCC\ResqueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bcc:resque:clear-db')
            ->setDescription('Issue FLUSHDB on the Redis DB dedicated for Resque');
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $host = $container->getParameter('resque.host');
        $port = $container->getParameter('resque.port');
        $db   = $container->getParameter('resque.database');
        $redis = new \Credis_Client($host, $port);
        $redis->select($db);
        $redis->flushDb();
    }
}

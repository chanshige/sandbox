<?php
namespace Jobchan\Command\Notice;

use Jobchan\Handler\BacklogHandler as Backlog;
use Jobchan\Handler\SlackHandler as Slack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractNotice
 *
 * @package Jobchan\Command\Notice
 */
abstract class AbstractNotice extends Command
{
    /** @var Backlog */
    protected $backlog;
    /** @var Slack */
    protected $slack;
    /** @var \DateTimeImmutable */
    protected $dateTime;

    /**
     * AbstractNotice constructor.
     *
     * @param Backlog            $backlogHandler
     * @param Slack              $slackHandler
     * @param \DateTimeImmutable $dateTime
     */
    public function __construct(Backlog $backlogHandler, Slack $slackHandler, \DateTimeImmutable $dateTime = null)
    {
        $this->backlog = $backlogHandler;
        $this->slack = $slackHandler;
        $this->dateTime = $dateTime;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Notify the issues of "Open" and "In Progress" on the backlog.');

        $this->addOption(
            'slack-notify',
            'slack',
            InputOption::VALUE_NONE,
            'notify slack service'
        );

        $this->addOption('channel', null, InputOption::VALUE_OPTIONAL);
        $this->addOption('username', null, InputOption::VALUE_OPTIONAL);
        $this->addOption('icon', null, InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('slack-notify')) {
            $this->slack->channel($input->getOption('channel'))
                ->username($input->getOption('username'))
                ->icon($input->getOption('icon'));
        }
    }
}

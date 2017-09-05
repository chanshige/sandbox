<?php
namespace Jobchan\Command\Notice;

use Jobchan\Util\Format;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EstimateMitsuru
 *
 * @package Jobchan\Command\Notice
 */
class EstimateMitsuru extends AbstractNotice
{
    protected function configure()
    {
        $this->setName('notice:estimate');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $issues = Format::issues(
            json_decode($this->backlog->issues([
                'projectId' => [getenv('ESTIMATE_PROJECT_ID')],
                'statusId' => [1, 2],
                'dueDateSince' => $this->dateTime->format('Y-m-d'),
                'dueDateUntil' => $this->dateTime->modify('+1 day')->format('Y-m-d')
            ])), true
        );

        $message = count($issues) > 0 ?
            Format::createCodeBlocMsg('本日期限の未対応&相談中お見積はこちら。', $issues) :
            '本日期限の未対応&相談中お見積はありませんでした。';

        if ($input->getOption('slack-notify')) {
            $this->slack->text($message)->send();
            return;
        }

        $output->writeln($message);
    }
}

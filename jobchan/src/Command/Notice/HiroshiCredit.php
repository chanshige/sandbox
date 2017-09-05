<?php
namespace Jobchan\Command\Notice;

use Jobchan\Util\Format;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class HiroshiCredit
 *
 * @package Jobchan\Command\Notice
 */
class HiroshiCredit extends AbstractNotice
{
    protected function configure()
    {
        $this->setName('notice:credit');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $issues = Format::issues(
            json_decode($this->backlog->issues([
                'projectId' => [getenv('CREDIT_PROJECT_ID')],
                'statusId' => [1, 2, 3]])
            )
        );

        $message = count($issues) > 0 ?
            Format::createCodeBlocMsg('完了していない課題があります。',
                $issues, '担当者は確認をお願いします。') : '完了していない課題はありませんでした。報告しておきます。';

        if ($input->getOption('slack-notify')) {
            $this->slack->text("<!here|@here> " . $message)->send();
            return;
        }

        $output->writeln($message);
    }
}

<?php
namespace Jobchan\Command\Notice;

use Jobchan\Util\Format;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ResourceBooya
 *
 * @package Jobchan\Command\Notice
 */
class ResourceBooya extends AbstractNotice
{
    protected function configure()
    {
        $this->setName('notice:resource');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $issues = Format::issues(
            json_decode($this->backlog->issues([
                'projectId' => [getenv('RESOURCE_PROJECT_ID')],
                'statusId' => [1, 2]])
            )
        );

        $message = count($issues) > 0 ?
            Format::createCodeBlocMsg('リソース相談室(RESOURCE)に、ご新規＆未完了の相談があります。', $issues) :
            'リソース相談室(RESOURCE)へのご新規相談はありません。';

        if ($input->getOption('slack-notify')) {
            $this->slack->text($message)->send();
            return;
        }

        $output->writeln($message);
    }
}

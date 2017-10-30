<?php
namespace Selenium\Command;

use Exception\ExecutionException;
use Selenium\Driver\DriverInterface;
use Selenium\Util\Common;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SSLChecker
 *
 * @package Selenium\Resource
 */
class SSLChecker extends Command
{
    /** @var DriverInterface */
    private $driver;

    /**
     * SSLChecker constructor.
     *
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver)
    {
        parent::__construct();
        $this->driver = $driver;
    }

    /**
     * Configure.
     *
     * @return void.
     */
    public function configure()
    {
        $this->setName('sslchecker')
            ->setDescription('Always-On SSL Checker')
            ->setHelp('This command is... SSL Checker.');

        $this->addArgument('xml-url', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return void.
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $xmlObject = Common::loadXmlString(
                Common::fileGetContents($input->getArgument('xml-url'))
            );
            // RemoteWebDriver
            $driver = $this->driver->create();
        } catch (ExecutionException $e) {
            $output->writeln($e->getMessage());
            return;
        }

        $output->writeln('[SSL CHECK START]: --------------------------');
        // Basic認証回避用
        $driver->get($input->getArgument('xml-url'));

        $count = 0;
        foreach ($xmlObject as $item) {
            $driver->get($item->loc);
            // Grep
            $content = $this->checkMixedContent($driver->manage()->getLog('browser'));
            $output->writeln(self::output($item->loc, $content['isSSL']));
            // Error
            if (!$content['isSSL']) {
                $output->writeln('<comment>[ERROR DETAIL] ' . var_export($content['data'], true) . '</comment>');
            }
            $count++;
        }
        /** Quit */
        $driver->quit();
        $output->writeln('[TOTAL]: ' . $count);
        $output->writeln('[SSL CHECK END]: ----------------------------');
    }

    /**
     * Grep Mixed Content from Browser Message.
     *
     * @param array $array
     * @return array (isSSL => bool , data => array)
     */
    private function checkMixedContent($array)
    {
        $result = preg_grep('/.*Mixed Content.*/i', array_column($array, 'message'));
        return ['isSSL' => count($result) == 0, 'data' => $result];
    }

    /**
     * Result format.
     *
     * @param string $url
     * @param bool   $isSSL
     * @return string
     */
    private static function output($url, $isSSL)
    {
        // output color
        $color = $isSSL ? 'info' : 'error';

        return "<{$color}>[SSL:" . ($isSSL ? 'OK' : 'NG') . "]</{$color}> [URL] {$url}";
    }
}

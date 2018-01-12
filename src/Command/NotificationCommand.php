<?php namespace App\Command;

use App\Model\Notification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Currency;
use App\Service\Sender;
use App\Model\Exchange;
use Twig\Template;

class NotificationCommand extends Command
{
    /** @var Sender */
    private $sender;

    /** @var Currency */
    private $currency;

    /**
     * NotificationCommand constructor.
     * @param Sender $sender
     * @param Currency $currency
     * @param \Twig_Environment $twig
     */
    public function __construct(Sender $sender, Currency $currency, \Twig_Environment $twig)
    {
        $this->sender = $sender;
        $this->currency = $currency;
        $this->twig = $twig;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('notification');


    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = $this->currency->getCurrencies();

        $items = new Exchange\Collection();

        foreach ($this->getData() as $item) {
            $exchange = new Exchange\Model();
            $exchange
                ->setSymbol($item['symbol'])
                ->setCount($item['count'])
                ->setBidAmount(isset($item['bid_amount']) ? $item['bid_amount'] : null)
                ->setBidPrice(isset($item['bid_price']) ? $item['bid_price'] : null)
                ->setFree(isset($item['free']) ? $item['free'] : null)
                ->setCurrency($this->getCurrency($currencies, $item['symbol']))
            ;
            $items->add($exchange);
        }

        $invested = 1200;
        $amount = number_format($items->getAmount(), 2);
        $percent = number_format($items->getAmount() * 100 / $invested, 2);
        $earn = number_format($items->getAmount() - $invested, 2);

        $title = '';
        $title .= $amount . 'zł ' . "\n" . $earn . ' (' . $percent . '%)';
        $message = $this->twig->render('pushover.notify.html.twig', [
            'items' => $items,
            'invested' => $invested,
            'percent' => $items->getAmount() * 100 / $invested,
            'earn' => $items->getAmount() - $invested,
        ]);

        $notification = new Notification(
            $title, $message
        );
        $notification->setIsHtml(true);
        $notification->setPriority(-1);
//

        $this->sender->notification($notification);
//
//        die('asd');
//
//
//        $items = [];


    }

    function getCurrency($currencies, $symbol)
    {
        foreach ($currencies as $currency) {
            if ($currency->getSymbol() == $symbol) {
                return $currency;
            }
        }
        return null;
    }

    protected function getData()
    {
        return include(__DIR__ . '/../../config/coindata/data.php');
    }
}
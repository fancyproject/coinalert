<?php namespace App\Controller;

use App\Model\Exchange;
use App\Service\Currency;
use App\Service\Sender;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /** @var Sender */
    private $sender;

    /** @var Currency */
    private $currency;

    private $typeMapping = [
        'dud' => 'data4',
        'dud2' => 'data',
        'broda' => 'data2',
        'don' => 'data3',
    ];

    /**
     * IndexController constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender, Currency $currency)
    {
        $this->sender = $sender;
        $this->currency = $currency;
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

    public function summary()
    {
        $items = [];
        foreach ($this->typeMapping as $key => $filename) {
            $items[$key] = $this->prepareData($filename);
        }

        return $this->render('summary.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'dud');

        if ($type && isset($this->typeMapping[$type])) {
            $data = $this->prepareData($this->typeMapping[$type]);
        } else {
            throw $this->createNotFoundException();
        }

        return $this->render('index.html.twig', [
            'items' => $data,
        ]);
    }

    /**
     * @param string $filename
     * @return Exchange\Collection
     * @throws \Exception
     */
    protected function prepareData(string $filename)
    {
        $data = include(__DIR__ . '/../../config/coindata/' . $filename . '.php');
        $currencies = $this->currency->getCurrencies();

        $items = new Exchange\Collection();
        $items->setInvested($data['invested']);

        foreach ($data['items'] as $item) {
            $exchange = new Exchange\Model();

            $currency = $this->getCurrency($currencies, $item['symbol']);
            if ($currency === null) {
                throw new \Exception('Invalid currency: ' . $item['symbol']);
            }

            $exchange
                ->setSymbol($item['symbol'])
                ->setCount($item['count'])
                ->setBidAmount(isset($item['bid_amount']) ? $item['bid_amount'] : null)
                ->setBidPrice(isset($item['bid_price']) ? $item['bid_price'] : null)
                ->setFree(isset($item['free']) ? $item['free'] : null)
                ->setCurrency($currency)
            ;
            $items->add($exchange);
        }
        return $items;
    }
}
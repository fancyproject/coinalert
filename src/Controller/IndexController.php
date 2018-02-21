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

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $currencies = $this->currency->getCurrencies();

        $items = new Exchange\Collection();

        if($request->get('type')=='broda'){
            $file = 'data2';
        }elseif($request->get('type')=='don') {
            $file = 'data3';
        }elseif($request->get('type')=='dud') {
            $file = 'data4';
        }else{
            $file = 'data';
        }

        $data = $this->getData($file);
        $invested = $data['invested'];

        foreach ($data['items'] as $item) {
            $exchange = new Exchange\Model();

            $currency = $this->getCurrency($currencies, $item['symbol']);
            if($currency === null){
                throw new \Exception('Invalid currency: '. $item['symbol']);
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



//        dump(get_class($this->get('twig')));exit;

        return $this->render('index.html.twig', [
            'items' => $items,
            'invested' => $invested,
            'percent' => $items->getAmount() * 100 / $invested,
            'earn' => $items->getAmount() - $invested,
        ]);
    }

    protected function getData(string $filename)
    {
        return include(__DIR__ . '/../../config/coindata/'.$filename.'.php');
    }
}
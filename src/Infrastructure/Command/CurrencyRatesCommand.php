<?php

namespace App\Infrastructure\Command;

use App\Application\Find\RateFindUseCase;
use App\Application\Save\RateSaveUseCase;
use App\Application\Save\CurrencySaveUseCase;
use App\Infrastructure\HttpClient\GuzzleClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


#[AsCommand(
    name: 'app:currency:rates',
    description: 'Create currency rates',
    hidden: false
)]
class CurrencyRatesCommand extends Command
{
    public function __construct(private CurrencySaveUseCase $currencySave, private GuzzleClient $guzzleClient, private RateFindUseCase $rateFindUseCase, private RateSaveUseCase $rateSaveUseCase)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('currencies', InputArgument::IS_ARRAY, 'Argument description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currencies = $input->getArgument('currencies');

        $baseCurrency = $currencies[0];
        unset($currencies[0]);

        $targetCurrencies = implode(',', $currencies);

        $currencies = $this->guzzleClient->get("https://api.freecurrencyapi.com/v1/latest", "?apikey=k9ZVTyKiJfhYE5FtePKSg26bbszBuD1lWMcCm9Ea&base_currency=$baseCurrency&currencies=$targetCurrencies");

        $currencies = json_encode($currencies['data']);

        $this->currencySave->__invoke($baseCurrency, $currencies);

        $status = $this->rateSaveUseCase->__invoke($baseCurrency, $currencies);
          

        return Command::SUCCESS;
    }
}

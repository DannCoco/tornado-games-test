<?php

namespace App\Infrastructure\Controller;

use App\Application\Find\CurrencyFindUseCase;
use App\Application\Find\RateFindUseCase;
use App\Application\Save\RateSaveUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends AbstractController
{
    public function __construct(private RateFindUseCase $rateFindUseCase, private RateSaveUseCase $rateSaveUseCase, private CurrencyFindUseCase $currencyFindUseCase) 
    {
    }

    /**
     * @param $key
     * 
     * @return JsonResponse
     */
    #[Route('/api/exchange-rates', name: 'app_rate_get_key', methods: ["GET"])]
    public function getKeyAction(Request $request) 
    {
        $baseCurrency = $request->query->get('base_currency', null);
        $targetCurrencies = $request->query->get('target_currencies', null);

        if (!$baseCurrency) {
            return $this->json([
                "status" => Response::HTTP_BAD_REQUEST,
                "data" => [],
                "error" => "base_currency is required"
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!$targetCurrencies) {
            return $this->json([
                "status" => Response::HTTP_BAD_REQUEST,
                "data" => [],
                "error" => "target_currencies is required"
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $data = $this->rateFindUseCase->__invoke($baseCurrency);
            if (count($data) > 0) {
                return $this->json([
                    "status" => Response::HTTP_OK,
                    "data" => $data
                ], Response::HTTP_OK);
            } else {
                // Get currencies from MySql
                $currencies = $this->currencyFindUseCase->__invoke($baseCurrency);
                
                // Save data in Redis
                $this->rateSaveUseCase->__invoke($baseCurrency, $currencies);
                
                // Get data from redis
                $data = $this->rateFindUseCase->__invoke($baseCurrency);

                return $this->json([
                    "status" => Response::HTTP_OK,
                    "data" => $data
                ], Response::HTTP_OK);
            }
        
            return $this->json([
                "status" => Response::HTTP_NOT_FOUND,
                "data" => []
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->json([
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "data" => []
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

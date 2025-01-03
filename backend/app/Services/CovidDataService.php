<?

namespace App\Services;

use App\Http\Requests\FilterDataCountryRequest;
use Illuminate\Support\Facades\Http;
use App\Services\ReturnService;

class CovidDataService
{
    private ReturnService $returnService;

    function __construct(ReturnService $returnService)
    {
        $this->returnService = $returnService;
    }

    //Filtra os dados de acordo com o país
    public function filterDataCountry(FilterDataCountryRequest $request):Array
    {
        $countrys = ["Brazil", "Canada", "Australia"];

        try {
            $url = 'https://dev.kidopilabs.com.br/exercicio/covid.php?pais=';
            $queryParams = $request->input('country');

            if(!in_array($queryParams, $countrys)){
                
                return $this->returnService->respondNotFound($queryParams);
            }

            $response = Http::get($url . $queryParams);
                
            if($response->ok() && !empty($response->json())){
                return $this->returnService->respondSuccess($response->json());
            }

            if(empty($response->json()) || !$response->ok()){
                return $this->returnService->respondNoContent();
            }

        } catch (\Throwable $th) {
            return $this->returnService->respondError($th);
        }
       
    }
}
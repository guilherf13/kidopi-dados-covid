<?

namespace App\Services;

use App\Enums\Country;
use App\Http\Requests\FilterDataCountryRequest;
use Illuminate\Support\Facades\Http;

class CovidDataService
{
    //Filtra os dados de acordo com o país
    public function filterDataCountry(FilterDataCountryRequest $request):array
    {
        try {
            $baseUrl = env("Base_URL");
            $queryParams = $request->input('country');

            if(!Country::isValid($queryParams)){
                return $this->sendError('Invalid country', []);
            }
            
            $completeQuery = $baseUrl . '?pais=' . $queryParams;
            $response = Http::get($completeQuery);

            if($response->ok()){
                return $this->sendSucess('Data found successfully', $response->json());
            }

            return $this->sendError('Data not found', $response->json());

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
       
    }

    public function sendError(string $mensage = '', array $data = []):array 
    {
        return [
            'status' => 'error',
            'message' => $mensage,
            'data' => $data
        ];
    }

    public function sendSucess(string $mensage = '', array $data = []):array 
    {
        return [
            'status' => 'sucess',
            'message' => $mensage,
            'data' => $data
        ];
    }
}
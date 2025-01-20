<?

namespace App\Services;

use App\Enums\Country;
use App\Http\Requests\FilterDataCountryRequest;
use App\Models\ApiCovidAccessLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class CovidDataService
{

    function __construct(private ApiCovidAccessLog $apiCovidAccessLog)
    {   
    }

    //Filtra os dados de acordo com o país disponivel Brasil/Canada/Australia
    public function filterDataCountry(FilterDataCountryRequest $request):array
    {
        try {
            $queryParams = $request->input('country');

            if(!Country::isValid($queryParams)){
                return $this->sendError('Invalid country', []);
            }
            
            $completeQuery = "https://dev.kidopilabs.com.br/exercicio/covid.php" . '?pais=' . $queryParams;
            $response = Http::get($completeQuery);
            

            if($response->ok()){
                $this->apiCovidAccessLog->create(['country' => $queryParams]);
                return $this->sendSucess('Data found successfully', $response->json());
            }

            return $this->sendError('Data not found', $response->json());

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
       
    }

    public function acessData(): array 
    {
        $acess = $this->apiCovidAccessLog::orderBy('api_acess_at', 'desc')->first();
        $dataFormat = Carbon::parse($acess->api_acess_at)->format('d/m/Y H:i');
        
        $datas = [
            'date' => $dataFormat,
            'country' => $acess->country
        ];

        return $this->sendSucess('', $datas);
    }

    public function covidCountry($queryParams):array 
    {
        try {
            $completeQuery = "https://dev.kidopilabs.com.br/exercicio/covid.php" . '?pais=' . $queryParams;
            $response = Http::get($completeQuery);

            if($response->ok() && $response->json() != []){
                return $this->sendSucess('Data found successfully', $response->json());
            }

            return $this->sendError('Data not found', $response->json());

        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }

    /*  
        Padrão de retorno para o controller, 
        formatando respostas de erro e sucesso 
        com status, mensagem e dados em formato array.
    */
    public function sendError(string $mensage = '', array $data = []):array 
    {
        Log::error($mensage);
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
<?

namespace App\Services;

class ReturnService
{
    //Padrão de retorno adotado para os dados dos seviços.
    //data: Dados retornados
    //status: Status da requisição
    //mensage: Mensagem de retorno
    //status_code: Código de status da requisição

    public const STATUS_CODE = [
        'success' => 200,
        'error' => 500,
        'not_found' => 404,
        'unauthorized' => 401,
        'no_content' => 204,
    ];

    public const STATUS = [
        'success' => 'success',
        'error' => 'error',
        'not_found' => 'not_found',
        'unauthorized' => 'unauthorized',
        'no_content' => 'no_content',
    ];

    public function returnData($data, $status, $mensage, $status_code):Array
    {
        return [
            'data' => $data, 
            'status' => $status,
            'mensage'=> $mensage,
            'status_code' => $status_code,
        ];
    }

    /**
     * Response quando o país é encontrado.
     */
    public function respondSuccess(array $data): array
    {
        return $this->returnData(
            $data,
            ReturnService::STATUS['success'],
            'Success, data found',
            ReturnService::STATUS_CODE['success']
        );
    }

    /**
     * Response quando o país não é encontrado.
     */
    public function respondNotFound(string $country): array
    {
        return $this->returnData(
            [],
            ReturnService::STATUS['not_found'],
            "Failed, $country does not exist in the base",
            ReturnService::STATUS_CODE['not_found']
        );
    }

    /**
     * Response quando não há conteúdo.
     */
    public function respondNoContent(): array
    {
        return $this->returnData(
            [],
            ReturnService::STATUS['no_content'],
            'Failed, data not found',
            ReturnService::STATUS_CODE['no_content']
        );
    }

    /**
     * Response quando a error.
     */
    public function respondError(\Throwable $exception): array
    {
        return $this->returnData(
            [],
            ReturnService::STATUS['error'],
            'Error: ' . $exception->getMessage(),
            ReturnService::STATUS_CODE['error']
        );
    }
}

# API Endpoints

## 1. `/covid-data?country=pais`

### Descrição:
Este endpoint retorna os dados de casos confirmados e mortes relacionados à COVID-19 para o país informado. A pesquisa é restrita aos países "Brazil", "Australia" e "Canada", sendo que o parâmetro `country` deve corresponder a um desses valores.

### Parâmetros:
- `country` (string): País para o qual os dados serão retornados. Aceita somente "Brazil", "Australia" ou "Canada".

### Exemplo de Requisição:
```http

GET http://localhost:80/api/v1/covid-data?country=Australia

Exemplo de Resposta com sucesso:

{
    "data": {
        "status": "sucess",
        "message": "Data found successfully",
        "data": [
            {
                "ProvinciaEstado": "Australian Capital Territory",
                "Pais": "Australia",
                "Confirmados": 203680,
                "Mortos": 125
            },
            {
                "ProvinciaEstado": "New South Wales",
                "Pais": "Australia",
                "Confirmados": 3463759,
                "Mortos": 5046
            },
            {
                "ProvinciaEstado": "Northern Territory",
                "Pais": "Australia",
                "Confirmados": 96447,
                "Mortos": 70
            },
        ]
    }
}
```

Eexemplo de error na resposta:

```http
{
    "data": {
        "status": "error",
        "message": "Invalid country",
        "data": []
    }
}
```

## 2. `/acess-data`

### Descrição:
Este endpoint retorna informações sobre a última pesquisa realizada, incluindo o país pesquisado e a data/hora da consulta.

### Parâmetros:
- Não recebe paramentros.

### Exemplo de Requisição:
```http
GET http://localhost:80/api/v1/acess-data

Exemplo de Resposta com sucesso:

{
  "status": "sucess",
  "data": {
    "Pais": "Australia",
    "DataHoraUltimaPesquisa": "2025-01-06 14:30:00"
  }
}
```

## 3. `/covid-country?country=pais`

### Descrição:
Este endpoint retorna os dados sem restrição por pais.

### Parâmetros:
- `country` (string): País para o qual os dados serão retornados.

### Exemplo de Requisição:
```http
http://localhost:80/api/v1/covid-country?country=Brazil

Exemplo de Resposta com sucesso:

{
    "data": {
        "status": "sucess",
        "message": "Data found successfully",
        "data": [
            {
                "ProvinciaEstado": "Acre",
                "Pais": "Brazil",
                "Confirmados": 149378,
                "Mortos": 2027
            },
            {
                "ProvinciaEstado": "Alagoas",
                "Pais": "Brazil",
                "Confirmados": 320552,
                "Mortos": 7118
            },
            {
                "ProvinciaEstado": "Amapa",
                "Pais": "Brazil",
                "Confirmados": 178178,
                "Mortos": 2159
            },
        ]
    }
}
```
```http
Exemplo de Resposta com error:

{
    "data": {
        "status": "error",
        "message": "Data not found",
        "data": []
    }
}
```





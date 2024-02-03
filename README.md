## Installation

```bash
composer install

php artisan key:generate
php artisan storage:link
#~~~~~~~~~~~~~~~~~~~~~~~~~~
#For Production:
php artisan config:cache
php artisan route:cache
php artisan view:cache
#~~~~~~~~~~~~~~~~~~~~~~~~~~
php artisan migrate
#~~~~~~~~~~~
#For dev
npm install
vite dev
#~~~~~~~~~~~ 
```
# API
### Получить коттеджи
```http request
GET /api/V1/cottages
```
### Ответ
```
{
    "data": [
        {
            "id": 1,
            "name": "Громово-Коттедж №1",
            "cottage_type_id": 1,
            "gallery_id": 11,
            "schema_gallery_id": 12,
            "summer_gallery_id": 13,
            "winter_gallery_id": 14,
            "area": 108,
            "floors": 2,
            "bedrooms": 1,
            "single_beds": 5,
            "double_beds": 1,
            "additional_single_beds": 1,
            "additional_double_beds": 5,
            "bathrooms": 3,
            "showers": 0,
            "sauna": true,
            "fireplace": false,
            "floor1_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor2_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor3_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "is_active": false
        },
        {
            "id": 2,
            "name": "Громово-Коттедж №2",
            "cottage_type_id": 1,
            "gallery_id": 15,
            "schema_gallery_id": 16,
            "summer_gallery_id": 17,
            "winter_gallery_id": 18,
            "area": 197,
            "floors": 2,
            "bedrooms": 4,
            "single_beds": 1,
            "double_beds": 5,
            "additional_single_beds": 4,
            "additional_double_beds": 1,
            "bathrooms": 4,
            "showers": 0,
            "sauna": true,
            "fireplace": true,
            "floor1_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor2_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor3_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "is_active": false
        },
        {
            "id": 3,
            "name": "Громово-Коттедж №3",
            "cottage_type_id": 1,
            "gallery_id": 19,
            "schema_gallery_id": 20,
            "summer_gallery_id": 21,
            "winter_gallery_id": 22,
            "area": 185,
            "floors": 2,
            "bedrooms": 4,
            "single_beds": 3,
            "double_beds": 3,
            "additional_single_beds": 2,
            "additional_double_beds": 1,
            "bathrooms": 1,
            "showers": 4,
            "sauna": true,
            "fireplace": false,
            "floor1_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor2_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "floor3_features": [
                "...",
                "...",
                "...",
                "...",
                "..."
            ],
            "is_active": false
        },
```

### Получить коттедж
```http request
GET /api/cottage/{id}
```
### Ответ
```
{
    "data": {
        "id": 3,
        "name": "Громово-Коттедж №3",
        "cottage_type_id": 1,
        "gallery_id": 19,
        "schema_gallery_id": 20,
        "summer_gallery_id": 21,
        "winter_gallery_id": 22,
        "area": 185,
        "floors": 2,
        "bedrooms": 4,
        "single_beds": 3,
        "double_beds": 3,
        "additional_single_beds": 2,
        "additional_double_beds": 1,
        "bathrooms": 1,
        "showers": 4,
        "sauna": true,
        "fireplace": false,
        "floor1_features": [
            "...",
            "...",
            "...",
            "...",
            "..."
        ],
        "floor2_features": [
            "...",
            "...",
            "...",
            "...",
            "..."
        ],
        "floor3_features": [
            "...",
            "...",
            "...",
            "...",
            "..."
        ],
        "is_active": false
    }
}
```

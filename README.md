# backducks

# API Documentation

## Introduction

This document provides information about the API endpoints, methods, and data formats used in the Backducks Debug API.

## Base URL

The base URL for all API endpoints is:

```
http://127.0.0.1/api/
```

## Endpoints

### 1. Create Detour

- **Endpoint**: `create.php`
- **Method**: `POST`
- **Description**: Create a new detour record.
- **Request Body**:
  - `parcel_number` (14 char numeric): Parcel number of the detour.
  - `type` (integer): Type of the detour.
  - `delivery_day` (date YYYY-MM-DD): Delivery day for the detour.

#### Example Request

```json
{
  "parcel_number": "12345657901234",
  "type": 1,
  "delivery_day": "2023-09-30"
}
```

#### Example Response

```json
{
  "status": 200,
  "message": "Detour created successfully"
}
```

### 2. Update Detour

- **Endpoint**: `update.php`
- **Method**: `PUT`
- **Description**: Update an existing detour record.
- **Request Body**:
  - `id` (integer): ID of the detour record.
  - `parcel_number` (14 char numeric): Parcel number of the detour.
  - `type` (integer): Type of the detour.
  - `delivery_day` (date YYYY-MM-DD): Delivery day for the detour.

#### Example Request

```json
{
  "id": 1,
  "parcel_number": "12345657901234",
  "type": 2,
  "delivery_day": "2023-10-05"
}
```

#### Example Response

```json
{
  "status": 200,
  "message": "Detour updated successfully"
}
```

### 3. Delete Detour

- **Endpoint**: `delete.php`
- **Method**: `DELETE`
- **Description**: Delete a detour record.
- **Request Parameters**:
  - `id` (integer): ID of the detour record.

#### Example Request

```
http://example.com/api/delete.php?id=1
```

#### Example Response

```json
{
  "status": 200,
  "message": "Detour deleted successfully"
}
```

### 4. Get Detours

- **Endpoint**: `read.php`
- **Method**: `GET`
- **Description**: Retrieve a list of detour records.

#### Example Request

```
http://example.com/api/read.php
```

#### Example Response

```json
{
  "status": 200,
  "message": "Detour record fetch successful",
  "data": [
    {
      "id": 1,
      "parcel_number": "12345657901234",
      "type": 2,
      "delivery_day": "2023-10-05",
      "insert_date": "2023-09-21 10:30:45"
    },
    // ... Additional records ...
  ]
}
```

---

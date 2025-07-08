# API Documentation

## Authentication

All protected endpoints require an API key in the `Authorization` header. You can send it directly or use the `Bearer` scheme.

```
Authorization: your_api_key_here

# or

Authorization: Bearer your_api_key_here
```

## Endpoints

### GET /api/v1/time
Get current server time.

**Response:**
```json
{
  "server_time": "2025-07-08T21:38:58.000000Z",
  "timestamp": 1720474738,
  "timezone": "UTC"
}
```

### GET /api/v1/flagbits/active
Get active flagbits for a transaction.

**Parameters:**
- `transaction_id` (required): The ID of the transaction.

**Headers:**
- `Authorization`: A valid standard or master API key.

**Response:**
```json
{
  "transaction_id": 3,
  "active_flagbits": [
    {
      "flagbit_id": 12,
      "name": "TRANSACTION_FLAG_CHECKOUT",
      "description": "1 = für Checkout erstellt",
      "set_at": "2021-09-01T13:15:58.000000Z"
    }
  ]
}
```

### GET /api/v1/flagbits/history
Get complete flagbit history for a transaction.

**Parameters:**
- `transaction_id` (required): The ID of the transaction.

**Headers:**
- `Authorization`: A valid standard or master API key.

**Response:**
```json
{
  "transaction_id": 3,
  "flagbit_history": [
    {
      "flagbit_id": 12,
      "name": "TRANSACTION_FLAG_CHECKOUT",
      "description": "1 = für Checkout erstellt",
      "valid_from": "2021-09-01T00:00:00.000000Z",
      "valid_to": "2030-10-01T00:00:00.000000Z",
      "set_at": "2021-09-01T13:15:58.000000Z",
      "is_active": true
    }
  ]
}
```

### POST /api/v1/flagbits/set
Set a flagbit for a transaction.

**Headers:**
- `Authorization`: A valid master API key.
- `Content-Type`: application/json

**Body:**
```json
{
  "transaction_id": 3,
  "flagbit_id": 5
}
```

**Response:**
```json
{
  "message": "Flagbit set successfully",
  "transaction_id": 3,
  "flagbit_id": 5
}
```

### DELETE /api/v1/flagbits/remove
Remove a flagbit from a transaction.

**Headers:**
- `Authorization`: A valid master API key.
- `Content-Type`: application/json

**Body:**
```json
{
  "transaction_id": 3,
  "flagbit_id": 5
}
```

**Response:**
```json
{
  "message": "Flagbit removed successfully",
  "transaction_id": 3,
  "flagbit_id": 5
}
```

## Error Responses

### 401 Unauthorized
```json
{
  "error": "API key required"
}
```

### 403 Forbidden
```json
{
  "error": "Master key required"
}
```

### 404 Not Found
```json
{
  "error": "Transaction not found or access denied"
}
```

### 422 Validation Error
```json
{
  "error": "Validation failed",
  "details": {
    "transaction_id": ["The transaction id field is required."]
  }
}
```

## Flagbit Constants

| ID | Constant | Description |
|----|----------|-------------|
| 1 | TRANSACTION_FLAG_CLEARING | 0 = Direct, 1 = Accounting |
| 2 | TRANSACTION_FLAG_GUARANTEE | Payment guarantee |
| 3 | TRANSACTION_FLAG_3DSECURE | 3D-Secure |
| 4 | TRANSACTION_FLAG_EXT_API | 0 = XML, 1 = iFrame |
| 5 | TRANSACTION_FLAG_DEMO | Demo |
| 6 | TRANSACTION_FLAG_AUTHORIZATION | Pre-auth payment |
| 7 | TRANSACTION_FLAG_ACCRUAL | Block paying-out process |
| 8 | TRANSACTION_FLAG_STAKEHOLDER_EVALUATED | Transfer of stakeholder amount |
| 9 | TRANSACTION_FLAG_BASKET_EVALUATED | Basket was analyzed |
| 10 | TRANSACTION_FLAG_BASKET_ITEM_EVALUATED | Basket position was analyzed |
| 11 | TRANSACTION_FLAG_SECUCORE | Created via secucore |
| 12 | TRANSACTION_FLAG_CHECKOUT | Created for smart checkout |
| 13 | TRANSACTION_FLAG_LVP | Low Value Payment Flag |
| 14 | TRANSACTION_FLAG_TRA | Transaction Risk Analyze Flag |
| 15 | TRANSACTION_FLAG_MIT | Merchant initiated transaction |
